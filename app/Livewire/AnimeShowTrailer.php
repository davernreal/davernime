<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AnimeShowTrailer extends Component
{
    protected $url = "https://api.jikan.moe/v4/anime/";
    public $anime_id, $trailer_embed_url;

    public function placeholder()
    {
        return <<<'HTML'
        <div class="w-full h-[100px] lg:w-[400px] lg:h-[200px] bg-gray-200 animate-pulse rounded-md">
        </div>
        HTML;
    }
    public function mount()
    {
        $this->loadTrailerUrl();
    }

    public function loadTrailerUrl()
    {
        $cacheKey = "anime-trailer-{$this->anime_id}";
        try {
            $this->trailer_embed_url = Cache::remember($cacheKey, now()->addMinutes(5), function () {
                $response = \Illuminate\Support\Facades\Http::get("{$this->url}{$this->anime_id}");

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['data']['trailer']['embed_url'] ?? null;
                }

                return null;
            });

        } catch (\Throwable $th) {
            Log::error('[ERROR => Livewire/AnimeShowTrailer]' . $th->getMessage());
            $this->trailer_embed_url = null;
        }
    }

    public function render()
    {
        return view('livewire.anime-show-trailer');
    }
}
