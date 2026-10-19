<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\News;
use App\Models\NewsCategory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalNews = News::count();
        $publishedNews = $totalNews; // all active news in portal are published
        $draftNews = 0; // ready status
        $totalAuthors = Author::count();
        $featuredNews = News::where('is_featured', true)->count();

        return [
            Stat::make('Total News', $totalNews)
                ->description('Total artikel berita')
                ->descriptionIcon('heroicon-o-newspaper')
                ->color('primary')
                ->chart([3, 5, 7, 6, 8, 9, $totalNews]),

            Stat::make('Published News', $publishedNews)
                ->description('Artikel telah rilis')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->chart([2, 4, 6, 7, 7, 8, $publishedNews]),

            Stat::make('Draft News', $draftNews)
                ->description('Draft berita (Ready)')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('gray'),

            Stat::make('Total Authors', $totalAuthors)
                ->description('Jurnalis terdaftar')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info')
                ->chart([1, 2, 2, 3, 3, 4, $totalAuthors]),

            Stat::make('Featured News', $featuredNews)
                ->description('Artikel unggulan aktif')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning'),
        ];
    }
}
