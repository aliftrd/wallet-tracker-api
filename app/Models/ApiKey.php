<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ApiKey extends Model
{
    protected $fillable = [
        'name',
        'key',
        'status'
    ];

    public function scopeFindActiveKey($query, string $key): Builder
    {
        return $query->where('key', $key)
            ->where('status', true);
    }
}
