<div class="navbar bg-base-100 shadow-sm">
    <div class="container mx-auto w-full flex gap-2 items-center">
        <div class="lg:hidden">
            <label for="menu-toggle" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </label>
        </div>

        <div class="flex-1">
            <svg class="size-8 fill-current" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100"
                height="100" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M 1.5 0 C 0.672 0 0 0.672 0 1.5 C 0 2.328 0.672 3 1.5 3 C 1.676 3 1.843 2.9642031 2 2.9082031 L 2 6.5898438 C 2 6.8498437 2.1090625 7.1090625 2.2890625 7.2890625 L 2.9609375 7.9609375 C 3.9709375 7.1109375 5.3 6.31 7 5.75 L 7 4.6796875 C 7 4.2696875 6.7491406 3.9 6.3691406 3.75 L 2.7636719 2.3027344 C 2.9116719 2.0697344 3 1.796 3 1.5 C 3 0.672 2.328 0 1.5 0 z M 22.5 0 C 21.672 0 21 0.672 21 1.5 C 21 1.796 21.088328 2.0697344 21.236328 2.3027344 L 17.630859 3.75 C 17.250859 3.9 17 4.2696875 17 4.6796875 L 17 5.75 C 18.7 6.31 20.029063 7.1109375 21.039062 7.9609375 L 21.710938 7.2890625 C 21.890937 7.1090625 22 6.8498438 22 6.5898438 L 22 2.9082031 C 22.157 2.9642031 22.324 3 22.5 3 C 23.328 3 24 2.328 24 1.5 C 24 0.672 23.328 0 22.5 0 z M 12 7 C 11.82 7 11.640703 6.9997656 11.470703 7.0097656 C 11.290703 7.0097656 11.119219 7.0190625 10.949219 7.0390625 C 9.3992187 7.1290625 8.09 7.4508594 7 7.8808594 C 5.95 8.3008594 5.1001562 8.8196094 4.4101562 9.3496094 C 3.8801562 9.7596094 3.4591406 10.190078 3.1191406 10.580078 C 3.0991406 10.590078 3.0898437 10.609141 3.0898438 10.619141 C 2.0498437 11.999141 1.5 13.580469 1.5 15.230469 C 1.5 17.880469 2.9201562 20.249844 5.1601562 21.839844 C 6.8001562 23.169844 9.23 24 12 24 C 14.77 24 17.199844 23.169844 18.839844 21.839844 C 21.079844 20.249844 22.5 17.880469 22.5 15.230469 C 22.5 13.610469 21.980469 12.049219 20.980469 10.699219 C 20.980469 10.699219 20.980703 10.689687 20.970703 10.679688 C 20.620703 10.259688 20.159844 9.7996094 19.589844 9.3496094 C 18.899844 8.8196094 18.05 8.3008594 17 7.8808594 C 15.79 7.4008594 14.319063 7.0697656 12.539062 7.0097656 C 12.359063 6.9997656 12.18 7 12 7 z M 12 8.75 C 13.12 8.75 14 9.52 14 10.5 C 14 11.48 13.12 12.25 12 12.25 C 10.88 12.25 10 11.48 10 10.5 C 10 9.52 10.88 8.75 12 8.75 z M 7.7402344 14.470703 C 7.9202344 14.470703 8.0997656 14.519375 8.2597656 14.609375 L 10.529297 15.949219 C 11.429297 16.489219 12.529219 16.509297 13.449219 16.029297 L 15.960938 14.710938 C 16.280938 14.540938 16.649687 14.550703 16.929688 14.720703 C 18.269687 15.540703 19 16.610469 19 17.730469 C 19 20.040469 15.79 22 12 22 C 8.21 22 5 20.040469 5 17.730469 C 5 16.550469 5.8405469 15.400078 7.3105469 14.580078 C 7.4405469 14.500078 7.5902344 14.470703 7.7402344 14.470703 z M 8 16 C 7.25 16 6.6699219 16.66 6.6699219 17.5 C 6.6699219 18.34 7.25 19 8 19 C 8.75 19 9.3300781 18.34 9.3300781 17.5 C 9.3300781 16.66 8.75 16 8 16 z M 16 16 C 15.25 16 14.669922 16.66 14.669922 17.5 C 14.669922 18.34 15.25 19 16 19 C 16.75 19 17.330078 18.34 17.330078 17.5 C 17.330078 16.66 16.75 16 16 16 z M 12 18.330078 A 1 0.67 0 0 0 12 19.669922 A 1 0.67 0 0 0 12 18.330078 z">
                </path>
            </svg>
        </div>

        <ul class="hidden lg:flex gap-4 items-center">
            <li>
                <a href="{{ route('home.index') }}" class="select-none {{ Route::is('home.index') ? 'px-4 py-2 rounded-xl bg-base-300' : '' }}">Home</a>
            </li>
            <li>
                <a href="{{ route('anime.index') }}" class="select-none {{ Route::is('anime.index') || Route::is('anime.show') ? 'px-4 py-2 rounded-xl bg-base-300' : '' }}">Anime</a>
            </li>
            <li>
                <a href="{{ route('anime.movie') }}" class="select-none {{ Route::is('anime.movie') ? 'px-4 py-2 rounded-xl bg-base-300' : '' }}">Movie</a>
            </li>
            <li><a href="{{ route('recommendation') }}" class="select-none {{ Route::is('recommendation') ?  'px-4 py-2 rounded-xl bg-base-300' : '' }}">Recommendation</a></li>
        </ul>

        <div class="dropdown dropdown-end" id="user-dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full @guest bg-gray-200 @endguest">
                    @auth
                        @if (Auth::user()->avatar_url !== null)
                            <img src="{{ Storage::url(Auth::user()->avatar_url) }}" alt="User Avatar">
                        @else
                            @php
                                $user_name = urlencode(Auth::user()->name);
                            @endphp
                            <img src="https://ui-avatars.com/api/?name={{ $user_name }}" alt="User Avatar">
                        @endif
                    @endauth
                </div>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow">
                @auth
                    @if (Auth::user()->role == 'admin')
                        <li>
                            <a href="{{ route('filament.admin.pages.dashboard') }}">
                                Open Dashboard
                            </a>
                        </li>
                    @endif
                @endauth
                @auth
                    <li><a href="{{ route('profile.index') }}">Profile</a></li>
                @endauth
                @auth
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-error w-full">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </li>
                @endauth

                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                @endguest
            </ul>
        </div>
    </div>
</div>

<input type="checkbox" id="menu-toggle" class="hidden">
<div class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden" id="overlay"></div>

<div id="mobile-menu"
    class="fixed top-0 left-0 w-64 h-full bg-base-100 shadow-lg transform -translate-x-full transition-transform z-30">
    <div class="p-4">
        <label for="menu-toggle" class="btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </label>
    </div>
    <ul class="p-4 space-y-4">
        <li><a href="{{ route('home.index') }}" class="block text-lg {{ Route::is('home.index') ? 'font-bold' : ''}}">Home</a></li>
        <li><a href="{{ route('anime.index') }}" class="block text-lg {{ Route::is('anime.index') || Route::is('anime.show') ? 'font-bold' : '' }}">Anime</a></li>
        <li><a href="{{ route('anime.movie') }}" class="block text-lg {{ Route::is('anime.movie') ? 'font-bold' : '' }}">Movie</a></li>
        <li><a href="{{ route('recommendation') }}" class="block text-lg">Recommendation</a></li>
    </ul>
</div>
