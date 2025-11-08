<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdatePasswordController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePasswordRequest $request): JsonResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->validated('current_password'), $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Invalid current password',
            ]);
        }

        $user->update([
            'password' => bcrypt($request->validated('password')),
        ]);

        return $this->resolveSuccessResponse(
            message: 'Password updated successfully',
            data: $user->toResource(),
        );
    }
}
