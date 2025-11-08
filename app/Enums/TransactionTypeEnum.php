<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum TransactionTypeEnum: string implements HasLabel, HasColor, HasIcon
{
    case INCOME = 'income';
    case EXPENSE = 'expense';

    public function getLabel(): string
    {
        return match ($this) {
            self::INCOME => 'Income',
            self::EXPENSE => 'Expense',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::INCOME => 'success',
            self::EXPENSE => 'danger',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::INCOME => Heroicon::ArrowDownCircle,
            self::EXPENSE => Heroicon::ArrowUpCircle,
        };
    }
}
