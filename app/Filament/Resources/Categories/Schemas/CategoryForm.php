<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Enums\CategoryTypeEnum;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->inlineLabel()
            ->components([
                Section::make('Category Details')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        Select::make('type')
                            ->options(CategoryTypeEnum::class)
                            ->preload()
                            ->searchable()
                            ->required(),
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
