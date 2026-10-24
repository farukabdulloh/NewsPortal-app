<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Author;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->maxLength(200)
                    ->required(),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(200)
                    ->unique(ignoreRecord: true),

                Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'author' => 'Author',
                    ])
                    ->required()
                    ->default('author')
                    ->live(),

                TextInput::make('author_username')
                    ->label('Username Author')
                    ->helperText('Nama unik penulis untuk halaman publik, mis. budisantoso.')
                    ->visible(fn (Get $get): bool => $get('role') === 'author')
                    ->required(fn (Get $get): bool => $get('role') === 'author')
                    ->maxLength(200)
                    ->regex('/^[a-zA-Z0-9_.-]+$/')
                    ->unique(
                        table: Author::class,
                        column: 'username',
                        ignorable: fn (?User $record): ?Author => $record?->author,
                    )
                    ->afterStateHydrated(
                        fn (TextInput $component, ?User $record) => $component->state($record?->author?->username)
                    ),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->minLength(8)
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),

                Toggle::make('email_verified_at')
                    ->label('Email Terverifikasi')
                    ->dehydrated(true)
                    ->afterStateHydrated(function ($component, $state) {
                        $component->state($state !== null);
                    })
                    ->dehydrateStateUsing(function ($state) {
                        return $state ? now() : null;
                    }),
            ]);
    }
}
