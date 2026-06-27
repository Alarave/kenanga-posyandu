@php $lastRecord = $patient->medicalRecords()->orderBy('visit_date', 'desc')->first(); @endphp
{{-- Card Informasi Detail Lansia (Unified Premium Card) --}}
<div class="bg-white rounded-[3rem] border border-slate-100 shadow-[0_4px_30px_rgba(15,23,42,0.06)] overflow-hidden transition-all duration-500 relative">
    @include('livewire.admin.patient-management.details.header')

    {{-- Details Sections in Google Form style (Stacked Vertically) --}}
    <div class="px-12 pb-12 pt-10 space-y-10">
        {{-- Section 1: Identitas Pribadi --}}
        <div>
            <h4 class="text-base font-black text-on-surface uppercase tracking-[0.2em] mb-6 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-outline">badge</span>
                Identitas Pribadi
            </h4>
            <div class="space-y-5">
                {{-- Gender --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Jenis Kelamin</p>
                    <span @class([
                        'px-3.5 py-1.5 rounded-xl text-base font-black uppercase tracking-wider border inline-block w-fit shadow-xs',
                        'bg-sky-50 text-sky-600 border-sky-100' => $patient->gender == 'L' || $patient->gender == 'M',
                        'bg-pink-50 text-pink-600 border-pink-100' => $patient->gender == 'F' || $patient->gender == 'P',
                    ])>
                        {{ ($patient->gender == 'L' || $patient->gender == 'M') ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                </div>
                {{-- Tempat Lahir --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Tempat Lahir</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->place_of_birth ?? '-' }}</span>
                </div>
                {{-- Tanggal Lahir --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Tanggal Lahir</p>
                    <span class="text-body-lg font-black text-on-surface">{{ \Carbon\Carbon::parse($patient->birth_date)->translatedFormat('d F Y') }}</span>
                </div>
                {{-- Usia --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Usia</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->age }}</span>
                </div>
                {{-- Riwayat Penyakit --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Riwayat Penyakit</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->historical_diseases ?? '-' }}</span>
                </div>
                {{-- Obat Saat Ini --}}
                <div class="pb-4 last:border-b-0 last:pb-0">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Obat Saat Ini</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $lastRecord->current_medication ?? '-' }}</span>
                </div>
            </div>
        </div>

        <hr class="border-slate-100">

        {{-- Section 2: Domisili & Kontak --}}
        <div>
            <h4 class="text-base font-black text-on-surface uppercase tracking-[0.2em] mb-6 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-outline">location_on</span>
                Domisili & Kontak
            </h4>
            <div class="space-y-5">
                {{-- No HP --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">No. HP / WhatsApp</p>
                    <span class="text-body-lg font-black text-on-surface font-mono">{{ $patient->phone_number ?? '-' }}</span>
                </div>
                {{-- Unit Posyandu --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2.5">Unit Posyandu</p>
                    <span class="px-3.5 py-1.5 rounded-xl text-base font-black uppercase tracking-wider border inline-block bg-primary-container text-primary border-teal-100 shadow-xs">{{ $patient->posyandu->name ?? '-' }}</span>
                </div>
                {{-- RT --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">RT Domisili</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->rt_domisili ? 'RT ' . sprintf('%02d', $patient->rt_domisili) : '-' }}</span>
                </div>
                {{-- RW --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">RW Domisili</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->dusun_rt_rw ?? '-' }}</span>
                </div>
                {{-- Alamat --}}
                <div class="pb-4 last:border-b-0 last:pb-0">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Alamat Lengkap</p>
                    <span class="text-base font-semibold text-on-surface-variant leading-relaxed bg-surface-container-low/50 p-4 rounded-2xl border border-slate-100/60 block">{{ $patient->address }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Posbindu Metrics Monitor (Premium Bento) --}}
<div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] mt-8">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-14 h-14 rounded-2xl bg-error-container text-error flex items-center justify-center shadow-xs">
            <span class="material-symbols-outlined text-[28px]">monitoring</span>
        </div>
        <h4 class="text-base font-black text-on-surface uppercase tracking-widest">Pengukuran Posbindu Terakhir</h4>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        {{-- Blood Pressure --}}
        <div class="p-8 rounded-2xl border border-slate-100 bg-surface-container-low/50 hover:bg-white hover:shadow-xl transition-all duration-300">
            <p class="text-xs font-black text-outline-variant uppercase tracking-widest mb-2">Tekanan Darah</p>
            @if(isset($lastRecord->systolic_bp) && isset($lastRecord->diastolic_bp))
                <p class="text-headline-md font-black text-on-surface">{{ $lastRecord->systolic_bp }}/{{ $lastRecord->diastolic_bp }} <span class="text-xs font-bold text-outline-variant">mmHg</span></p>
                @php
                    $isHighBp = $lastRecord->systolic_bp >= 140 || $lastRecord->diastolic_bp >= 90;
                    $isLowBp = $lastRecord->systolic_bp < 90 || $lastRecord->diastolic_bp < 60;
                @endphp
                @if($isHighBp)
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-red-50 text-error border border-red-100">Hipertensi</span>
                @elseif($isLowBp)
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-blue-50 text-secondary border border-blue-100">Hipotensi</span>
                @else
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-emerald-50 text-primary border border-emerald-100">Normal</span>
                @endif
            @else
                <p class="text-headline-md font-black text-outline-variant">-</p>
            @endif
        </div>

        {{-- Blood Sugar --}}
        <div class="p-8 rounded-2xl border border-slate-100 bg-surface-container-low/50 hover:bg-white hover:shadow-xl transition-all duration-300">
            <p class="text-xs font-black text-outline-variant uppercase tracking-widest mb-2">Gula Darah</p>
            @if(isset($lastRecord->blood_sugar))
                <p class="text-headline-md font-black text-on-surface">{{ $lastRecord->blood_sugar }} <span class="text-xs font-bold text-outline-variant">mg/dL</span></p>
                @if($lastRecord->blood_sugar >= 200)
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-red-50 text-error border border-red-100">Tinggi</span>
                @elseif($lastRecord->blood_sugar < 70)
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-blue-50 text-secondary border border-blue-100">Rendah</span>
                @else
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-emerald-50 text-primary border border-emerald-100">Normal</span>
                @endif
            @else
                <p class="text-headline-md font-black text-outline-variant">-</p>
            @endif
        </div>

        {{-- Uric Acid --}}
        <div class="p-8 rounded-2xl border border-slate-100 bg-surface-container-low/50 hover:bg-white hover:shadow-xl transition-all duration-300">
            <p class="text-xs font-black text-outline-variant uppercase tracking-widest mb-2">Asam Urat</p>
            @if(isset($lastRecord->uric_acid))
                <p class="text-headline-md font-black text-on-surface">{{ $lastRecord->uric_acid }} <span class="text-xs font-bold text-outline-variant">mg/dL</span></p>
                @php
                    $isHighUric = ($patient->gender == 'L' || $patient->gender == 'M') ? ($lastRecord->uric_acid >= 7.0) : ($lastRecord->uric_acid >= 6.0);
                @endphp
                @if($isHighUric)
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-red-50 text-error border border-red-100">Tinggi</span>
                @else
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-emerald-50 text-primary border border-emerald-100">Normal</span>
                @endif
            @else
                <p class="text-headline-md font-black text-outline-variant">-</p>
            @endif
        </div>

        {{-- Cholesterol --}}
        <div class="p-8 rounded-2xl border border-slate-100 bg-surface-container-low/50 hover:bg-white hover:shadow-xl transition-all duration-300">
            <p class="text-xs font-black text-outline-variant uppercase tracking-widest mb-2">Kolesterol</p>
            @if(isset($lastRecord->cholesterol))
                <p class="text-headline-md font-black text-on-surface">{{ $lastRecord->cholesterol }} <span class="text-xs font-bold text-outline-variant">mg/dL</span></p>
                @if($lastRecord->cholesterol >= 200)
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-red-50 text-error border border-red-100">Tinggi</span>
                @else
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-emerald-50 text-primary border border-emerald-100">Normal</span>
                @endif
            @else
                <p class="text-headline-md font-black text-outline-variant">-</p>
            @endif
        </div>
    </div>
</div>
