<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

abstract class Controller
{
    protected function resolveSuccessResponse(string $message, array|JsonResource|Collection|null $data = null, Response | int $status = Response::HTTP_OK): JsonResponse
    {
        $response['message'] = $message;
        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    protected function resolveErrorResponse(string $message, ?array $errors = [], Response | int $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $response['message'] = $message;
        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}
