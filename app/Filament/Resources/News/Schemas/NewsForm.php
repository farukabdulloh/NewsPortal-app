<?php

namespace App\Filament\Resources\News\Schemas;

use App\Models\Author;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'username')
                    ->required()
                    ->options(function(){
                        $user = auth()->user();
                        if ($user && $user->isAdmin()){
                            return Author::pluck('username','id');
                        } elseif($user && $user->author){
                            return [$user->author->id => $user->author->username];
                        };
                        return [];
                    })
                    ->default(function(){
                        $user = auth()->user();
                        return $user && $user->author ? $user->author->id : null;
                    })
                    ->disabled(function(){
                        $user = auth()->user();
                        return $user && !$user->isAdmin();   
                    })
                    ->dehydrated(true),
                Select::make('news_category_id')
                    ->label('Kategori')
                    ->relationship('newsCategory', 'title')
                    ->required(),
                TextInput::make('title')
                    ->label('Judul Berita')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->readOnly(),
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('thumbnails')
                    ->visibility('public')
                    ->required(),
                Toggle::make('is_featured')
                    ->label('Jadikan Berita Unggulan (Featured)')
                    ->default(false)
                    ->visible(fn () => auth()->user()?->isAdmin() ?? false),
                RichEditor::make('content')
                    ->label('Konten Berita')
                    ->required()
                    ->columnSpanFull(), 
            ]);
    }
}
