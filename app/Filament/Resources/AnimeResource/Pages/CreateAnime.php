<?php

namespace App\Filament\Resources\AnimeResource\Pages;

use App\Filament\Resources\AnimeResource;
use App\Models\Anime;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAnime extends CreateRecord
{
    protected static string $resource = AnimeResource::class;

    protected function getFormActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['anime_id'] = Anime::max('anime_id') + 1;
        // dd($data);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
