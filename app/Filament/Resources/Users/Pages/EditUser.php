<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $authorUsername = $data['author_username'] ?? null;
        unset($data['author_username']);

        $record->update($data);

        if ($record instanceof User && $record->role === 'author' && filled($authorUsername)) {
            // updateOrCreate mencegah profil duplikat: cocokkan berdasarkan
            // user_id, perbarui username, dan biarkan avatar/bio tetap utuh.
            $record->author()->updateOrCreate(
                ['user_id' => $record->id],
                ['username' => $authorUsername],
            );
        }

        // Role berubah menjadi admin: profil Author yang ada dipertahankan
        // beserta seluruh atribusi beritanya, tidak dihapus maupun diubah.

        return $record;
    }
}
