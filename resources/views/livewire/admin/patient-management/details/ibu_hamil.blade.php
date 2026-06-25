{{-- Card Informasi Detail Ibu Hamil (Unified Premium Card) --}}
<div class="bg-white rounded-[3rem] border border-slate-100 shadow-[0_4px_30px_rgba(15,23,42,0.06)] overflow-hidden transition-all duration-500 relative">
    @include('livewire.admin.patient-management.details.header')

    {{-- Details Sections in Google Form style (Stacked Vertically) --}}
    <div class="px-12 pb-12 pt-10 space-y-10">
        {{-- Section 1: Identitas Pribadi --}}
        <div>
            <h4 class="text-base font-black text-slate-800 uppercase tracking-[0.2em] mb-6 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-slate-500">badge</span>
                Identitas Pribadi
            </h4>
            <div class="space-y-5">
                {{-- Husband Name --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Nama Suami</p>
                    <span class="text-lg font-black text-slate-800">{{ $patient->husband_name ?: $patient->parent_name ?: '-' }}</span>
                </div>
                {{-- Gender --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Jenis Kelamin</p>
                    <span class="px-3.5 py-1.5 rounded-xl text-base font-black uppercase tracking-wider border inline-block w-fit shadow-xs bg-pink-50 text-pink-700 border-pink-100">Perempuan</span>
                </div>
                {{-- Tempat Lahir --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Tempat Lahir</p>
                    <span class="text-lg font-black text-slate-800">{{ $patient->place_of_birth ?? '-' }}</span>
                </div>
                {{-- Tanggal Lahir --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Lahir</p>
                    <span class="text-lg font-black text-slate-800">{{ \Carbon\Carbon::parse($patient->birth_date)->translatedFormat('d F Y') }}</span>
                </div>
                {{-- Usia --}}
                <div class="pb-4 last:border-b-0 last:pb-0">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Usia</p>
                    <span class="text-lg font-black text-slate-800">{{ $patient->age }}</span>
                </div>
            </div>
        </div>

        <hr class="border-slate-100">

        {{-- Section 2: Domisili & Kontak --}}
        <div>
            <h4 class="text-base font-black text-slate-800 uppercase tracking-[0.2em] mb-6 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-slate-500">location_on</span>
                Domisili & Kontak
            </h4>
            <div class="space-y-5">
                {{-- No HP --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">No. HP / WhatsApp</p>
                    <span class="text-lg font-black text-slate-800 font-mono">{{ $patient->phone_number ?? '-' }}</span>
                </div>
                {{-- Unit Posyandu --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2.5">Unit Posyandu</p>
                    <span class="px-3.5 py-1.5 rounded-xl text-base font-black uppercase tracking-wider border inline-block bg-teal-50 text-teal-600 border-teal-100 shadow-xs">{{ $patient->posyandu->name ?? '-' }}</span>
                </div>
                {{-- RT --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">RT Domisili</p>
                    <span class="text-lg font-black text-slate-800">{{ $patient->rt_domisili ? 'RT ' . sprintf('%02d', $patient->rt_domisili) : '-' }}</span>
                </div>
                {{-- RW --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">RW Domisili</p>
                    <span class="text-lg font-black text-slate-800">{{ $patient->dusun_rt_rw ?? '-' }}</span>
                </div>
                {{-- Kelurahan --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Kelurahan / Desa</p>
                    <span class="text-lg font-black text-slate-800">{{ $patient->desa_kelurahan ?? '-' }}</span>
                </div>
                {{-- Kecamatan --}}
                <div class="pb-4 border-b border-slate-100">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Kecamatan</p>
                    <span class="text-lg font-black text-slate-800">{{ $patient->kecamatan ?? '-' }}</span>
                </div>
                {{-- Alamat --}}
                <div class="pb-4 last:border-b-0 last:pb-0">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Lengkap</p>
                    <span class="text-base font-semibold text-slate-600 leading-relaxed bg-slate-50/50 p-4 rounded-2xl border border-slate-100/60 block">{{ $patient->address }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pemantauan Kesehatan Ibu Hamil (Bento Grid) --}}
<div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] mt-8">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shadow-xs">
            <span class="material-symbols-outlined text-[28px]">pregnant_woman</span>
        </div>
        <h4 class="text-base font-black text-slate-800 uppercase tracking-widest">Pemeriksaan Kehamilan Terakhir</h4>
    </div>

    @php $lastRecord = $patient->medicalRecords()->orderBy('visit_date', 'desc')->first(); @endphp
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Antropometri --}}
        <div class="p-8 rounded-4xl border border-slate-100 bg-slate-50/50">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Berat & Tinggi Badan</p>
            <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                <span class="text-sm font-semibold text-slate-500">Berat</span>
                <span class="text-base font-black text-slate-800">{{ $lastRecord->weight ?? '-' }} kg</span>
            </div>
            <div class="flex justify-between items-center py-2.5">
                <span class="text-sm font-semibold text-slate-500">Tinggi</span>
                <span class="text-base font-black text-slate-800">{{ $lastRecord->height ?? '-' }} cm</span>
            </div>
        </div>

        {{-- LILA (Lingkar Lengan Atas) --}}
        <div class="p-8 rounded-4xl border border-slate-100 bg-slate-50/50 flex flex-col justify-between">
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">LILA (Lingkar Lengan Atas)</p>
                @if(isset($lastRecord->upper_arm_circumference))
                    <p class="text-3xl font-black text-slate-800">{{ $lastRecord->upper_arm_circumference }} <span class="text-sm font-bold text-slate-400">cm</span></p>
                @else
                    <p class="text-3xl font-black text-slate-400">—</p>
                @endif
            </div>
            
            @if(isset($lastRecord->upper_arm_circumference))
                @if($lastRecord->upper_arm_circumference < 23.5)
                    <div class="mt-4 px-4 py-2 rounded-xl bg-red-50 border border-red-100 text-red-600 text-xs font-black uppercase tracking-wider flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">warning</span>
                        Risiko KEK
                    </div>
                @else
                    <div class="mt-4 px-4 py-2 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-black uppercase tracking-wider flex items-center gap-1.5 w-max">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                        Normal
                    </div>
                @endif
            @endif
        </div>

        {{-- Tablet Tambah Darah (Fe) --}}
        <div class="p-8 rounded-4xl border border-slate-100 bg-slate-50/50 flex flex-col justify-between">
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Suplementasi Tablet Fe</p>
                @if(isset($lastRecord->pill_fe))
                    <p class="text-xl font-black text-slate-800">{{ $lastRecord->pill_fe ? 'Sudah Diberikan' : 'Belum Diberikan' }}</p>
                @else
                    <p class="text-3xl font-black text-slate-400">—</p>
                @endif
            </div>

            @if(isset($lastRecord->pill_fe))
                @if($lastRecord->pill_fe)
                    <div class="mt-4 px-4 py-2 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-black uppercase tracking-wider flex items-center gap-1.5 w-max">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                        Tercukupi
                    </div>
                @else
                    <div class="mt-4 px-4 py-2 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 text-xs font-black uppercase tracking-wider flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">priority_high</span>
                        Perlu Tablet Fe
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
