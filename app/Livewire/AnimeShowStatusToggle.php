<?php

namespace App\Livewire;

use Livewire\Component;

class AnimeShowStatusToggle extends Component
{

    public $anime_id;
    public $status;

    public function mount($anime_id, $status)
    {
        $this->anime_id = $anime_id;
        $this->status = $status;
    }

    public function setStatus(string $status)
    {
        $user = auth()->user();
        if(! $user){
            return;
        }

        $user->animeList()->syncWithoutDetaching([
            $this->anime_id => ['status' => $status],
        ]);
    
        $this->status = $status;
    }

    public function render()
    {
        return view('livewire.anime-show-status-toggle');
    }
}
