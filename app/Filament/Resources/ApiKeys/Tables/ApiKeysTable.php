<?php

namespace App\Filament\Resources\ApiKeys\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\ApiKeys\Schemas\ApiKeyForm;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ApiKeysTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                ToggleColumn::make('status'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->button()
                    ->modalWidth('sm')
                    ->color('warning'),
                Action::make('regenerate')
                    ->button()
                    ->color('danger')
                    ->icon(Heroicon::OutlinedKey)
                    ->action(function ($record) {
                        $record->key = ApiKeyForm::generateKey();
                        $record->save();

                        Notification::make()
                            ->title('API Key Regenerated')
                            ->body("API Key: <span class='font-mono'>{$record->key}</span>")
                            ->success()
                            ->icon(Heroicon::OutlinedKey)
                            ->duration(10000)
                            ->send();
                    }),
                DeleteAction::make()
                    ->button()
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
