<?php

namespace App\Filament\Resources\AppConfigs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class AppConfigForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Key and Value')
                    ->schema([
                        TextInput::make('key')
                            ->required(),
                        TextInput::make('description'),
                        MarkdownEditor::make('value')
                            ->label('Value')
                            ->required()
                            ->columnSpanFull()
                            ->visible(fn($record) => $record?->key === 'GEMINI_OCR_PROMPT'),
                        TextInput::make('value')
                            ->label('Value')
                            ->required()
                            ->columnSpanFull()
                            ->visible(fn($record) => $record?->key !== 'GEMINI_OCR_PROMPT'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
