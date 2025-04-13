<?php

namespace App\Http\Controllers;

use App\Exports\AnimeExport;
use App\Jobs\ExportAnimeJob;
use App\Jobs\SendAnimeCsvToApi;
use App\Models\Anime;
use App\Models\Genre;
use App\Services\AnimeExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class AnimeController extends Controller
{
    protected array $type = ['Unknown', 'TV', 'OVA', 'Special', 'CM', 'ONA', 'Music', 'Movie', 'TV Special', 'PV'];
    protected array $status = ['Finished Airing', 'Currently Airing', 'Not yet aired'];
    protected array $sort = [
        'latest' => 'Latest',
        'oldest' => 'Oldest',
        'title_asc' => 'Title (A-Z)',
        'title_desc' => 'Title (Z-A)',
    ];

    public function index(Request $request)
    {
        $query = Anime::query();
        $hasFilter = false;

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('english_title', 'LIKE', '%' . $request->search . '%');
            });
            $hasFilter = true;
        }

        if ($request->has('genre') && !empty($request->genre)) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('id', $request->genre);
            });
            $hasFilter = true;
        }

        if ($request->has('type') && array_key_exists($request->type, $this->type)) {
            $query->where('type', $this->type[$request->type]);
            $hasFilter = true;
        }

        if ($request->has('status') && array_key_exists($request->status, $this->status)) {
            $query->where('status', $this->status[$request->status]);
            $hasFilter = true;
        }

        if ($request->has('sort') && array_key_exists($request->sort, $this->sort)) {
            switch ($request->sort) {
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
            }
        }

        if (!$hasFilter) {
            $query->whereDoesntHave('genres', function ($q) {
                $q->where('id', 16);
            })->orderBy('created_at', 'desc');
        }

        $animes = $query->paginate(18);
        $genres = Genre::orderBy('name', 'asc')->pluck('name', 'id');

        $types = collect($this->type)->map(fn($type, $index) => ['id' => $index, 'name' => $type]);
        $statuses = collect($this->status)->map(fn($status, $index) => ['id' => $index, 'name' => $status]);

        $sort = $this->sort;
        $filters = $request->only(['search', 'genre', 'type', 'status', 'sort']);

        $page = 'Anime';

        return view('pages.anime.index', compact('animes', 'filters', 'genres', 'types', 'statuses', 'sort', 'page'));
    }

    public function show(string $id)
    {
        $anime = Anime::where('anime_id', $id)->firstOrFail();

        if (Auth::check()) {
            Auth::user()->saveHistory($anime->anime_id);
        }

        $genres = $anime->genres->pluck('name', 'id');
        $producers = $anime->producers->pluck('name', 'id');
        $studios = $anime->studios->pluck('name', 'id');
        $licensors = $anime->licensors->pluck('name', 'id');
        return view('pages.anime.show', compact('anime', 'genres', 'producers', 'studios', 'licensors'));
    }

    public function movie(Request $request)
    {
        $query = Anime::query();

        $query->where('type', 'Movie');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('english_title', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->has('genre') && !empty($request->genre)) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('id', $request->genre);
            });
        }

        if ($request->has('sort') && array_key_exists($request->sort, $this->sort)) {
            switch ($request->sort) {
                case 'latest':
                    $query->orderBy('anime_id', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('anime_id', 'asc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $animes = $query->paginate(18);
        $genres = Genre::orderBy('name', 'asc')->pluck('name', 'id');

        $statuses = collect($this->status)->map(fn($status, $index) => ['id' => $index, 'name' => $status]);

        $sort = $this->sort;
        $filters = $request->only(['search', 'genre', 'sort']);

        $page = 'Movie Anime';

        return view('pages.anime.index', compact('animes', 'filters', 'genres', 'statuses', 'sort', 'page'));
    }

    public function recommendation()
    {
        $fav_animes_count = Auth::user()->favorites()->count();
        $recent_seen_count = Auth::user()->histories()->count();
        return view('pages.recommendation.index', compact('fav_animes_count', 'recent_seen_count'));
    }

    public function export()
    {
        try {
            $start_time = microtime(true);
            $timestamp = now()->timestamp;
            Cache::put('anime_job_timestamp', $timestamp);
            SendAnimeCsvToApi::dispatch($timestamp, 1);
            $end_time = microtime(true);

            $duration = round($end_time - $start_time, 2);
            return response()->json(['message' => 'Export successful', 'time_taken' => "$duration seconds"], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
