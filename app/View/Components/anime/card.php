<?php

namespace App\View\Components\anime;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class card extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $imageUrl = "",
        public string $title,
        public string $type,
    )
    {
        $this->title = $title;
        $this->imageUrl = $imageUrl;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.anime.card');
    }
}
