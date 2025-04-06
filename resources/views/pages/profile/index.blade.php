@extends('layout.app')

@section('title', Auth::user()->name . ' - ' . config('app.name'))

@section('content')
    <x-navbar />

    <div class="relative w-full h-[200px] bg-gradient-to-r from-blue-400 to-teal-400">
        <div class="container mx-auto pt-4">
            <x-alert />
        </div>
    </div>

    <div class="container mx-auto">
        <div class="relative flex justify-center lg:justify-start">
            <div
                class="w-[100px] h-[100px] rounded-full overflow-hidden border-4 border-white 
                        absolute -top-12 bg-gray-300">
                @if (Auth::user()->avatar_url !== null)
                    <img src="/{{ Auth::user()->avatar_url }}" alt="User Avatar" class="w-full h-full object-cover">
                @else
                    @php
                        $user_name = urlencode(Auth::user()->name);
                    @endphp
                    <img src="https://ui-avatars.com/api/?name={{ $user_name }}" alt="User Avatar"
                        class="w-full h-full object-cover">
                @endif
            </div>
        </div>

    </div>
    <div class="container mx-auto mt-16">
        <h2 class="font-bold text-2xl text-center lg:text-start">{{ Auth::user()->name }}</h2>
        <div class="flex flex-col items-center lg:items-start gap-2">
            <div class="tooltip tooltip-bottom"
                data-tip="{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d F Y h:i:s') }}">
                <h5>Joined {{ \Carbon\Carbon::parse(Auth::user()->created_at)->diffForHumans() }}</h5>
            </div>
            <div>
                <a href="{{ route('profile.edit') }}" class="btn btn-neutral btn-sm">
                    Edit Profile
                </a>
            </div>
        </div>

        <div class="my-8">
            <h2 class="font-bold text-xl ">Favorite Anime</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($fav_animes as $item)
                    <a href="{{ route('anime.show', $item->anime_id) }}">
                        <x-anime.card :animeId="$item->anime_id" :title="$item->title" :imageUrl="$item->image_url" :type="$item->type" />
                    </a>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $fav_animes->links('pagination::simple-tailwind') }}
            </div>
        </div>
    </div>
@endsection
