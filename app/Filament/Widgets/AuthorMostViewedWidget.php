<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AuthorMostViewedWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $authorId = auth()->user()?->author?->id ?? 0;

        return $table
            ->query(
                News::query()
                    ->with('newsCategory')
                    ->where('author_id', $authorId)
                    ->orderByDesc('view_count')
                    ->limit(5)
            )
            ->heading('Berita Terpopuler Saya')
            ->description('Artikel Anda dengan pembukaan halaman terbanyak.')
            ->paginated(false)
            ->defaultSort('view_count', 'desc')
            ->columns([
                TextColumn::make('view_count')
                    ->label('Views')
                    ->numeric()
                    ->alignEnd()
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->imageHeight(40)
                    ->circular()
                    ->defaultImageUrl(asset('assets/img/Berita-Liburan.png')),

                TextColumn::make('title')
                    ->label('Judul Berita')
                    ->limit(50)
                    ->weight('medium')
                    ->searchable(),

                TextColumn::make('newsCategory.title')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),

                TextColumn::make('is_featured')
                    ->label('Status')
                    ->badge()
                    ->state(fn (News $record): string => $record->is_featured ? 'Featured' : 'Published')
                    ->color(fn (News $record): string => $record->is_featured ? 'warning' : 'success'),

                TextColumn::make('created_at')
                    ->label('Tanggal Terbit')
                    ->dateTime('d M Y'),
            ]);
    }
}
