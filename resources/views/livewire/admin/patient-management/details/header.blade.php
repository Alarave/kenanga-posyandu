@php
    $cat = $patient->category;
    $badgeStyle = match($cat) {
        'bayi', 'baduta', 'balita' => 'bg-primary-container border border-teal-100 text-primary',
        'lansia' => 'bg-amber-50 border border-amber-100 text-amber-600',
        'ibu_hamil' => 'bg-error-container border border-rose-100 text-error',
        default => 'bg-secondary-container border border-indigo-100 text-secondary',
    };
@endphp
{{-- Card Top Action Bar --}}
<div class="px-10 py-6 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6 print:hidden bg-white/80 backdrop-blur-md sticky top-16 z-20 transition-all duration-300 shadow-xs">
    <div class="flex items-center gap-3">
        <span class="text-base font-black uppercase tracking-widest text-transparent bg-clip-text bg-linear-to-r {{ $theme['gradient'] }}">Profil Detail Warga</span>
    </div>
    <div class="flex items-center gap-3 flex-wrap justify-end">
        <a href="{{ route('admin.patients.edit', $patient->id) }}" class="flex items-center gap-2 px-5 py-3 rounded-2xl border border-outline-variant text-on-surface-variant bg-white font-black text-xs uppercase tracking-wider whitespace-nowrap hover:bg-surface-container-low transition-all duration-300 hover:scale-105 active:scale-95 shadow-sm hover:shadow-md hover:border-outline-variant hover:-translate-y-0.5">
            <span class="material-symbols-outlined text-[20px]">edit</span>
            <span>Edit Profil</span>
        </a>
        <a href="{{ route('admin.reports.individual', $patient->id) }}" class="flex items-center gap-2 px-5 py-3 rounded-2xl bg-primary hover:bg-teal-700 text-white font-black text-xs uppercase tracking-wider whitespace-nowrap transition-all duration-300 hover:scale-105 active:scale-95 shadow-md hover:shadow-lg hover:-translate-y-0.5">
            <span class="material-symbols-outlined text-[20px]">article</span>
            <span>Lihat Rapor</span>
        </a>
        <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Hapus data warga ini?')" class="inline">
            @csrf @method('DELETE')
            <button type="submit" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-error-container text-error hover:bg-rose-500 hover:text-white transition-all duration-300 hover:scale-105 active:scale-95 shadow-sm hover:shadow-md hover:-translate-y-0.5 cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">delete</span>
            </button>
        </form>
    </div>
</div>

{{-- Profile Card Header (Premium Centered) --}}
<div class="flex flex-col items-center text-center p-12 relative border-b border-slate-100">
    <div class="relative mb-8">
        <div class="w-32 h-32 rounded-2xl border-4 border-white bg-surface-container-low shadow-xl overflow-hidden relative ring-1 ring-slate-100 flex items-center justify-center">
            @if($patient->profile_photo)
                <img src="{{ asset('storage/' . $patient->profile_photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-linear-to-br from-slate-50 to-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-outline-variant text-[56px] select-none">{{ $theme['avatar_icon'] }}</span>
                </div>
            @endif
        </div>
    </div>
    
    <h1 class="text-5xl font-black text-on-surface mb-4 tracking-tight">{{ $patient->full_name }}</h1>
    
    <div class="flex flex-wrap justify-center items-center gap-3">
        <span class="px-6 py-2.5 bg-surface-container-low/80 border border-outline-variant/80 text-on-surface-variant rounded-lg text-base font-black font-mono tracking-wider shadow-xs">
            NIK: {{ $patient->id_number }}
        </span>
        <span class="px-6 py-2.5 rounded-lg text-base font-black uppercase tracking-widest shadow-xs {{ $badgeStyle }}">
            {{ $theme['name'] }}
        </span>
    </div>
</div>
