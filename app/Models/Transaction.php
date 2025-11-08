<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'user_category_id',
        'type',
        'store_name',
        'date',
        'note',
        'tax_amount',
        'total_amount',
    ];

    protected $casts = [
        'type' => TransactionTypeEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(UserCategory::class, 'user_category_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function isExpense(): bool
    {
        return $this->type === TransactionTypeEnum::EXPENSE;
    }

    public function isIncome(): bool
    {
        return $this->type === TransactionTypeEnum::INCOME;
    }

    /**
     * Apply this transaction to a wallet's balance
     */
    public function applyToWallet(Wallet $wallet): void
    {
        if ($this->isIncome()) {
            $wallet->balance += $this->total_amount;
        } elseif ($this->isExpense()) {
            $wallet->balance -= $this->total_amount;
        }

        $wallet->save();
    }

    /**
     * Revert this transaction from a wallet's balance
     */
    public function revertFromWallet(Wallet $wallet): void
    {
        if ($this->isIncome()) {
            $wallet->balance -= $this->total_amount;
        } elseif ($this->isExpense()) {
            $wallet->balance += $this->total_amount;
        }

        $wallet->save();
    }

    /**
     * Revert a transaction with specific values from a wallet's balance
     */
    public static function revertTransactionFromWallet(
        Wallet $wallet,
        TransactionTypeEnum $type,
        float $amount
    ): void {
        if ($type === TransactionTypeEnum::INCOME) {
            $wallet->balance -= $amount;
        } elseif ($type === TransactionTypeEnum::EXPENSE) {
            $wallet->balance += $amount;
        }

        $wallet->save();
    }

    /**
     * Update wallet balance when transaction is modified
     * Handles both wallet changes and amount/type changes
     */
    public function updateWalletBalanceOnEdit(
        ?int $oldWalletId,
        TransactionTypeEnum $oldType,
        float $oldAmount
    ): void {
        $currentWallet = $this->wallet;

        // If wallet changed, revert from old wallet and apply to new wallet
        if ($oldWalletId && $oldWalletId != $this->wallet_id) {
            $oldWallet = Wallet::findOrFail($oldWalletId);

            // Revert from old wallet
            self::revertTransactionFromWallet($oldWallet, $oldType, $oldAmount);

            // Apply to new wallet
            $this->applyToWallet($currentWallet);
        } else {
            // Same wallet, revert old values and apply new values
            self::revertTransactionFromWallet($currentWallet, $oldType, $oldAmount);
            $this->applyToWallet($currentWallet);
        }
    }

    /**
     * Update wallet balance (legacy method for backward compatibility)
     */
    public function updateWalletBalance(): void
    {
        $this->applyToWallet($this->wallet);
    }
}
