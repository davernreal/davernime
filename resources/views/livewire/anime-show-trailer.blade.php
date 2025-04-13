<div>
    @if ($trailer_embed_url)
        <iframe src="{{ $trailer_embed_url }}" width="560" height="315" frameborder="0" allowfullscreen></iframe>
    @else
        <p>
            No trailer available.
        </p>
    @endif
</div>
