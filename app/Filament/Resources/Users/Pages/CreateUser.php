<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $authorUsername = $data['author_username'] ?? null;
        unset($data['author_username']);

        $record = parent::handleRecordCreation($data);

        if ($record instanceof User && $record->role === 'author' && filled($authorUsername) && ! $record->author()->exists()) {
            $record->author()->create(['username' => $authorUsername]);
        }

        return $record;
    }
}
