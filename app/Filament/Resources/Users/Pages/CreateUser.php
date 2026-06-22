<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Diasble "Create Another" button
    protected static bool $canCreateAnother = false;

    // Redirect to resource index after form action
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // After creating a record, mark email as verified
    protected function afterCreate() : void{
        $this->record->email_verified_at = now();
        $this->record->save();
    }
}
