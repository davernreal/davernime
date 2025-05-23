@extends('layout.app')

@section('title', 'Anime List - ' . config('app.name'))

@section('content')
    <x-navbar />

    <div class="container mx-auto pb-8">
        <div class="py-10">
            <div class="flex flex-col gap-2">
                <h1 class="lg:text-3xl font-bold uppercase">{{ $page }} List</h1>
            </div>
        </div>

        <div class="">
            <form action="{{ strtolower($page) === 'anime' ? route('anime.index') : route('anime.movie') }}" method="GET"
                class="grid grid-cols-2 lg:flex lg:flex-wrap gap-2">
                <input type="text" class="input input-bordered w-full lg:w-fit col-span-2" placeholder="Search "
                    name="search" value="{{ request('search') }}" id="search" />
                <select class="select w-full lg:w-fit" name="genre" id="genre-search">
                    <option disabled selected>Genre</option>
                    @foreach ($genres as $index => $item)
                        @if (strtolower($item) !== strtolower('unknown'))
                            <option value="{{ $index }}"
                                {{ (string) request('genre') === (string) $index ? 'selected' : '' }}>{{ $item }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @isset($types)
                    <select class="select w-full lg:w-fit" name="type" id="type-search">
                        <option disabled selected>Type</option>
                        @foreach ($types as $item)
                            @if (strtolower($item['name']) !== strtolower('unknown'))
                                <option value="{{ $item['id'] }}"
                                    {{ (string) request('status') === (string) $item['id'] ? 'selected' : '' }}>
                                    {{ $item['name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                @endisset
                <select class="select w-full lg:w-fit" name="status" id="status-search">
                    <option disabled selected>Status</option>
                    @foreach ($statuses as $index => $item)
                        @if (strtolower($item['name']) !== strtolower('unknown'))
                            <option value="{{ $item['id'] }}"
                                {{ (string) request('status') === (string) $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}</option>
                        @endif
                    @endforeach
                </select>
                <select name="sort" class="select select-bordered w-full lg:w-fit" id="sort-search">
                    <option value="">Sort by</option>
                    @foreach ($sort as $key => $value)
                        <option value="{{ $key }}" {{ request('sort') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-primary col-span-2">Search</button>
                @if (collect(request()->only(['search', 'genre', 'type', 'status', 'sort']))->filter(fn($value) => $value !== null && $value !== '')->isNotEmpty())
                    <a href="{{ strtolower($page) === 'anime' ? route('anime.index') : route('anime.movie') }}"
                        class="btn btn-dash btn-error" id="reset-btn">Reset Filter</a>
                @endif
            </form>
        </div>

        @if (isset($animes) && $animes->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 py-4" id="anime-list">
                @foreach ($animes as $item)
                    <a href="{{ route('anime.show', $item->anime_id) }}" class="anime-card" data-genre="{{ collect($item->genres)->pluck('name')->join(', ') }}" data-status="{{ $item->status }}">
                        <x-anime.card :title="$item->title" :imageUrl="$item->image_url" :type="$item->type" />
                    </a>
                @endforeach
            </div>
        @else
            <div class="mt-8" id="anime-list">
                <p class="text-center text-lg font-bold">No {{ strtolower($page) }} found</p>
            </div>
        @endif

        <div>
            @isset($animes)
                {{ $animes->links('pagination::tailwind') }}
            @endisset
        </div>
    </div>
@endsection
