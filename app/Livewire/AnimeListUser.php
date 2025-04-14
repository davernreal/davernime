<?php

namespace App\Livewire;

use App\Models\Anime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class AnimeListUser extends Component
{
    use WithPagination;

    public $page = 1;

    public $perPage = 6;

    public $animes;

    public $hasMore=true;

    public function placeholder()
    {
        return view('components.anime.card-placeholder');
    }

    public function mount()
    {
        $this->animes = collect();
        $this->loadMore();
    }

    public function loadMore()
    {
        $user_fav = Auth::user()->favorites()->orderByPivot('user_favorites.updated_at', 'desc')->pluck('user_favorites.anime_id')->toArray();
        $recent = Auth::user()->histories()->orderByPivot('user_histories.updated_at', 'desc')->take(5)->pluck('user_histories.anime_id')->toArray();
        try {
            $response = Http::asForm()->withOptions([
                'query' => [
                    'page' => $this->page,
                    'page_size' => $this->perPage,
                ]
            ])->post('http://127.0.0.1:5000/anime/user?page', [
                'user_favorites' => json_encode($user_fav),
                'user_history' => json_encode($recent),
            ]);

            $data = $response->json();
            $recommendation_ids = [];

            foreach ($data['recommendations'] as $value) {
                $recommendation_ids[] = $value['id'];
            }

            // dd($recommendation_ids);
            $newAnimes = Anime::whereIn('anime_id', $recommendation_ids)
                ->orderByRaw('FIELD(anime_id, ' . implode(',', $recommendation_ids) . ')')
                ->get();

            $this->animes = $this->animes->merge($newAnimes)->unique('anime_id')->values();

            $this->page++;

            if (count($recommendation_ids) < $this->perPage || (($this->page - 1) * $this->perPage) >= 50) {
                $this->hasMore = false;
            }
        } catch (\Throwable $e) {
            logger()->error('Failed to fetch recommendations: ' . $e->getMessage());

            $this->hasMore = false;
        }
    }

    public function render()
    {

        return view('livewire.anime-list-user');
    }

    public function updatedAnimeId()
    {
        $this->resetPage();
    }
}
