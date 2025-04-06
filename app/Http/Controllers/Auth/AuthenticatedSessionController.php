<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create(Request $request)
    {
        return view('pages.auth.login', [
            // 'redirect' => $request->query('redirect') ?? null,
            'url' => $request->query('redirect') ? route('login.store', ['redirect' => $request->query('redirect')]) : route('login.store')
        ]);
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $redirect = $request->query('redirect') ?? route('home.index');
        return redirect($redirect);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home.index'));
    }
}
