<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class FeaturedNewsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                News::query()
                    ->with(['author.user', 'newsCategory'])
                    ->where('is_featured', true)
                    ->latest()
                    ->limit(5)
            )
            ->heading('Featured News (Berita Unggulan)')
            ->description('Artikel terpilih yang ditayangkan di banner utama.')
            ->paginated(false)
            ->columns([
                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->imageHeight(38)
                    ->circular()
                    ->defaultImageUrl(asset('assets/img/Berita-Liburan.png')),

                TextColumn::make('title')
                    ->label('Judul Berita')
                    ->limit(32)
                    ->weight('medium'),

                TextColumn::make('newsCategory.title')
                    ->label('Kategori')
                    ->badge()
                    ->color('warning'),

                TextColumn::make('author.user.name')
                    ->label('Penulis')
                    ->limit(18),

                TextColumn::make('created_at')
                    ->label('Rilis')
                    ->dateTime('d M Y'),
            ]);
    }
}
