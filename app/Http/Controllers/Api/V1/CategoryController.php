<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\CategoryTypeEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Category\GetCategoryRequest;
use App\Http\Resources\UserCategoryResource;
use App\Models\UserCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetCategoryRequest $request): JsonResponse
    {
        $categories = UserCategory::findByCurrentUser()
            ->OfType(CategoryTypeEnum::from($request->validated('type')))
            ->get();

        return $this->resolveSuccessResponse(
            message: 'Categories fetched successfully',
            data: UserCategoryResource::collection($categories),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserCategory $userCategory)
    {
        $userCategory->delete();

        return $this->resolveSuccessResponse(
            message: 'User category deleted successfully',
        );
    }
}
