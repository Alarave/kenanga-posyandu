@extends('layouts.guest')

@section('title', 'Masuk - Dashboard Posyandu')

@section('content')
{{-- ── Modern Header Section ── --}}
<div class="mb-12 text-center md:text-left">
    <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-primary/20">
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-lg bg-primary/40 opacity-75"></span>
            <span class="relative inline-flex rounded-lg h-2 w-2 bg-primary"></span>
        </span>
        Akses Petugas & Kader
    </div>
    
    <h2 class="text-4xl lg:text-5xl font-black text-on-surface mb-4 tracking-tight">
        Selamat Datang <br> <span class="text-primary italic">Kembali.</span>
    </h2>
    <p class="text-body-lg font-bold text-outline max-w-sm">
        Gunakan akun resmi Anda untuk mengelola data Posyandu.
    </p>
</div>

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    {{-- ── Email Input Field ── --}}
    <div class="group">
        <label for="email" class="ml-4 font-black text-on-surface-variant uppercase tracking-[0.2em] text-[11px] flex items-center gap-2 mb-2 group-focus-within:text-primary transition-colors">
            <span class="material-symbols-outlined text-[16px]">alternate_email</span>
            Alamat Email Resmi
        </label>
        <div class="relative">
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="nama@posyandu.com"
                   class="w-full h-16 px-6 rounded-2xl bg-surface-container-low border-2 border-transparent text-body-lg font-bold text-on-surface placeholder:text-outline-variant focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all shadow-sm hover:bg-surface-container-low">
            <div class="absolute inset-y-0 right-6 flex items-center text-outline-variant group-focus-within:text-primary transition-colors pointer-events-none">
                <span class="material-symbols-outlined text-[24px]">verified_user</span>
            </div>
        </div>
    </div>

    {{-- ── Password Input Field ── --}}
    <div class="group">
        <div class="flex justify-between items-center px-4 mb-2">
            <label for="password" class="font-black text-on-surface-variant uppercase tracking-[0.2em] text-[11px] flex items-center gap-2 group-focus-within:text-primary transition-colors">
                <span class="material-symbols-outlined text-[16px]">key</span>
                Kata Sandi Akun
            </label>
        </div>
        <div class="relative">
            <input id="password" type="password" name="password" required
                   placeholder="••••••••"
                   class="w-full h-16 px-6 pr-16 rounded-2xl bg-surface-container-low border-2 border-transparent text-headline-sm font-black text-on-surface placeholder:text-slate-300 focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all shadow-sm hover:bg-surface-container-low tracking-widest">
            
            <button type="button" onclick="togglePassword()" id="toggleBtn"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center rounded-xl text-outline-variant hover:bg-white hover:text-primary hover:shadow transition-all active:scale-95">
                <span class="material-symbols-outlined text-[24px]" id="toggleIcon">visibility</span>
            </button>
        </div>
    </div>

    {{-- ── Advanced Options ── --}}
    <div class="flex items-center justify-between px-4 pt-2">
        <label class="relative flex items-center gap-3 cursor-pointer group select-none">
            <div class="relative">
                <input id="remember_me" type="checkbox" name="remember" 
                       class="sr-only peer">
                <div class="w-10 h-6 bg-surface-container-high rounded-lg peer peer-checked:bg-primary transition-all after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-lg after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
            </div>
            <span class="text-sm font-bold text-on-surface-variant group-hover:text-primary transition-colors">Ingat Perangkat</span>
        </label>

        {{-- Hubungi Admin untuk Lupa Sandi --}}
        <a href="{{ route('public.contact') }}" class="text-sm font-bold text-primary hover:text-primary/80 hover:underline transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">support_agent</span>
            Lupa Sandi?
        </a>
    </div>

    {{-- ── Submission ── --}}
    <div class="pt-6">
        <button type="submit" id="submitBtn"
                class="w-full h-16 bg-primary hover:bg-primary/90 text-white text-body-lg font-black uppercase tracking-[0.2em] rounded-2xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98] transition-all flex items-center justify-center gap-4 group">
            <span>Masuk</span>
            <span class="material-symbols-outlined text-[24px] group-hover:translate-x-2 transition-transform">arrow_forward</span>
        </button>
    </div>

    {{-- ── Sign Up Link ── --}}
    <div class="pt-8 border-t border-slate-100 text-center">
        <p class="text-sm font-bold text-outline">
            Belum memiliki akun petugas? 
            <a href="{{ route('public.contact') }}" class="text-primary hover:text-primary/80 hover:underline transition-colors ml-1">
                Hubungi Admin
            </a>
        </p>
    </div>
</form>

<script>
    function togglePassword() {
        const passInput = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        const btn = document.getElementById('toggleBtn');
        
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.textContent = 'visibility_off';
            btn.classList.add('bg-white', 'text-primary', 'shadow');
        } else {
            passInput.type = 'password';
            icon.textContent = 'visibility';
            btn.classList.remove('bg-white', 'text-primary', 'shadow');
        }
    }

    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `
            <div class="w-6 h-6 border-4 border-white/30 border-t-white rounded-lg animate-spin"></div>
            <span class="font-black uppercase tracking-[0.2em]">Memverifikasi...</span>
        `;
    });
</script>
@endsection
