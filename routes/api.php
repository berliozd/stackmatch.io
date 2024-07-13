<?php

use App\Http\Controllers\Api\AiAssistantController;
use App\Http\Controllers\Api\HistoriesController;
use App\Http\Controllers\Api\TechsController;
use App\Http\Controllers\Api\TechTagsController;
use App\Http\Controllers\Api\UserWebsitesController;
use App\Http\Controllers\Api\WebsitesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/websites/search', [WebsitesController::class, 'search']);
    Route::post('/websites/add', [WebsitesController::class, 'store']);
    Route::get('/tech-tags', [TechTagsController::class, 'index']);
    Route::get('/techs/search/{techName}', [TechsController::class, 'search']);

    // User websites
    Route::get('/websites/list', [UserWebsitesController::class, 'list']);
    Route::get('/user_website/{id}', [UserWebsitesController::class, 'index']);
    Route::delete('/user_website/{id}', [UserWebsitesController::class, 'destroy']);
    Route::post('/histories/add', [HistoriesController::class, 'store']);

    // AI
    Route::post('/ai/contact_email', [AiAssistantController::class, 'askContactEmailContent']);
});