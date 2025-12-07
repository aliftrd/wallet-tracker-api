<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\UpdateFcmTokenRequest;

class UpdateFcmTokenController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateFcmTokenRequest $request)
    {
        tap($request->user())
            ->update(['fcm_token' => $request->fcm_token]);

        return $this->resolveSuccessResponse('FCM token updated successfully');
    }
}
