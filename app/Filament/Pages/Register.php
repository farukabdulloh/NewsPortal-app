<?php

namespace App\Filament\Pages;

use App\Models\Author;
use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Exceptions\TooManyRequestsException;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),

                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(200)
                    ->unique(Author::class, 'username'),

                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->maxLength(200)
                    ->unique(User::class, 'email'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(8),

                TextInput::make('password_confirmation')
                    ->label('Konfirmasi Password')
                    ->password()
                    ->same('password')
                    ->required()
                    ->dehydrated(false),

                FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image()
                    ->disk('public')
                    ->directory('avatars')
                    ->required(),

                Textarea::make('bio')
                    ->label('Bio')
                    ->required()
                    ->maxLength(1000)
                    ->rows(3),
            ]);
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title('Terlalu banyak aksi')
                ->body('Silakan coba lagi dalam ' . $exception->secondsUntilAvailable . ' detik.')
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'author',
        ]);

        Author::create([
            'user_id'  => $user->id,
            'username' => $data['username'],
            'avatar'   => $data['avatar'],
            'bio'      => $data['bio'],
        ]);

        event(new Registered($user));

        $this->form->fill();

        Notification::make()
            ->title('Registrasi Berhasil')
            ->success()
            ->send();

        return app(RegistrationResponse::class);
    }
}