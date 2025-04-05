@props([
    'imageUrl' => '',
    'title' => '',
    'type' => '',
    'height' => null,
])
<figure class="{{ $height ?? 'h-[300px]' }} relative">
    <img src="{{ $imageUrl }}" class="w-full h-full object-cover rounded-xl" />
    <div class="absolute w-full h-full left-0 top-0 p-2">
        <div class="badge badge-primary">{{ $type }}</div>
    </div>
</figure>
<p class="line-clamp-3 w-[90%]">
    {{ $title }}
</p>