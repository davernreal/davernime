<?php

namespace App\Filament\Resources\StreamingPlatformResource\Pages;

use App\Filament\Resources\StreamingPlatformResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStreamingPlatform extends EditRecord
{
    protected static string $resource = StreamingPlatformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (is_null($data['logo']) && is_null($data['logo_url'])) {
            unset($data['logo']);
            unset($data['logo_url']);
        } else {
            $data['logo'] = $data['logo_url'] ?? $data['logo'];
            unset($data['logo_url']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string|null
    {
        return $this->getResource()::getUrl('index');
    }
}
