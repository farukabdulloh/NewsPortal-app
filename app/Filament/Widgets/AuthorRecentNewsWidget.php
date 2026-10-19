<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AuthorRecentNewsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $authorId = auth()->user()?->author?->id ?? 0;

        return $table
            ->query(
                News::query()
                    ->with('newsCategory')
                    ->where('author_id', $authorId)
                    ->latest()
                    ->limit(6)
            )
            ->heading('Artikel Terbaru Saya')
            ->description('Daftar tulisan terbaru Anda yang telah terbit.')
            ->paginated(false)
            ->columns([
                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->imageHeight(40)
                    ->circular()
                    ->defaultImageUrl(asset('assets/img/Berita-Liburan.png')),

                TextColumn::make('title')
                    ->label('Judul Berita')
                    ->limit(50)
                    ->weight('medium'),

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
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i'),
            ]);
    }
}
