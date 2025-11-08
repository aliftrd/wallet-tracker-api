<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Transaction\TransactionGetRequest;
use App\Http\Requests\Transaction\TransactionStoreRequest;
use App\Http\Requests\Transaction\TransactionUpdateRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\UserCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(Transaction::class, 'transaction');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TransactionGetRequest $request)
    {
        $transactions = Transaction::whereUserId(Auth::id())
            ->when($request->validated()['type'] ?? null, fn($query) => $query->where('type', $request->validated()['type']))
            ->latest()
            ->simplePaginate();

        return $this->resolveSuccessResponse(
            message: 'Transactions fetched successfully',
            data: TransactionResource::collection($transactions),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionStoreRequest $request)
    {
        $transaction = DB::transaction(function () use ($request) {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'user_category_id' => $request->validated('category_id'),
                ...$request->validated()
            ]);
            $transaction->applyToWallet($transaction->wallet);
            $transaction->items()->createMany($request->validated('items'));

            return $transaction;
        });

        return $this->resolveSuccessResponse(
            message: 'Transaction created successfully',
            data: $transaction->toResource(),
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->abortIfNotOwner($transaction);

        return $this->resolveSuccessResponse(
            message: 'Transaction fetched successfully',
            data: $transaction->toResource(),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionUpdateRequest $request, Transaction $transaction)
    {
        $this->abortIfNotOwner($transaction);

        $category = UserCategory::whereUserId(Auth::id())
            ->whereId($request->validated('category_id'))
            ->whereType($request->validated('type'))
            ->firstOrFail();

        throw_if(!$category, ValidationException::withMessages([
            'category_id' => 'The category is invalid.',
        ]));

        $transaction = DB::transaction(function () use ($request, $transaction, $category) {
            $oldWalletId = $transaction->wallet_id;
            $oldType = $transaction->type;
            $oldTotalAmount = $transaction->total_amount;

            $transaction->update([
                'user_category_id' => $category->id ?? null,
                ...$request->validated()
            ]);
            $transaction->items()->delete();
            $transaction->items()->createMany($request->validated('items'));

            $transaction->updateWalletBalanceOnEdit($oldWalletId, $oldType, $oldTotalAmount);
            return $transaction;
        });

        return $this->resolveSuccessResponse(
            message: 'Transaction updated successfully',
            data: $transaction->toResource(),
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->abortIfNotOwner($transaction);

        DB::transaction(function () use ($transaction) {
            $transaction->items()->delete();
            $transaction->revertFromWallet($transaction->wallet);
            $transaction->delete();
        });

        return $this->resolveSuccessResponse(
            message: 'Transaction deleted successfully',
        );
    }
}
