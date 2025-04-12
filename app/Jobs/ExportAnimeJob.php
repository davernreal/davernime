<?php

namespace App\Jobs;

use App\Exports\AnimeExport;
use App\Services\AnimeExportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExportAnimeJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $export = AnimeExportService::exportToCsv();
        if ($export) {
            Log::info('[SUCCESS] Success to export data to csv');
        } else {
            Log::error('[ERROR] Failed to export data to csv');
        }
    }
}
