<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentNewsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                News::query()
                    ->with(['author.user', 'newsCategory'])
                    ->latest()
                    ->limit(6)
            )
            ->heading('Recent News (Berita Terbaru)')
            ->description('Daftar artikel yang baru saja diterbitkan di NewsPortal.')
            ->paginated(false)
            ->columns([
                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->imageHeight(40)
                    ->circular()
                    ->defaultImageUrl(asset('assets/img/Berita-Liburan.png')),

                TextColumn::make('title')
                    ->label('Judul Berita')
                    ->limit(45)
                    ->wrap()
                    ->weight('medium')
                    ->searchable(),

                TextColumn::make('author.user.name')
                    ->label('Author')
                    ->description(fn (News $record): string => '@' . ($record->author?->username ?? '-')),

                TextColumn::make('newsCategory.title')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->state(fn (News $record): string => $record->is_featured ? 'Featured' : 'Published')
                    ->color(fn (News $record): string => $record->is_featured ? 'warning' : 'success'),

                TextColumn::make('created_at')
                    ->label('Tanggal Terbit')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ]);
    }
}
