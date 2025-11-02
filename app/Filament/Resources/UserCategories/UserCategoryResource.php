<?php

namespace App\Filament\Resources\UserCategories;

use App\Filament\Resources\UserCategories\Pages\CreateUserCategory;
use App\Filament\Resources\UserCategories\Pages\EditUserCategory;
use App\Filament\Resources\UserCategories\Pages\ListUserCategories;
use App\Filament\Resources\UserCategories\Schemas\UserCategoryForm;
use App\Filament\Resources\UserCategories\Tables\UserCategoriesTable;
use App\Models\UserCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserCategoryResource extends Resource
{
    protected static ?string $model = UserCategory::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Tag;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return UserCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserCategories::route('/'),
            'create' => CreateUserCategory::route('/create'),
            'edit' => EditUserCategory::route('/{record}/edit'),
        ];
    }
}
