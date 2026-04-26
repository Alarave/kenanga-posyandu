{{--
    Posyandu Modal Component
    ────────────────────────
    Props:
        id       — string ID unik modal (default: 'modal')
        title    — string judul modal
        size     — 'sm' | 'md' | 'lg' | 'xl'  (default: 'md')

    Slots:
        $slot        — konten body modal
        $footer      — konten footer modal (opsional)

    Usage (Alpine.js x-data):
        <div x-data="{ open: false }">
            <button @click="open = true">Buka Modal</button>
            <x-modal title="Konfirmasi Hapus" size="sm">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
                <x-slot:footer>
                    <x-button @click="open = false" variant="outline">Batal</x-button>
                    <x-button type="submit" variant="danger">Hapus</x-button>
                </x-slot:footer>
            </x-modal>
        </div>
--}}

@props([
    'id'    => 'modal',
    'title' => '',
    'size'  => 'md',
])

@php
    $maxWidth = match($size) {
        'sm'  => 'max-w-sm',
        'lg'  => 'max-w-2xl',
        'xl'  => 'max-w-4xl',
        default => 'max-w-lg',  // md
    };
@endphp

{{-- Backdrop + panel — dikontrol oleh Alpine x-show="open" di parent --}}
<div
    id="{{ $id }}"
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
    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-inverse-surface/40 backdrop-blur-sm"
        @click="open = false"
        aria-hidden="true">
    </div>

    {{-- Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="relative w-full {{ $maxWidth }} bg-surface-container-lowest rounded-2xl shadow-xl
               border border-outline-variant overflow-hidden"
    >
        {{-- Header --}}
        @if($title)
        <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant">
            <h3 id="{{ $id }}-title"
                class="text-[15px] font-bold text-on-surface leading-tight">
                {{ $title }}
            </h3>
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
        <div class="px-6 py-5 text-body-md text-on-surface-variant">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        @if(isset($footer))
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-outline-variant bg-surface-container-low">
            {{ $footer }}
        </div>
        @endif
    </div>
</div>
