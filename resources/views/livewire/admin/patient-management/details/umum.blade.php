{{-- Card Informasi Detail Umum (Unified Premium Card) --}}
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
                <div class="pb-4 last:border-b-0 last:pb-0">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Usia</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->age }}</span>
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
                {{-- Alamat --}}
                <div class="pb-4 last:border-b-0 last:pb-0">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Alamat Lengkap</p>
                    <span class="text-base font-semibold text-on-surface-variant leading-relaxed bg-surface-container-low/50 p-4 rounded-2xl border border-slate-100/60 block">{{ $patient->address }}</span>
                </div>
            </div>
        </div>

        <hr class="border-slate-100">

        {{-- Section 3: Sosial Ekonomi --}}
        <div>
            <h4 class="text-base font-black text-on-surface uppercase tracking-[0.2em] mb-6 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-outline">real_estate_agent</span>
                Sosial Ekonomi
            </h4>
            <div class="space-y-5">
                {{-- Pendidikan --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Pendidikan</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->education ?? '-' }}</span>
                </div>
                {{-- Pekerjaan --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Pekerjaan</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->job ?? '-' }}</span>
                </div>
                {{-- Rumah --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Kondisi Rumah</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->house_condition ?? '-' }}</span>
                </div>
                {{-- Sanitasi --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Sanitasi</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->has_latrine ? 'Jamban Sehat' : 'Tidak Ada' }}</span>
                </div>
                {{-- Ekonomi --}}
                <div class="pb-4 last:border-b-0 last:pb-0">
                    <p class="text-sm font-black text-outline-variant uppercase tracking-widest mb-2">Status Ekonomi</p>
                    <span class="text-body-lg font-black text-on-surface">{{ $patient->economic_status ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Card Antropometri Terakhir --}}
<div class="bg-linear-to-br from-emerald-50 to-teal-50 rounded-[3rem] border border-emerald-100 p-10 shadow-sm relative overflow-hidden group mt-8">
    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-primary/5 rounded-lg blur-2xl group-hover:scale-150 transition-transform"></div>
    <div class="flex items-center gap-4 mb-8">
        <div class="w-14 h-14 rounded-2xl bg-white text-primary flex items-center justify-center shadow-xs">
            <span class="material-symbols-outlined text-[28px]">monitor_weight</span>
        </div>
        <h4 class="text-base font-black text-emerald-800 uppercase tracking-widest">Pengukuran Terakhir</h4>
    </div>
    @php $lastRecord = $patient->medicalRecords()->orderBy('visit_date', 'desc')->first(); @endphp
    <div class="grid grid-cols-2 gap-6">
        <div class="p-6 bg-white/60 backdrop-blur-md rounded-2xl border border-emerald-100 shadow-xs">
            <p class="text-xs font-black text-primary/60 uppercase tracking-widest mb-2">Berat</p>
            <p class="text-headline-md font-black text-emerald-900">{{ $lastRecord->weight ?? '-' }} <span class="text-xs font-bold">kg</span></p>
        </div>
        <div class="p-6 bg-white/60 backdrop-blur-md rounded-2xl border border-emerald-100 shadow-xs">
            <p class="text-xs font-black text-primary/60 uppercase tracking-widest mb-2">Tinggi</p>
            <p class="text-headline-md font-black text-emerald-900">{{ $lastRecord->height ?? '-' }} <span class="text-xs font-bold">cm</span></p>
        </div>
    </div>
</div>
