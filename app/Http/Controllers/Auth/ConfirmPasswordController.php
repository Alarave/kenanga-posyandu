<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfirmPasswordController extends Controller
{
    public function showConfirmationForm()
    {
        return view('auth.confirm-password');
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (! Auth::guard('web')->validate(['email' => Auth::user()->email, 'password' => $request->password])) {
            throw ValidationException::withMessages(['password' => ['The provided password is incorrect.']]);
        }

        return redirect()->route('dashboard')->with('success', 'Password confirmed successfully.');
    }
}
