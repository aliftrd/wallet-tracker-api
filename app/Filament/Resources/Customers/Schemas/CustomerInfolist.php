<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Support\Icons\Heroicon;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email'),
                ImageEntry::make('avatar')
                    ->imageSize('sm')
                    ->circular(),
                IconEntry::make('email_verified_at')
                    ->label('Verified')
                    ->icon(fn($record) => $record->email_verified_at !== null ? Heroicon::OutlinedCheckCircle : Heroicon::OutlinedXCircle)
                    ->color(fn($record) => $record->email_verified_at !== null ? 'success' : 'danger')
                    ->getStateUsing(fn($record) => $record->email_verified_at !== null),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
