<?php

namespace App\Filament\Resources\ProducerResource\Pages;

use App\Filament\Resources\ProducerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProducer extends CreateRecord
{
    protected static string $resource = ProducerResource::class;
    
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
