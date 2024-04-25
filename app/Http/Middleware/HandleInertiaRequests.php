<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $locales = array_map('basename', glob(base_path('lang') . '/*', GLOB_ONLYDIR));
        $res = array_merge(parent::share($request), [
            'app' => [
                'name' => config('app.name'),
                'locales' => $locales,
                'home_route' => config('app.home-route'),
            ]
        ]);
        if (!empty($request->user())) {
            if (!empty($subscription = auth()->user()?->subscription())) {
                $subscription->on_grace_period = $subscription->onGracePeriod();
                $subscription->end_date = $subscription->ends_at ? $subscription->ends_at->timestamp : 0;
                $subscription->is_valid = $subscription->valid();
            }
            $res['subscription'] = $subscription;
        }
        return $res;
    }
}
