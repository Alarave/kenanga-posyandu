@extends('layouts.guest')

@section('title', 'Atur Ulang Kata Sandi')

@section('content')
<div class="mb-12">
    <h2 class="text-display-sm md:text-5xl font-black text-on-surface tracking-tight font-jakarta leading-tight mb-4">
        Atur Ulang <br> <span class="text-primary italic">Kata Sandi.</span>
    </h2>
    <p class="text-body-lg font-bold text-outline italic">Silakan buat kata sandi baru Anda.</p>
</div>

<form method="POST" action="{{ route('password.store') }}" class="space-y-8">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Alamat Email -->
    <div>
        <label for="email" class="font-black text-on-surface-variant uppercase tracking-widest flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-primary">mail</span>
            Alamat Email
        </label>
        <div class="relative group">
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                   class="w-full h-16 px-8 rounded-2xl bg-surface-container-low border-2 border-slate-100 text-body-lg font-bold text-on-surface focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-teal-600 transition-all opacity-70" readonly>
        </div>
    </div>

    <!-- Kata Sandi Baru -->
    <div>
        <label for="password" class="font-black text-on-surface-variant uppercase tracking-widest flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-primary">lock_reset</span>
            Kata Sandi Baru
        </label>
        <div class="relative group">
            <input id="password" type="password" name="password" required
                   placeholder="Masukkan sandi baru..."
                   class="w-full h-16 px-8 rounded-2xl bg-surface-container-low border-2 border-slate-100 text-body-lg font-bold text-on-surface focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-teal-600 transition-all">
        </div>
    </div>

    <!-- Konfirmasi Kata Sandi -->
    <div>
        <label for="password_confirmation" class="font-black text-on-surface-variant uppercase tracking-widest flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-primary">check_circle</span>
            Konfirmasi Sandi Baru
        </label>
        <div class="relative group">
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   placeholder="Ulangi sandi baru..."
                   class="w-full h-16 px-8 rounded-2xl bg-surface-container-low border-2 border-slate-100 text-body-lg font-bold text-on-surface focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-teal-600 transition-all">
        </div>
    </div>

    <!-- Submit -->
    <div class="pt-4">
        <button type="submit" 
                class="w-full h-20 bg-primary text-white text-headline-sm font-black uppercase tracking-[0.2em] rounded-[2.5rem] shadow-2xl hover:bg-teal-700 transition-all flex items-center justify-center gap-4">
            Simpan Sandi Baru
            <span class="material-symbols-outlined text-[28px]">save</span>
        </button>
    </div>

</form>
@endsection
