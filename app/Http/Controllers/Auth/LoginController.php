<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $key = 'login.'.$request->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($key);
            return back()->withErrors(['email' => "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik."]);
        }

        $email = strtolower($request->email);
        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => $email, 'password' => $request->password], $remember)) {
            \Illuminate\Support\Facades\RateLimiter::clear($key);
            return redirect()->route('dashboard')->with('success', 'Berhasil masuk ke sistem.');
        }

        \Illuminate\Support\Facades\RateLimiter::hit($key, 60);

        return back()->withErrors(['email' => 'Email atau password yang Anda masukkan salah.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.articles.index')->with('success', 'Berhasil keluar.');
    }
}
