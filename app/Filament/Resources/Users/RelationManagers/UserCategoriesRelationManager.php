<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\UserCategories\Tables\UserCategoriesTable;
use App\Filament\Resources\UserCategories\Schemas\UserCategoryForm;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\CreateAction;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UserCategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    public function form(Schema $schema): Schema
    {
        return UserCategoryForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return UserCategoriesTable::configure($table)
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
