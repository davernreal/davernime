<div x-data="{ open: false }" class="relative inline-block text-left">
    <button @click="open = !open" class="flex items-center justify-center btn {{ $status ? 'btn-primary' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-plus"
            viewBox="0 0 16 16">
            <path
                d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
            <path
                d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4" />
        </svg>
    </button>

    <div x-show="open" @click.outside="open = false" x-transition
        class="absolute mt-2 w-48 bg-base-100 rounded-md shadow-lg z-10">
        <ul class="py-1 text-sm">
            @php
                $statuses = [
                    'planned' => '📺 Plan to Watch',
                    'completed' => '✅ Completed',
                ];
            @endphp

            @foreach ($statuses as $key => $label)
                <li>
                    <button
                        @if ($status !== $key) wire:click.prevent="setStatus('{{ $key }}')" @endif
                        class="w-full text-left px-4 py-2 hover:bg-base-300 {{ $status === $key ? 'font-bold  cursor-default bg-base-300' : 'cursor-pointer' }}">
                        {{ $label }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
