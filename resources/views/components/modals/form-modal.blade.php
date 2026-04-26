{{--
    Posyandu Form Modal Component
    ──────────────────────────────
    Modal yang berisi form input.
    Dikontrol oleh Alpine.js x-data="{ open: false }" di parent.

    Props:
        title       — string judul modal
        size        — 'sm' | 'md' | 'lg' | 'xl'  (default: 'md')
        action      — string URL form action
        method      — string HTTP method (default: 'POST')
        enctype     — string enctype (default: 'application/x-www-form-urlencoded')
        submitText  — string teks tombol submit (default: 'Simpan')
        cancelText  — string teks tombol batal (default: 'Batal')
        submitVariant — string variant tombol submit (default: 'primary')
        wireSubmit  — string wire:submit handler (opsional, menggantikan form action)
        id          — string ID unik modal (default: 'form-modal')

    Slots:
        $slot   — konten form (field-field input)
        $footer — footer custom (opsional)

    Usage — Form biasa:
        <div x-data="{ open: false }">
            <x-button @click="open = true" variant="secondary" icon="add">Tambah</x-button>
            <x-modals.form-modal
                title="Tambah Jadwal"
                action="{{ route('admin.schedules.store') }}"
                submit-text="Simpan Jadwal">
                <x-date-time.datetime-picker name="start_time" label="Waktu Mulai" :required="true" />
                <x-date-time.datetime-picker name="end_time" label="Waktu Selesai" :required="true" />
            </x-modals.form-modal>
        </div>

    Usage — Livewire form:
        <x-modals.form-modal
            title="Edit Data"
            wire-submit="save"
            submit-text="Update">
            <x-forms.text-input name="name" label="Nama" wire:model="name" />
        </x-modals.form-modal>
--}}

@props([
    'title'         => '',
    'size'          => 'md',
    'action'        => '',
    'method'        => 'POST',
    'enctype'       => 'application/x-www-form-urlencoded',
    'submitText'    => 'Simpan',
    'cancelText'    => 'Batal',
    'submitVariant' => 'primary',
    'wireSubmit'    => '',
    'id'            => 'form-modal',
])

@php
    $maxWidth = match($size) {
        'sm' => 'max-w-sm',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        default => 'max-w-lg',
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
        <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant flex-shrink-0">
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

        {{-- Form --}}
        @if($wireSubmit)
            <form wire:submit.prevent="{{ $wireSubmit }}" class="flex flex-col flex-1 overflow-hidden">
        @elseif($action)
            <form
                method="POST"
                action="{{ $action }}"
                enctype="{{ $enctype }}"
                class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @if(!in_array(strtoupper($method), ['GET', 'POST']))
                    @method($method)
                @endif
        @else
            <div class="flex flex-col flex-1 overflow-hidden">
        @endif

            {{-- Scrollable body --}}
            <div class="px-6 py-5 space-y-4 overflow-y-auto flex-1">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-outline-variant bg-surface-container-low flex-shrink-0">
                @if(isset($footer))
                    {{ $footer }}
                @else
                    <x-button @click="open = false" variant="outline" type="button">
                        {{ $cancelText }}
                    </x-button>
                    <x-button type="submit" variant="{{ $submitVariant }}">
                        {{ $submitText }}
                    </x-button>
                @endif
            </div>

        @if($wireSubmit || $action)
            </form>
        @else
            </div>
        @endif

    </div>
</div>
