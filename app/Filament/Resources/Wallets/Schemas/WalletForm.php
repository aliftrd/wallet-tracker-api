<?php

namespace App\Filament\Resources\Wallets\Schemas;

use App\Filament\Resources\Users\RelationManagers\WalletsRelationManager;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

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
                            ->required()
                            ->hiddenOn(WalletsRelationManager::class),
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('balance')
                            ->required()
                            ->numeric(),
                        ColorPicker::make('color')
                            ->required(),
                        TextInput::make('icon')
                            ->helperText(
                                new HtmlString('You can find the icon code point in <a href="https://api.flutter.dev/flutter/material/Icons-class.html" target="_blank">here</a>.')
                            )
                            ->required(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
