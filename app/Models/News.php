<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'author_id',
        'news_category_id',
        'title',
        'slug',
        'thumbnail',
        'content',
        'is_featured'
    ];

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function newsCategory(){
        return $this->belongsTo(NewsCategory::class);
    }

    public function banner(){
        return $this->hasOne(Banner::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            $cleanPath = ltrim(str_replace(['/storage/', 'storage/', 'public/'], '', $this->thumbnail), '/');
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
                return \Illuminate\Support\Facades\Storage::disk('public')->url($cleanPath);
            }
            if (file_exists(public_path('storage/' . $cleanPath))) {
                return asset('storage/' . $cleanPath);
            }
        }

        return asset('assets/img/Berita-Liburan.png');
    }
}
