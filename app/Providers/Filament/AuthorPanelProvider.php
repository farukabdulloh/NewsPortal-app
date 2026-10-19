<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\AuthorLogin;
use App\Filament\Pages\Auth\AuthorRegister;
use App\Filament\Resources\News\NewsResource;
use App\Filament\Widgets\AuthorRecentNewsWidget;
use App\Filament\Widgets\AuthorStatsWidget;
use App\Filament\Widgets\AuthorWelcomeWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AuthorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('author')
            ->path('author')
            ->homeUrl('/')
            ->login(AuthorLogin::class)
            ->registration(AuthorRegister::class)
            ->brandName('NewsPortal Penulis')
            ->brandLogo(asset('assets/img/Logo.png'))
            ->brandLogoHeight('2rem')
            ->colors([
                'primary' => Color::hex('#528270'),
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.custom-theme')
            )
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn () => view('filament.auth.back-button')
            )
            ->renderHook(
                PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE,
                fn () => view('filament.auth.back-button')
            )
            ->resources([
                NewsResource::class,
            ])
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                AuthorWelcomeWidget::class,
                AuthorStatsWidget::class,
                AuthorRecentNewsWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
