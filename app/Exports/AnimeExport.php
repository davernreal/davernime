<?php

namespace App\Exports;

use App\Models\Anime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use function PHPSTORM_META\map;

class AnimeExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Anime::with([
            'genres', 'producers', 'licensors', 'studios'
        ])->get();
    }

    public function headings(): array
    {
        return [   
            'anime_id',
            'name',
            'genres',
            'licensors',
            'producers',
            'studios',
            'source',
            'rating',
            'type'
        ];
    }

    public function map($anime): array
    {
        return [
            $anime->anime_id,
            $anime->title,
            $anime->genres->pluck('name')->implode(', '),
            $anime->licensors->pluck('name')->implode(', '),
            $anime->studios->pluck('name')->implode(', '),
            $anime->producers->pluck('name')->implode(', '),
            $anime->source,
            $anime->rating,
            $anime->type
        ];
    }
}
