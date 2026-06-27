@extends('layouts.admin-layout')

@section('admin-title')
    Detail Rekam Medis - {{ $medicalRecord->patient->full_name }}
@endsection



@section('admin-content')
@php
    $category = $medicalRecord->patient->category ?? 'balita';
    $isChild = in_array($category, ['bayi', 'baduta', 'balita', 'anak_sekolah']);
    $isPregnancy = ($category === 'ibu_hamil');
    $isLansia = ($category === 'lansia');
@endphp

<div class="w-full pb-12 px-4 space-y-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
    
    {{-- Top Navigation & Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6" 
         x-show="loaded" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.medical-records.index') }}" 
               class="w-12 h-12 rounded-2xl bg-white border border-outline-variant flex items-center justify-center text-outline hover:text-primary hover:border-primary/30 transition-all shadow-sm no-print">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h2 class="text-headline-md font-black text-on-surface tracking-tight">Detail Pemeriksaan</h2>
                <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-outline-variant mt-1">
                    <a href="#" class="hover:text-primary">Admin</a>
                    <span class="w-1 h-1 rounded-lg bg-slate-300"></span>
                    <a href="{{ route('admin.medical-records.index') }}" class="hover:text-primary">Rekam Medis</a>
                    <span class="w-1 h-1 rounded-lg bg-slate-300"></span>
                    <span class="text-on-surface-variant">ID #{{ $medicalRecord->id }}</span>
                </nav>
            </div>
        </div>
        <div class="flex items-center gap-3 no-print">
            <button onclick="window.print()" class="h-12 px-6 rounded-2xl bg-white border border-outline-variant text-on-surface-variant font-bold text-sm flex items-center gap-2 hover:bg-surface-container-low transition-all">
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
                <div class="bg-linear-to-br from-primary/5 via-white to-secondary/5 p-10 rounded-[2.9rem] flex flex-col md:flex-row items-center gap-10 relative">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-lg blur-3xl group-hover:bg-primary/10 transition-colors"></div>
                    
                    {{-- Avatar Section --}}
                    <div class="relative">
                        <div class="w-32 h-32 rounded-[2.5rem] bg-linear-to-br from-primary to-primary-container p-1 shadow-2xl rotate-3 group-hover:rotate-0 transition-transform duration-500">
                            <div class="w-full h-full rounded-[2.3rem] bg-white flex items-center justify-center font-black text-4xl text-primary border-4 border-white overflow-hidden">
                                @if($medicalRecord->patient->profile_photo)
                                    <img src="{{ asset('storage/' . $medicalRecord->patient->profile_photo) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($medicalRecord->patient->full_name, 0, 1)) }}
                                @endif
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-lg bg-white border-4 border-teal-50 flex items-center justify-center shadow-lg text-primary">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left space-y-4">
                        <div>
                            <span class="px-4 py-1.5 rounded-lg bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest border border-primary/20">
                                @if($isChild)
                                    Balita ({{ ucfirst($category) }}) • {{ $medicalRecord->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ $medicalRecord->patient->age }}
                                @elseif($isPregnancy)
                                    Ibu Hamil / Nifas • {{ $medicalRecord->patient->age }}
                                @elseif($isLansia)
                                    Lansia • {{ $medicalRecord->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ $medicalRecord->patient->age }}
                                @else
                                    {{ ucfirst($category) }} • {{ $medicalRecord->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ $medicalRecord->patient->age }}
                                @endif
                            </span>
                            <h1 class="text-4xl font-black text-on-surface tracking-tight mt-4 leading-tight">
                                {{ $medicalRecord->patient->full_name }}
                            </h1>
                            <p class="text-outline font-bold flex items-center justify-center md:justify-start gap-2 mt-1">
                                <span class="material-symbols-outlined text-[18px] text-outline-variant">fingerprint</span>
                                NIK: {{ $medicalRecord->patient->id_number }}
                            </p>
                            @if($isPregnancy && $medicalRecord->patient->husband_name)
                                <p class="text-outline text-sm font-semibold flex items-center justify-center md:justify-start gap-2 mt-1">
                                    <span class="material-symbols-outlined text-[18px] text-outline-variant">person</span>
                                    Nama Suami: {{ $medicalRecord->patient->husband_name }}
                                </p>

                            @endif
                            @if($medicalRecord->patient->phone_number)
                                <p class="text-outline text-sm font-semibold flex items-center justify-center md:justify-start gap-2 mt-1">
                                    <span class="material-symbols-outlined text-[18px] text-outline-variant">phone</span>
                                    No HP: {{ $medicalRecord->patient->phone_number }}
                                </p>
                            @endif
                            @if($medicalRecord->patient->address)
                                <p class="text-outline text-sm font-semibold flex items-center justify-center md:justify-start gap-2 mt-1">
                                    <span class="material-symbols-outlined text-[18px] text-outline-variant">home</span>
                                    Alamat: {{ $medicalRecord->patient->address }}
                                    @if($medicalRecord->patient->dusun_rt_rw || $medicalRecord->patient->desa_kelurahan || $medicalRecord->patient->kecamatan)
                                        ({{ implode(', ', array_filter([$medicalRecord->patient->dusun_rt_rw, $medicalRecord->patient->desa_kelurahan, $medicalRecord->patient->kecamatan])) }})
                                    @endif
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 pt-4">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest">Tanggal Periksa</span>
                                <span class="text-sm font-black text-on-surface-variant">{{ $medicalRecord->visit_date->format('d M Y') }}</span>
                            </div>
                            @if($isChild)
                                <div class="w-px h-8 bg-surface-container-high"></div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest">Metode Ukur</span>
                                    <span class="text-sm font-black text-on-surface-variant uppercase">{{ $medicalRecord->measurement_method === 'recumbent' ? 'Telentang' : 'Berdiri' }}</span>
                                </div>
                            @elseif($isPregnancy && $medicalRecord->gestational_age)
                                <div class="w-px h-8 bg-surface-container-high"></div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest">Usia Kehamilan</span>
                                    <span class="text-sm font-black text-on-surface-variant">{{ $medicalRecord->gestational_age }}</span>
                                </div>
                            @endif
                            <div class="w-px h-8 bg-surface-container-high"></div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest">Pemeriksa</span>
                                <span class="text-sm font-black text-on-surface-variant">{{ $medicalRecord->user->name ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Vital Stats Bento Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6"
                 x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-y-8">
                
                @php
                    if ($isChild) {
                        $stats = [
                            ['label' => 'Berat Badan', 'value' => $medicalRecord->weight, 'unit' => 'kg', 'icon' => 'monitor_weight', 'color' => 'teal'],
                            ['label' => 'Tinggi Badan', 'value' => $medicalRecord->height, 'unit' => 'cm', 'icon' => 'height', 'color' => 'blue'],
                            ['label' => 'Lingkar Kepala', 'value' => $medicalRecord->head_circumference, 'unit' => 'cm', 'icon' => 'analytics', 'color' => 'indigo'],
                            ['label' => 'Lingkar Lengan', 'value' => $medicalRecord->upper_arm_circumference, 'unit' => 'cm', 'icon' => 'straighten', 'color' => 'rose'],
                        ];
                    } elseif ($isPregnancy) {
                        $stats = [
                            ['label' => 'BB Sekarang', 'value' => $medicalRecord->weight, 'unit' => 'kg', 'icon' => 'monitor_weight', 'color' => 'teal'],
                            ['label' => 'Tekanan Darah', 'value' => $medicalRecord->blood_pressure, 'unit' => 'mmHg', 'icon' => 'favorite', 'color' => 'blue'],
                            ['label' => 'LILA Bumil', 'value' => $medicalRecord->upper_arm_circumference, 'unit' => 'cm', 'icon' => 'straighten', 'color' => 'rose'],
                            ['label' => 'Usia Kehamilan', 'value' => $medicalRecord->gestational_age ?: '-', 'unit' => '', 'icon' => 'calendar_today', 'color' => 'indigo'],
                        ];
                    } else { // Lansia
                        $stats = [
                            ['label' => 'Berat Badan', 'value' => $medicalRecord->weight, 'unit' => 'kg', 'icon' => 'monitor_weight', 'color' => 'teal'],
                            ['label' => 'Tinggi Badan', 'value' => $medicalRecord->height, 'unit' => 'cm', 'icon' => 'height', 'color' => 'blue'],
                            ['label' => 'IMT Lansia', 'value' => $medicalRecord->imt, 'unit' => '', 'icon' => 'analytics', 'color' => 'indigo'],
                            ['label' => 'Lingkar Perut', 'value' => $medicalRecord->waist_circumference, 'unit' => 'cm', 'icon' => 'straighten', 'color' => 'rose'],
                        ];
                    }
                @endphp

                @foreach($stats as $stat)
                <div class="bento-inner bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col items-center text-center group">
                    <div class="w-14 h-14 rounded-2xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">{{ $stat['icon'] }}</span>
                    </div>
                    <span class="text-[10px] font-black text-outline-variant uppercase tracking-[0.2em] mb-2">{{ $stat['label'] }}</span>
                    <div class="text-headline-md font-black text-on-surface tracking-tighter">
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
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-lg blur-3xl"></div>
                    <div class="relative space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-primary-container text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined">clinical_notes</span>
                            </div>
                            <h3 class="text-sm font-black text-on-surface uppercase tracking-widest">Hasil Akhir & Diagnosa</h3>
                        </div>
                        <div class="p-8 rounded-2xl bg-primary-container/50 border border-teal-100/50">
                            <p class="text-headline-sm font-black text-on-surface leading-tight">
                                {{ $medicalRecord->diagnosis ?: 'Tidak ada diagnosis atau kesimpulan khusus.' }}
                            </p>
                            @if($isChild && $medicalRecord->weight_status)
                                <div class="mt-4 flex items-center gap-2">
                                    <span @class([
                                        'px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest',
                                        'bg-primary text-white' => $medicalRecord->weight_status === 'N',
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
                <div class="bg-inverse-surface rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group">
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary/10 rounded-lg blur-3xl"></div>
                    <div class="relative space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center">
                                <span class="material-symbols-outlined">forum</span>
                            </div>
                            <h3 class="text-sm font-black text-white/50 uppercase tracking-widest">Keluhan & Temuan</h3>
                        </div>
                        <div class="p-8 rounded-2xl bg-white/5 border border-white/10">
                            <p class="text-body-lg font-bold text-white/90 italic leading-relaxed">
                                "{{ $medicalRecord->complaint ?: 'Tidak ada keluhan khusus yang dicatat petugas.' }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CATEGORY SPECIFIC LAYOUTS --}}
            @if($isChild)
                {{-- Perkembangan KPSP Section --}}
                @if($medicalRecord->childDevelopment)
                <div class="bg-white rounded-[3rem] p-12 border border-slate-100 shadow-sm"
                     x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0 translate-y-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-8 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-display-sm">child_care</span>
                            </div>
                            <div>
                                <h3 class="text-body-lg font-black text-on-surface tracking-tight">Evaluasi Perkembangan (KPSP)</h3>
                                <p class="text-sm font-bold text-outline-variant uppercase tracking-widest mt-1">Kelompok Usia: {{ $medicalRecord->childDevelopment->age_group_months }} Bulan</p>
                            </div>
                        </div>
                        <div @class([
                            'px-6 py-3 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-lg shadow-current/10',
                            'bg-primary text-white' => $medicalRecord->childDevelopment->development_status === 'Sesuai',
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
                        <div class="flex items-center justify-between p-6 rounded-2xl bg-surface-container-low border border-slate-100/50 group hover:bg-white hover:shadow-md transition-all">
                            <div class="flex items-center gap-4">
                                <span class="material-symbols-outlined text-slate-300 group-hover:text-primary transition-colors">{{ $info[1] }}</span>
                                <span class="text-sm font-bold text-on-surface-variant">{{ $info[0] }}</span>
                            </div>
                            @if($medicalRecord->childDevelopment->$key)
                                <div class="flex items-center gap-2 text-primary font-black text-[10px] uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span> Sesuai
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-error font-black text-[10px] uppercase tracking-widest bg-error-container px-3 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-[14px]">error</span> Belum
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    @if($medicalRecord->childDevelopment->note)
                    <div class="mt-10 p-8 rounded-2xl bg-orange-50/30 border border-orange-100">
                        <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest block mb-2">Catatan Khusus Perkembangan</span>
                        <p class="text-sm font-bold text-on-surface-variant italic">"{{ $medicalRecord->childDevelopment->note }}"</p>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Skrining TBC Anak --}}
                @if($medicalRecord->tbc_screening_cough || $medicalRecord->tbc_screening_fever || $medicalRecord->tbc_screening_contact || $medicalRecord->tbc_screening_lethargy || $medicalRecord->tbc_screening_lumps || $medicalRecord->other_symptoms || $medicalRecord->pmt_given)
                <div class="bg-white rounded-[3rem] p-12 border border-slate-100 shadow-sm"
                     x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0 translate-y-8">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="w-14 h-14 rounded-2xl bg-error-container text-error flex items-center justify-center">
                            <span class="material-symbols-outlined text-display-sm">medical_services</span>
                        </div>
                        <div>
                            <h3 class="text-body-lg font-black text-on-surface tracking-tight">Skrining Kesehatan & Gejala</h3>
                            <p class="text-sm font-bold text-outline-variant uppercase tracking-widest mt-1">Deteksi Dini Gejala Penyakit / TBC Balita</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach([
                            'tbc_screening_cough' => 'Batuk > 2 Minggu',
                            'tbc_screening_fever' => 'Demam > 2 Minggu',
                            'tbc_screening_contact' => 'Kontak Serumah TBC',
                            'tbc_screening_lethargy' => 'Anak Lesu / Tidak Aktif',
                            'tbc_screening_lumps' => 'Benjolan di Leher'
                        ] as $key => $label)
                        <div class="flex items-center justify-between p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                            <span class="text-sm font-bold text-on-surface-variant">{{ $label }}</span>
                            @if($medicalRecord->$key)
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-rose-100 text-rose-700">YA</span>
                            @else
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-surface-container-high text-outline">TIDAK</span>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    @if($medicalRecord->other_symptoms)
                    <div class="mt-8 p-6 rounded-2xl bg-surface-container-low border border-slate-100/50">
                        <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-2">Gejala Lainnya</span>
                        <p class="text-sm font-semibold text-on-surface-variant">{{ $medicalRecord->other_symptoms }}</p>
                    </div>
                    @endif

                    @if($medicalRecord->pmt_given)
                    <div class="mt-4 p-6 rounded-2xl bg-primary-container/50 border border-teal-100/50">
                        <span class="text-[10px] font-black text-primary uppercase tracking-widest block mb-2">Makanan Tambahan (PMT)</span>
                        <p class="text-sm font-bold text-teal-800">{{ $medicalRecord->pmt_given }}</p>
                    </div>
                    @endif
                </div>
                @endif

            @elseif($isPregnancy)
                {{-- Riwayat Kehamilan bumil --}}
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group"
                     x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0 translate-y-8">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-lg blur-3xl"></div>
                    <div class="relative space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-primary-container text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined">assignment</span>
                            </div>
                            <h3 class="text-sm font-black text-on-surface uppercase tracking-widest">Riwayat Kehamilan & Persalinan</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-6 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Kehamilan Ke (Anak Ke)</span>
                                <span class="text-body-lg font-black text-on-surface">{{ $medicalRecord->pregnancy_number ?? '-' }}</span>
                            </div>
                            <div class="p-6 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Jarak Kehamilan Sebelumnya</span>
                                <span class="text-body-lg font-black text-on-surface">{{ $medicalRecord->pregnancy_spacing ?? '-' }}</span>
                            </div>
                            <div class="p-6 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Berat & Tinggi Badan Awal</span>
                                <span class="text-body-lg font-black text-on-surface">
                                    BB: {{ $medicalRecord->starting_weight ?? '-' }} kg / TB: {{ $medicalRecord->starting_height ?? '-' }} cm
                                </span>
                            </div>
                            <div class="p-6 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Persalinan (HPL / Nyata)</span>
                                <span class="text-body-lg font-black text-on-surface">
                                    {{ $medicalRecord->delivery_date ? $medicalRecord->delivery_date->format('d M Y') : '-' }} 
                                    @if($medicalRecord->delivery_method)
                                        ({{ $medicalRecord->delivery_method }})
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ANC checkup & Plotting KIA --}}
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group"
                     x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0 translate-y-8">
                    <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-pink-500/5 rounded-lg blur-3xl"></div>
                    <div class="relative space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center">
                                <span class="material-symbols-outlined">analytics</span>
                            </div>
                            <h3 class="text-sm font-black text-on-surface uppercase tracking-widest">Pemeriksaan Bumil (ANC) & Plotting KIA</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="p-6 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Plotting IMT (KIA)</span>
                                <span class="text-base font-black text-on-surface">{{ $medicalRecord->imt_plotting_status ?: '-' }}</span>
                            </div>
                            <div class="p-6 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Plotting LILA (KIA)</span>
                                <span class="text-base font-black text-on-surface">{{ $medicalRecord->lila_plotting_status ?: '-' }}</span>
                            </div>
                            <div class="p-6 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Plotting TD (KIA)</span>
                                <span class="text-base font-black text-on-surface">{{ $medicalRecord->bp_plotting_status ?: '-' }}</span>
                            </div>
                        </div>

                        {{-- Skrining Gejala TBC Bumil --}}
                        <div class="p-6 rounded-2xl border border-slate-100 space-y-4">
                            <span class="text-xs font-black text-outline uppercase tracking-widest block border-b pb-2">Skrining Gejala TBC Bumil</span>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach([
                                    'tbc_screening_cough' => 'Batuk Terus',
                                    'tbc_screening_fever' => 'Demam >2 Minggu',
                                    'tbc_screening_weight_loss' => 'BB Turun',
                                    'tbc_screening_contact' => 'Kontak Pasien TBC'
                                ] as $key => $label)
                                    <div class="p-4 rounded-xl bg-surface-container-low border border-slate-100 flex flex-col items-center">
                                        <span class="text-[9px] font-black text-outline-variant uppercase tracking-tight text-center">{{ $label }}</span>
                                        <span class="text-sm font-black mt-1 uppercase {{ $medicalRecord->$key ? 'text-error' : 'text-on-surface-variant' }}">
                                            {{ $medicalRecord->$key ? 'Ya' : 'Tidak' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Postpartum / Nifas --}}
                @if($medicalRecord->postpartum_period)
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group"
                     x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0 translate-y-8">
                    <div class="absolute -top-24 -left-24 w-64 h-64 bg-orange-500/5 rounded-lg blur-3xl"></div>
                    <div class="relative space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center">
                                <span class="material-symbols-outlined">baby_changing_station</span>
                            </div>
                            <h3 class="text-sm font-black text-on-surface uppercase tracking-widest">Pemeriksaan Ibu Nifas & Menyusui</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Periode Pemeriksaan</span>
                                <span class="text-base font-black text-on-surface">{{ $medicalRecord->postpartum_period }}</span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">KB Pasca Salin</span>
                                <span class="text-base font-black text-on-surface">{{ $medicalRecord->postpartum_kb ?: '-' }}</span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Plotting IMT Nifas</span>
                                <span class="text-base font-black text-on-surface">{{ $medicalRecord->postpartum_imt_plotting ?: '-' }}</span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Plotting TD Nifas</span>
                                <span class="text-base font-black text-on-surface">{{ $medicalRecord->postpartum_bp_plotting ?: '-' }}</span>
                            </div>
                        </div>

                        <div class="p-6 rounded-2xl bg-surface-container-low border border-slate-100/50 space-y-4">
                            <span class="text-xs font-black text-outline uppercase tracking-widest block border-b pb-2">Vitamin A & Nutrisi Nifas</span>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span class="text-[9px] font-black text-outline-variant uppercase">Pemberian Vit A</span>
                                    <span class="text-sm font-black block mt-0.5 text-on-surface-variant">{{ $medicalRecord->nakes_gives_vit_a ?: '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-[9px] font-black text-outline-variant uppercase">Jumlah Kapsul</span>
                                    <span class="text-sm font-black block mt-0.5 text-on-surface-variant">{{ $medicalRecord->vit_a_capsule_count ?: '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-[9px] font-black text-outline-variant uppercase">Rutin Konsumsi</span>
                                    <span class="text-sm font-black block mt-0.5 text-on-surface-variant">{{ $medicalRecord->consumes_vit_a_regularly ?: '-' }}</span>
                                </div>
                                <div class="md:col-span-3">
                                    <span class="text-[9px] font-black text-outline-variant uppercase">Apakah Menyusui?</span>
                                    <span class="text-sm font-black block mt-0.5 text-on-surface-variant">{{ $medicalRecord->is_breastfeeding ?: '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            @elseif($isLansia)
                {{-- Pemeriksaan Fisik & Darah Posbindu --}}
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group"
                     x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0 translate-y-8">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-orange-500/5 rounded-lg blur-3xl"></div>
                    <div class="relative space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center">
                                <span class="material-symbols-outlined">monitor_heart</span>
                            </div>
                            <h3 class="text-sm font-black text-on-surface uppercase tracking-widest">Pemeriksaan Darah & Tekanan Darah (Posbindu)</h3>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Tekanan Darah</span>
                                <span class="text-body-lg font-black text-on-surface">
                                    @if($medicalRecord->systolic_bp || $medicalRecord->diastolic_bp)
                                        {{ $medicalRecord->systolic_bp ?? '-' }}/{{ $medicalRecord->diastolic_bp ?? '-' }} <span class="text-xs font-bold text-outline-variant">mmHg</span>
                                    @elseif($medicalRecord->blood_pressure)
                                        {{ $medicalRecord->blood_pressure }} <span class="text-xs font-bold text-outline-variant">mmHg</span>
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Gula Darah (GDS)</span>
                                <span class="text-body-lg font-black text-on-surface">
                                    {{ $medicalRecord->blood_sugar ?? '-' }} <span class="text-xs font-bold text-outline-variant">mg/dL</span>
                                </span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Asam Urat</span>
                                <span class="text-body-lg font-black text-on-surface">
                                    {{ $medicalRecord->uric_acid ?? '-' }} <span class="text-xs font-bold text-outline-variant">mg/dL</span>
                                </span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block">Kolesterol</span>
                                <span class="text-body-lg font-black text-on-surface">
                                    {{ $medicalRecord->cholesterol ?? '-' }} <span class="text-xs font-bold text-outline-variant">mg/dL</span>
                                </span>
                            </div>
                        </div>

                        @if($medicalRecord->current_medication)
                        <div class="p-6 rounded-2xl bg-surface-container-low border border-slate-100/50">
                            <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-2">Obat yang Sedang Diminum</span>
                            <p class="text-sm font-bold text-on-surface-variant">{{ $medicalRecord->current_medication }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Riwayat & Perilaku Berisiko --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8"
                     x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0 translate-y-8">
                    
                    {{-- Riwayat Penyakit Keluarga --}}
                    <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-red-500/5 rounded-lg blur-3xl"></div>
                        <div class="relative space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-red-50 text-error flex items-center justify-center">
                                    <span class="material-symbols-outlined">family_history</span>
                                </div>
                                <h3 class="text-sm font-black text-on-surface uppercase tracking-widest">Penyakit Keluarga</h3>
                            </div>
                            
                            @php
                                $familyHistory = [];
                                if (is_string($medicalRecord->family_disease_history)) {
                                    $familyHistory = json_decode($medicalRecord->family_disease_history, true) ?: [];
                                } elseif (is_array($medicalRecord->family_disease_history)) {
                                    $familyHistory = $medicalRecord->family_disease_history;
                                }
                            @endphp

                            @if(!empty($familyHistory))
                                <div class="flex flex-wrap gap-2">
                                    @foreach($familyHistory as $disease)
                                        <span class="px-4 py-2 rounded-lg bg-red-50 text-red-700 text-xs font-black border border-red-100">
                                            {{ $disease }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm font-bold text-slate-300 italic">Tidak ada riwayat penyakit keluarga.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Perilaku Berisiko Mandiri --}}
                    <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-amber-500/5 rounded-lg blur-3xl"></div>
                        <div class="relative space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                    <span class="material-symbols-outlined">warning</span>
                                </div>
                                <h3 class="text-sm font-black text-on-surface uppercase tracking-widest">Perilaku Berisiko</h3>
                            </div>

                            @php
                                $behaviors = [];
                                if (is_string($medicalRecord->risk_behaviors)) {
                                    $behaviors = json_decode($medicalRecord->risk_behaviors, true) ?: [];
                                } elseif (is_array($medicalRecord->risk_behaviors)) {
                                    $behaviors = $medicalRecord->risk_behaviors;
                                }
                            @endphp

                            @if(!empty($behaviors))
                                <div class="flex flex-wrap gap-2">
                                    @foreach($behaviors as $behavior)
                                        <span class="px-4 py-2 rounded-lg bg-amber-50 text-amber-700 text-xs font-black border border-amber-100">
                                            {{ $behavior }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm font-bold text-slate-300 italic">Tidak ada perilaku berisiko.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sensorik & Skrining Posbindu --}}
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group"
                     x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0 translate-y-8">
                    <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-indigo-500/5 rounded-lg blur-3xl"></div>
                    <div class="relative space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-secondary-container text-secondary flex items-center justify-center">
                                <span class="material-symbols-outlined">psychology</span>
                            </div>
                            <h3 class="text-sm font-black text-on-surface uppercase tracking-widest">Sensorik & Skrining Posbindu</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest block mb-1">Tes Penglihatan (Mata)</span>
                                <span class="text-sm font-black text-on-surface">{{ $medicalRecord->eye_test ?: '-' }}</span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest block mb-1">Tes Pendengaran (Telinga)</span>
                                <span class="text-sm font-black text-on-surface">{{ $medicalRecord->ear_test ?: '-' }}</span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest block mb-1">Skrining PUMA (Paru)</span>
                                <span class="text-sm font-black text-on-surface">{{ $medicalRecord->puma_screening === 'Ya' || $medicalRecord->puma_screening === '1' ? 'YA' : 'TIDAK' }}</span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest block mb-1">Skrining TBC</span>
                                <span class="text-sm font-black text-on-surface">{{ $medicalRecord->tbc_screening_status === 'Ya' || $medicalRecord->tbc_screening_status === '1' ? 'YA' : 'TIDAK' }}</span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest block mb-1">Skrining Kesehatan Jiwa</span>
                                <span class="text-sm font-black text-on-surface">{{ $medicalRecord->mental_screening === 'Ya' || $medicalRecord->mental_screening === '1' ? 'YA' : 'TIDAK' }}</span>
                            </div>
                            <div class="p-5 rounded-2xl bg-surface-container-low border border-slate-100/50">
                                <span class="text-[9px] font-black text-outline-variant uppercase tracking-widest block mb-1">Penggunaan Kontrasepsi</span>
                                <span class="text-sm font-black text-on-surface">{{ $medicalRecord->contraception ?: '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- RIGHT COLUMN: Meds, Vax & Context --}}
        <div class="lg:col-span-4 space-y-8"
             x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-500" x-transition:enter-start="opacity-0 translate-x-4">
            
            {{-- Medical Context Card --}}
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl space-y-10 relative overflow-hidden">
                <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-primary/5 rounded-lg blur-3xl"></div>
                
                @if($isChild)
                    <h3 class="text-xs font-black text-outline-variant uppercase tracking-[0.3em] text-center">Treatment & Suplemen</h3>

                    <div class="space-y-8 relative">
                        {{-- Imunisasi --}}
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 rounded-2xl bg-secondary-container text-secondary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">vaccines</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest">Vaksin Diberikan</span>
                                    @if($medicalRecord->is_basic_immunization_complete)
                                        <span class="text-[9px] font-black text-emerald-500 uppercase tracking-tighter">✓ Lengkap</span>
                                    @endif
                                </div>
                                <p @class([
                                    'text-sm font-black truncate',
                                    'text-on-surface' => $medicalRecord->vaccine_name,
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
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-1">Vitamin A</span>
                                <div class="flex items-center gap-2">
                                    @if($medicalRecord->vitamin_a_color !== 'none' && $medicalRecord->vitamin_a_color !== null)
                                        <span @class([
                                            'w-4 h-4 rounded-lg border-4 border-white shadow-sm',
                                            'bg-blue-500' => $medicalRecord->vitamin_a_color === 'biru',
                                            'bg-red-500' => $medicalRecord->vitamin_a_color === 'merah',
                                        ])></span>
                                        <span class="text-sm font-black text-on-surface">Kapsul {{ ucfirst($medicalRecord->vitamin_a_color) }}</span>
                                    @elseif($medicalRecord->vitamin_a)
                                        <span class="w-4 h-4 rounded-lg border-4 border-white shadow-sm bg-amber-500"></span>
                                        <span class="text-sm font-black text-on-surface">Sudah Diberikan</span>
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
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-1">Obat Cacing</span>
                                <span @class([
                                    'text-sm font-black',
                                    'text-on-surface' => $medicalRecord->deworming_medicine,
                                    'text-slate-300 italic' => !$medicalRecord->deworming_medicine,
                                ])>
                                    {{ $medicalRecord->deworming_medicine ? 'Diberikan' : 'Tidak Diberikan' }}
                                </span>
                            </div>
                        </div>

                        {{-- MP-ASI / ASI Eksklusif --}}
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 rounded-2xl bg-primary-container text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">nutrition</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-1">Nutrisi & MP-ASI</span>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-outline">ASI Eksklusif</span>
                                        <span class="text-xs font-black {{ $medicalRecord->is_exclusive_breastfeeding ? 'text-primary' : 'text-slate-300' }}">
                                            {{ $medicalRecord->is_exclusive_breastfeeding ? 'YA' : 'TIDAK' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-outline">MP-ASI Sesuai</span>
                                        <span class="text-xs font-black {{ $medicalRecord->mp_asi ? 'text-primary' : 'text-slate-300' }}">
                                            {{ $medicalRecord->mp_asi ? 'YA' : 'TIDAK' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($isPregnancy)
                    <h3 class="text-xs font-black text-outline-variant uppercase tracking-[0.3em] text-center">Layanan & Suplemen ANC</h3>

                    <div class="space-y-8 relative">
                        {{-- TTD / MMS --}}
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 rounded-2xl bg-secondary-container text-secondary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">pill</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-1">Tablet Tambah Darah (TTD/MMS)</span>
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-xs font-bold">
                                        <span class="text-outline">Diberikan Nakes:</span>
                                        <span class="{{ $medicalRecord->nakes_gives_fe_mms === 'Ya' ? 'text-primary' : 'text-outline' }}">{{ $medicalRecord->nakes_gives_fe_mms ?: '-' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs font-bold">
                                        <span class="text-outline">Dikonsumsi Rutin:</span>
                                        <span class="{{ $medicalRecord->consumes_fe_mms_regularly === 'Ya' ? 'text-primary' : 'text-outline' }}">{{ $medicalRecord->consumes_fe_mms_regularly ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MT Bumil KEK --}}
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 rounded-2xl bg-primary-container text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">restaurant</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-1">Makanan Tambahan (MT) KEK</span>
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-xs font-bold">
                                        <span class="text-outline">Diberikan Nakes:</span>
                                        <span class="{{ $medicalRecord->nakes_gives_mt_kek === 'Ya' ? 'text-primary' : 'text-outline' }}">{{ $medicalRecord->nakes_gives_mt_kek ?: '-' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs font-bold">
                                        <span class="text-outline">Rutin Konsumsi:</span>
                                        <span class="{{ $medicalRecord->consumes_mt_kek_regularly === 'Ya' ? 'text-primary' : 'text-outline' }}">{{ $medicalRecord->consumes_mt_kek_regularly ?: '-' }}</span>
                                    </div>
                                    @if($medicalRecord->mt_package_details)
                                        <div class="mt-2 text-xs font-bold text-on-surface-variant bg-surface-container-low p-2.5 rounded-lg border border-slate-100">
                                            Detail Paket: {{ $medicalRecord->mt_package_details }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Kelas Ibu Hamil --}}
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">school</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-1">Kelas Ibu Hamil</span>
                                <span class="text-sm font-black text-on-surface">{{ $medicalRecord->joins_pregnant_class === 'Ya' ? 'Mengikuti Kelas' : ($medicalRecord->joins_pregnant_class === 'Tidak' ? 'Tidak Mengikuti' : '-') }}</span>
                            </div>
                        </div>
                    </div>
                @else {{-- Lansia --}}
                    <h3 class="text-xs font-black text-outline-variant uppercase tracking-[0.3em] text-center">Konseling & Edukasi</h3>

                    <div class="space-y-8 relative">
                        {{-- Edukasi --}}
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 rounded-2xl bg-primary-container text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">school</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-1">Materi Edukasi Lansia</span>
                                <p class="text-sm font-bold text-on-surface-variant leading-relaxed">{{ $medicalRecord->education ?: 'Pemberian edukasi pola hidup bersih, sehat, dan nutrisi seimbang.' }}</p>
                            </div>
                        </div>

                        {{-- Riwayat Penyakit --}}
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 rounded-2xl bg-secondary-container text-secondary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">history</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest block mb-1">Riwayat Penyakit</span>
                                <p class="text-sm font-bold text-on-surface-variant leading-relaxed">{{ $medicalRecord->disease_history ?: 'Tidak ada catatan riwayat penyakit kronis.' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Action Footer --}}
                <div class="pt-10 border-t border-slate-50">
                    <div class="bg-surface-container-low rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="material-symbols-outlined text-outline-variant">info</span>
                            <span class="text-[10px] font-black text-outline-variant uppercase tracking-widest">Info Administrasi</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="text-outline-variant">Status Rujukan</span>
                                <span class="text-on-surface-variant text-right">
                                    @if($isPregnancy)
                                        {{ $medicalRecord->referral_type ?: ($medicalRecord->anc_referral ? 'Ada Rujukan ANC' : 'Tidak Ada') }}
                                    @else
                                        {{ $medicalRecord->referral_type === 'None' ? 'Tidak Ada' : ($medicalRecord->referral_type ?: 'Tidak Ada') }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="text-outline-variant">ID System</span>
                                <span class="text-on-surface-variant">#REC-{{ str_pad($medicalRecord->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Counselor / Personnel Note --}}
            <div class="bg-linear-to-br from-primary to-primary-container rounded-[3rem] p-10 text-white shadow-2xl shadow-primary/30 relative overflow-hidden group">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-lg blur-2xl"></div>
                <div class="relative space-y-6">
                    <h3 class="text-[10px] font-black text-white/50 uppercase tracking-widest">Nasihat & Konseling</h3>
                    <p class="text-sm font-bold leading-relaxed">
                        @if($isPregnancy && $medicalRecord->counseling_topic)
                            <strong>Topik Penyuluhan:</strong> {{ $medicalRecord->counseling_topic }}
                            @if($medicalRecord->counseling_notes)
                                <br><br>{{ $medicalRecord->counseling_notes }}
                            @endif
                        @elseif($isPregnancy)
                            {{ $medicalRecord->counseling_notes ?: 'Lakukan pemeriksaan kehamilan secara berkala, konsumsi zat besi/kalsium sesuai anjuran nakes.' }}
                        @else
                            {{ $medicalRecord->counseling_notes ?: 'Pertahankan pola hidup sehat, makan makanan bergizi dan rutin melakukan cek kesehatan di posyandu.' }}
                        @endif
                    </p>
                    <div class="pt-6 border-t border-white/10 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
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