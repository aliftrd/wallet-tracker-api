<?php

namespace App\Models;

use App\Enums\CategoryTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class UserCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'color',
        'icon',
    ];

    protected $casts = [
        'type' => CategoryTypeEnum::class,
    ];

    public function scopeFindByCurrentUser(Builder $query): Builder
    {
        return $query->where('user_id', Auth::id());
    }

    public function scopeOfType(Builder $query, CategoryTypeEnum $type): Builder
    {
        return $query->where('type', $type);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
