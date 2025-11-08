<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UpdateProfileController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateProfileRequest $request): JsonResponse
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
        ]);

        return $this->resolveSuccessResponse(
            message: 'Profile updated successfully',
            data: $user->toResource(),
        );
    }
}
