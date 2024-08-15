<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Mailjet\Client;
use Mailjet\Resources;

class SendMailService
{
    public function sendEmail(string $content, string $subject, User $user, bool $sendToSupport = true): void
    {
        $mj = $this->getClient();
        $messages = [
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
                'HTMLPart' => $content
            ]
        ];
        if ($sendToSupport) {
            $messages[] = [
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
                'HTMLPart' => $content
            ];
        }
        $body = ['Messages' => $messages];
        Log::info('sending mail to ' . $user->email);
        $mj->post(Resources::$Email, ['body' => $body]);
        Log::info('After sending mail to ' . $user->email);
    }

    public function addToContactList(User $user): void
    {
        try {
            $params = [
                'Contacts' => [
                    [
                        'Email' => $user->email,
                        'IsExcludedFromCampaigns' => false,
                        'Name' => $user->name,
                        'Properties' => 'Object'
                    ]
                ],
                'ContactsLists' => [['Action' => 'addforce', 'ListID' => config('services.mailjet.list_id')]]
            ];
            $mj = $this->getClient();
            $response = $mj->post(Resources::$ContactManagemanycontacts, ['body' => $params]);
            Log::info('added to contact list : ' . $response->success());
            Log::info(json_encode($response->getData()));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function getClient(): Client
    {
        return new Client(
            config('services.mailjet.client_id'),
            config('services.mailjet.client_secret'),
            true,
            ['version' => 'v3.1']
        );
    }
}