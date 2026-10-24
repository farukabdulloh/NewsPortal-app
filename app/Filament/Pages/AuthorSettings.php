<?php

namespace App\Filament\Pages;

use App\Models\Author;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Auth\Pages\EditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Panel;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AuthorSettings extends EditProfile
{
    protected static bool $isDiscovered = false;

    protected static bool $shouldRegisterNavigation = true;

    protected Width | string | null $maxWidth = '4xl';

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::Cog6Tooth;

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Author Settings';

    protected static ?int $navigationSort = 99;

    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user && method_exists($user, 'isAuthor') && $user->isAuthor();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return 'settings';
    }

    public static function getRelativeRouteName(Panel $panel): string
    {
        return 'profile';
    }

    public static function registerRoutes(Panel $panel): void
    {
        \Illuminate\Support\Facades\Route::name('auth.')->group(fn () => static::routes($panel));
    }

    public function getTitle(): string | Htmlable
    {
        return 'Author Settings — Pengaturan Penulis';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'Perbarui foto profil, foto sampul, biodata diri, serta keamanan kata sandi akun Anda.';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                View::make('filament.pages.author-settings-header'),
                $this->getFormContentComponent(),
            ]);
    }

    public function getFormContentComponent(): Component
    {
        return parent::getFormContentComponent()
            ->extraAttributes(['class' => 'np-settings-form']);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil & Foto Sampul')
                    ->description('Kelola foto profil, foto sampul/cover, dan informasi biodata yang tampil ke publik.')
                    ->schema([
                        FileUpload::make('cover')
                            ->label('Foto Sampul / Cover')
                            ->image()
                            ->disk('public')
                            ->directory('covers')
                            ->visibility('public')
                            ->imagePreviewHeight('120')
                            ->helperText('Rekomendasi rasio banner 16:9 (format JPG, PNG, WEBP). Foto sampul default NewsPortal otomatis digunakan jika belum diunggah.')
                            ->columnSpan(1),

                        FileUpload::make('avatar')
                            ->label('Foto Profil (Avatar)')
                            ->image()
                            ->disk('public')
                            ->directory('avatars')
                            ->visibility('public')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400')
                            ->imagePreviewHeight('96')
                            ->helperText('Foto profil rasio 1:1. Preview foto langsung terlihat sebelum disimpan.')
                            ->columnSpan(1),

                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(200)
                            ->helperText('Nama yang dicantumkan pada publikasi berita Anda.'),

                        TextInput::make('username')
                            ->label('Username Publik')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Username unik penulis Anda di halaman publik NewsPortal.'),

                        Textarea::make('bio')
                            ->label('Biodata Penulis (Bio)')
                            ->rows(4)
                            ->maxLength(1000)
                            ->placeholder('Tuliskan pengenalan diri, minat topik berita, atau latar belakang keahlian Anda...')
                            ->helperText('Bio akan ditampilkan di kartu profil penulis Anda.')
                            ->columnSpanFull(),
                    ])
                    ->columns(['default' => 1, 'lg' => 2]),

                Section::make('Ubah Kata Sandi (Password)')
                    ->description('Kosongkan semua kolom di bawah ini jika Anda tidak ingin mengganti kata sandi akun.')
                    ->schema([
                        TextInput::make('currentPassword')
                            ->label('Kata Sandi Saat Ini (Lama)')
                            ->password()
                            ->revealable()
                            ->required(fn (Get $get): bool => filled($get('password')))
                            ->rule(function () {
                                return function ($attribute, $value, $fail) {
                                    if (filled($value) && ! Hash::check($value, auth()->user()->password)) {
                                        $fail('Kata sandi lama yang Anda masukkan tidak sesuai.');
                                    }
                                };
                            })
                            ->helperText('Wajib dimasukkan jika hendak menentukan kata sandi baru.')
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        TextInput::make('password')
                            ->label('Kata Sandi Baru')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->same('passwordConfirmation')
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                            ->helperText('Minimal 8 karakter.')
                            ->validationMessages([
                                'same' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.',
                                'min'  => 'Kata sandi baru minimal harus 8 karakter.',
                            ]),

                        TextInput::make('passwordConfirmation')
                            ->label('Konfirmasi Kata Sandi Baru')
                            ->password()
                            ->revealable()
                            ->required(fn (Get $get): bool => filled($get('password')))
                            ->helperText('Ketik ulang kata sandi baru untuk memastikan kesesuaian.')
                            ->dehydrated(false),
                    ])
                    ->columns(['default' => 1, 'lg' => 2]),
            ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = $this->getUser();
        $author = $user->author;

        if ($author) {
            $data['username'] = $author->username;
            $data['bio'] = $author->bio;
            $data['avatar'] = $author->avatar;
            $data['cover'] = $author->cover;
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $bio = $data['bio'] ?? null;
        $avatar = $data['avatar'] ?? null;
        $cover = $data['cover'] ?? null;

        unset(
            $data['bio'],
            $data['avatar'],
            $data['cover'],
            $data['username'],
            $data['currentPassword'],
            $data['passwordConfirmation']
        );

        $avatarPath = is_array($avatar) ? (reset($avatar) ?: null) : ($avatar ?: null);
        $coverPath = is_array($cover) ? (reset($cover) ?: null) : ($cover ?: null);

        // Perbarui atribut User (nama dan kata sandi jika diisi)
        $userUpdate = [
            'name' => $data['name'],
        ];

        if (! empty($data['password'])) {
            $userUpdate['password'] = $data['password'];
        }

        $record->update($userUpdate);

        // Perbarui profil Author (bio, avatar, cover)
        if ($record instanceof User && $record->isAuthor()) {
            $author = $record->author;

            if (! $author) {
                $author = $record->author()->create([
                    'username' => \Illuminate\Support\Str::slug($record->name, '') ?: 'author_' . $record->id,
                ]);
            }

            $author->bio = $bio;
            $author->avatar = $avatarPath;
            $author->cover = $coverPath;
            $author->save();
        }

        return $record;
    }

    protected function sendSuccessNotification(): void
    {
        Notification::make()
            ->title('Pengaturan Berhasil Disimpan')
            ->body('Foto profil, foto sampul, biodata, dan profil Anda telah diperbarui dengan aman.')
            ->success()
            ->send();
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Simpan Perubahan')
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label('Batal')
            ->url(url('/author'))
            ->color('gray');
    }
}
