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

    public function scopeActive($query): Builder
    {
        return $query->where('status', true);
    }
}
