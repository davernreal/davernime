<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Licensor;
use App\Models\Producer;
use App\Models\Source;
use App\Models\Studio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->importData('genre');
        $this->importData('studio');
        $this->importData('producer');
        $this->importData('licensor');
        $this->importData('source');
    }

    private function importData($type)
    {
        $validTypes = [
            'studio' => Studio::class,
            'producer' => Producer::class,
            'licensor' => Licensor::class,
            'source' => Source::class,
            'genre' => Genre::class,
        ];

        if (!array_key_exists($type, $validTypes)) {
            return;
        }

        $filePath = public_path("master/unique_{$type}s.json");

        if (!File::exists($filePath)) {
            echo "File not found: {$type}\n";
            return;
        }

        $jsonData = File::get($filePath);
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Error decoding JSON for {$type}\n";
            return;
        }

        $modelClass = $validTypes[$type];
        foreach ($data as $name) {
            $modelClass::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        echo "{$type} import done.\n";
    }
}
