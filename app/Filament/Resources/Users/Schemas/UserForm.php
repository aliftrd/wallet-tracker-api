<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->inlineLabel()
            ->components([
                Section::make('Account Details')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->required(),
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->getOptionLabelFromRecordUsing(fn(Role $record) => Str::headline($record->name))
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['avatar'] = 'https://ui-avatars.com/api/?name=' . $data['name'];

        return $data;
    }
}
