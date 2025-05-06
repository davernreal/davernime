<div>
    @if ($trailer_embed_url)
        <iframe src="{{ $trailer_embed_url }}" class="w-full lg:w-[50%] h-[300px]" frameborder="0" allowfullscreen></iframe>
    @else
        <p>
            No trailer available.
        </p>
    @endif
</div>
