<?php

namespace App\Filament\Pages;

use App\Filament\Resources\News\NewsResource;
use App\Models\News;
use Filament\Actions\EditAction;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class MostViewedNews extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::ChartBar;

    protected static ?string $navigationLabel = 'Most Viewed';

    protected static ?string $title = 'Most Viewed News';

    protected ?string $subheading = 'Berita dengan jumlah pembukaan halaman tertinggi.';

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                EmbeddedTable::make(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // Query terkurasi dari NewsResource: Admin melihat seluruh
            // berita, Author hanya beritanya sendiri (penegakan di sisi
            // server, bukan sekadar menyembunyikan UI).
            ->query(fn () => NewsResource::getEloquentQuery())
            ->defaultSort('view_count', 'desc')
            ->columns([
                TextColumn::make('view_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->alignEnd()
                    ->badge()
                    ->color('primary'),
                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->imageHeight(40)
                    ->circular()
                    ->defaultImageUrl(asset('assets/img/Berita-Liburan.png')),
                TextColumn::make('title')
                    ->label('Judul Berita')
                    ->limit(50)
                    ->weight('medium')
                    ->searchable(),
                TextColumn::make('author.user.name')
                    ->label('Author')
                    ->description(fn (News $record): string => '@' . ($record->author?->username ?? '-')),
                TextColumn::make('newsCategory.title')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),
                TextColumn::make('is_featured')
                    ->label('Status')
                    ->badge()
                    ->state(fn (News $record): string => $record->is_featured ? 'Featured' : 'Published')
                    ->color(fn (News $record): string => $record->is_featured ? 'warning' : 'success'),
                TextColumn::make('created_at')
                    ->label('Tanggal Terbit')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn (News $record): string => NewsResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
