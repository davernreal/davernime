<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use \App\Helper\Convert;
use App\Models\Anime;
use App\Models\Genre;
use App\Models\Licensor;
use App\Models\Producer;
use App\Models\Studio;
use Illuminate\Support\Facades\DB;

class AnimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = Storage::disk('public')->path('anime_cleaned.csv');
        $data = $this->readCSV($file);

        $anime = [];
        for ($i = 1; $i < (count($data) - 1); $i++) {
        // for ($i = 1; $i < 2; $i++) {
            print_r($data[$i]);

            if (strtoupper($data[$i][19]) === "UNKNOWN" || $data[$i][19] === "?" || $data[$i][19] === "") {
                $episodes = null;
            } else {
                $episodes = $data[$i][19];
            }

            if ($data[$i][17] === "Unknown" || strtolower($data[$i][17]) === "not available" || $data[$i][17] === "") {
                $aired = [null, null];
            } else {
                $aired = explode(' to ', $data[$i][17]);
            
                foreach ($aired as $index => $value) {
                    if ($value === '?' || empty($value)) {
                        $aired[$index] = null;
                    } elseif (preg_match('/^\d{4}$/', $value)) { 
                        $aired[$index] = Carbon::createFromFormat('Y-m-d', $value . '-01-01')->format('Y-m-d');
                    } else {
                        $aired[$index] = Carbon::parse($value)->format('Y-m-d');
                    }
                }

                $aired = array_pad($aired, 2, null);
            }

            $store = Anime::create([
                'anime_id' => $data[$i][1],
                'title' => $data[$i][2],
                'english_title' => strtolower(trim($data[$i][3])) == '' ? null : trim($data[$i][3]),
                'other_title' => strtolower(trim($data[$i][4])) == '' ? null : trim($data[$i][4]),
                'synopsis' => strtolower(trim($data[$i][11])) == '' ? null : trim($data[$i][11]),
                'type' => strtolower(trim($data[$i][7])) == '' ? 'unknown' : trim($data[$i][7]),
                'episodes' => $episodes,
                'source' => strtolower(trim($data[$i][5])) == '' ? null : trim($data[$i][5]),
                'aired_from' => $aired[0],
                'aired_to' => $aired[1],
                'duration' => strtolower(trim($data[$i][18])) == '' ? null : Convert::convertToTime([$data[$i][18]]),
                'premiered_season' => strtolower(trim($data[$i][15])) == '' ? null : trim($data[$i][15]),
                'premiered_year' => strtolower(trim($data[$i][16])) == '' ? null : trim($data[$i][16]),
                'rating' => strtolower(trim($data[$i][9])) == '' ? null : trim($data[$i][9]),
                'status' => strtolower(trim($data[$i][6])) == '' ? null : trim($data[$i][6]),
                'trailer_url' => strtolower(trim($data[$i][10])) == '' ? null : trim($data[$i][10]),
                'score' => strtolower(trim($data[$i][20])) == '' || strtolower(trim($data[$i][20])) == '' ? null : trim($data[$i][20]),
                'image_url' => strtolower(trim($data[$i][21])) == '' ? null : trim($data[$i][21])
            ]);

            $genres = explode(', ', $data[$i][8]);
            foreach ($genres as $item) {
                $genre = Genre::where('name', $item)->first();
                if ($genre) {
                    $store->genres()->attach($genre->id);
                }
            }

            $licensors = explode(', ', $data[$i][14]);
            foreach ($licensors as $item) {
                $licensor = Licensor::where('name', $item)->first();
                if ($licensor) {
                    $store->licensors()->attach($licensor->id);
                }
            }

            $studios = explode(', ', $data[$i][13]);
            foreach ($studios as $item) {
                $studio = Studio::where('name', $item)->first();
                if ($studio) {
                    $store->studios()->attach($studio->id);
                }
            }

            $producers = explode(', ', $data[$i][12]);
            foreach ($producers as $item) {
                $producer = Producer::where('name', $item)->first();
                if ($producer) {
                    $store->producers()->attach($producer->id);
                }
            }
        }
    }

    private function readCSV($csvFile, $delimiter = ',')
    {
        $file_handle = fopen($csvFile, 'r');
        while ($csvRow = fgetcsv($file_handle, null, $delimiter)) {
            $line_of_text[] = $csvRow;
        }
        fclose($file_handle);
        return $line_of_text;
    }

    private function import()
    {
        $file = Storage::path('anime-dataset-2023.csv');
        $data = $this->readCSV($file);

        $animeData = [];
        $animeGenres = [];
        $animeLicensors = [];
        $animeStudios = [];
        $animeProducers = [];

        // Fetch all existing records for related tables
        $genres = Genre::pluck('id', 'name')->toArray();
        $licensors = Licensor::pluck('id', 'name')->toArray();
        $studios = Studio::pluck('id', 'name')->toArray();
        $producers = Producer::pluck('id', 'name')->toArray();

        foreach (array_slice($data, 1, count($data) - 2) as $row) {
            $premiered = $row[10] === "UNKNOWN" ? [null, null] : explode(' ', $row[10]);
            $episodes = in_array($row[8], ["UNKNOWN", "?"]) ? null : (int) $row[8];

            $aired = [null, null];
            if (!in_array(strtolower($row[9]), ["unknown", "not available"])) {
                $aired = explode(' to ', $row[9]);
                foreach ($aired as $index => $value) {
                    $aired[$index] = $value === '?' ? null : Carbon::parse($value)->format('Y-m-d');
                }
            }

            $anime = [
                'anime_id' => $row[0],
                'title' => $row[1],
                'english_title' => $row[2],
                'other_title' => $row[3],
                'synopsis' => $row[6],
                'type' => $row[7],
                'episodes' => $episodes,
                'source' => $row[15],
                'aired_from' => $aired[0],
                'aired_to' => $aired[1],
                'duration' => Convert::convertToTime([$row[16]]),
                'premiered_season' => $premiered[0] ?? null,
                'premiered_year' => $premiered[1] ?? null,
                'rating' => $row[17],
                'status' => $row[11],
                'image_url' => $row[23],
            ];

            $animeData[] = $anime;

            // Prepare relationships
            foreach (explode(', ', $row[5]) as $item) {
                if (isset($genres[$item])) {
                    $animeGenres[] = ['anime_id' => $row[0], 'genre_id' => $genres[$item]];
                }
            }
            foreach (explode(', ', $row[13]) as $item) {
                if (isset($licensors[$item])) {
                    $animeLicensors[] = ['anime_id' => $row[0], 'licensor_id' => $licensors[$item]];
                }
            }
            foreach (explode(', ', $row[14]) as $item) {
                if (isset($studios[$item])) {
                    $animeStudios[] = ['anime_id' => $row[0], 'studio_id' => $studios[$item]];
                }
            }
            foreach (explode(', ', $row[12]) as $item) {
                if (isset($producers[$item])) {
                    $animeProducers[] = ['anime_id' => $row[0], 'producer_id' => $producers[$item]];
                }
            }
        }

        // Batch insert for performance
        DB::table('anime')->insert($animeData);
        DB::table('anime_genre')->insert($animeGenres);
        DB::table('anime_licensor')->insert($animeLicensors);
        DB::table('anime_studio')->insert($animeStudios);
        DB::table('anime_producer')->insert($animeProducers);

        echo "Seeder completed successfully!";
    }
}
