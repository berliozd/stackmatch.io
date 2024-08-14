<?php

namespace App\Listeners;

use App\Models\User;
use App\Services\SendMailService;
use Laravel\Cashier\Events\WebhookHandled;

readonly class SendSubscriptionCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(private SendMailService $sendMailService)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookHandled $event): void
    {
        \Log::info($event->payload['type']);
        if ('customer.subscription.created' !== $event->payload['type']) {
            \Log::info($event->payload['type'] . ' so returning.');
            return;
        }
        $stripeCustomer = $event->payload['data']['object']['customer'];
        \Log::info($stripeCustomer);
        $user = User::where('stripe_id', $stripeCustomer)->first();
        $this->sendEmail($user);
    }

    private function sendEmail(User $user): void
    {
        $content = <<<HTML
Hi :user_name,
<br/>
<br/>
Thank you for upgrading to :app_name Premium!
<br/>
<br/>
We're thrilled to have you as a premium member and excited to help you unlock the full potential of our platform. 
Your upgrade comes with a host of advanced features designed to enhance your experience and help you achieve your goals more effectively.
<br/>
Here's what you gain with your premium subscription:
<br/>
<br/>
<br/>

<strong>1: Unlimited searches:</strong><br>
<p>
Enjoy the freedom to search for as many websites as you need, without any restrictions. 
Find the perfect matches for your tech stack effortlessly.
</p>

<strong>2: Unlimited websites:</strong><br>
<p>
Add as many websites to your list as you want, allowing you to keep track of all your potential clients and partners without any limitations.
</p>

<strong>3: No ads:</strong><br>
<p>
Experience a seamless and uninterrupted browsing experience with no advertisements, ensuring you can focus on what matters most.
</p>

<strong>4: Priority Support:</strong><br>
<p>
As a premium user, you'll receive priority support from our dedicated team. 
We're here to help you make the most of your experience with and ensure you have all the resources you need to succeed.
</p>
<br/>

<p>
To start enjoying your premium benefits, simply log in to your account: <a href=":app_url"><strong>:app_url</strong></a>
</p>
<p>
If you have any questions or need assistance, please don't hesitate to reach out to our support team. We're here to help you make the most of your experience.
</p>
<br/>
Thank you for choosing us, and here's to turning your ideas into reality!
<br/>
Best Regards,
<br/>
Didier
Founder of :app_name
HTML;
        $content = __(
            $content,
            [
                'user_name' => $user->name,
                'app_name' => config('app.name'),
                'nb_fee_credits' => config('app.free-ai-credits'),
                'app_url' => config('app.url')
            ]
        );

        $subject = __(
            'Welcome to :app_name Premium – Unlock Unlimited Possibilities!',
            ['app_name' => config('app.name')]
        );
        $this->sendMailService->sendEmail($content, $subject, $user);
    }
}
