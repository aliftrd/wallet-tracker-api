<?php

namespace App\Models;

use App\Enums\CategoryTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    public $casts = [
        'type' => CategoryTypeEnum::class,
    ];
}
