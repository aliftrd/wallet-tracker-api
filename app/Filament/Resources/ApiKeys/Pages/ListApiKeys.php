<?php

namespace App\Filament\Resources\ApiKeys\Pages;

use App\Filament\Resources\ApiKeys\ApiKeyResource;
use App\Filament\Resources\ApiKeys\Schemas\ApiKeyForm;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListApiKeys extends ListRecords
{
    protected static string $resource = ApiKeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false)
                ->modalWidth('sm')
                ->mutateDataUsing(function (array $data): array {
                    $data['key'] = ApiKeyForm::generateKey();
                    return $data;
                })
                ->after(function ($record) {
                    Notification::make()
                        ->title('API Key Created')
                        ->body("API Key: <span class='font-mono'>{$record->key}</span>")
                        ->success()
                        ->icon(Heroicon::OutlinedKey)
                        ->duration(10000)
                        ->send();
                }),
        ];
    }
}
