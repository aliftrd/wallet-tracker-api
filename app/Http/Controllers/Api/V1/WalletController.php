<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Wallet\CreateWalletRequest;
use App\Http\Requests\Wallet\UpdateWalletRequest;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\WalletResource;

class WalletController extends ApiController
{
    protected $customerId;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Wallet::whereCustomerId(Auth::id())->orderByDesc('id')->get();

        return $this->resolveSuccessResponse('Wallets retrieved successfully', data: WalletResource::collection($wallets));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateWalletRequest $request)
    {
        $payload = $request->validated();
        $payload['customer_id'] = Auth::id();
        $wallet = Wallet::create($payload);

        return $this->resolveSuccessResponse('Wallet created successfully', data: new WalletResource($wallet));
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        $this->abortIfNotOwner($wallet);

        return $this->resolveSuccessResponse('Wallet retrieved successfully', data: new WalletResource($wallet));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWalletRequest $request, Wallet $wallet)
    {
        $this->abortIfNotOwner($wallet);

        $wallet->update($request->validated());

        return $this->resolveSuccessResponse('Wallet updated successfully', data: new WalletResource($wallet));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        $this->abortIfNotOwner($wallet);

        $wallet->delete();

        return response()->noContent();
    }
}
