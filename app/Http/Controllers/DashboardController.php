<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Redirect berdasarkan role pengguna
        if ($user->isSuperAdmin() || $user->isAdmin() || $user->isCoordinator() || $user->isKader()) {
            // Admin, coordinator, staff, dan medical ke admin dashboard
            return view('admin.dashboard');
        } elseif ($user->isPatient()) {
            // Patient ke patient dashboard (jika ada)
            return view('patient.dashboard');
        } elseif ($user->isPartner()) {
            // Partner ke partner dashboard (jika ada)
            return view('partner.dashboard');
        }

        // Default fallback
        return view('admin.dashboard');
    }
}