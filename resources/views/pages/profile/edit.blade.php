@extends('layout.app')

@section('title', 'Edit Profile - ' . config('app.name'))

@section('content')
    <x-navbar />

    <div class="relative w-full h-[200px] bg-gradient-to-r from-blue-400 to-teal-400">
    </div>

    <div class="container mx-auto py-4">
        <h2 class="font-bold text-2xl">Edit Profile</h2>
        <h3>Update your name and email address</h3>

        <form class="mt-4 flex flex-col gap-4 w-full lg:w-[35%]" action="{{ route('profile.update') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="flex items-center gap-4">
                <div class="w-[100px] h-[100px] rounded-full overflow-hidden">
                    @if (Auth::user()->avatar_url !== null)
                        <img src="/{{ Auth::user()->avatar_url }}" alt="User Avatar" class="w-full h-full object-cover"
                            id="image-preview">
                    @else
                        @php
                            $user_name = urlencode(Auth::user()->name);
                        @endphp
                        <img src="https://ui-avatars.com/api/?name={{ $user_name }}" alt="User Avatar"
                            class="w-full h-full object-cover" id="image-preview">
                    @endif
                </div>
                <input type="file" id="image-upload" class="hidden" name="avatar" accept=".jpg, .jpeg, .png">
                <div>
                    <label for="my_modal_6" class="btn" id="upload-image">Upload Image</label>
                </div>
            </div>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Name</legend>
                <input type="text" name="name" value="{{ $user->name }}" class="input w-full"
                    placeholder="Your Name" />
                @error('name')
                    @foreach ($errors->get('name') as $error)
                        <p class="text-error">{{ $error }}</p>
                    @endforeach
                @enderror
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Email</legend>
                <input type="email" name="email" value="{{ $user->email }}" class="input w-full"
                    placeholder="Your Email" />
                @error('email')
                    @foreach ($errors->get('email') as $error)
                        <p class="text-error">{{ $error }}</p>
                    @endforeach
                @enderror
            </fieldset>
            <div>
                <button class="btn btn-primary" type="submit" id="save-button">
                    Save
                </button>
            </div>
        </form>

        @if (auth()->user()->role !== 'admin')
            <div class="mt-8 flex flex-col gap-4">
                <h2 class="font-bold text-2xl">Delete Account</h2>
                <div class="card border-red-100 bg-red-50 dark:border-red-200/10 dark:bg-red-700/10 w-full lg:w-[35%]">
                    <div class="card-body p-4">
                        <h4 class="card-title">Warning!</h4>
                        <p>Please proceed with caution, this cannot be undone.</p>
                        <form class="card-actions justify-start" id="delete-account" action="{{ route('profile.destroy') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-error" type="submit" id="delete-button">Delete Account</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/profile/update.js'])
@endpush
