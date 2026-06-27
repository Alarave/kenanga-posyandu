{{-- Card Informasi Detail Balita (Unified Premium Card) --}}
<div class="bg-white rounded-[3rem] border border-slate-100 shadow-[0_4px_30px_rgba(15,23,42,0.06)] overflow-hidden transition-all duration-500 relative">
    @include('livewire.admin.patient-management.details.header')

    {{-- Details Sections in Google Form style (Stacked Vertically) --}}
    <div class="px-12 pb-12 space-y-12">
        {{-- Section 1: Identitas Pribadi --}}
        <div class="pt-10">
            <h3 class="text-base font-black text-on-surface uppercase tracking-[0.2em] mb-8 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-outline">badge</span>
                Identitas Pribadi
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Gender --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Gender</span>
                    <span @class([
                        'px-4 py-2 rounded-2xl text-sm font-black uppercase tracking-wider border inline-block w-fit shadow-xs',
                        'bg-sky-50 text-sky-600 border-sky-100' => $patient->gender == 'L' || $patient->gender == 'M',
                        'bg-pink-50 text-pink-600 border-pink-100' => $patient->gender == 'F' || $patient->gender == 'P',
                    ])>
                        {{ ($patient->gender == 'L' || $patient->gender == 'M') ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                </div>
                {{-- Tempat Lahir --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Tempat Lahir</span>
                    <span class="text-headline-sm font-black text-on-surface">{{ $patient->place_of_birth ?? '-' }}</span>
                </div>
                {{-- Tanggal Lahir --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Tanggal Lahir</span>
                    <span class="text-headline-sm font-black text-on-surface">{{ \Carbon\Carbon::parse($patient->birth_date)->translatedFormat('d M Y') }}</span>
                </div>
                {{-- Usia --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Usia</span>
                    <span class="text-headline-sm font-black text-on-surface">{{ $patient->age }}</span>
                </div>
            </div>
        </div>

        {{-- Section 2: Keluarga & Lahir --}}
        <div class="pt-10 border-t border-slate-100">
            <h3 class="text-base font-black text-on-surface uppercase tracking-[0.2em] mb-8 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-outline">family_restroom</span>
                Keluarga & Lahir
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Ayah --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Ayah</span>
                    <span class="text-headline-sm font-black text-on-surface leading-snug">{{ $patient->father_name ?? '-' }}</span>
                </div>
                {{-- Ibu --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Ibu</span>
                    <span class="text-headline-sm font-black text-on-surface leading-snug">{{ $patient->mother_name ?? '-' }}</span>
                </div>
                {{-- BB Lahir --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Berat Lahir</span>
                    <span class="text-headline-sm font-black text-on-surface">{{ isset($patient->weight_at_birth) ? $patient->weight_at_birth . ' kg' : '-' }}</span>
                </div>
                {{-- PB Lahir --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Tinggi Lahir</span>
                    <span class="text-headline-sm font-black text-on-surface">{{ isset($patient->height_at_birth) ? $patient->height_at_birth . ' cm' : '-' }}</span>
                </div>
                {{-- NIK Ibu --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">NIK Ibu</span>
                    <span class="text-headline-sm font-black text-on-surface font-mono">{{ $patient->mother_nik ?? '-' }}</span>
                </div>
                {{-- KIA Ownership --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Buku KIA</span>
                    @if($patient->kia_book_ownership)
                        <span class="bg-primary text-white px-5 py-2.5 rounded-2xl text-xs font-black w-fit uppercase tracking-wider border border-teal-700 shadow-xs inline-block">Memiliki</span>
                    @else
                        <span class="bg-red-500 text-white px-5 py-2.5 rounded-2xl text-xs font-black w-fit uppercase tracking-wider border border-red-600 shadow-xs inline-block">Tidak Memiliki</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Section 3: Domisili & Kontak --}}
        <div class="pt-10 border-t border-slate-100">
            <h3 class="text-base font-black text-on-surface uppercase tracking-[0.2em] mb-8 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-outline">location_on</span>
                Domisili & Kontak
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Telepon --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Telepon</span>
                    <span class="text-headline-sm font-black text-on-surface font-mono">{{ $patient->phone_number ?? '-' }}</span>
                </div>
                {{-- Unit Posyandu --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Unit Posyandu</span>
                    <span class="px-4 py-2 rounded-2xl text-sm font-black uppercase tracking-wider border inline-block bg-primary-container text-primary border-teal-100 w-fit shadow-xs">{{ $patient->posyandu->name ?? '-' }}</span>
                </div>
                {{-- RT --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">RT</span>
                    <span class="text-headline-sm font-black text-on-surface">{{ $patient->rt_domisili ? 'RT ' . sprintf('%02d', $patient->rt_domisili) : '-' }}</span>
                </div>
                {{-- Alamat --}}
                <div class="bg-surface-container-low/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between gap-3 shadow-xs hover:bg-surface-container-low transition-colors sm:col-span-2 lg:col-span-1">
                    <span class="text-xs font-black text-outline-variant uppercase tracking-widest">Alamat</span>
                    <span class="text-base font-black text-on-surface leading-snug">{{ $patient->address }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $immunizationStatus = $patient->getImmunizationStatus();
    $totalCount = 0;
    $receivedCount = 0;
    foreach ($immunizationStatus as $group) {
        foreach ($group['vaccines'] as $vax) {
            $totalCount++;
            if ($vax['received']) {
                $receivedCount++;
            }
        }
    }
@endphp

{{-- Kartu Imunisasi --}}
<div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,108,73,0.05)] mt-8">
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-secondary-container text-secondary flex items-center justify-center shadow-xs">
                <span class="material-symbols-outlined text-[28px]">vaccines</span>
            </div>
            <div>
                <h3 class="text-base font-black text-on-surface uppercase tracking-[0.2em]">Kartu Imunisasi</h3>
                <p class="text-sm font-bold text-outline-variant mt-1">Status kelengkapan vaksinasi anak</p>
            </div>
        </div>
        <div class="bg-secondary-container border border-indigo-100 rounded-2xl px-6 py-3 flex flex-col items-end shadow-xs">
            <span class="text-xs font-black text-secondary uppercase tracking-widest mb-0.5">Capaian Imunisasi</span>
            <span class="text-headline-sm font-black text-on-surface">{{ $receivedCount }} <span class="text-sm font-bold text-outline-variant">/ {{ $totalCount }}</span></span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($immunizationStatus as $group)
            <div @class([
                'p-8 rounded-2xl border transition-all duration-300',
                'bg-surface-container-low border-slate-100 opacity-60' => !$group['vaccines'][0]['is_due'],
                'bg-white border-slate-100 shadow-sm' => $group['vaccines'][0]['is_due']
            ])>
                <div class="flex items-center justify-between mb-6">
                    <span class="text-xs font-black text-secondary bg-secondary-container px-4 py-1.5 rounded-lg uppercase tracking-widest">
                        {{ $group['label'] }}
                    </span>
                    @php
                        $allReceived = collect($group['vaccines'])->every('received', true);
                        $anyDue = collect($group['vaccines'])->contains('is_due', true);
                    @endphp
                    @if($allReceived)
                        <span class="material-symbols-outlined text-emerald-500 text-[24px]">check_circle</span>
                    @elseif($anyDue)
                        <span class="material-symbols-outlined text-amber-400 text-[24px] animate-pulse">priority_high</span>
                    @endif
                </div>
                
                <div class="space-y-4">
                    @foreach($group['vaccines'] as $vax)
                        <div class="flex items-center justify-between p-5 rounded-2xl {{ $vax['received'] ? 'bg-emerald-50/50' : 'bg-surface-container/30' }}">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-sm font-black text-on-surface">{{ $vax['name'] }}</span>
                                <span class="text-xs font-bold text-outline uppercase tracking-wider">{{ $vax['prevent'] }}</span>
                            </div>
                            @if($vax['received'])
                                <div class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center shadow-xs">
                                    <span class="material-symbols-outlined text-[18px]">done</span>
                                </div>
                            @else
                                <div class="w-9 h-9 rounded-xl bg-surface-container-high text-outline flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[18px]">close</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
