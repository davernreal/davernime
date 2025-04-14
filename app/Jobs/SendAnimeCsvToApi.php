<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\AnimeRecalculatedApiNotification;
use App\Services\AnimeExportService;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendAnimeCsvToApi implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $timestamp, public $user_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $latest = Cache::get('anime_job_timestamp');

        if ($this->timestamp < $latest) {
            Log::info('[SKIP] Old job skipped');
            print_r("Old job skipped" . PHP_EOL);
            return;
        }
        print_r("Exporting Anime to CSV..." . PHP_EOL);
        $export = AnimeExportService::exportToCsv();

        if ($export) {
            print_r("Exporting Anime to CSV success" . PHP_EOL);
            Log::info('[SUCCESS] Success to export data to CSV');
        } else {
            print_r("Exporting Anime to CSV error" . PHP_EOL);
            Log::error('[ERROR] Failed to export data to CSV');
            throw new \Exception('Failed to export data to CSV');
        }

        $csvPath = AnimeExportService::getCsvPath();

        if (!file_exists($csvPath)) {
            Log::error("[ERROR] CSV file not found at path: {$csvPath}");
            throw new \Exception("Cannot found CSV file at path {$csvPath}");
        }

        try {
            $response = Http::timeout(30)
                ->attach('dataset', file_get_contents($csvPath), 'anime.csv')
                ->post('http://127.0.0.1:5000/anime');

            if ($response->successful()) {
                Log::info('[SUCCESS] Successfully sent anime CSV to Flask API.');
                $admin = User::where('id', $this->user_id)->first();
                if ($admin) {
                    $admin->notify(new AnimeRecalculatedApiNotification());
                    Log::info('Creating the notification' . PHP_EOL);
                }
            } else {
                Log::error('[ERROR] Flask API error: ' . $response->body());
                throw new \Exception("API responded with error: " . $response->body());
            }
        } catch (\Throwable $th) {
            Log::error("[ERROR] Exception thrown while sending CSV: {$th->getMessage()}");
            throw new \Exception("Exception thrown while sending CSV: {$th->getMessage()}");
        }
    }
}
