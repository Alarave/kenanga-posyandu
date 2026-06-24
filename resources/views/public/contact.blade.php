@extends('layouts.public-layout')

@section('title', 'Hubungi Kami - Posyandu Digital')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-12 pb-32 relative">

    {{-- Decor --}}
    <div class="absolute -top-10 right-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] pointer-events-none"></div>

    <!-- Hero Section -->
    <div class="relative rounded-[3.5rem] overflow-hidden min-h-[450px] flex items-center mb-24 bg-on-surface group shadow-[0_40px_100px_-20px_rgba(0,104,95,0.25)]">
        <img src="https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?q=80&w=2020&auto=format&fit=crop" 
             class="absolute inset-0 w-full h-full object-cover opacity-30 scale-105 group-hover:scale-100 transition-transform duration-[3s]">
        <div class="absolute inset-0 bg-gradient-to-r from-on-surface via-on-surface/50 to-transparent"></div>
        
        <div class="relative z-10 px-10 md:px-24 py-20 max-w-2xl">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-primary/20 backdrop-blur-md rounded-full mb-8 border border-white/10">
                <span class="text-[10px] font-black text-white uppercase tracking-[0.3em]">Bantuan & Support</span>
            </div>
            <h1 class="text-5xl md:text-8xl font-black text-white mb-8 leading-[1] tracking-tight font-jakarta">
                Hubungi <span class="text-primary italic">Kami.</span>
            </h1>
            <p class="text-white/70 text-xl font-medium leading-relaxed italic opacity-80">
                Kami siap memberikan informasi dan bantuan terbaik untuk kesehatan keluarga Anda di wilayah Bekasi Timur.
            </p>
        </div>
    </div>

    <!-- Contact Grid (Floating Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-32">
        @php
            $contacts = [
                [
                    'label' => 'WhatsApp',
                    'desc' => 'Respon cepat untuk tanya jawab langsung.',
                    'val' => '+62 812-3456-7890',
                    'icon' => 'fab fa-whatsapp',
                    'color' => 'bg-emerald-500',
                    'link' => 'https://wa.me/6281234567890'
                ],
                [
                    'label' => 'Email Resmi',
                    'desc' => 'Kirim surat resmi atau proposal kerjasama.',
                    'val' => 'posyanduilp_kenanga1@gmail.com',
                    'icon' => 'fas fa-envelope-open-text',
                    'color' => 'bg-primary',
                    'link' => 'mailto:posyanduilp_kenanga1@gmail.com'
                ],
                [
                    'label' => 'Instagram',
                    'desc' => 'Dapatkan info kegiatan harian tim kami.',
                    'val' => '@posyandu_digital',
                    'icon' => 'fab fa-instagram',
                    'color' => 'bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600',
                    'link' => 'https://instagram.com/posyandu_digital'
                ]
            ];
        @endphp

        @foreach($contacts as $c)
        <a href="{{ $c['link'] }}" target="_blank" class="bento-card p-12 group hover-lift border border-outline-variant/30 flex flex-col h-full bg-white">
            <div class="w-20 h-20 {{ $c['color'] }} rounded-[2rem] flex items-center justify-center text-white mb-10 shadow-xl group-hover:rotate-6 transition-all duration-500">
                <i class="{{ $c['icon'] }} text-[32px]"></i>
            </div>
            <h3 class="text-2xl font-black text-on-surface mb-3 italic font-jakarta">{{ $c['label'] }}</h3>
            <p class="text-on-surface-variant text-sm font-medium leading-relaxed mb-10 opacity-70">{{ $c['desc'] }}</p>
            <div class="mt-auto flex items-center justify-between">
                <span class="text-[11px] font-black uppercase tracking-widest text-primary">{{ $c['val'] }}</span>
                <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">open_in_new</span>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Map & Address -->
    <div class="bg-surface-container rounded-[5rem] overflow-hidden shadow-2xl relative border border-outline-variant group">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="p-16 md:p-32 flex flex-col justify-center">
                <h6 class="text-primary font-black text-[10px] uppercase tracking-[0.4em] mb-6">Alamat Kantor</h6>
                <h2 class="text-4xl md:text-6xl font-black text-on-surface mb-10 leading-tight italic font-jakarta tracking-tight">Bekasi Timur,<br><span class="text-primary/30 underline decoration-primary/20">Indonesia.</span></h2>
                <div class="space-y-10 mb-16">
                    <div class="flex items-start gap-6">
                        <span class="material-symbols-outlined text-primary text-[28px] shrink-0">location_on</span>
                        <p class="text-on-surface-variant font-medium text-lg leading-relaxed max-w-sm italic opacity-80">
                            Jl. Mawar Raya No. 123, Kelurahan Duren Jaya, Kecamatan Bekasi Timur, Kota Bekasi.
                        </p>
                    </div>
                    <div class="flex items-start gap-6">
                        <span class="material-symbols-outlined text-primary text-[28px] shrink-0">schedule</span>
                        <p class="text-on-surface-variant font-medium text-lg italic opacity-80">Senin - Jumat: 08.00 - 16.00</p>
                    </div>
                </div>
                <a href="https://www.google.com/maps/search/Bekasi+Timur" target="_blank" class="btn-premium inline-flex items-center px-12 py-5 bg-on-surface text-white text-[11px] font-black uppercase tracking-widest rounded-full hover:bg-primary transition-all shadow-xl active:scale-95 self-start">
                    Dapatkan Navigasi <span class="material-symbols-outlined text-[18px] ml-4">map</span>
                </a>
            </div>
            <div class="relative min-h-[500px] lg:min-h-full overflow-hidden bg-primary-dark">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=2074&auto=format&fit=crop" 
                     class="absolute inset-0 w-full h-full object-cover opacity-50 scale-110 group-hover:scale-100 transition-all duration-[4s]" 
                     alt="Map">
                <div class="absolute inset-0 bg-primary/20 mix-blend-overlay"></div>
                {{-- Glowing dot on map --}}
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <div class="w-12 h-12 bg-primary/40 rounded-full animate-ping absolute"></div>
                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center relative shadow-[0_0_40px_var(--primary)]">
                        <span class="material-symbols-outlined text-white text-[24px]">push_pin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
