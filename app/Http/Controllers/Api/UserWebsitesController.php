<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWebsite;

class UserWebsitesController extends Controller
{
    public function list()
    {
        return UserWebsite::where('user_id', auth()->user()->id)->with('website.techs.tech.techTag')->get();
    }

    public function index(string $id)
    {
        $q = UserWebsite::where('user_id', auth()->user()->id)->where('id', $id)
            ->with('website.techs.tech.techTag')
            ->with('website.emails')
            ->with('histories');
        return $q->first();
    }

    public function destroy(string $id)
    {
        UserWebsite::where('user_id', auth()->user()->id)->where('id', $id)->delete();
    }
}
