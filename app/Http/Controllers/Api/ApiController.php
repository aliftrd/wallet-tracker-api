<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

abstract class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function abortIfNotOwner(Model $model): void
    {
        throw_if($model->user_id !== Auth::id(), AuthorizationException::class);
    }

    protected function resolveSuccessResponse(string $message, array|JsonResource|Collection|null $data = null, Response | int $status = Response::HTTP_OK): JsonResponse
    {
        $response['message'] = $message;

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    protected function resolvePaginatedResponse(string $message, ResourceCollection $data, Response | int $status = Response::HTTP_OK): JsonResponse
    {
        $response['message'] = $message;
        $response['data'] = [
            'data' => $data->collection,
            'meta' => [
                'current_page' => $data->currentPage(),
                'next_page' => $data->hasMorePages() ? $data->currentPage() + 1 : null,
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ],
        ];

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
