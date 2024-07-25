<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use OpenAI;
use OpenAI\Client;

class AIService
{
    private const string GPT_ENGINE_VERSION_4o = 'gpt-4o';
    private const string GPT_ENGINE_VERSION_35_TURBO = 'gpt-3.5-turbo';

    public function getInsight(
        string $context,
        string $question,
        string $engine = self::GPT_ENGINE_VERSION_35_TURBO
    ): string {
        Log::info($context);
        Log::info($question);
        Log::info($engine);
        $client = $this->getClient();
        $response = $client->chat()->create([
            'model' => $engine,
            'messages' => [
                ['role' => 'user', 'content' => $context],
                ['role' => 'user', 'content' => $question]
            ],
        ]);
        $aiInsight = $response->choices[0]->message->content;
        Log::info($aiInsight);
        return $aiInsight;
    }

    public function getEmailContent(string $name): string
    {
        return $this->getInsight(
            'Company name : ' . $name,
            $this->getContactEmail()
        );
    }

    private function getClient(): Client
    {
        return OpenAI::client(config('services.openai.api_key'));
    }


    private function getLanguageFromContext(string $context): string
    {
        return $this->getInsight(
            $context,
            'Give me the human locale language of this project. ' .
            'Your answer should only be the human locale language like for example french, english, spanish. ' .
            'Your answer should be a single word in lower case.'
        );
    }

    public function getLanguage(): string
    {
        $userSettings = json_decode(auth()->user()?->settings, true);
        $lang = $userSettings['lang'] ?? App::getLocale();
        return match ($lang) {
            'en' => 'english',
            'fr' => 'french',
            default => 'unknown',
        };
    }

    private function getContactEmail(): string
    {
        return 'write an email explaining that I would like to get in touch and offer my services or products.'
            . 'Be short and concise'
            . ', write in ' . $this->getLanguage()
            . ',do not add the subject'
            . 'add a signature with name' . auth()->user()->name;
    }
}