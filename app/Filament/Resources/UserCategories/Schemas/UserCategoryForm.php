<?php

namespace App\Filament\Resources\UserCategories\Schemas;

use App\Enums\CategoryTypeEnum;
use App\Filament\Resources\Users\RelationManagers\UserCategoriesRelationManager;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class UserCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->inlineLabel()
            ->components([
                Section::make('Category Details')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->preload()
                            ->searchable()
                            ->required()
                            ->hiddenOn(UserCategoriesRelationManager::class),
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
