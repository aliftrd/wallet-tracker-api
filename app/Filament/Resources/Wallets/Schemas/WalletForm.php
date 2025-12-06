<?php

namespace App\Filament\Resources\Wallets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WalletForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('initial_balance')
                    ->required()
                    ->numeric(),
            ]);
    }
}
