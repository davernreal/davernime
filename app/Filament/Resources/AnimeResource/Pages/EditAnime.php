<?php

namespace App\Filament\Resources\AnimeResource\Pages;

use App\Filament\Resources\AnimeResource;
use App\Services\AnimeExportService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EditAnime extends EditRecord
{
    protected static string $resource = AnimeResource::class;

    protected function getFormActions(): array
    {
        return [];
    }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }

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

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }


    protected function afterSave()
    {
        // dd($this->record);
        $record = $this->record;

        $csvPath = AnimeExportService::getCsvPath();

        if (! file_exists($csvPath)) {
            Notification::make()
                ->title('CSV file not found')
                ->danger()
                ->send();

            session()->flash('restore_form_data', $record->toArray());

            return redirect()->route('filament.admin.resources.animes.edit', $record->anime_id);
        }
        try {
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
                $this->halt();
                throw new \Exception("API responded with error: " . $response->body());
            }

            Notification::make()
                ->title('Saved successfully!')
                ->success()
                ->body('Anime data has been saved')
                ->send();

            return redirect()->route('filament.admin.resources.animes.index');
        } catch (\Throwable $e) {
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
            $this->halt();
            return redirect()->route('filament.admin.resources.animes.edit', $record->anime_id);
        }   
    }
}
