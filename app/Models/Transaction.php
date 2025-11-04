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

    public function isTransfer(): bool
    {
        return $this->type === TransactionTypeEnum::TRANSFER;
    }
}
