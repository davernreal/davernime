<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producer extends Model
{
    protected $fillable = ['name', 'slug'];
    
    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_producers');
    }
}
