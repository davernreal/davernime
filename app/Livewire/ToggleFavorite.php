<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ToggleFavorite extends Component
{
    public $animeId;
    public $isFavorited = false;

    public function mount($animeId)
    {
        $this->animeId = $animeId;
        if (Auth::check()) {
            $this->isFavorited = Auth::user()
                ->favorites()
                ->where('user_favorites.anime_id', $this->animeId)
                ->exists();
        }
    }

    public function toggleFavorite()
    {
        $user = Auth::user();
        $exists = $user->favorites()->where('user_favorites.anime_id', $this->animeId)->exists();

        if ($exists) {
            $user->favorites()->detach($this->animeId);
            $this->isFavorited = false;
        } else {
            $user->favorites()->attach($this->animeId);
            $this->isFavorited = true;
        }
    }

    public function render()
    {
        return view('livewire.toggle-favorite');
    }
}
