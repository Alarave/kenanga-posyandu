{{--
    Posyandu Alert Component
    ────────────────────────
    Props:
        type     — 'success' | 'error' | 'warning' | 'info'  (default: 'info')
        message  — string pesan (opsional, bisa pakai $slot)
        title    — string judul opsional
        dismissible — boolean (default: false)

    Usage:
        <x-alert type="success" message="Data berhasil disimpan." />
        <x-alert type="error" title="Gagal!">Terjadi kesalahan pada server.</x-alert>
        <x-alert type="warning" :dismissible="true">Sesi Anda akan berakhir.</x-alert>
--}}

@props([
    'type'        => 'info',
    'message'     => '',
    'title'       => '',
    'dismissible' => false,
])

@php
    $config = match($type) {
        'success' => [
            'bg'     => 'bg-emerald-50',
            'border' => 'border-status-normal',
            'text'   => 'text-emerald-800',
            'icon'   => 'fa-circle-check',
            'iconColor' => 'text-status-normal',
        ],
        'error' => [
            'bg'     => 'bg-red-50',
            'border' => 'border-error',
            'text'   => 'text-red-800',
            'icon'   => 'fa-circle-exclamation',
            'iconColor' => 'text-error',
        ],
        'warning' => [
            'bg'     => 'bg-amber-50',
            'border' => 'border-status-warning',
            'text'   => 'text-amber-800',
            'icon'   => 'fa-triangle-exclamation',
            'iconColor' => 'text-status-warning',
        ],
        default => [  // info
            'bg'     => 'bg-blue-50',
            'border' => 'border-secondary',
            'text'   => 'text-blue-800',
            'icon'   => 'fa-circle-info',
            'iconColor' => 'text-secondary',
        ],
    };
@endphp

<div
    role="alert"
    {{ $attributes->merge([
        'class' => "flex items-start gap-3 p-4 rounded-xl border-l-4 {$config['bg']} {$config['border']} {$config['text']}"
    ]) }}
    style="font-family:'Public Sans',sans-serif;"
    @if($dismissible) x-data="{ show: true }" x-show="show" @endif
>
    {{-- Icon --}}
    <i class="fas {{ $config['icon'] }} {{ $config['iconColor'] }} mt-0.5 flex-shrink-0 text-[16px]"></i>

    {{-- Content --}}
    <div class="flex-1 min-w-0">
        @if($title)
            <p class="font-bold text-[13px] leading-tight mb-1">{{ $title }}</p>
        @endif
        <p class="text-[13px] leading-relaxed">
            {{ $message ?: $slot }}
        </p>
    </div>

    {{-- Dismiss button --}}
    @if($dismissible)
        <button
            @click="show = false"
            class="flex-shrink-0 p-1 rounded-lg opacity-60 hover:opacity-100 transition-opacity"
            aria-label="Tutup">
            <i class="fas fa-xmark text-[13px]"></i>
        </button>
    @endif
</div>
