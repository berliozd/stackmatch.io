<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\WebsiteAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebsitesController extends Controller
{
    public function search(Request $request)
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

    public function store(Request $request)
    {
        $website = $this->createWebsite($request);
        $this->createRelations($request, 'emails', 'emails', 'email', $website);
        $this->createRelations($request, 'phones', 'phones', 'phone', $website);
        $this->createRelations($request, 'socials', 'socials', 'social', $website);
        $this->createTechs($request, $website);
        $this->createAddress($request, $website);
        $website->users()->attach(auth()->user()->id);
        return $website;
    }

    private function createWebsite(Request $request): Website
    {
        $websiteData = $request->validate([
            'url' => 'required',
            'name' => 'nullable|string',
        ]);
        return Website::updateOrCreate(['url' => $websiteData['url']], $websiteData);
    }

    private function createRelations(
        Request $request,
        string $requestKey,
        string $relationName,
        string $relationCol,
        Website $website
    ) {
        $relations = $request->get($requestKey, []) ?? [];
        foreach ($relations as $relation) {
            $website->{$relationName}()->updateOrCreate(
                [$relationCol => $relation],
                ['website_id' => $website->id],
            );
        }
    }

    private function createTechs(Request $request, Website $website): void
    {
        $techs = $request->get('techs', []) ?? [];
        foreach ($techs as $tech) {
            $website->techs()->updateOrCreate(
                ['tech_id' => $tech['id']],
                ['website_id' => $website->id],
            );
        }
    }

    private function createAddress(Request $request, Website $website): void
    {
        $addressId = $website->address()?->first()?->id;
        if (!empty($addressId)) {
            WebsiteAddress::destroy([$website->address()->first()->id]);
        }
        $addressData = $request->validate([
            'city' => 'nullable|string',
            'postcode' => 'nullable|string',
            'country' => 'nullable|string',
        ]);
        if (!empty($addressData['city']) || !empty($addressData['postcode']) || !empty($addressData['country'])) {
            $website->address()->create($addressData);
        }
    }
}
