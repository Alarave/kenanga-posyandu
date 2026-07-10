{{-- Grid Informasi Detail Ibu Hamil --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- 1. Identitas Pribadi --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">badge</span>
                </div>
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Identitas Pribadi</h4>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">NIK / No. Identitas</span>
                    <span class="text-sm font-black text-slate-700 font-mono">{{ $patient->id_number }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap</span>
                    <span class="text-sm font-black text-slate-700 text-right ml-4">{{ $patient->full_name }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Suami</span>
                    <span class="text-sm font-black text-slate-700 text-right ml-4">{{ $patient->husband_name ?: $patient->parent_name ?: '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Jenis Kelamin</span>
                    <span class="text-sm font-black text-slate-700">
                        @if(trim(strtoupper($patient->gender)) === 'L' || trim(strtoupper($patient->gender)) === 'M')
                            Laki-laki
                        @elseif(trim(strtoupper($patient->gender)) === 'P' || trim(strtoupper($patient->gender)) === 'W')
                            Perempuan
                        @else
                            {{ $patient->gender }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tempat Lahir</span>
                    <span class="text-sm font-black text-slate-700 text-right ml-4">{{ $patient->place_of_birth ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Lahir</span>
                    <span class="text-sm font-black text-slate-700">{{ \Carbon\Carbon::parse($patient->birth_date)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Usia</span>
                    <span class="text-sm font-black text-slate-700">{{ $patient->age }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Domisili & Kontak --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">location_on</span>
                </div>
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Domisili & Kontak</h4>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No. HP / WhatsApp</span>
                    <span class="text-sm font-black text-slate-700 font-mono">{{ $patient->phone_number ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Unit Posyandu</span>
                    <span class="text-sm font-black text-slate-700 text-right ml-4">{{ $patient->posyandu->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">RT Domisili</span>
                    <span class="text-sm font-black text-slate-700">{{ $patient->rt_domisili ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">RW Domisili</span>
                    <span class="text-sm font-black text-slate-700">{{ $patient->dusun_rt_rw ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kelurahan / Desa</span>
                    <span class="text-sm font-black text-slate-700 text-right ml-4">{{ $patient->desa_kelurahan ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kecamatan</span>
                    <span class="text-sm font-black text-slate-700 text-right ml-4">{{ $patient->kecamatan ?? '-' }}</span>
                </div>
                <div class="flex flex-col py-2.5">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Lengkap</span>
                    <p class="text-xs font-bold text-slate-600 bg-slate-50 p-4 rounded-2xl border border-slate-100 leading-relaxed">{{ $patient->address }}</p>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Pemantauan Kesehatan Ibu Hamil (Bento Grid) --}}
<div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] mt-8">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-[20px]">pregnant_woman</span>
        </div>
        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Pemeriksaan Kehamilan Terakhir</h4>
    </div>

    @php $lastRecord = $patient->medicalRecords()->orderBy('visit_date', 'desc')->first(); @endphp
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Hero Bento: Usia Kehamilan & HPL --}}
        <div class="col-span-1 lg:col-span-2 bg-linear-to-br from-rose-50 to-pink-50 rounded-[2rem] p-6 shadow-sm border border-rose-100 flex flex-col justify-between relative overflow-hidden group">
            <span class="material-symbols-outlined absolute -right-6 -bottom-6 text-[120px] text-rose-500/5 rotate-12 group-hover:scale-110 transition-transform duration-700 font-light">pregnant_woman</span>
            <div class="relative z-10 flex flex-col h-full justify-between gap-6">
                <div>
                    <span class="text-[11px] font-black text-rose-400 uppercase tracking-widest block mb-1">Usia Kehamilan</span>
                    <div class="text-4xl font-black text-rose-600 tracking-tighter leading-none">{{ $lastRecord->gestational_age ?? '-' }}</div>
                </div>
                <div class="flex items-center gap-3 bg-white/60 backdrop-blur-md rounded-2xl p-4 border border-white/50 w-max">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-500 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    </div>
                    <div>
                        <span class="text-[9px] font-black text-rose-400 uppercase tracking-widest block">HPL / Taksiran</span>
                        <span class="text-sm font-bold text-rose-900">{{ $patient->delivery_date ? \Carbon\Carbon::parse($patient->delivery_date)->translatedFormat('d M Y') : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- LILA --}}
        <div @class([
            'rounded-[2rem] p-6 shadow-sm border flex flex-col justify-between relative overflow-hidden',
            'bg-red-50 border-red-200 text-red-700' => $lastRecord && $lastRecord->lila_plotting_status === 'KEK',
            'bg-white border-slate-100 text-slate-800' => !$lastRecord || $lastRecord->lila_plotting_status !== 'KEK'
        ])>
            <span @class([
                'text-[10px] font-black uppercase tracking-widest block mb-2',
                'text-red-500' => $lastRecord && $lastRecord->lila_plotting_status === 'KEK',
                'text-slate-400' => !$lastRecord || $lastRecord->lila_plotting_status !== 'KEK'
            ])>LILA (Lingkar Lengan)</span>
            <div>
                <span class="text-3xl font-black tracking-tight">{{ $lastRecord->upper_arm_circumference ?? '-' }}<span class="text-sm font-bold opacity-50 ml-1">cm</span></span> 
                @if($lastRecord && $lastRecord->lila_plotting_status)
                    <div class="mt-2 text-[10px] font-bold px-3 py-1 rounded-xl inline-flex items-center gap-1.5 {{ $lastRecord->lila_plotting_status === 'KEK' ? 'bg-red-100 text-red-600' : 'bg-slate-100 text-slate-600' }}">
                        <span class="material-symbols-outlined text-[14px]">{{ $lastRecord->lila_plotting_status === 'KEK' ? 'warning' : 'info' }}</span>
                        {{ $lastRecord->lila_plotting_status }}
                    </div>
                @endif
            </div>
        </div>
        
        {{-- Hemoglobin --}}
        <div @class([
            'rounded-[2rem] p-6 shadow-sm border flex flex-col justify-between relative overflow-hidden',
            'bg-red-50 border-red-200 text-red-700' => $lastRecord && $lastRecord->hemoglobin && $lastRecord->hemoglobin < 11,
            'bg-white border-slate-100 text-slate-800' => !$lastRecord || !$lastRecord->hemoglobin || $lastRecord->hemoglobin >= 11
        ])>
            <span @class([
                'text-[10px] font-black uppercase tracking-widest block mb-2',
                'text-red-500' => $lastRecord && $lastRecord->hemoglobin && $lastRecord->hemoglobin < 11,
                'text-slate-400' => !$lastRecord || !$lastRecord->hemoglobin || $lastRecord->hemoglobin >= 11
            ])>Hemoglobin (Hb)</span>
            <div>
                <span class="text-3xl font-black tracking-tight">{{ $lastRecord->hemoglobin ?? '-' }}<span class="text-sm font-bold opacity-50 ml-1">g/dL</span></span>
            </div>
        </div>

        {{-- Tekanan Darah --}}
        <div @class([
            'rounded-[2rem] p-6 shadow-sm border flex flex-col justify-between relative overflow-hidden',
            'bg-orange-50 border-orange-200 text-orange-700' => $lastRecord && in_array($lastRecord->bp_plotting_status, ['Hipertensi', 'Hipotensi']),
            'bg-white border-slate-100 text-slate-800' => !$lastRecord || !in_array($lastRecord->bp_plotting_status, ['Hipertensi', 'Hipotensi'])
        ])>
            <span @class([
                'text-[10px] font-black uppercase tracking-widest block mb-2',
                'text-orange-500' => $lastRecord && in_array($lastRecord->bp_plotting_status, ['Hipertensi', 'Hipotensi']),
                'text-slate-400' => !$lastRecord || !in_array($lastRecord->bp_plotting_status, ['Hipertensi', 'Hipotensi'])
            ])>Tekanan Darah</span>
            <div>
                <span class="text-2xl font-black tracking-tight">{{ $lastRecord && $lastRecord->systolic_bp ? $lastRecord->systolic_bp . '/' . $lastRecord->diastolic_bp : '-' }}<span class="text-sm font-bold opacity-50 ml-1">mmHg</span></span>
            </div>
        </div>
        
        {{-- Tablet Fe --}}
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Suplementasi Tablet Fe</span>
            <div class="flex items-center gap-3 mt-1">
                @if($lastRecord && (in_array(strtolower(trim($lastRecord->nakes_gives_fe_mms ?? '')), ['ya', '1', 'true', 'sudah']) || $lastRecord->pill_fe == 1))
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">check</span>
                    </div>
                    <span class="text-base font-bold text-slate-800">Sudah Diberikan</span>
                @else
                    <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">priority_high</span>
                    </div>
                    <span class="text-base font-bold text-slate-600">Belum Diberikan</span>
                @endif
            </div>
        </div>
        
        {{-- BB/TB --}}
        <div class="col-span-1 lg:col-span-2 bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex items-center justify-around gap-4">
            <div class="text-center">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Berat Badan Terakhir</span>
                <span class="text-2xl font-black text-slate-700 tracking-tight">{{ $lastRecord->weight ?? '-' }}<span class="text-sm font-bold opacity-50 ml-1">kg</span></span>
            </div>
            <div class="w-px h-12 bg-slate-100"></div>
            <div class="text-center">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Tinggi Badan Terakhir</span>
                <span class="text-2xl font-black text-slate-700 tracking-tight">{{ $lastRecord->height ?? '-' }}<span class="text-sm font-bold opacity-50 ml-1">cm</span></span>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>

{{-- Riwayat Pemeriksaan Table --}}
<div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] mt-8">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-[20px]">history</span>
        </div>
        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Riwayat Pemeriksaan Kehamilan</h4>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-100">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50">
                <tr class="border-b border-slate-100">
                    <th class="py-4 px-5 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Tanggal</th>
                    <th class="py-4 px-5 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Usia Kehamilan</th>
                    <th class="py-4 px-5 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">BB / TB</th>
                    <th class="py-4 px-5 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">LILA</th>
                    <th class="py-4 px-5 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Hb</th>
                    <th class="py-4 px-5 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Tekanan Darah</th>
                    <th class="py-4 px-5 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Tablet Fe</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($patient->medicalRecords()->orderBy('visit_date', 'desc')->get() as $record)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-5 text-sm font-bold text-slate-700 whitespace-nowrap">{{ \Carbon\Carbon::parse($record->visit_date)->translatedFormat('d M Y') }}</td>
                        <td class="py-4 px-5 text-sm font-semibold text-slate-600">{{ $record->gestational_age ?? '-' }}</td>
                        <td class="py-4 px-5 text-sm font-semibold text-slate-600 whitespace-nowrap">{{ $record->weight ?? '-' }} kg / {{ $record->height ?? '-' }} cm</td>
                        <td class="py-4 px-5 whitespace-nowrap">
                            <span class="text-sm font-semibold text-slate-600">{{ $record->upper_arm_circumference ?? '-' }} cm</span>
                            @if($record->lila_plotting_status === 'KEK')
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-wider bg-red-50 text-red-600 border border-red-100">KEK</span>
                            @endif
                        </td>
                        <td class="py-4 px-5 text-sm font-semibold text-slate-600 whitespace-nowrap">{{ $record->hemoglobin ?? '-' }} g/dL</td>
                        <td class="py-4 px-5 text-sm font-semibold text-slate-600 whitespace-nowrap">{{ $record->systolic_bp ? $record->systolic_bp . '/' . $record->diastolic_bp : '-' }} mmHg</td>
                        <td class="py-4 px-5 text-sm font-semibold text-slate-600 whitespace-nowrap">
                            @if(in_array(strtolower(trim($record->nakes_gives_fe_mms ?? '')), ['ya', '1', 'true', 'sudah']) || $record->pill_fe == 1)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <span class="material-symbols-outlined text-[12px]">check</span> Ya
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-50 text-slate-500 border border-slate-200">
                                    <span class="material-symbols-outlined text-[12px]">close</span> Tidak
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center">
                            <div class="inline-flex flex-col items-center justify-center text-slate-400">
                                <span class="material-symbols-outlined text-[48px] font-light mb-3">clinical_notes</span>
                                <span class="text-sm font-semibold">Belum ada riwayat pemeriksaan</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
