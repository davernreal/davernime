@extends('layout.auth.app')

@section('title', 'Create an account - ' . config('app.name'))

@section('heading_title', 'Create your account')

@section('content')
    <div class="flex flex-col lg:flex-row w-full lg:w-fit">
        <div
            class="w-full lg:w-[300px] h-[130px] lg:h-full lg:block rounded-t-xl lg:rounded-none lg:rounded-l-xl overflow-hidden">
            <img src="https://static0.gamerantimages.com/wordpress/wp-content/uploads/2024/12/best-school-anime-everyone-should-watch.jpg"
                alt="" class="grayscale w-full select-none pointer-events-none h-full object-cover" draggable="false">
        </div>
        <div
            class="card rounded-none rounded-b-xl lg:rounded-r-xl w-full bg-base-100 p-10 flex-1 lg:w-[400px]">
            <form class="flex flex-col items-center gap-4" action="{{ route('register.store') }}" method="POST">
                @csrf
                <div class="w-full">
                    <label class="input w-full @error('name') input-error @enderror">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                        <input type="text" placeholder="Your Name" name="name" id="name"
                            value="{{ @old('name') }}" />
                    </label>
                    @error('name')
                        <div id="name-error">
                            @foreach ($errors->get('name') as $error)
                                <span class="text-sm text-red-500 error-message">{{ $error }}</span>
                            @endforeach
                        </div>
                    @enderror
                </div>
                <div class="w-full">
                    <label class="input w-full @error('email') input-error @enderror">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path
                                d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z" />
                        </svg>
                        <input type="text" placeholder="Email" name="email" id="email" value="{{ old('email') }}"/>
                    </label>
                    @error('email')
                        <div id="email-error">
                            @foreach ($errors->get('email') as $error)
                                <span class="text-sm text-red-500 error-message">{{ $error }}</span>
                            @endforeach
                        </div>
                    @enderror
                </div>
                <div class="w-full">
                    <label class="input w-full @error('password') input-error @enderror">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path
                                d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                        </svg>
                        <input type="password" placeholder="Password" name="password" id="password" />
                    </label>
                    @error('password')
                        <div id="password-error">
                            @foreach ($errors->get('password') as $error)
                                <span class="text-sm text-red-500 error-message">{{ $error }}</span>
                            @endforeach
                        </div>
                    @enderror
                </div>
                <div class="w-full">
                    <label class="input w-full @error('confirm_password') input-error @enderror">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path
                                d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                        </svg>
                        <input type="password" placeholder="Confirm Password" name="confirm_password"
                            id="confirm-password" />
                    </label>
                    @error('confirm_password')
                        <div id="confirm_password-error">
                            @foreach ($errors->get('confirm_password') as $error)
                                <span class="text-sm text-red-500 error-message">{{ $error }}</span>
                            @endforeach
                        </div>
                    @enderror
                </div>
                <div class="w-full">
                    <button class="btn btn-primary w-full" id="register-btn">Create</button>
                </div>
            </form>
            <div class="divider text-sm">OR</div>
            <div class="text-center">
                <p>Already have an account?
                    <span>
                        <a href="{{ route('login') }}" class="text-sm lg:text-base link link-hover">Login here</a>
                    </span>
                </p>
            </div>
        </div>
    </div>
@endsection
