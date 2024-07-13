<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AIService;
use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    public function __construct(private readonly AIService $aiService)
    {
    }

    public function askContactEmailContent(Request $request): array
    {
        $name = (int)$request->get('name');
        return ['response' => $this->aiService->getEmailContent($name)];
    }
}
