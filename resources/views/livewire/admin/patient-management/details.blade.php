@extends('layouts.admin-layout')

@section('admin-title') @endsection

@section('admin-content')
<div class="max-w-5xl mx-auto space-y-8 pb-10">

    {{-- ── Premium Header & Actions ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 px-2">
        <div class="space-y-2">
            {{-- Breadcrumbs --}}
            <nav class="flex items-center gap-2 group/nav">
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-slate-100 shadow-sm transition-all hover:border-teal-200">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-teal-600 transition-colors">
                        <span class="material-symbols-outlined text-[14px]">home</span>
                        Beranda
                    </a>
                    <span class="material-symbols-outlined text-[14px] text-slate-300">chevron_right</span>
                    <a href="{{ route('admin.patients.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-teal-600 transition-colors">Data Warga</a>
                    <span class="material-symbols-outlined text-[14px] text-slate-300">chevron_right</span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-teal-600">Profil Detail</span>
                </div>
            </nav>
            <h1 class="text-3xl font-black tracking-tight leading-none">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-emerald-500">{{ $patient->full_name }}</span>
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <x-button href="{{ route('admin.patients.edit', $patient->id) }}" 
                      variant="secondary" 
                      class="!rounded-2xl h-14 !px-8 font-black shadow-xl shadow-teal-500/10 hover:-translate-y-0.5 transition-all">
                <span class="material-symbols-outlined mr-2">edit</span>
                Edit Profil
            </x-button>
            
            <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Hapus data warga ini?')">
                @csrf @method('DELETE')
                <button type="submit" 
                        class="h-14 w-14 flex items-center justify-center rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </form>
        </div>
    </div>

    {{-- ── Bento Grid Detail ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- Card 1: Identitas Visual (Premium) --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-[3rem] border border-slate-100 p-10 flex flex-col items-center text-center relative overflow-hidden group shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                {{-- Decorative Background --}}
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-teal-500/5 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="relative mb-8">
                    <div class="w-48 h-48 rounded-[3rem] border-4 border-white bg-slate-50 shadow-xl overflow-hidden relative z-10">
                        @if($patient->profile_photo)
                            <img src="{{ asset('storage/' . $patient->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center">
                                <span class="material-symbols-outlined text-slate-300 text-[96px]" style="font-variation-settings: 'wght' 100;">account_circle</span>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 px-5 py-2 bg-slate-900 text-white text-[10px] font-black rounded-2xl uppercase tracking-[0.2em] shadow-xl z-20 whitespace-nowrap">
                        {{ str_replace('_', ' ', $patient->category) }}
                    </div>
                </div>

                <h2 class="text-3xl font-black text-slate-900 leading-tight mb-2 tracking-tight">{{ $patient->full_name }}</h2>
                <div class="flex items-center gap-2 mb-8">
                    <span @class([
                        'text-[11px] font-black px-4 py-1 rounded-full uppercase tracking-widest border',
                        'text-sky-600 bg-sky-50 border-sky-100' => $patient->gender == 'L' || $patient->gender == 'M',
                        'text-pink-600 bg-pink-50 border-pink-100' => $patient->gender == 'F' || $patient->gender == 'P',
                    ])>NIK: {{ $patient->id_number }}</span>
                </div>

                <div class="w-full grid grid-cols-2 gap-4 pt-8 border-t border-slate-50">
                    <div @class([
                        'p-4 rounded-3xl border text-center group transition-all duration-500',
                        'bg-sky-50 border-sky-100 hover:bg-white hover:shadow-sky-100/50 hover:shadow-xl' => $patient->gender == 'L' || $patient->gender == 'M',
                        'bg-pink-50 border-pink-100 hover:bg-white hover:shadow-pink-100/50 hover:shadow-xl' => $patient->gender == 'F' || $patient->gender == 'P',
                    ])>
                        <p @class([
                            'text-[9px] font-black uppercase tracking-widest mb-1',
                            'text-sky-400' => $patient->gender == 'L' || $patient->gender == 'M',
                            'text-pink-400' => $patient->gender == 'F' || $patient->gender == 'P',
                        ])>Gender</p>
                        <p @class([
                            'text-[11px] font-black',
                            'text-sky-700' => $patient->gender == 'L' || $patient->gender == 'M',
                            'text-pink-700' => $patient->gender == 'F' || $patient->gender == 'P',
                        ])>{{ ($patient->gender == 'L' || $patient->gender == 'M') ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    
                    <div class="p-4 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[2rem] text-center group hover:scale-105 transition-all duration-500 shadow-lg shadow-emerald-100 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-12 h-12 bg-white/10 rounded-full blur-lg"></div>
                        <p class="text-[9px] font-black text-white/70 uppercase tracking-widest mb-1 relative z-10">Usia</p>
                        <p class="text-[11px] font-black text-white relative z-10">{{ $patient->age }}</p>
                    </div>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="bg-white rounded-[3rem] border border-slate-100 p-8 space-y-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">contact_phone</span>
                    </div>
                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Kontak & Domisili</h4>
                </div>
                
                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">phone_iphone</span>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Nomor Telepon</p>
                            <p class="text-sm font-black text-slate-700">{{ $patient->phone_number }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">location_on</span>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Alamat</p>
                            <p class="text-sm font-bold text-slate-600 leading-relaxed">{{ $patient->address }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">home_work</span>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Lokasi Layanan</p>
                            <p class="text-sm font-black text-slate-700">{{ str_contains($patient->posyandu->name, 'Posyandu') ? $patient->posyandu->name : 'Posyandu ' . $patient->posyandu->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Data Medis & Sosial --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- Grid Informasi Spesifik (Bento Style) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Info Utama --}}
                <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">clinical_notes</span>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Data Rekam Medis</h4>
                    </div>
                    
                    <div class="space-y-6">
                        @if(in_array($patient->category, ['bayi','baduta','balita','anak_sekolah']))
                            <div class="flex justify-between items-center py-3 border-b border-slate-50">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Ayah</span>
                                <span class="text-sm font-black text-slate-700">{{ $patient->father_name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-slate-50">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Ibu</span>
                                <span class="text-sm font-black text-slate-700">{{ $patient->mother_name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Buku KIA</span>
                                <span @class([
                                    'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border',
                                    'bg-teal-50 text-teal-600 border-teal-100' => $patient->kia_book_ownership,
                                    'bg-red-50 text-red-500 border-red-100' => !$patient->kia_book_ownership,
                                ])>
                                    {{ $patient->kia_book_ownership ? 'Memiliki' : 'Tidak Ada' }}
                                </span>
                            </div>
                        @endif

                        @if(in_array($patient->category, ['ibu_hamil', 'remaja', 'umum', 'lansia']))
                            <div class="flex justify-between items-center py-3 border-b border-slate-50">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pendidikan</span>
                                <span class="text-sm font-black text-slate-700">{{ $patient->education ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pekerjaan</span>
                                <span class="text-sm font-black text-slate-700">{{ $patient->job ?? '-' }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Info Lingkungan --}}
                <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">real_estate_agent</span>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Sosial Ekonomi</h4>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-center py-3 border-b border-slate-50">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rumah</span>
                            <span class="text-sm font-black text-slate-700">{{ $patient->house_condition ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-slate-50">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sanitasi</span>
                            <span class="text-sm font-black text-slate-700">{{ $patient->has_latrine ? 'Jamban Sehat' : 'Tidak Ada' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ekonomi</span>
                            <span class="text-sm font-black text-slate-700">{{ $patient->economic_status ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Card Tambahan: Antropometri Terakhir --}}
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-[3rem] border border-emerald-100 p-10 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-white text-emerald-600 flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">monitor_weight</span>
                        </div>
                        <h4 class="text-sm font-black text-emerald-800 uppercase tracking-widest">Antropometri Terakhir</h4>
                    </div>
                    @php $lastRecord = $patient->medicalRecords()->orderBy('visit_date', 'desc')->first(); @endphp
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white/60 backdrop-blur-md rounded-2xl border border-emerald-100">
                            <p class="text-[9px] font-black text-emerald-600/60 uppercase tracking-widest mb-1">Berat</p>
                            <p class="text-xl font-black text-emerald-900">{{ $lastRecord->weight ?? '-' }} <span class="text-[10px]">kg</span></p>
                        </div>
                        <div class="p-4 bg-white/60 backdrop-blur-md rounded-2xl border border-emerald-100">
                            <p class="text-[9px] font-black text-emerald-600/60 uppercase tracking-widest mb-1">Tinggi</p>
                            <p class="text-xl font-black text-emerald-900">{{ $lastRecord->height ?? '-' }} <span class="text-[10px]">cm</span></p>
                        </div>
                    </div>
                </div>

                {{-- Card Tambahan: Atensi Kesehatan (Dinamis dari DB) --}}
                <div class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-[3rem] border border-rose-100 p-10 shadow-sm relative overflow-hidden group">
                    <div class="absolute -left-10 -top-10 w-32 h-32 bg-rose-500/5 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white text-rose-500 flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">priority_high</span>
                        </div>
                        <h4 class="text-sm font-black text-rose-800 uppercase tracking-widest">Atensi Kesehatan</h4>
                    </div>

                    @php
                        $ageMonths = $patient->age_in_months;
                        $missingVaccines = $patient->getMissingVaccines();
                        $currentMonth = now()->month;
                        $isVitaminAMonth = in_array($currentMonth, [2, 8]);
                        $hasVitaminAThisPeriod = $patient->medicalRecords()
                            ->whereMonth('visit_date', $currentMonth)
                            ->whereYear('visit_date', now()->year)
                            ->where('vitamin_a', true)
                            ->exists();
                        
                        $isEligibleVitaminA = $ageMonths >= 6 && $ageMonths <= 59;
                    @endphp

                    <div class="space-y-3">
                        {{-- Logika Vitamin A --}}
                        @if($isEligibleVitaminA)
                            @if($isVitaminAMonth && !$hasVitaminAThisPeriod)
                                <div class="flex items-center gap-3 p-3 bg-white/60 rounded-2xl border border-rose-100">
                                    <div class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></div>
                                    <p class="text-[11px] font-bold text-rose-900">Perlu vitamin A bulan ini</p>
                                </div>
                            @elseif($hasVitaminAThisPeriod)
                                <div class="flex items-center gap-3 p-3 bg-white/60 rounded-2xl border border-emerald-100 opacity-80">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <p class="text-[11px] font-bold text-emerald-800">Vitamin A sudah diberikan</p>
                                </div>
                            @else
                                <div class="flex items-center gap-3 p-3 bg-white/40 rounded-2xl border border-slate-100">
                                    <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                                    <p class="text-[11px] font-bold text-slate-500 italic">Jadwal Vitamin A: Feb/Agu</p>
                                </div>
                            @endif
                        @endif

                        {{-- Logika Imunisasi --}}
                        @if(!empty($missingVaccines))
                            <div class="flex items-center gap-3 p-3 bg-white/60 rounded-2xl border border-amber-100">
                                <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                <div class="flex-1">
                                    <p class="text-[10px] font-black text-amber-800 uppercase leading-none mb-1">Jadwal Imunisasi</p>
                                    <p class="text-[11px] font-bold text-amber-900 leading-tight">Perlu: {{ $missingVaccines[0] }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3 p-3 bg-white/60 rounded-2xl border border-emerald-100 opacity-80">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <p class="text-[11px] font-bold text-slate-600">Imunisasi dasar lengkap</p>
                            </div>
                        @endif
                        
                        @if(empty($missingVaccines) && !$isEligibleVitaminA)
                            <p class="text-[10px] text-center font-bold text-slate-400 py-4 uppercase tracking-widest italic">Tidak ada atensi mendesak</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bottom Section: Growth Chart (True Full Width) --}}
@if(in_array($patient->category, ['bayi', 'baduta', 'balita']))
    <div class="w-full px-4 md:px-8 lg:px-12 mt-16 pb-24">
        <div class="max-w-[1600px] mx-auto">
            @livewire('admin.patient-management.growth-chart', ['patient' => $patient, 'isEmbedded' => true])
        </div>
    </div>
@endif

@endsection