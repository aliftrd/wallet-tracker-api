<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Category;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $user = $this->record;
        foreach (Category::get() as $category) {
            $user->categories()->create([
                'name' => $category->name,
                'type' => $category->type,
                'color' => $category->color,
                'icon' => $category->icon,
            ]);
        }
    }
}
