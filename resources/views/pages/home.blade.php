@extends('layout.app')

@section('title', 'Home - ' . config("app.name"))

@section('content')
    <x-navbar />

    <div class="container mx-auto">
        <div class="py-10">
            <div class="flex flex-col gap-2">
                <h1 class="lg:text-3xl font-bold">DAVERNIME</h1>
                <h3 class="lg:text-xl">Get your favorite anime updates here!</h3>
            </div>
        </div>

        <div>
            <div class="py-4 grid grid-cols-1 lg:grid-cols-12 gap-4">
                <div class="lg:col-span-9">
                    <div class="flex flex-col gap-4">
                        <h2 class="text-lg font-bold uppercase">
                            Currently Airing
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($currently_airing as $item)
                                <a href="{{ route('anime.show', $item->anime_id) }}">
                                    <x-anime.card :animeId="$item->anime_id" :title="$item->title" :imageUrl="$item->image_url" :type="$item->type" />
                                </a>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <a href="{{ route('anime.index', ['status' => 1]) }}" class="btn btn-primary">Show More</a>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 mt-8">
                        <h2 class="text-lg font-bold uppercase">
                            Recently Added
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($recently_added as $item)
                                <a href="{{ route('anime.show', $item->anime_id) }}">
                                    <x-anime.card :animeId="$item->anime_id" :title="$item->title" :imageUrl="$item->image_url" :type="$item->type" />
                                </a>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <a href="{{ route('anime.index', ['sort' => 'latest']) }}" class="btn btn-primary">Show More</a>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-3 flex flex-col gap-4">
                    <div>
                        <h2 class="text-lg font-bold uppercase">
                            Genre
                        </h2>
                    </div>
                    <div>
                        @foreach ($genres as $genre)
                            <a href="{{ route('anime.index', 'genre='.$genre->id) }}">
                                <button class="btn m-1">{{ $genre->name }}</button>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
