<?php

namespace App\Filament\Resources\News\Schemas;

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
                    ->relationship('author', 'username')
                    ->required()
                    ->options(function(){
                        $user = auth()->user();
                        if ($user->isAdmin()){
                            return Author::pluck('username','id');
                        } elseif($user->author){
                            return [$user->author->id => $user->author->username];
                        };
                        return[];
                    })
                     ->default (function(){
                          $user = auth()->user();
                          return $user->author ? $user->author->id : null;
                     })
                     ->disabled(function(){
                        $user = auth()->user();
                        return !$user->isAdmin();   
                     }),
                Select::make('news_category_id')
                    ->relationship('newsCategory', 'title')
                    ->required(),
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->readOnly(),
                FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('thumbnails')
                    ->visibility('public')
                    ->required(),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(), 
            ]);
    }
}
