<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AdminWelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.admin-welcome-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function getUserName(): string
    {
        return auth()->user()?->name ?? 'Administrator';
    }

    public function getFormattedDate(): string
    {
        return now()->translatedFormat('l, d F Y');
    }
}
