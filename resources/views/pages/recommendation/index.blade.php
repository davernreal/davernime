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
                        You need to add some favorite anime and watch some anime to get recommendations. But we have some recommendations for you based on this season:
                    </p>
                    @if (count($animes) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-4">
                            @foreach ($animes as $key => $anime)
                                <a href="{{ route('anime.show',$anime['anime_id']) }}">
                                    <x-anime.card :animeId="$anime['anime_id']" :imageUrl="$anime['image_url']" :title="$anime['title']" :type="$anime['type']" />
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-4">
                            <p class="text-center text-gray-500">No recommendations available at the moment.</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

@endsection
