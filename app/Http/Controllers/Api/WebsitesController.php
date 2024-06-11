<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebsitesController extends Controller
{
    public function list(Request $request)
    {
        $country = $request->get('country');
        Log::info($country);
        $tech = $request->get('tech');
        Log::info($tech);

        $url = sprintf(
            'https://api.builtwith.com/lists11/api.json?KEY=%s&TECH=%s&&meta=yes',
            config('app.built_with_api_key'),
            urlencode($tech),
        );
        if (!empty($country)) {
            $url .= sprintf('&COUNTRY=%s', $country);
        }

        Log::info($url);

        try {
            $response = json_decode(file_get_contents($url), true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [];
        }
        Log::info($response);
        return $response['Results'] ?? [];
    }
}
