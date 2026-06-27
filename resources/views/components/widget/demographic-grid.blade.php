@props(['stats' => []])

@php
    // Default values in case the array is empty
    $bayi = $stats['bayi'] ?? 0;
    $baduta = $stats['baduta'] ?? 0;
    $balita = $stats['balita'] ?? 0;
    $anakSekolah = $stats['anak_sekolah'] ?? 0;
    $ibuHamil = $stats['ibu_hamil'] ?? 0;
    $remaja = $stats['remaja'] ?? 0;
    $lansia = $stats['lansia'] ?? 0;
    $umum = $stats['umum'] ?? 0;
@endphp

<div class="grid grid-cols-2 md:grid-cols-4 gap-3">
    {{-- 1. Bayi --}}
    <div class="bg-white border border-outline-variant rounded-xl p-3 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-blue-50 text-secondary flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[22px]">child_care</span>
        </div>
        <div>
            <p class="text-[11px] font-medium text-outline leading-none mb-1">Bayi (0-11 bln)</p>
            <h4 class="text-headline-sm font-bold text-on-surface leading-none">{{ number_format($bayi) }}</h4>
        </div>
    </div>

    {{-- 2. Baduta --}}
    <div class="bg-white border border-outline-variant rounded-xl p-3 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-500 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[22px]">stroller</span>
        </div>
        <div>
            <p class="text-[11px] font-medium text-outline leading-none mb-1">Baduta (12-23 bln)</p>
            <h4 class="text-headline-sm font-bold text-on-surface leading-none">{{ number_format($baduta) }}</h4>
        </div>
    </div>

    {{-- 3. Balita --}}
    <div class="bg-white border border-outline-variant rounded-xl p-3 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-primary-container text-primary flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[22px]">sentiment_satisfied</span>
        </div>
        <div>
            <p class="text-[11px] font-medium text-outline leading-none mb-1">Balita (24-59 bln)</p>
            <h4 class="text-headline-sm font-bold text-on-surface leading-none">{{ number_format($balita) }}</h4>
        </div>
    </div>

    {{-- 4. Anak Sekolah --}}
    <div class="bg-white border border-outline-variant rounded-xl p-3 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-secondary-container text-secondary flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[22px]">school</span>
        </div>
        <div>
            <p class="text-[11px] font-medium text-outline leading-none mb-1">Anak Sekolah</p>
            <h4 class="text-headline-sm font-bold text-on-surface leading-none">{{ number_format($anakSekolah) }}</h4>
        </div>
    </div>

    {{-- 5. Ibu Hamil --}}
    <div class="bg-white border border-outline-variant rounded-xl p-3 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[22px]">pregnant_woman</span>
        </div>
        <div>
            <p class="text-[11px] font-medium text-outline leading-none mb-1">Ibu Hamil</p>
            <h4 class="text-headline-sm font-bold text-on-surface leading-none">{{ number_format($ibuHamil) }}</h4>
        </div>
    </div>

    {{-- 6. Remaja --}}
    <div class="bg-white border border-outline-variant rounded-xl p-3 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[22px]">emoji_people</span>
        </div>
        <div>
            <p class="text-[11px] font-medium text-outline leading-none mb-1">Remaja</p>
            <h4 class="text-headline-sm font-bold text-on-surface leading-none">{{ number_format($remaja) }}</h4>
        </div>
    </div>

    {{-- 7. Lansia --}}
    <div class="bg-white border border-outline-variant rounded-xl p-3 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[22px]">elderly</span>
        </div>
        <div>
            <p class="text-[11px] font-medium text-outline leading-none mb-1">Lansia</p>
            <h4 class="text-headline-sm font-bold text-on-surface leading-none">{{ number_format($lansia) }}</h4>
        </div>
    </div>

    {{-- 8. Umum / Lainnya --}}
    <div class="bg-white border border-outline-variant rounded-xl p-3 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-surface-container text-on-surface-variant flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[22px]">group</span>
        </div>
        <div>
            <p class="text-[11px] font-medium text-outline leading-none mb-1">Umum / Lainnya</p>
            <h4 class="text-headline-sm font-bold text-on-surface leading-none">{{ number_format($umum) }}</h4>
        </div>
    </div>
</div>
