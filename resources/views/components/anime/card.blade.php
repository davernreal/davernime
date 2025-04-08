@props([
    'imageUrl' => null,
    'title' => '',
    'type' => '',
    'height' => null,
    'animeId' => null,
])
<figure class="{{ $height ?? 'h-[300px]' }} relative">
    <img src="{{ (!is_null($imageUrl) ? filter_var($imageUrl, FILTER_VALIDATE_URL) ? $imageUrl : asset('storage/'.$imageUrl) : "https://placehold.co/600x400")  }}" class="w-full h-full object-cover rounded-xl" />
    <div class="absolute w-full h-full left-0 top-0 p-2 flex justify-between">
        <div class="badge badge-primary">{{ $type }}</div>
    </div>
</figure>
<p class="line-clamp-3 w-[90%]">
    {{ $title }}
</p>
