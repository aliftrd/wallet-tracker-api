<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Wallet\WalletStoreRequest;
use App\Http\Requests\Wallet\WalletUpdateRequest;
use App\Http\Resources\WalletResource;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WalletController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(Wallet::class, 'wallet');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Wallet::whereUserId(Auth::id())->get();

        return $this->resolveSuccessResponse(
            message: 'Wallets fetched successfully',
            data: WalletResource::collection($wallets),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WalletStoreRequest $request): JsonResponse
    {
        $wallet = Wallet::create([
            'user_id' => Auth::id(),
            ...$request->validated(),
        ]);

        return $this->resolveSuccessResponse(
            message: 'Wallet created successfully',
            data: $wallet->toResource(),
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet): JsonResponse
    {
        return $this->resolveSuccessResponse(
            message: 'Wallet fetched successfully',
            data: $wallet->toResource(),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WalletUpdateRequest $request, Wallet $wallet): JsonResponse
    {
        $wallet->update($request->validated());

        return $this->resolveSuccessResponse(
            message: 'Wallet updated successfully',
            data: $wallet->toResource(),
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet): JsonResponse
    {
        $wallet->delete();

        return $this->resolveSuccessResponse(
            message: 'Wallet deleted successfully',
        );
    }
}
