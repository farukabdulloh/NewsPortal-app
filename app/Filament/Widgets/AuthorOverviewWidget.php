<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AuthorOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Author::query()
                    ->with('user')
                    ->withCount('news')
                    ->latest()
                    ->limit(5)
            )
            ->heading('Author Overview (Penulis)')
            ->description('Ringkasan jurnalis dan produktivitas artikel.')
            ->paginated(false)
            ->columns([
                ImageColumn::make('avatar')
                    ->disk('public')
                    ->imageHeight(38)
                    ->circular()
                    ->defaultImageUrl(asset('assets/img/profile.png')),

                TextColumn::make('user.name')
                    ->label('Nama Penulis')
                    ->description(fn (Author $record): string => '@' . $record->username)
                    ->weight('medium'),

                TextColumn::make('news_count')
                    ->label('Artikel')
                    ->badge()
                    ->color('success'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->state(fn (): string => 'Aktif')
                    ->color('success'),
            ]);
    }
}
