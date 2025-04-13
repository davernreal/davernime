<?php

namespace Database\Seeders;

use App\Models\StreamingPlatform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StreamingPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StreamingPlatform::create([
            'name' => 'Netflix',
            'color' => '#b91c1c',
            'logo' => 'https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/227_Netflix_logo-512.png'
        ]);
    }
}
