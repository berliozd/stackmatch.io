<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;


class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render(
            'Dashboard',
            $this->getData()
        );
    }

    public function getData(): array
    {
        if (!empty(auth()->user())) {
            if (!empty($subscription = auth()->user()?->subscription())) {
                $subscription->on_grace_period = $subscription->onGracePeriod();
                $subscription->end_date = $subscription->ends_at ? $subscription->ends_at->timestamp : 0;
                $subscription->is_valid = $subscription->valid();
            }
        }
        return [
            'invoices' => auth()->user()?->invoices(),
            'subscription' => $subscription
        ];
    }
}
