<?php

namespace App\Exports;

use App\Models\Anime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use function PHPSTORM_META\map;

class AnimeExport implements FromQuery, WithHeadings, WithMapping
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Anime::with([
    //         'genres', 'producers', 'licensors', 'studios'
    //     ])->get();
    // }

    use Exportable;

    public function query()
    {
        return Anime::query()->with([
            'genres', 'producers', 'licensors', 'studios'
        ])->orderBy('id');
    }

    public function headings(): array
    {
        return [   
            'anime_id',
            'title',
            'genres',
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
            $anime->studios->pluck('name')->implode(', '),
            $anime->source,
            $anime->rating,
            $anime->type
        ];
    }
}