<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'avatar',
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
        if ($this->avatar && file_exists(public_path('storage/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }

        return asset('assets/img/profile.png');
    }
}
