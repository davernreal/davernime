<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Genre;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('name', 'asc')->whereNot('name', 'Unknown')->get();
        $currently_airing = Anime::whereDoesntHave('genres', function ($query) {
            $query->where('genre_id', 16);
        })
            ->where('status', 'Currently Airing')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        $recently_added =
            Anime::whereHas('genres', function ($query) {
                $query->where('genre_id', '!=', 16);
            })->orderBy('id', 'desc')->limit(8)->get();

        return view('pages/home', compact('genres', 'currently_airing', 'recently_added'));
    }
}
