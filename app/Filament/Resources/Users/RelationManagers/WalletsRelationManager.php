<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Wallets\Schemas\WalletForm;
use App\Filament\Resources\Wallets\Tables\WalletsTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\CreateAction;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class WalletsRelationManager extends RelationManager
{
    protected static string $relationship = 'wallets';

    public function form(Schema $schema): Schema
    {
        return WalletForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return WalletsTable::configure($table)
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
