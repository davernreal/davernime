@extends('layout.app')

@section('title', 'Anime Recommendation - ' . config('app.name'))

@section('content')

    <x-navbar />

    <div class="container mx-auto">
        <div class="py-10">
            <h1 class="lg:text-3xl font-bold uppercase">Recommendation List</h1>
            @if (!$fav_animes_count == 0 && !$recent_seen_count == 0)
                <div>
                    Based on your favorite anime and recently seen anime, we recommend you to watch:
                </div>
                @livewire('anime-list-user', ['lazy' => true])
            @else
                <div class="mt-4">
                    <p>
                        You need to add some favorite anime and watch some anime to get recommendations.
                    </p>
                    <p>
                        Go to <a href="{{ route('anime.index') }}" class="link">Anime List</a>
                    </p>
                </div>
            @endif
        </div>
    </div>

@endsection
