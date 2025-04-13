<?php

namespace App\Filament\Resources\AnimeResource\Pages;

use App\Filament\Resources\AnimeResource;
use App\Jobs\SendAnimeCsvToApi;
use App\Models\Anime;
use App\Models\Source;
use App\Services\AnimeExportService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $data['source'] = Source::find($data['source'])->name;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate()
    {
        $timestamp = now()->timestamp;
        Cache::put('anime_job_timestamp', $timestamp);
        SendAnimeCsvToApi::dispatch($timestamp, auth()->user()->id);
    }
}
