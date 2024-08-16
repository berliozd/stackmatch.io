<?php

namespace App\Http\Controllers\App\Subscribe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\SubscriptionBuilder;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var SubscriptionBuilder $subscriptionBuilder */
        $subscriptionBuilder = Auth::user()->newSubscription('default', config('cashier.basic_price'));

        $subscriptionBuilder->allowPromotionCodes();

        if (($trialPeriod = config('cashier.trial_period')) > 0) {
            $subscriptionBuilder->trialDays((int)$trialPeriod);
        }
        if (isset($_COOKIE['promotekit_referral'])) {
            $subscriptionBuilder->withMetadata(['promotekit_referral' => $_COOKIE['promotekit_referral']]);
        }

        return $subscriptionBuilder->checkout(['success_url' => route('websites')]);
    }
}
