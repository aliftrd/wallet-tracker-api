<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Enums\TransactionTypeEnum;
use App\Filament\Resources\Users\RelationManagers\TransactionsRelationManager;
use App\Models\UserCategory;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make()
                    ->steps([
                        static::getUserStep(),
                        static::getTypeAndCategoryStep(),
                        static::getTransactionDetailsStep(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function getUserStep(): Step
    {
        return Step::make('User')
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->preload()
                    ->searchable()
                    ->disabledOn('edit')
                    ->required(),
            ])
            ->hiddenOn(TransactionsRelationManager::class);
    }

    public static function getTypeAndCategoryStep(): Step
    {
        return Step::make('Type & Category')
            ->schema([
                Select::make('type')
                    ->options(TransactionTypeEnum::class)
                    ->live()
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(fn(Set $set) => $set('user_category_id', null)),
                Select::make('user_category_id')
                    ->label('Category')
                    ->options(function (Get $get, $livewire) {
                        $userId = $get('user_id');
                        $type = $get('type');

                        // If on TransactionsRelationManager, get user_id from parent
                        if (!$userId && $livewire instanceof TransactionsRelationManager) {
                            $userId = $livewire->getOwnerRecord()->id;
                        }

                        if (!$userId || !$type) {
                            return [];
                        }

                        return UserCategory::where('user_id', $userId)
                            ->where('type', $type)
                            ->pluck('name', 'id');
                    })
                    ->live()
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function getTransactionDetailsStep(): Step
    {
        return Step::make('Transaction Details')
            ->schema([
                Select::make('wallet_id')
                    ->relationship(
                        name: 'wallet',
                        titleAttribute: 'name',
                        modifyQueryUsing: function ($query, Get $get, $livewire) {
                            $userId = $get('user_id');

                            // If on TransactionsRelationManager, get user_id from parent
                            if (!$userId && $livewire instanceof TransactionsRelationManager) {
                                $userId = $livewire->getOwnerRecord()->id;
                            }

                            if ($userId) {
                                return $query->where('user_id', $userId);
                            }

                            return $query;
                        }
                    )
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} ({$record->balance})")
                    ->preload()
                    ->searchable()
                    ->required(),
                Group::make()
                    ->schema([
                        TextInput::make('store_name')
                            ->required(),
                        DateTimePicker::make('date')
                            ->required(),
                    ])
                    ->columns(2),
                Textarea::make('note'),
                static::getTransactionItemsFormField(),
                Group::make()
                    ->schema([
                        TextInput::make('tax_amount')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->prefix('IDR'),
                        TextInput::make('total_amount')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->prefix('IDR')
                            ->suffixAction(function () {
                                return Action::make('calculate')
                                    ->label('Calculate')
                                    ->icon(Heroicon::Calculator)
                                    ->action(function (Get $get, Set $set) {
                                        $items = $get('items') ?? [];
                                        $totalAmount = collect($items)
                                            ->sum(fn($item) => $item['total_amount'] ?? 0);
                                        $taxAmount = $get('tax_amount') ?? 0;
                                        $set('total_amount', $totalAmount + $taxAmount);
                                    });
                            }),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getTransactionItemsFormField(): Repeater
    {
        return Repeater::make('items')
            ->label('Items')
            ->relationship('items')
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('quantity')
                    ->numeric()
                    ->default(1)
                    ->required(),
                TextInput::make('price')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('total_amount')
                    ->default(0)
                    ->required()
                    ->prefix('IDR')
                    ->suffixAction(function () {
                        return Action::make('calculate')
                            ->label('Calculate')
                            ->icon(Heroicon::Calculator)
                            ->action(function (Get $get, Set $set) {
                                $totalAmount = $get('price') * $get('quantity');
                                $set('total_amount', $totalAmount);
                            });
                    })
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }
}
