<?php

namespace App\Filament\Resources\LicensorResource\Pages;

use App\Filament\Resources\LicensorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLicensor extends CreateRecord
{
    protected static string $resource = LicensorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = \Illuminate\Support\Str::snake($data['name']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
