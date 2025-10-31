<?php

namespace App\Models;

use App\Policies\WalletPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

#[UsePolicy(WalletPolicy::class)]
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'balance',
        'color',
        'icon',
    ];

    public function getBalanceAttribute(int $value): string
    {
        return Number::currency($value, in: 'IDR', precision: 0);
    }

    public function scopeFindByCurrentUser(Builder $query): Builder
    {
        return $query->where('user_id', Auth::id());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
