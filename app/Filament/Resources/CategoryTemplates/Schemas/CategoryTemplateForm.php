<?php

namespace App\Filament\Resources\CategoryTemplates\Schemas;

use App\Enums\CategoryTypeEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(CategoryTypeEnum::class)
                    ->native(false)
                    ->required(),
            ])
            ->columns(1);
    }
}
