<?php

namespace App\Filament\Resources\Wallets\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WalletForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->inlineLabel()
            ->components([
                Section::make('Wallet Details')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('balance')
                            ->required()
                            ->numeric(),
                        ColorPicker::make('color')
                            ->required(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
