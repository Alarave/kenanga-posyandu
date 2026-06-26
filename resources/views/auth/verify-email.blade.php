@extends('layouts.guest')

@section('title', 'Verifikasi Email')

@section('content')
<div class="mb-12">
    <h2 class="text-3xl md:text-5xl font-black text-slate-800 tracking-tight font-jakarta leading-tight mb-4">
        Verifikasi <br> <span class="text-teal-600 italic">Email Anda.</span>
    </h2>
    <p class="text-lg font-bold text-slate-500 italic leading-relaxed">
        Terima kasih telah mendaftar! Sebelum mulai, silakan verifikasi alamat email Anda melalui tautan yang baru saja kami kirimkan.
    </p>
</div>

@if (session('status') == 'verification-link-sent')
    <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200 rounded-4xl text-emerald-700 font-bold text-lg flex items-center gap-4 shadow-sm">
        <span class="material-symbols-outlined text-[32px]">mark_email_read</span>
        Tautan verifikasi baru telah dikirim ke email Anda.
    </div>
@endif

<div class="space-y-6">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" 
                class="w-full h-20 bg-teal-600 text-white text-xl font-black uppercase tracking-[0.2em] rounded-[2.5rem] shadow-2xl hover:bg-teal-700 transition-all flex items-center justify-center gap-4">
            Kirim Ulang Email
            <span class="material-symbols-outlined text-[28px]">send</span>
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="text-center">
        @csrf
        <button type="submit" class="text-lg font-black text-slate-400 hover:text-red-500 uppercase tracking-widest transition-colors">
            Keluar / Logout
        </button>
    </form>
</div>
@endsection
