<?php

namespace App\Filament\Resources\AnimeResource\Pages;

use App\Filament\Resources\AnimeResource;
use App\Models\Anime;
use App\Services\AnimeExportService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateAnime extends CreateRecord
{

    private bool $isSuccess = false;

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
        if ($this->isSuccess) {
            return $this->getResource()::getUrl('index');
        } else {
            return $this->getResource()::getUrl('create');
        }
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function afterCreate()
    {
        $record = $this->record;

        $csvPath = AnimeExportService::getCsvPath();

        if (! file_exists($csvPath)) {
            Notification::make()
                ->title('CSV file not found')
                ->danger()
                ->send();

            session()->flash('restore_form_data', $record->toArray());
            $record->delete();

            return redirect()->route('filament.admin.resources.animes.create');
        }

        try {
            // throw new \Exception("This is a forced exception to fail the code below.");

            $exportSuccess = AnimeExportService::exportToCsv();

            if (! $exportSuccess) {
                throw new \Exception("Failed to export CSV");
            }

            $response = Http::timeout(10)
                ->attach(
                    'dataset',
                    file_get_contents($csvPath),
                    'anime.csv'
                )
                ->post('http://127.0.0.1:5000/anime');

            if (! $response->successful()) {
                $this->isSuccess = false;
                throw new \Exception("API responded with error: " . $response->body());
            }

            Notification::make()
                ->title('Saved successfully!')
                ->success()
                ->body('Anime data has been saved')
                ->send();

            $this->isSuccess = true;
            return redirect()->route('filament.admin.resources.animes.index');
        } catch (\Throwable $e) {
            $this->isSuccess = false;
            Log::error('Gagal proses export / API: ' . $e->getMessage());

            Notification::make()
                ->title('Failed to process Anime')
                ->body('Error: ' . $e->getMessage())
                ->danger()
                ->send();

            session()->flash('restore_form_data', array_merge(
                $record->toArray(),
                [
                    'studio' => $record->studios()->pluck('id')->toArray(),
                    'genre' => $record->genres()->pluck('id')->toArray(),
                    'producer' => $record->producers()->pluck('id')->toArray(),
                    'licensor' => $record->licensors()->pluck('id')->toArray(),
                ]
            ));
            $record->delete();

            // dd($record->toArray());  

            return redirect()->route('filament.admin.resources.animes.create');
        }
    }
}
