<?php

use App\Http\Controllers\Api\TechsController;
use App\Http\Controllers\Api\TechTagsController;
use App\Http\Controllers\Api\WebsitesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/websites', [WebsitesController::class, 'list']);
//    Route::get('/website/{domain}', [WebsitesController::class, 'index']);
    Route::get('/tech-tags', [TechTagsController::class, 'index']);
    Route::get('/techs/search/{techName}', [TechsController::class, 'search']);
});