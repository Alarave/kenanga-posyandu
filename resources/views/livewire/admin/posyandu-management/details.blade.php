@extends('layouts.admin-layout')

@section('admin-title')
    Detail Posyandu: {{ $posyandu->name }}
@endsection

@section('admin-actions')
    <div class="flex gap-2">
        <a href="{{ route('admin.posyandu.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 bg-white text-gray-600 font-bold text-sm shadow-sm transition-all hover:bg-gray-50">
            <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
            Kembali
        </a>
        <a href="{{ route('admin.posyandu.edit', $posyandu->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-white font-bold text-sm shadow-sm transition-all bg-teal-600 hover:bg-teal-700">
            <span class="material-symbols-outlined" style="font-size:18px;">edit</span>
            Edit Posyandu
        </a>
    </div>
@endsection

@section('admin-content')
@php
    $balitaCount = $posyandu->patients()->where('category', 'balita')->count();
    $ibuHamilCount = $posyandu->patients()->where('category', 'ibu_hamil')->count();
    $lansiaCount = $posyandu->patients()->where('category', 'lansia')->count();
    $totalCount = $posyandu->patients()->count();
@endphp
<div class="space-y-6">
    {{-- Main Info Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Card: Detail Posyandu --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between" style="background:#F8FAFC;">
                <h3 class="font-bold text-gray-900 flex items-center gap-2" style="font-size:16px;">
                    <span class="material-symbols-outlined text-teal-600">home_health</span>
                    Informasi Unit Posyandu
                </h3>
                <span class="px-2.5 py-1 bg-teal-50 text-teal-700 rounded-full text-xs font-bold">
                    {{ $posyandu->unique_code ?: 'Tanpa Kode' }}
                </span>
            </div>
            
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-8">
                    {{-- Logo/Photo --}}
                    <div class="w-32 h-32 rounded-3xl bg-gray-50 border border-gray-100 flex-shrink-0 overflow-hidden shadow-sm">
                        @if($posyandu->logo_photo)
                            <img src="{{ asset('storage/' . $posyandu->logo_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <span class="material-symbols-outlined" style="font-size:48px;">image</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 space-y-6">
                        <div>
                            <h1 class="text-2xl font-black text-gray-900 mb-2">{{ $posyandu->name }}</h1>
                            <div class="flex items-center gap-2 text-slate-500 mb-4">
                                <span class="material-symbols-outlined" style="font-size:18px;">location_on</span>
                                <span class="text-sm font-medium">{{ $posyandu->address ?: 'Alamat belum diatur' }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-gray-50">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pedukuhan / Wilayah</p>
                                <p class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-blue-500" style="font-size:18px;">map</span>
                                    {{ $posyandu->pedukuhan->name ?? '—' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kode Unik Posyandu</p>
                                <p class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-teal-600" style="font-size:18px;">fingerprint</span>
                                    {{ $posyandu->unique_code ?: '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Distribusi Pasien Terdaftar</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                {{-- Balita --}}
                                <div class="bg-blue-50/50 border border-blue-100/50 rounded-2xl p-4 flex flex-col justify-between group hover:shadow-xs transition-all duration-300">
                                    <div class="w-8 h-8 rounded-lg bg-blue-500 text-white flex items-center justify-center shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">child_care</span>
                                    </div>
                                    <div class="mt-3">
                                        <span class="text-[9px] font-bold text-blue-600 uppercase tracking-wider block mb-0.5">Balita</span>
                                        <p class="text-2xl font-black text-slate-800 tracking-tight">{{ $balitaCount }} <span class="text-xs font-normal text-slate-400">anak</span></p>
                                    </div>
                                </div>

                                {{-- Ibu Hamil --}}
                                <div class="bg-pink-50/50 border border-pink-100/50 rounded-2xl p-4 flex flex-col justify-between group hover:shadow-xs transition-all duration-300">
                                    <div class="w-8 h-8 rounded-lg bg-pink-500 text-white flex items-center justify-center shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">pregnant_woman</span>
                                    </div>
                                    <div class="mt-3">
                                        <span class="text-[9px] font-bold text-pink-600 uppercase tracking-wider block mb-0.5">Ibu Hamil</span>
                                        <p class="text-2xl font-black text-slate-800 tracking-tight">{{ $ibuHamilCount }} <span class="text-xs font-normal text-slate-400">bumil</span></p>
                                    </div>
                                </div>

                                {{-- Lansia --}}
                                <div class="bg-orange-50/50 border border-orange-100/50 rounded-2xl p-4 flex flex-col justify-between group hover:shadow-xs transition-all duration-300">
                                    <div class="w-8 h-8 rounded-lg bg-orange-500 text-white flex items-center justify-center shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">elderly</span>
                                    </div>
                                    <div class="mt-3">
                                        <span class="text-[9px] font-bold text-orange-600 uppercase tracking-wider block mb-0.5">Lansia</span>
                                        <p class="text-2xl font-black text-slate-800 tracking-tight">{{ $lansiaCount }} <span class="text-xs font-normal text-slate-400">jiwa</span></p>
                                    </div>
                                </div>

                                {{-- Total Warga --}}
                                <div class="bg-emerald-50/50 border border-emerald-100/50 rounded-2xl p-4 flex flex-col justify-between group hover:shadow-xs transition-all duration-300">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">groups</span>
                                    </div>
                                    <div class="mt-3">
                                        <span class="text-[9px] font-bold text-emerald-600 uppercase tracking-wider block mb-0.5">Total Warga</span>
                                        <p class="text-2xl font-black text-slate-800 tracking-tight">{{ $totalCount }} <span class="text-xs font-normal text-slate-400">jiwa</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Stats --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 overflow-hidden relative">
                <div class="relative z-10">
                    <h4 class="font-bold text-gray-900 mb-4 text-sm">Kegiatan Mendatang</h4>
                    @php
                        $nextSchedule = $posyandu->schedules()->where('start_time', '>=', now())->orderBy('start_time')->first();
                    @endphp
                    @if($nextSchedule)
                        <div class="p-3 rounded-xl bg-orange-50 border border-orange-100">
                            <p class="text-xs font-bold text-orange-800">{{ $nextSchedule->title }}</p>
                            <p class="text-[10px] text-orange-600 mt-1">
                                {{ \Carbon\Carbon::parse($nextSchedule->start_time)->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                    @else
                        <p class="text-xs text-gray-400 italic">Tidak ada jadwal terdekat.</p>
                    @endif
                </div>
                <span class="material-symbols-outlined absolute -right-6 -bottom-6 text-gray-50" style="font-size:100px;">calendar_today</span>
            </div>

            <div class="bg-slate-900 rounded-2xl p-6 text-white">
                <h4 class="font-bold text-xs uppercase tracking-widest opacity-60 mb-4">Aksi Cepat</h4>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.patients.create', ['posyandu_id' => $posyandu->id]) }}" 
                       class="p-3 rounded-xl bg-white/10 hover:bg-white/20 transition text-center">
                        <span class="material-symbols-outlined block mb-1">person_add</span>
                        <span class="text-[10px] font-bold">Warga</span>
                    </a>
                    <a href="{{ route('admin.schedules.create', ['posyandu_id' => $posyandu->id]) }}" 
                       class="p-3 rounded-xl bg-white/10 hover:bg-white/20 transition text-center">
                        <span class="material-symbols-outlined block mb-1">event</span>
                        <span class="text-[10px] font-bold">Jadwal</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
