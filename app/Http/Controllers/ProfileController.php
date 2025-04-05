<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile.index');
    }

    public function edit()
    {
        $user = Auth::getUser();
        return view('pages.profile.edit', compact('user'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user()->fill($request->validated());

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
                unlink(public_path($user->avatar_url));
            }

            $filename = time() . '_avatar.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('users/avatar'), $filename);

            $user->avatar_url = 'users/avatar/' . $filename;
        }

        $request->user()->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
