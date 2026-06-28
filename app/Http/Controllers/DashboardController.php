<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isSuperAdmin() || $user->isAdmin() || $user->isKader()) {
            return view('admin.dashboard');
        }

        return view('admin.dashboard');
    }
}