{{--
    Posyandu Info Modal Component
    ──────────────────────────────
    Modal informatif — menampilkan detail data, pesan sukses, atau panduan.
    Dikontrol oleh Alpine.js x-data="{ open: false }" di parent.

    Props:
        title       — string judul modal
        type        — 'info' | 'success' | 'warning' | 'neutral'  (default: 'info')
        size        — 'sm' | 'md' | 'lg' | 'xl'  (default: 'md')
        closeText   — string teks tombol tutup (default: 'Tutup')
        id          — string ID unik modal (default: 'info-modal')
        showClose   — boolean tampilkan tombol tutup di footer (default: true)

    Slots:
        $slot   — konten body modal
        $footer — footer custom (opsional)

    Usage — Info detail data:
        <div x-data="{ open: false }">
            <x-button @click="open = true" variant="outline" icon="visibility">Detail</x-button>
            <x-modals.info-modal title="Detail Pasien" size="lg">
                <div class="grid grid-cols-2 gap-4">
                    <x-detail-item label="Nama" :value="$patient->full_name" />
                    <x-detail-item label="NIK" :value="$patient->id_number" />
                </div>
            </x-modals.info-modal>
        </div>

    Usage — Pesan sukses:
        <x-modals.info-modal title="Berhasil!" type="success">
            <p>Data pasien berhasil disimpan ke sistem.</p>
        </x-modals.info-modal>
--}}

@props([
    'title'     => '',
    'type'      => 'info',
    'size'      => 'md',
    'closeText' => 'Tutup',
    'id'        => 'info-modal',
    'showClose' => true,
])

@php
    $maxWidth = match($size) {
        'sm' => 'max-w-sm',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        default => 'max-w-lg',
    };

    $headerConfig = match($type) {
        'success' => ['bg' => 'bg-emerald-50',  'border' => 'border-status-normal/30',  'icon' => 'check_circle',  'iconColor' => 'text-status-normal',  'titleColor' => 'text-emerald-900'],
        'warning' => ['bg' => 'bg-amber-50',    'border' => 'border-status-warning/30', 'icon' => 'warning',       'iconColor' => 'text-status-warning', 'titleColor' => 'text-amber-900'],
        'neutral' => ['bg' => 'bg-surface-container-low', 'border' => 'border-outline-variant', 'icon' => '', 'iconColor' => '', 'titleColor' => 'text-on-surface'],
        default   => ['bg' => 'bg-blue-50',     'border' => 'border-secondary/30',      'icon' => 'info',          'iconColor' => 'text-secondary',      'titleColor' => 'text-blue-900'],
    };
@endphp

{{-- Backdrop --}}
<div
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display:none; font-family:'Public Sans',sans-serif;"
    role="dialog"
    aria-modal="true"
    @if($title) aria-labelledby="{{ $id }}-title" @endif
>
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-inverse-surface/40 backdrop-blur-sm"
         @click="open = false"
         aria-hidden="true"></div>

    {{-- Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="relative w-full {{ $maxWidth }} bg-surface-container-lowest rounded-2xl
               shadow-xl border border-outline-variant overflow-hidden max-h-[90vh] flex flex-col"
    >
        {{-- Header --}}
        @if($title)
        <div class="flex items-center justify-between px-6 py-4 border-b {{ $headerConfig['border'] }} {{ $headerConfig['bg'] }} flex-shrink-0">
            <div class="flex items-center gap-3">
                @if($headerConfig['icon'])
                    <span class="material-symbols-outlined text-[20px] {{ $headerConfig['iconColor'] }}"
                          style="font-variation-settings:'FILL' 1;">
                        {{ $headerConfig['icon'] }}
                    </span>
                @endif
                <h3 id="{{ $id }}-title"
                    class="text-[15px] font-bold {{ $headerConfig['titleColor'] }} leading-tight">
                    {{ $title }}
                </h3>
            </div>
            <button
                @click="open = false"
                class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface-variant
                       hover:bg-surface-container transition-colors"
                aria-label="Tutup modal">
                <i class="fas fa-xmark text-[14px]"></i>
            </button>
        </div>
        @endif

        {{-- Body --}}
        <div class="px-6 py-5 text-[13px] text-on-surface-variant leading-relaxed overflow-y-auto flex-1">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        @if(isset($footer) || $showClose)
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-outline-variant bg-surface-container-low flex-shrink-0">
            @if(isset($footer))
                {{ $footer }}
            @elseif($showClose)
                <x-button @click="open = false" variant="outline">
                    {{ $closeText }}
                </x-button>
            @endif
        </div>
        @endif

    </div>
</div>
