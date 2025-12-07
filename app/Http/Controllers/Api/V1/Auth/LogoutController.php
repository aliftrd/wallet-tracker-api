<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class LogoutController extends ApiController
{
    public function __invoke(Request $request)
    {
        dd($request->user());
        $request->user()->currentAccessToken()->delete();
    }
}
