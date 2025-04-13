<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamingPlatform extends Model
{
    protected $fillable = [
        'name', 
        'color',
        'logo'
    ];

    protected $table = 'streaming_platforms';
}
