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
    case TRANSFER = 'transfer';

    public function getLabel(): string
    {
        return match ($this) {
            self::INCOME => 'Income',
            self::EXPENSE => 'Expense',
            self::TRANSFER => 'Transfer',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::INCOME => 'success',
            self::EXPENSE => 'danger',
            self::TRANSFER => 'warning',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::INCOME => Heroicon::ArrowDownCircle,
            self::EXPENSE => Heroicon::ArrowUpCircle,
            self::TRANSFER => Heroicon::ArrowRightCircle,
        };
    }
}
