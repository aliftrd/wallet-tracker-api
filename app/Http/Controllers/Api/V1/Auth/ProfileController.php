<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\UpdateProfileRequest;

class ProfileController extends ApiController
{
    public function show(Request $request)
    {
        $user = $request->user();

        return $this->resolveSuccessResponse('Profile retrieved successfully', data: $user->toResource());
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        tap($user)->update($request->validated());

        // TODO: Handle email change and send verification email

        return $this->resolveSuccessResponse('Profile updated successfully', data: $user->toResource());
    }
}
