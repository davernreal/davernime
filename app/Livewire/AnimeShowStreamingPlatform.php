<?php

namespace App\Livewire;

use App\Models\StreamingPlatform;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AnimeShowStreamingPlatform extends Component
{
    protected $url = "https://api.jikan.moe/v4/anime/";
    public $anime_id, $streaming_platform;
    public function placeholder()
    {
        return <<<'HTML'
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 w-3/4">
            <div class="w-full h-[40px] bg-red-200 animate-pulse rounded-md">
            </div>
            <div class="w-full h-[40px] bg-red-200 animate-pulse rounded-md">
            </div>
            <div class="w-full h-[40px] bg-red-200 animate-pulse rounded-md">
            </div>
            <div class="w-full h-[40px] bg-red-200 animate-pulse rounded-md">
            </div>
        </div>
        HTML;
    }

    public function mount()
    {
        $this->loadStreamingPlatform();
    }

    public function loadStreamingPlatform()
    {
        $cacheKey = "anime-streaming-platform-{$this->anime_id}";
        try {
            $this->streaming_platform = Cache::remember($cacheKey, now()->addMinutes(5), function () {
                Log::info('Fetching data from API for anime ID: ' . $this->anime_id);
                $response = \Illuminate\Support\Facades\Http::get("{$this->url}{$this->anime_id}/streaming");

                if ($response->successful()) {
                    $data = $response->json();
                    $platforms = $data['data'] ?? [];

                    return collect($platforms)->map(function ($platform) {
                        $platformName = $platform['name'];
                        $platformData = StreamingPlatform::where('name', $platformName)->first();

                        return [
                            'name' => $platform['name'],
                            'url' => $platform['url'] ?? "#",
                            'color' =>$platformData ? $platformData->color : null, 
                            'logo' => $platformData ? $platformData->logo : null,
                        ];
                    })->toArray();
                }

                return null;
            });

            if (Cache::has($cacheKey)) {
                Log::info('Data retrieved from cache for anime ID: ' . $this->anime_id);
            }
        } catch (\Throwable $th) {
            Log::error('[ERROR => Livewire/AnimeStreamingPlatform] ' . $th->getMessage());
            $this->streaming_platform = null;
        }
    }


    public function render()
    {
        return view('livewire.anime-show-streaming-platform');
    }
}
