<?php

namespace App\Filament\Resources\StreamingPlatformResource\Pages;

use App\Filament\Resources\StreamingPlatformResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStreamingPlatform extends CreateRecord
{
    protected static string $resource = StreamingPlatformResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['logo'] = $data['logo_url'] ?? $data['logo'];
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
