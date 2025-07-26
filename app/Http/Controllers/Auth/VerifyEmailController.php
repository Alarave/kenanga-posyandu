<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
    /**
     * Menampilkan halaman konfirmasi dan mengirimkan link verifikasi email jika belum diverifikasi.
     */
    public function show(Request $request)
    {
        // Jika email sudah terverifikasi
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('info', 'Your email is already verified.');
        }

        // Kirimkan notifikasi verifikasi email
        $request->user()->sendEmailVerificationNotification();

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Verification link has been sent to your email address.');
    }

    /**
     * Memverifikasi email pengguna berdasarkan ID dan hash.
     */
    public function verify(Request $request)
    {
        // Validasi ID dan hash dari URL
        $request->validate([
            'id' => 'required|exists:users,id',
            'hash' => 'required|string',
        ]);

        // Jika verifikasi berhasil
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user())); // Trigger event Verified
        }

        // Redirect ke dashboard setelah verifikasi dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Your email has been verified.');
    }
}
