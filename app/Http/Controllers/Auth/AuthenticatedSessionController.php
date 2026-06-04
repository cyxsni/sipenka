<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.surat-keluar.dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    return redirect()->route('user.surat-keluar.dashboard')
        ->with('success', 'Selamat datang, ' . $user->name . '!');
}

    public function destroy(Request $request): RedirectResponse
    {
        $name = Auth::user()->name ?? 'Pengguna';
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sampai jumpa, ' . $name . '! Anda telah berhasil logout.');
    }
}