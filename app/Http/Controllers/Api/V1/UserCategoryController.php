<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\CategoryTypeEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\UserCategory\UserCategoryGetRequest;
use App\Http\Requests\UserCategory\UserCategoryStoreRequest;
use App\Http\Requests\UserCategory\UserCategoryUpdateRequest;
use App\Http\Resources\UserCategoryResource;
use App\Models\UserCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserCategoryController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(UserCategory::class, 'userCategory');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UserCategoryGetRequest $request): JsonResponse
    {
        $type = CategoryTypeEnum::from($request->validated('type'));

        $categories = UserCategory::whereUserId(Auth::id())
            ->whereType($type)
            ->get();

        return $this->resolveSuccessResponse(
            message: 'Categories fetched successfully',
            data: UserCategoryResource::collection($categories),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCategoryStoreRequest $request)
    {
        $userCategory = UserCategory::create([
            'user_id' => Auth::id(),
            ...$request->validated(),
        ]);

        return $this->resolveSuccessResponse(
            message: 'User category created successfully',
            data: $userCategory->toResource(),
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(UserCategory $userCategory): JsonResponse
    {
        $this->abortIfNotOwner($userCategory);

        return $this->resolveSuccessResponse(
            message: 'User category fetched successfully',
            data: $userCategory->toResource(),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserCategoryUpdateRequest $request, UserCategory $userCategory)
    {
        $this->abortIfNotOwner($userCategory);

        $userCategory->update($request->validated());

        return $this->resolveSuccessResponse(
            message: 'User category updated successfully',
            data: $userCategory->toResource(),
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserCategory $userCategory)
    {
        $this->abortIfNotOwner($userCategory);

        $userCategory->delete();

        return $this->resolveSuccessResponse(
            message: 'User category deleted successfully',
        );
    }
}
