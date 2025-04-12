<?php

namespace App\Filament\Resources\AnimeResource\Pages;

use App\Filament\Resources\AnimeResource;
use App\Jobs\SendAnimeCsvToApi;
use App\Models\Source;
use App\Services\AnimeExportService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EditAnime extends EditRecord
{
    protected static string $resource = AnimeResource::class;

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (is_null($data['image_url'])) {
            unset($data['image_url']);
        }
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    protected function afterSave()
    {
        $timestamp = now()->timestamp;
        Cache::put('anime_job_timestamp', $timestamp);
        SendAnimeCsvToApi::dispatch($timestamp);
    }
}
