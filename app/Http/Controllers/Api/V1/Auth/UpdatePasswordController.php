<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        tap($user)
            ->update(['password' => Hash::make($request->new_password)]);

        return $this->resolveSuccessResponse('Password updated successfully');
    }
}
