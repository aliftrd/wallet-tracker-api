<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

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

    protected static function booted()
    {
        static::addGlobalScope('user-wallets', function (Builder $builder) {
            $builder->where('user_id', Auth::id());
        });
    }

    public function getBalanceAttribute(int $value): string
    {
        return Number::currency($value, in: 'IDR', precision: 0);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
