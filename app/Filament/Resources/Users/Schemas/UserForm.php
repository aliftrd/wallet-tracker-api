<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\GenderEnum;
use Filament\Forms\Components\DatePicker;
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
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null),
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->getOptionLabelFromRecordUsing(fn(Role $record) => Str::headline($record->name))
                            ->multiple()
                            ->preload()
                            ->required()
                            ->searchable(),
                        Select::make('gender')
                            ->options(GenderEnum::class)
                            ->preload()
                            ->searchable(),
                        DatePicker::make('birth_date'),
                        TextInput::make('phone')
                            ->tel()
                            ->unique(ignoreRecord: true)
                            ->helperText('Input your phone number in 62xxxxxxxxxx format')
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
