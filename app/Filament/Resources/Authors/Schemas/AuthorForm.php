<?php

namespace App\Filament\Resources\Authors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required( ),
                TextInput::make('username')
                    ->required(),
                FileUpload::make('avatar')
                     ->image()
                     ->disk('public')
                     ->directory('avatars')
                     ->visibility('public')
                     ->required(),
                Textarea::make('bio')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
