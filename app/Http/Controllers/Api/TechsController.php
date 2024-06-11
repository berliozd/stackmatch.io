<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tech;
use Illuminate\Support\Facades\Log;

class TechsController extends Controller
{
    public function index(string $techTagId)
    {
        Log::info('ici');
        return Tech::where('tech_tag_id', $techTagId)->get();
    }

    public function search(string $techName)
    {
        Log::info($techName);
        return Tech::where('name', 'like', '%' . $techName . '%')->get();
    }
}
