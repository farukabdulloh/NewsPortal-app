<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

class AuthorLogin extends BaseLogin
{
    public function mount(): void
    {
        if (Filament::auth()->check()) {
            if (! auth()->user()->isAuthor()) {
                Filament::auth()->logout();
                session()->invalidate();
                session()->regenerateToken();
            } else {
                redirect()->intended(Filament::getUrl());
            }
        }

        $this->form->fill();
    }

    public function getTitle(): string | Htmlable
    {
        return 'Login Penulis (Author) — NewsPortal';
    }

    public function getHeading(): string | Htmlable
    {
        return 'Masuk Panel Penulis';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return new HtmlString(
            'Belum punya akun? <a href="' . url('/author/register') . '" class="text-[#528270] hover:text-[#3e6657] dark:hover:text-[#88b5a3] font-semibold transition-colors">Daftar sebagai Penulis</a> &bull; Administrator? <a href="' . url('/admin/login') . '" class="text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">Login Admin &rarr;</a>'
        );
    }

    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->label('Belum punya akun? Daftar sebagai Penulis')
            ->url(url('/author/register'));
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (\DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        /** @var \Illuminate\Auth\SessionGuard $authGuard */
        $authGuard = Filament::auth();

        $authProvider = $authGuard->getProvider();
        $credentials = $this->getCredentialsFromFormData($data);

        $user = $authProvider->retrieveByCredentials($credentials);

        if ((! $user) || (! $authProvider->validateCredentials($user, $credentials))) {
            $this->userUndertakingMultiFactorAuthentication = null;

            $this->fireFailedEvent($authGuard, $user, $credentials);
            $this->throwFailureValidationException();
        }

        // Enforce role check: MUST be author
        if (! method_exists($user, 'isAuthor') || ! $user->isAuthor()) {
            throw ValidationException::withMessages([
                'data.email' => 'Akses ditolak. Halaman login ini khusus untuk Author/Penulis. Akun Administrator silakan login melalui halaman Admin.',
            ]);
        }

        $authorPanel = Filament::getPanel('author');
        if (! $authGuard->attemptWhen($credentials, function ($user) use ($authorPanel): bool {
            return $user->isAuthor() && $user->canAccessPanel($authorPanel);
        }, $data['remember'] ?? false)) {
            $this->fireFailedEvent($authGuard, $user, $credentials);
            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
