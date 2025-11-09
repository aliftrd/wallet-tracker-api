<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum GenderEnum: string implements HasLabel, HasColor
{
    case MALE = 'male';
    case FEMALE = 'female';

    public function getLabel(): string
    {
        return match ($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::MALE => 'info',
            self::FEMALE => 'danger',
        };
    }
}
