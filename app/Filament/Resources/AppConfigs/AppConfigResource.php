<?php

namespace App\Filament\Resources\AppConfigs;

use App\Filament\Resources\AppConfigs\Pages\EditAppConfig;
use App\Filament\Resources\AppConfigs\Pages\ListAppConfigs;
use App\Filament\Resources\AppConfigs\Schemas\AppConfigForm;
use App\Filament\Resources\AppConfigs\Tables\AppConfigsTable;
use App\Models\AppConfig;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AppConfigResource extends Resource
{
    protected static ?string $model = AppConfig::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Key;

    protected static ?string $recordTitleAttribute = 'key';
    protected static bool $canCreate = false;

    public static function form(Schema $schema): Schema
    {
        return AppConfigForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppConfigsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAppConfigs::route('/'),
            'edit' => EditAppConfig::route('/{record}/edit'),
        ];
    }
}
