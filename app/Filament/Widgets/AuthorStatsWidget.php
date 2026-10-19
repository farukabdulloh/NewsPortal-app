<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AuthorStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $author = auth()->user()?->author;
        $authorId = $author?->id;

        $myTotalNews = $authorId ? News::where('author_id', $authorId)->count() : 0;
        $myFeatured = $authorId ? News::where('author_id', $authorId)->where('is_featured', true)->count() : 0;
        $categoriesUsed = $authorId ? News::where('author_id', $authorId)->distinct('news_category_id')->count('news_category_id') : 0;

        return [
            Stat::make('Total Artikel Saya', $myTotalNews)
                ->description('Artikel yang telah ditulis')
                ->descriptionIcon('heroicon-o-newspaper')
                ->color('primary')
                ->chart([1, 2, 3, 4, $myTotalNews]),

            Stat::make('Artikel Unggulan', $myFeatured)
                ->description('Dipilih sebagai Berita Utama')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning'),

            Stat::make('Kategori Digunakan', $categoriesUsed)
                ->description('Topik berita yang dijangkau')
                ->descriptionIcon('heroicon-o-bookmark')
                ->color('info'),
        ];
    }
}
