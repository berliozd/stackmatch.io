<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;


class TestController extends Controller
{
    public function __invoke()
    {
        // TODO: Implement __invoke() method.
        var_dump('test controller');
    }
}
