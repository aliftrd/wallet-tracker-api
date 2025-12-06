<?php

namespace App\Filament\Resources\CategoryTemplates;

use App\Filament\Resources\CategoryTemplates\Pages\ListCategoryTemplates;
use App\Filament\Resources\CategoryTemplates\Schemas\CategoryTemplateForm;
use App\Filament\Resources\CategoryTemplates\Tables\CategoryTemplatesTable;
use App\Models\CategoryTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CategoryTemplateResource extends Resource
{
    protected static ?string $model = CategoryTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Tag;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Category';

    protected static UnitEnum|string|null $navigationGroup = 'Template';

    public static function form(Schema $schema): Schema
    {
        return CategoryTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoryTemplatesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategoryTemplates::route('/'),
        ];
    }
}
