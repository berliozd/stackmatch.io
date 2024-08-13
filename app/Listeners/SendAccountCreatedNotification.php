<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Mailjet\Client;
use Mailjet\Resources;

class SendAccountCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $this->sendEmail($event->user);
    }

    private function sendEmail($user): void
    {
        $content = <<<HTML
Hi :user_name,
<br/>
<br/>
<strong>Welcome to :app_name!</strong>
<br/>
<br/>
We're thrilled to have you join our community of developers, creators, recruiters, and investors. Your free account gives you access to a powerful tool designed to help you discover, connect, and innovate with the right technology partners.
<br/>
<br/>
<strong>Here's what you can do with your free account:</strong>
<br/>
<br/>
<ul>
<li><strong>Search and Filter:</strong> Find websites that use the technologies you're interested in (3 searches available with the free account).</li>
<li><strong>Connect:</strong> Reach out to potential clients, partners, or employers who match your tech stack (10 websites can be added with your free account).</li>
</ul>
<br/>
<br/>
<strong>Getting Started:</strong>
<br/>
<br/>
<ul>
<li><strong>Complete Your Profile</strong></li>
<li><strong>Start Searching:</strong> Use our advanced search filters to find websites that align with your interests.</li>
<li><strong>Connect and Collaborate:</strong> Reach out to potential partners and start building meaningful connections.</li>
</ul>
<br/>
<br/>
<strong>Need Help?</strong>
<br/>
<br/>
Our support team is here to assist you. Feel free to reach out to us at [support@stackmatch.io](mailto:support@stackmatch.io) with any questions or feedback.
<br/>
<br/>
<strong>Stay Tuned:</strong>
<br/>
<br/>
We'll keep you updated with the latest features, success stories, and tips to help you make the most of :app_name.
<br/>
<br/>
<strong>Thank you for joining us on this exciting journey!</strong>
<br/>
<br/>
Best regards,
<br/>
<br/>
Didier
<br/>
Founder of :app_name
<br/>
HTML;

        $mj = new Client(
            config('services.mailjet.client_id'),
            config('services.mailjet.client_secret'),
            true,
            ['version' => 'v3.1']
        );
        $subject = __(
            'Welcome to :app_name – Your Journey Starts Here!',
            ['app_name' => config('app.name')]
        );
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => config('services.mailjet.mail_from'),
                        'Name' => config('app.name')
                    ],
                    'To' => [
                        [
                            'Email' => $user->email,
                            'Name' => $user->name
                        ]
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => __(
                        $content,
                        [
                            'user_name' => $user->name,
                            'app_name' => config('app.name'),
                            'nb_fee_credits' => config('app.free-ai-credits'),
                            'app_url' => config('app.url')
                        ]
                    )
                ],
                [
                    'From' => [
                        'Email' => config('services.mailjet.mail_from'),
                        'Name' => config('app.name')
                    ],
                    'To' => [
                        [
                            'Email' => config('services.mailjet.mail_from'),
                            'Name' => config('app.name')
                        ]
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => __(
                        ':name :email has just created an account.',
                        ['name' => $user->name, 'email' => $user->email]
                    )
                ]
            ]
        ];
        $mj->post(Resources::$Email, ['body' => $body]);
    }
}
