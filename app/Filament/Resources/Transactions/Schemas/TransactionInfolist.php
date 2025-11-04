<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Transaction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Transaction Information')
                    ->schema([
                        TextEntry::make('user.name'),
                        TextEntry::make('wallet.name')->label('Wallet'),
                        TextEntry::make('category.name')
                            ->label('Category')
                            ->color(fn(Transaction $record) => $record->category->color),
                        TextEntry::make('type')
                            ->badge()
                            ->color(fn(Transaction $record) => $record->type->getColor()),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
                Section::make('Transaction Details')
                    ->schema([
                        Group::make([
                            TextEntry::make('store_name'),
                            TextEntry::make('date')->dateTime(),
                            TextEntry::make('note')
                                ->color('warning')
                                ->placeholder('Tidak ada catatan')
                                ->columnSpanFull()
                        ])->columns(2),
                        RepeatableEntry::make('items')
                            ->schema([
                                TextEntry::make('name'),
                                TextEntry::make('quantity'),
                                TextEntry::make('price')->money('IDR'),
                                TextEntry::make('total_amount')->money('IDR'),
                            ])
                            ->placeholder('Tidak ada item')
                            ->columns(4),
                        Group::make([
                            TextEntry::make('tax_amount')->money('IDR'),
                            TextEntry::make('total_amount')->money('IDR'),
                        ])->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
