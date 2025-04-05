<?php

namespace App\Models;

use App\Enums\StatusBadgeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Anime extends Model
{
    protected $table = "animes";
    protected $primaryKey = 'anime_id'; // Pakai anime_id sebagai primary key
    public $incrementing = false; // Matikan auto-increment
    protected $fillable = [
        'anime_id',
        'title',
        'english_title',
        'other_title',
        'synopsis',
        'type',
        'episodes',
        'source',
        'aired_from',
        'aired_to',
        'premiered_season',
        'premiered_year',
        'duration',
        'rating',
        'status',
        'image_url',
    ];
    
    protected $casts = [
        'status' => StatusBadgeEnum::class
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'anime_genres', 'anime_id', 'genre_id');
    }

    public function licensors(): BelongsToMany
    {
        return $this->belongsToMany(Licensor::class, 'anime_licensors', 'anime_id', 'licensor_id');
    }

    public function producers(): BelongsToMany
    {
        return $this->belongsToMany(Producer::class, 'anime_producers', 'anime_id', 'producer_id');
    }

    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'anime_studios', 'anime_id', 'studio_id');
    }
}
