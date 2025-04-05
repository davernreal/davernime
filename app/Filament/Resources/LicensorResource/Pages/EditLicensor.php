<?php

namespace App\Filament\Resources\LicensorResource\Pages;

use App\Filament\Resources\LicensorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLicensor extends EditRecord
{
    protected static string $resource = LicensorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = \Illuminate\Support\Str::snake($data['name']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
