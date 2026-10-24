<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function author(){
        return $this->hasOne(Author::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->author?->avatar_url ?? asset('assets/img/profile.png');
    }

    protected static function booted(): void
    {
        // Penghapusan diblokir selama User masih memiliki profil Author,
        // agar atribusi berita tidak menjadi yatim.
        static::deleting(function (User $user): bool {
            return ! $user->author()->exists();
        });
    }

    public function isAdmin(){
        return $this->role === 'admin';
    }

    public function isAuthor(){
        return $this->role === 'author';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }

        if ($panel->getId() === 'author') {
            return $this->isAuthor();
        }

        return false;
    }
}
