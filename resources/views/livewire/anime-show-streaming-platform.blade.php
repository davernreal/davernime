<div class="grid grid-cols-2 gap-4 lg:grid-cols-4 w-full lg:w-3/4">
    @if ($streaming_platform)
        @foreach ($streaming_platform as $platform)
            <a href="{{ $platform['url'] }}" target="_blank" class="btn"
                style="background-color: {{ $platform['color'] }}20;">
                @if ($platform['logo'])
                    @if (filter_var($platform['logo'], FILTER_VALIDATE_URL))
                        <img src="{{ $platform['logo'] }}" alt="{{ $platform['name'] }} logo" class="w-5 max-h-5">
                    @else
                        <img src="{{ asset('storage/' . $platform['logo']) }}" alt="{{ $platform['name'] }} logo"
                            class="w-5 max-h-5">
                    @endif
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-tv-fill" viewBox="0 0 16 16">
                        <path
                            d="M2.5 13.5A.5.5 0 0 1 3 13h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5M2 2h12s2 0 2 2v6s0 2-2 2H2s-2 0-2-2V4s0-2 2-2" />
                    </svg>
                @endif
                <p class="ml-2" style="color: {{ $platform['color'] }}">
                    {{ $platform['name'] }}
                </p>
            </a>
        @endforeach
    @else
        <p>No streaming platforms available.</p>
    @endif
</div>
