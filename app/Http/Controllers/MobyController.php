<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobyController extends Controller
{
    public function hosted(Request $request)
    {
        return (new \App\Services\Moby\MobyService())->hosted($request);
    }

    public function callback(Request $request)
    {
        return (new \App\Services\Moby\MobyService())->callback($request);
    }

    public function return(Request $request)
    {
        return (new \App\Services\Moby\MobyService())->callback($request);
    }
}
