<div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 py-4">
        @foreach ($animes as $item)
            <a href="{{ route('anime.show', $item->anime_id) }}">
                <x-anime.card :title="$item->title ?? 'No Title'" :imageUrl="$item->image_url ?? 'default.jpg'" :type="$item->type ?? 'Unknown'" />
            </a>
        @endforeach
    </div>

    <div class="text-center">
        @if ($hasMore)
            <button wire:click="loadMore" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Load More
            </button>
        @else
            <p class="text-gray-500">No more recommendations.</p>
        @endif
    </div>
    <div wire:loading>Loading...</div>
</div>
