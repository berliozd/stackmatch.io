<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWebsiteHistory;
use Illuminate\Http\Request;

class HistoriesController extends Controller
{

    public function store(Request $request)
    {
        $userWebsiteHistoryData = $request->validate([
            'user_website_id' => 'required',
            'content' => 'required|string',
        ]);
        return UserWebsiteHistory::create($userWebsiteHistoryData);
    }
}
