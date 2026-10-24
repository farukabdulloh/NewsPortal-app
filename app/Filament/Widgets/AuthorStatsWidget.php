<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AuthorStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getColumns(): int | array | null
    {
        return [
            'default' => 1,
            'sm' => 2,
            'lg' => 4,
            'xl' => 4,
        ];
    }
    protected function getStats(): array
    {
        $author = auth()->user()?->author;
        $authorId = $author?->id;

        $myTotalNews = $authorId ? News::where('author_id', $authorId)->count() : 0;
        $myTotalViews = $authorId ? (int) News::where('author_id', $authorId)->sum('view_count') : 0;
        $myFeatured = $authorId ? News::where('author_id', $authorId)->where('is_featured', true)->count() : 0;
        $categoriesUsed = $authorId ? News::where('author_id', $authorId)->distinct('news_category_id')->count('news_category_id') : 0;

        return [
            Stat::make('Total Artikel Saya', $myTotalNews)
                ->icon('heroicon-o-newspaper')
                ->description('Artikel yang telah ditulis')
                ->descriptionIcon('heroicon-o-pencil-square')
                ->color('primary')
                ->chart([1, 2, 3, 4, $myTotalNews]),

            Stat::make('Total Views Saya', $myTotalViews)
                ->icon('heroicon-o-eye')
                ->description('Pembukaan halaman artikel Anda')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('success'),

            Stat::make('Artikel Unggulan', $myFeatured)
                ->icon('heroicon-o-star')
                ->description('Dipilih sebagai Berita Utama')
                ->descriptionIcon('heroicon-o-sparkles')
                ->color('warning'),

            Stat::make('Kategori Digunakan', $categoriesUsed)
                ->icon('heroicon-o-bookmark')
                ->description('Topik berita yang dijangkau')
                ->descriptionIcon('heroicon-o-tag')
                ->color('info'),
        ];
    }
}
