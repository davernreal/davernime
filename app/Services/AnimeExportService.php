<?php

namespace App\Services;

use App\Exports\AnimeExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AnimeExportService
{

    public static function exportToCsv(string $path = 'dataset/anime.csv')
    {
        try {
            return Excel::store(new AnimeExport, $path, 'public', \Maatwebsite\Excel\Excel::CSV);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function getCsvPath(string $relativePath = 'dataset/anime.csv'): string
    {
        return Storage::disk('public')->path($relativePath);
    }
}
