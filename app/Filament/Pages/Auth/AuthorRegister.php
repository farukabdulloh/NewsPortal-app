<?php

namespace App\Filament\Pages\Auth;

use App\Models\Author;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;

class AuthorRegister extends BaseRegister
{
    public function getTitle(): string | Htmlable
    {
        return 'Registrasi Penulis — NewsPortal';
    }

    public function getHeading(): string | Htmlable
    {
        return 'Daftar sebagai Penulis';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return new HtmlString(
            'Bergabung bersama komunitas jurnalis NewsPortal. Sudah punya akun? <a href="' . url('/author/login') . '" class="text-[#528270] hover:text-[#3e6657] dark:hover:text-[#88b5a3] font-medium transition-colors">Masuk di sini &rarr;</a>'
        );
    }

    public function loginAction(): Action
    {
        return Action::make('login')
            ->link()
            ->label('Sudah punya akun? Masuk')
            ->url(url('/author/login'));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->placeholder('Contoh: Budi Santoso')
                    ->required()
                    ->maxLength(200),

                TextInput::make('username')
                    ->label('Username Publik')
                    ->placeholder('Contoh: budisantoso')
                    ->required()
                    ->maxLength(200)
                    ->regex('/^[a-zA-Z0-9_.-]+$/')
                    ->helperText('Hanya huruf, angka, tanda minus, garis bawah, dan titik.')
                    ->unique(Author::class, 'username'),

                TextInput::make('email')
                    ->label('Alamat E-mail')
                    ->placeholder('budi@example.com')
                    ->email()
                    ->required()
                    ->maxLength(200)
                    ->unique(User::class, 'email'),

                TextInput::make('password')
                    ->label('Kata Sandi (Password)')
                    ->password()
                    ->revealable()
                    ->required()
                    ->minLength(8),

                TextInput::make('password_confirmation')
                    ->label('Konfirmasi Kata Sandi')
                    ->password()
                    ->revealable()
                    ->same('password')
                    ->required()
                    ->dehydrated(false),

                FileUpload::make('avatar')
                    ->label('Foto Profil / Avatar')
                    ->image()
                    ->disk('public')
                    ->directory('avatars')
                    ->visibility('public')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('400')
                    ->imageResizeTargetHeight('400')
                    ->required(),

                Textarea::make('bio')
                    ->label('Biodata Singkat (Bio)')
                    ->placeholder('Ceritakan keahlian, minat topik berita, atau latar belakang jurnalisme Anda...')
                    ->required()
                    ->maxLength(1000)
                    ->rows(3),
            ]);
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(5);
        } catch (\DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException $exception) {
            Notification::make()
                ->title('Terlalu banyak permintaan')
                ->body('Silakan coba kembali dalam ' . $exception->secondsUntilAvailable . ' detik.')
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        // 1. Create User with role hardcoded strictly to 'author'
        $user = User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'role'              => 'author',
            'email_verified_at' => now(),
        ]);

        // 2. Create Author Profile
        $avatarPath = is_array($data['avatar']) ? (reset($data['avatar']) ?: null) : ($data['avatar'] ?? null);

        Author::create([
            'user_id'  => $user->id,
            'username' => $data['username'],
            'avatar'   => $avatarPath,
            'bio'      => $data['bio'],
        ]);

        event(new Registered($user));

        // 3. Log the user into the author panel session
        Filament::auth()->login($user);

        session()->regenerate();

        Notification::make()
            ->title('Pendaftaran Penulis Berhasil')
            ->body('Selamat datang di NewsPortal! Akun Anda telah aktif.')
            ->success()
            ->send();

        return app(RegistrationResponse::class);
    }
}
