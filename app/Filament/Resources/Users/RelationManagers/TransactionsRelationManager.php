<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Transactions\Schemas\TransactionForm;
use App\Filament\Resources\Transactions\Tables\TransactionsTable;
use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\CreateAction;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    public function form(Schema $schema): Schema
    {
        return TransactionForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return TransactionsTable::configure($table)
            ->headerActions([
                CreateAction::make()
                    ->url(fn() => TransactionResource::getUrl('create', ['user_id' => $this->getOwnerRecord()->id])),
            ]);
    }
}
