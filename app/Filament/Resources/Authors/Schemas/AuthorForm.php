<?php

namespace App\Filament\Resources\Authors\Schemas;

use App\Models\Author;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->options(function (?Author $record): array {
                        // Hanya User ber-role author; user milik record yang
                        // sedang diedit tetap disertakan agar relasi lama
                        // tidak hilang dari pilihan.
                        return User::query()
                            ->where('role', 'author')
                            ->when($record?->user_id, fn ($query, int $userId) => $query->orWhere('id', $userId))
                            ->pluck('name', 'id')
                            ->all();
                    })
                    ->searchable()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('username')
                    ->required()
                    ->maxLength(200)
                    ->regex('/^[a-zA-Z0-9_.-]+$/')
                    ->unique(ignoreRecord: true),
                FileUpload::make('avatar')
                     ->image()
                     ->disk('public')
                     ->directory('avatars')
                     ->visibility('public'),
                Textarea::make('bio')
                    ->columnSpanFull(),
            ]);
    }
}
