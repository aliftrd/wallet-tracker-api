<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TransactionTypeEnum: string implements HasLabel, HasIcon, HasColor
{
    case INCOME = 'INCOME';
    case EXPENSE = 'EXPENSE';

    public function getLabel(): string
    {
        return match ($this) {
            self::INCOME => 'Income',
            self::EXPENSE => 'Expense',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::INCOME => 'heroicon-o-arrow-down',
            self::EXPENSE => 'heroicon-o-arrow-up',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::INCOME => 'success',
            self::EXPENSE => 'danger',
        };
    }
}
