{{--
    Posyandu Confirm Modal Component
    ──────────────────────────────────
    Modal konfirmasi aksi destruktif (hapus, reset, dll.)
    Dikontrol oleh Alpine.js x-data="{ open: false }" di parent.

    Props:
        title       — string judul modal (default: 'Konfirmasi')
        message     — string pesan utama
        subMessage  — string pesan tambahan (opsional)
        type        — 'danger' | 'warning' | 'info'  (default: 'danger')
        confirmText — string teks tombol konfirmasi (default: 'Ya, Lanjutkan')
        cancelText  — string teks tombol batal (default: 'Batal')
        action      — string URL form action (untuk submit form)
        method      — string HTTP method (default: 'DELETE')
        size        — 'sm' | 'md'  (default: 'sm')

    Slots:
        $slot   — konten custom (opsional, menggantikan message)
        $footer — footer custom (opsional, menggantikan tombol default)

    Usage — Hapus dengan form POST:
        <div x-data="{ open: false }">
            <x-button @click="open = true" variant="danger" icon="trash">Hapus</x-button>
            <x-modals.confirm-modal
                title="Hapus Pasien"
                message="Apakah Anda yakin ingin menghapus pasien ini?"
                sub-message="Data yang dihapus tidak dapat dikembalikan."
                action="{{ route('admin.patients.destroy', $patient->id) }}"
                confirm-text="Ya, Hapus"
            />
        </div>

    Usage — Konfirmasi dengan custom footer:
        <x-modals.confirm-modal title="Reset Password" type="warning">
            <p>Password akan direset ke default.</p>
            <x-slot:footer>
                <x-button @click="open = false" variant="outline">Batal</x-button>
                <x-button wire:click="resetPassword" variant="warning">Reset</x-button>
            </x-slot:footer>
        </x-modals.confirm-modal>
--}}

@props([
    'title'       => 'Konfirmasi',
    'message'     => '',
    'subMessage'  => '',
    'type'        => 'danger',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText'  => 'Batal',
    'action'      => '',
    'method'      => 'DELETE',
    'size'        => 'sm',
])

@php
    $maxWidth = $size === 'sm' ? 'max-w-sm' : 'max-w-md';

    $iconConfig = match($type) {
        'warning' => ['icon' => 'warning',    'bg' => 'bg-amber-100',   'color' => 'text-status-warning'],
        'info'    => ['icon' => 'info',        'bg' => 'bg-blue-100',    'color' => 'text-secondary'],
        default   => ['icon' => 'delete_forever', 'bg' => 'bg-red-100', 'color' => 'text-error'],
    };

    $confirmVariant = match($type) {
        'warning' => 'warning',
        'info'    => 'primary',
        default   => 'danger',
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
    aria-labelledby="confirm-modal-title"
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
               shadow-xl border border-outline-variant overflow-hidden"
    >
        {{-- Body --}}
        <div class="p-6 text-center">

            {{-- Icon --}}
            <div class="w-14 h-14 {{ $iconConfig['bg'] }} rounded-lg flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-[28px] {{ $iconConfig['color'] }}"
                      style="font-variation-settings:'FILL' 1;">
                    {{ $iconConfig['icon'] }}
                </span>
            </div>

            {{-- Title --}}
            <h3 id="confirm-modal-title"
                class="text-[16px] font-bold text-on-surface mb-2">
                {{ $title }}
            </h3>

            {{-- Message --}}
            @if($slot->isNotEmpty())
                <div class="text-[13px] text-on-surface-variant leading-relaxed">
                    {{ $slot }}
                </div>
            @elseif($message)
                <p class="text-[13px] text-on-surface-variant leading-relaxed">{{ $message }}</p>
                @if($subMessage)
                    <p class="text-[12px] text-outline mt-1.5">{{ $subMessage }}</p>
                @endif
            @endif

        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-center gap-3 px-6 py-4 border-t border-outline-variant bg-surface-container-low">
            @if(isset($footer))
                {{ $footer }}
            @else
                {{-- Cancel --}}
                <x-button @click="open = false" variant="outline">
                    {{ $cancelText }}
                </x-button>

                {{-- Confirm --}}
                @if($action)
                    <form method="POST" action="{{ $action }}">
                        @csrf
                        @if(!in_array(strtoupper($method), ['GET', 'POST']))
                            @method($method)
                        @endif
                        <x-button type="submit" variant="{{ $confirmVariant }}">
                            {{ $confirmText }}
                        </x-button>
                    </form>
                @else
                    <x-button variant="{{ $confirmVariant }}" @click="open = false">
                        {{ $confirmText }}
                    </x-button>
                @endif
            @endif
        </div>

    </div>
</div>
