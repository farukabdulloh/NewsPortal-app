<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'avatar',
        'cover',
        'bio'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function news(){
        return $this->hasMany(News::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            $cleanPath = ltrim(str_replace(['/storage/', 'storage/', 'public/'], '', $this->avatar), '/');
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
                return \Illuminate\Support\Facades\Storage::disk('public')->url($cleanPath);
            }
            if (file_exists(public_path('storage/' . $cleanPath))) {
                return asset('storage/' . $cleanPath);
            }
        }

        return asset('assets/img/profile.png');
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover) {
            $cleanPath = ltrim(str_replace(['/storage/', 'storage/', 'public/'], '', $this->cover), '/');
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
                return \Illuminate\Support\Facades\Storage::disk('public')->url($cleanPath);
            }
            if (file_exists(public_path('storage/' . $cleanPath))) {
                return asset('storage/' . $cleanPath);
            }
        }

        return asset('assets/img/bg-profile.png');
    }
}
