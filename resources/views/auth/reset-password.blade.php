@extends('layouts.guest')

@section('title', 'Atur Ulang Kata Sandi')

@section('content')
<div class="mb-12">
    <h2 class="text-3xl md:text-5xl font-black text-slate-800 tracking-tight font-jakarta leading-tight mb-4">
        Atur Ulang <br> <span class="text-teal-600 italic">Kata Sandi.</span>
    </h2>
    <p class="text-lg font-bold text-slate-500 italic">Silakan buat kata sandi baru Anda.</p>
</div>

<form method="POST" action="{{ route('password.store') }}" class="space-y-8">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Alamat Email -->
    <div>
        <label for="email" class="font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-teal-600">mail</span>
            Alamat Email
        </label>
        <div class="relative group">
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                   class="w-full h-16 px-8 rounded-3xl bg-slate-50 border-2 border-slate-100 text-lg font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all opacity-70" readonly>
        </div>
    </div>

    <!-- Kata Sandi Baru -->
    <div>
        <label for="password" class="font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-teal-600">lock_reset</span>
            Kata Sandi Baru
        </label>
        <div class="relative group">
            <input id="password" type="password" name="password" required
                   placeholder="Masukkan sandi baru..."
                   class="w-full h-16 px-8 rounded-3xl bg-slate-50 border-2 border-slate-100 text-lg font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all">
        </div>
    </div>

    <!-- Konfirmasi Kata Sandi -->
    <div>
        <label for="password_confirmation" class="font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-teal-600">check_circle</span>
            Konfirmasi Sandi Baru
        </label>
        <div class="relative group">
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   placeholder="Ulangi sandi baru..."
                   class="w-full h-16 px-8 rounded-3xl bg-slate-50 border-2 border-slate-100 text-lg font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all">
        </div>
    </div>

    <!-- Submit -->
    <div class="pt-4">
        <button type="submit" 
                class="w-full h-20 bg-teal-600 text-white text-xl font-black uppercase tracking-[0.2em] rounded-[2.5rem] shadow-2xl hover:bg-teal-700 transition-all flex items-center justify-center gap-4">
            Simpan Sandi Baru
            <span class="material-symbols-outlined text-[28px]">save</span>
        </button>
    </div>

</form>
@endsection
