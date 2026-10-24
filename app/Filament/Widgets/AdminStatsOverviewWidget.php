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

    protected function getColumns(): int | array | null
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 3,
            'xl' => 6,
        ];
    }
    protected function getStats(): array
    {
        $totalNews = News::count();
        $publishedNews = $totalNews; // all active news in portal are published
        $draftNews = 0; // ready status
        $totalAuthors = Author::count();
        $featuredNews = News::where('is_featured', true)->count();
        $totalViews = News::sum('view_count');

        return [
            Stat::make('Total News', $totalNews)
                ->icon('heroicon-o-newspaper')
                ->description('Total artikel berita')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('primary')
                ->chart([3, 5, 7, 6, 8, 9, $totalNews]),

            Stat::make('Total Views', $totalViews)
                ->icon('heroicon-o-eye')
                ->description('Total pembukaan halaman berita')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('primary'),

            Stat::make('Published News', $publishedNews)
                ->icon('heroicon-o-check-circle')
                ->description('Artikel telah rilis')
                ->descriptionIcon('heroicon-o-check')
                ->color('success')
                ->chart([2, 4, 6, 7, 7, 8, $publishedNews]),

            Stat::make('Draft News', $draftNews)
                ->icon('heroicon-o-document-text')
                ->description('Draft berita (Ready)')
                ->descriptionIcon('heroicon-o-clock')
                ->color('gray'),

            Stat::make('Total Authors', $totalAuthors)
                ->icon('heroicon-o-user-group')
                ->description('Jurnalis terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('info')
                ->chart([1, 2, 2, 3, 3, 4, $totalAuthors]),

            Stat::make('Featured News', $featuredNews)
                ->icon('heroicon-o-star')
                ->description('Artikel unggulan aktif')
                ->descriptionIcon('heroicon-o-sparkles')
                ->color('warning'),
        ];
    }
}
