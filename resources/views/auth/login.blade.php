@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<div class="mb-12">
    <h2 class="text-3xl md:text-5xl font-black text-slate-800 tracking-tight font-jakarta leading-tight mb-4">
        Selamat <br> <span class="text-teal-600 italic">Datang Kembali.</span>
    </h2>
    <p class="text-lg font-bold text-slate-500 italic">Silakan masukkan data Anda untuk masuk ke sistem.</p>
</div>

<form method="POST" action="{{ route('login') }}" class="space-y-8">
    @csrf

    <!-- Alamat Email -->
    <div>
        <label for="email" class="font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-teal-600">mail</span>
            Alamat Email
        </label>
        <div class="relative group">
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="Contoh: nama@email.com"
                   class="w-full h-16 md:h-20 px-8 rounded-3xl bg-slate-50 border-2 border-slate-100 text-lg md:text-xl font-bold text-slate-900 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all shadow-inner">
        </div>
        <p class="mt-3 text-sm font-bold text-slate-400 italic">Masukkan alamat email yang sudah didaftarkan.</p>
    </div>

    <!-- Kata Sandi -->
    <div>
        <div class="flex justify-between items-center mb-3">
            <label for="password" class="font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-teal-600">lock</span>
                Kata Sandi
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-black text-teal-600 hover:underline tracking-tight uppercase">
                    Lupa Sandi?
                </a>
            @endif
        </div>
        <div class="relative group">
            <input id="password" type="password" name="password" required
                   placeholder="Masukkan kata sandi..."
                   class="w-full h-16 md:h-20 px-8 rounded-3xl bg-slate-50 border-2 border-slate-100 text-lg md:text-xl font-bold text-slate-900 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all shadow-inner">
        </div>
    </div>

    <!-- Ingat Saya -->
    <div class="flex items-center gap-4 bg-slate-50/50 p-6 rounded-[2rem] border border-slate-100">
        <input id="remember_me" type="checkbox" name="remember" 
               class="w-8 h-8 text-teal-600 border-2 border-outline-variant rounded-xl focus:ring-teal-500 transition-all cursor-pointer shadow-sm">
        <label for="remember_me" class="!mb-0 text-lg font-black text-slate-700 cursor-pointer select-none">
            Ingat saya di perangkat ini
        </label>
    </div>

    <!-- Submit -->
    <div class="pt-4">
        <button type="submit" 
                class="w-full h-20 bg-teal-600 text-white text-xl font-black uppercase tracking-[0.2em] rounded-[2.5rem] shadow-2xl shadow-teal-900/20 hover:bg-teal-700 hover:-translate-y-1 active:translate-y-0 transition-all flex items-center justify-center gap-4">
            Masuk Sekarang
            <span class="material-symbols-outlined text-[28px]">arrow_forward</span>
        </button>
    </div>

    {{-- Support Text --}}
    <p class="text-center text-sm font-bold text-slate-400">
        Butuh bantuan? Silakan hubungi admin Posyandu melalui WhatsApp.
    </p>

</form>
@endsection
