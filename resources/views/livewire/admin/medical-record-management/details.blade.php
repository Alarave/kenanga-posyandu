@extends('layouts.admin-layout')

@section('admin-title')
    Detail Rekam Medis - {{ $medicalRecord->patient->full_name }}
@endsection

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .bento-inner {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .bento-inner:hover {
        transform: translateY(-4px);
    }
    .gradient-text {
        background: linear-gradient(135deg, #006c49 0%, #14b8a6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endpush

@section('admin-content')
<div class="w-full pb-12 px-4 space-y-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
    
    {{-- Top Navigation & Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6" 
         x-show="loaded" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.medical-records.index') }}" 
               class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-primary hover:border-primary/30 transition-all shadow-sm">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Detail Pemeriksaan</h2>
                <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mt-1">
                    <a href="#" class="hover:text-primary">Admin</a>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <a href="{{ route('admin.medical-records.index') }}" class="hover:text-primary">Rekam Medis</a>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="text-slate-600">ID #{{ $medicalRecord->id }}</span>
                </nav>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="h-12 px-6 rounded-2xl bg-white border border-slate-200 text-slate-600 font-bold text-sm flex items-center gap-2 hover:bg-slate-50 transition-all">
                <span class="material-symbols-outlined text-[20px]">print</span>
                Cetak
            </button>
            <x-button href="{{ route('admin.medical-records.edit', $medicalRecord->id) }}" variant="primary" size="md" icon="edit" class="h-12 shadow-lg shadow-primary/20">
                Edit Data
            </x-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- LEFT COLUMN: Patient Hero & Vital Stats --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- Patient Hero Glass Card --}}
            <div class="glass-card rounded-[3rem] p-1 shadow-xl overflow-hidden group"
                 x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-100" x-transition:enter-start="opacity-0 translate-x-4">
                <div class="bg-gradient-to-br from-primary/5 via-white to-secondary/5 p-10 rounded-[2.9rem] flex flex-col md:flex-row items-center gap-10 relative">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors"></div>
                    
                    {{-- Avatar Section --}}
                    <div class="relative">
                        <div class="w-32 h-32 rounded-[2.5rem] bg-gradient-to-br from-primary to-primary-container p-1 shadow-2xl rotate-3 group-hover:rotate-0 transition-transform duration-500">
                            <div class="w-full h-full rounded-[2.3rem] bg-white flex items-center justify-center font-black text-4xl text-primary border-4 border-white overflow-hidden">
                                @if($medicalRecord->patient->profile_photo)
                                    <img src="{{ asset('storage/' . $medicalRecord->patient->profile_photo) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($medicalRecord->patient->full_name, 0, 1)) }}
                                @endif
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-full bg-white border-4 border-teal-50 flex items-center justify-center shadow-lg text-primary">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left space-y-4">
                        <div>
                            <span class="px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest border border-primary/20">
                                {{ $medicalRecord->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ $medicalRecord->patient->age }}
                            </span>
                            <h1 class="text-4xl font-black text-slate-900 tracking-tight mt-4 leading-tight">
                                {{ $medicalRecord->patient->full_name }}
                            </h1>
                            <p class="text-slate-500 font-bold flex items-center justify-center md:justify-start gap-2 mt-1">
                                <span class="material-symbols-outlined text-[18px] text-slate-400">fingerprint</span>
                                NIK: {{ $medicalRecord->patient->id_number }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 pt-4">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kunjungan Terakhir</span>
                                <span class="text-sm font-black text-slate-700">{{ $medicalRecord->visit_date->format('d M Y') }}</span>
                            </div>
                            <div class="w-px h-8 bg-slate-200"></div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Metode Ukur</span>
                                <span class="text-sm font-black text-slate-700 uppercase">{{ $medicalRecord->measurement_method === 'recumbent' ? 'Telentang' : 'Berdiri' }}</span>
                            </div>
                            <div class="w-px h-8 bg-slate-200"></div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pemeriksa</span>
                                <span class="text-sm font-black text-slate-700">{{ $medicalRecord->user->name ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Vital Stats Bento Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6"
                 x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-y-8">
                
                @php
                    $stats = [
                        ['label' => 'Berat Badan', 'value' => $medicalRecord->weight, 'unit' => 'kg', 'icon' => 'monitor_weight', 'color' => 'teal'],
                        ['label' => 'Tinggi Badan', 'value' => $medicalRecord->height, 'unit' => 'cm', 'icon' => 'height', 'color' => 'blue'],
                        ['label' => 'Lingkar Kepala', 'value' => $medicalRecord->head_circumference, 'unit' => 'cm', 'icon' => 'analytics', 'color' => 'indigo'],
                        ['label' => 'Lingkar Lengan', 'value' => $medicalRecord->upper_arm_circumference, 'unit' => 'cm', 'icon' => 'straighten', 'color' => 'rose'],
                    ];
                @endphp

                @foreach($stats as $stat)
                <div class="bento-inner bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col items-center text-center group">
                    <div class="w-14 h-14 rounded-2xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">{{ $stat['icon'] }}</span>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">{{ $stat['label'] }}</span>
                    <div class="text-3xl font-black text-slate-900 tracking-tighter">
                        {{ $stat['value'] ?? '-' }} <span class="text-sm font-bold text-slate-300 ml-1">{{ $stat['unit'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Diagnosis & Clinical Notes --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8"
                 x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 translate-y-8">
                
                {{-- Diagnosis Card --}}
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl"></div>
                    <div class="relative space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                                <span class="material-symbols-outlined">clinical_notes</span>
                            </div>
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Hasil Akhir & Diagnosa</h3>
                        </div>
                        <div class="p-8 rounded-[2rem] bg-teal-50/50 border border-teal-100/50">
                            <p class="text-xl font-black text-slate-800 leading-tight">
                                {{ $medicalRecord->diagnosis }}
                            </p>
                            @if($medicalRecord->weight_status)
                                <div class="mt-4 flex items-center gap-2">
                                    <span @class([
                                        'px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest',
                                        'bg-emerald-500 text-white' => $medicalRecord->weight_status === 'N',
                                        'bg-amber-500 text-white' => $medicalRecord->weight_status === 'T',
                                        'bg-rose-500 text-white' => $medicalRecord->weight_status === '2T',
                                    ])>
                                        Status BB: {{ $medicalRecord->weight_status === 'N' ? 'Naik' : ($medicalRecord->weight_status === 'T' ? 'Tetap/Turun' : '2x Tidak Naik') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Complaint Card --}}
                <div class="bg-slate-900 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group">
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
                    <div class="relative space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center">
                                <span class="material-symbols-outlined">forum</span>
                            </div>
                            <h3 class="text-sm font-black text-white/50 uppercase tracking-widest">Keluhan & Temuan</h3>
                        </div>
                        <div class="p-8 rounded-[2rem] bg-white/5 border border-white/10">
                            <p class="text-lg font-bold text-white/90 italic leading-relaxed">
                                "{{ $medicalRecord->complaint ?: 'Tidak ada keluhan khusus yang dicatat petugas.' }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Perkembangan KPSP Section (If exists) --}}
            @if($medicalRecord->childDevelopment)
            <div class="bg-white rounded-[3rem] p-12 border border-slate-100 shadow-sm"
                 x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0 translate-y-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-8 border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">child_care</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 tracking-tight">Evaluasi Perkembangan (KPSP)</h3>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-1">Kelompok Usia: {{ $medicalRecord->childDevelopment->age_group_months }} Bulan</p>
                        </div>
                    </div>
                    <div @class([
                        'px-6 py-3 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-lg shadow-current/10',
                        'bg-emerald-500 text-white' => $medicalRecord->childDevelopment->development_status === 'Sesuai',
                        'bg-amber-500 text-white' => $medicalRecord->childDevelopment->development_status === 'Meragukan',
                        'bg-rose-500 text-white' => $medicalRecord->childDevelopment->development_status === 'Penyimpangan',
                    ])>
                        Status: {{ $medicalRecord->childDevelopment->development_status }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @foreach([
                        'motor_gross' => ['Motorik Kasar', 'directions_run'],
                        'motor_fine' => ['Motorik Halus', 'gesture'],
                        'language' => ['Bicara & Bahasa', 'record_voice_over'],
                        'social' => ['Sosialisasi & Kemandirian', 'groups']
                    ] as $key => $info)
                    <div class="flex items-center justify-between p-6 rounded-2xl bg-slate-50 border border-slate-100/50 group hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-primary transition-colors">{{ $info[1] }}</span>
                            <span class="text-sm font-bold text-slate-700">{{ $info[0] }}</span>
                        </div>
                        @if($medicalRecord->childDevelopment->$key)
                            <div class="flex items-center gap-2 text-emerald-600 font-black text-[10px] uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span> Sesuai
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-rose-500 font-black text-[10px] uppercase tracking-widest bg-rose-50 px-3 py-1 rounded-full">
                                <span class="material-symbols-outlined text-[14px]">error</span> Belum
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                @if($medicalRecord->childDevelopment->note)
                <div class="mt-10 p-8 rounded-[2rem] bg-orange-50/30 border border-orange-100">
                    <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest block mb-2">Catatan Khusus Perkembangan</span>
                    <p class="text-sm font-bold text-slate-700 italic">"{{ $medicalRecord->childDevelopment->note }}"</p>
                </div>
                @endif
            </div>
            @endif
        </div>

        {{-- RIGHT COLUMN: Meds, Vax & Context --}}
        <div class="lg:col-span-4 space-y-8"
             x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-500" x-transition:enter-start="opacity-0 translate-x-4">
            
            {{-- Medical Context Card --}}
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl space-y-10 relative overflow-hidden">
                <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-primary/5 rounded-full blur-3xl"></div>
                
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] text-center">Treatment & Suplemen</h3>

                <div class="space-y-8 relative">
                    {{-- Imunisasi --}}
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">vaccines</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Vaksin Diberikan</span>
                                @if($medicalRecord->is_basic_immunization_complete)
                                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-tighter">✓ Lengkap</span>
                                @endif
                            </div>
                            <p @class([
                                'text-sm font-black truncate',
                                'text-slate-800' => $medicalRecord->vaccine_name,
                                'text-slate-300 italic' => !$medicalRecord->vaccine_name,
                            ])>
                                {{ $medicalRecord->vaccine_name ?: 'Tidak ada pemberian' }}
                            </p>
                        </div>
                    </div>

                    {{-- Vitamin A --}}
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">biotech</span>
                        </div>
                        <div class="flex-1">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Vitamin A</span>
                            <div class="flex items-center gap-2">
                                @if($medicalRecord->vitamin_a_color !== 'none' && $medicalRecord->vitamin_a_color !== null)
                                    <span @class([
                                        'w-4 h-4 rounded-full border-4 border-white shadow-sm',
                                        'bg-blue-500' => $medicalRecord->vitamin_a_color === 'biru',
                                        'bg-red-500' => $medicalRecord->vitamin_a_color === 'merah',
                                    ])></span>
                                    <span class="text-sm font-black text-slate-800">Kapsul {{ ucfirst($medicalRecord->vitamin_a_color) }}</span>
                                @elseif($medicalRecord->vitamin_a)
                                    <span class="w-4 h-4 rounded-full border-4 border-white shadow-sm bg-amber-500"></span>
                                    <span class="text-sm font-black text-slate-800">Sudah Diberikan</span>
                                @else
                                    <span class="text-sm font-bold text-slate-300 italic">Tidak Diberikan</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Obat Cacing --}}
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">pill</span>
                        </div>
                        <div class="flex-1">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Obat Cacing</span>
                            <span @class([
                                'text-sm font-black',
                                'text-slate-800' => $medicalRecord->deworming_medicine,
                                'text-slate-300 italic' => !$medicalRecord->deworming_medicine,
                            ])>
                                {{ $medicalRecord->deworming_medicine ? 'Diberikan' : 'Tidak Diberikan' }}
                            </span>
                        </div>
                    </div>

                    {{-- MP-ASI / ASI Eksklusif --}}
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">nutrition</span>
                        </div>
                        <div class="flex-1">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Nutrisi & MP-ASI</span>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-500">ASI Eksklusif</span>
                                    <span class="text-xs font-black {{ $medicalRecord->is_exclusive_breastfeeding ? 'text-teal-600' : 'text-slate-300' }}">
                                        {{ $medicalRecord->is_exclusive_breastfeeding ? 'YA' : 'TIDAK' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-500">MP-ASI Sesuai</span>
                                    <span class="text-xs font-black {{ $medicalRecord->mp_asi ? 'text-teal-600' : 'text-slate-300' }}">
                                        {{ $medicalRecord->mp_asi ? 'YA' : 'TIDAK' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Footer --}}
                <div class="pt-10 border-t border-slate-50">
                    <div class="bg-slate-50 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="material-symbols-outlined text-slate-400">info</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Info Administrasi</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="text-slate-400">Status Rujukan</span>
                                <span class="text-slate-700">{{ $medicalRecord->referral_type === 'None' ? 'Tidak Ada' : $medicalRecord->referral_type }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="text-slate-400">ID System</span>
                                <span class="text-slate-700">#REC-{{ str_pad($medicalRecord->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Counselor / Personnel Note --}}
            <div class="bg-gradient-to-br from-primary to-primary-container rounded-[3rem] p-10 text-white shadow-2xl shadow-primary/30 relative overflow-hidden group">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative space-y-6">
                    <h3 class="text-[10px] font-black text-white/50 uppercase tracking-widest">Nasihat & Konseling</h3>
                    <p class="text-sm font-bold leading-relaxed">
                        {{ $medicalRecord->counseling_notes ?: 'Berikan nutrisi yang cukup dan pastikan anak mendapatkan istirahat yang berkualitas.' }}
                    </p>
                    <div class="pt-6 border-t border-white/10 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-white/50 uppercase tracking-widest">Petugas</span>
                            <span class="text-xs font-black">{{ $medicalRecord->user->name ?? 'Staf Posyandu' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
on