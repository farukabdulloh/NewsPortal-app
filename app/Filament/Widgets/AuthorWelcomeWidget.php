<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AuthorWelcomeWidget extends Widget
{
    protected string $view = 'filament.widgets.author-welcome-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function getAuthorName(): string
    {
        return auth()->user()?->name ?? 'Penulis';
    }

    public function getFormattedDate(): string
    {
        return now()->translatedFormat('l, d F Y');
    }
}
