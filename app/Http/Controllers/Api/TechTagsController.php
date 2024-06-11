<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TechTag;

class TechTagsController extends Controller
{
    public function index()
    {
        return TechTag::with('techs')->get();
    }
}
