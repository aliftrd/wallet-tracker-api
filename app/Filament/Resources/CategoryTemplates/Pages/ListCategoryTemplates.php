<?php

namespace App\Filament\Resources\CategoryTemplates\Pages;

use App\Filament\Resources\CategoryTemplates\CategoryTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategoryTemplates extends ListRecords
{
    protected static string $resource = CategoryTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false)
                ->modalWidth('sm'),
        ];
    }
}
