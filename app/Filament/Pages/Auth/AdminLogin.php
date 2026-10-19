<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

class AdminLogin extends BaseLogin
{
    public function mount(): void
    {
        if (Filament::auth()->check()) {
            if (! auth()->user()->isAdmin()) {
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
        return 'Login Admin — NewsPortal';
    }

    public function getHeading(): string | Htmlable
    {
        return 'Masuk Admin Panel';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return new HtmlString(
            'Khusus Administrator. Bukan Admin? <a href="' . url('/author/login') . '" class="text-[#528270] hover:text-[#3e6657] dark:hover:text-[#88b5a3] font-medium transition-colors">Masuk sebagai Penulis &rarr;</a>'
        );
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

        // Enforce role check: MUST be admin
        if (! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            throw ValidationException::withMessages([
                'data.email' => 'Akses ditolak. Halaman login ini khusus untuk Administrator. Akun Penulis (Author) silakan login melalui halaman Author.',
            ]);
        }

        $adminPanel = Filament::getPanel('admin');
        if (! $authGuard->attemptWhen($credentials, function ($user) use ($adminPanel): bool {
            return $user->isAdmin() && $user->canAccessPanel($adminPanel);
        }, $data['remember'] ?? false)) {
            $this->fireFailedEvent($authGuard, $user, $credentials);
            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
