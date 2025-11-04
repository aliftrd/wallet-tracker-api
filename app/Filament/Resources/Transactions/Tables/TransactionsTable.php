<?php

namespace App\Filament\Resources\Transactions\Tables;

use App\Enums\TransactionTypeEnum;
use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Resources\Users\RelationManagers\TransactionsRelationManager;
use App\Models\Transaction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\SelectFilter;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->hiddenOn(TransactionsRelationManager::class)
                    ->searchable(),
                TextColumn::make('wallet.name')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->visibleOn(TransactionsRelationManager::class)
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User')
                    ->preload()
                    ->multiple()
                    ->searchable(),
                SelectFilter::make('type')
                    ->options(TransactionTypeEnum::class)
                    ->preload()
                    ->searchable(),
                SelectFilter::make('category.name')
                    ->relationship(
                        name: 'category',
                        titleAttribute: 'name',
                        modifyQueryUsing: function ($query, Get $get) {
                            $userId = $get('user_id');
                            $type = $get('type');

                            if (!$userId || !$type) {
                                return $query;
                            }

                            return $query->where('user_id', $userId)->where('type', $type);
                        }
                    )
                    ->label('Category')
                    ->preload()
                    ->visibleOn(TransactionsRelationManager::class)
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->link()
                    ->hiddenLabel()
                    ->icon(Heroicon::ChevronRight)
                    ->url(fn(Transaction $record) => TransactionResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
