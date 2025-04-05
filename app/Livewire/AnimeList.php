<?php

namespace App\Livewire;

use App\Models\Anime;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class AnimeList extends Component
{
    use WithPagination;

    public function placeholder()
    {
        return view('components.anime.card-placeholder');
    }

    public $anime_id;
    public $page = 1;
    public $perPage = 6;
    public $animes;
    public $hasMore = true;

    public function mount($anime_id)
    {
        $this->anime_id = $anime_id;
        $this->animes = collect();
        $this->loadMore();
    }

    public function loadMore()
    {
        $response = Http::get('http://127.0.0.1:5000/anime/' . $this->anime_id, [
            'page' => $this->page,
            'page_size' => $this->perPage,
        ]);

        $data = $response->json();
        $recommendation_ids = $data['recommendations'] ?? [];

        $newAnimes = Anime::whereIn('anime_id', $recommendation_ids)->get();

        $this->animes = $this->animes->merge($newAnimes)->unique('anime_id')->values();

        $this->page++;

        if (count($recommendation_ids) < $this->perPage || (($this->page - 1) * $this->perPage) >= 50) {
            $this->hasMore = false;
        }
    }

    public function render()
    {
        return view('livewire.anime-list');
    }

    public function updatedAnimeId()
    {
        $this->resetPage();
    }
}
