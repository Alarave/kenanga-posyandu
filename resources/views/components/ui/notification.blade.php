@props(['type' => 'success', 'message' => ''])

@php
    $config = [
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-500',
            'text_bold' => 'text-green-800',
            'text_dim' => 'text-green-700',
            'icon' => 'check_circle',
            'icon_color' => 'text-green-600',
            'btn_color' => 'text-green-500 hover:text-green-700 focus:ring-green-500',
            'title' => 'Berhasil!'
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-500',
            'text_bold' => 'text-red-800',
            'text_dim' => 'text-red-700',
            'icon' => 'error',
            'icon_color' => 'text-red-600',
            'btn_color' => 'text-red-500 hover:text-red-700 focus:ring-red-500',
            'title' => 'Kesalahan!'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-500',
            'text_bold' => 'text-yellow-800',
            'text_dim' => 'text-yellow-700',
            'icon' => 'warning',
            'icon_color' => 'text-yellow-600',
            'btn_color' => 'text-yellow-500 hover:text-yellow-700 focus:ring-yellow-500',
            'title' => 'Peringatan!'
        ]
    ][$type];
@endphp

<div 
    x-data="{ 
        show: true, 
        nType: @js($type), 
        nMessage: @js($message),
        config: {
            success: { bg: 'bg-green-50', border: 'border-green-500', text_bold: 'text-green-800', text_dim: 'text-green-700', icon: 'check_circle', icon_color: 'text-green-600', btn_color: 'text-green-500 hover:text-green-700', title: 'Berhasil!' },
            error: { bg: 'bg-red-50', border: 'border-red-500', text_bold: 'text-red-800', text_dim: 'text-red-700', icon: 'error', icon_color: 'text-red-600', btn_color: 'text-red-500 hover:text-red-700', title: 'Kesalahan!' },
            warning: { bg: 'bg-yellow-50', border: 'border-yellow-500', text_bold: 'text-yellow-800', text_dim: 'text-yellow-700', icon: 'warning', icon_color: 'text-yellow-600', btn_color: 'text-yellow-500 hover:text-yellow-700', title: 'Peringatan!' }
        }
    }" 
    x-show="show" 
    x-init="
        if($attributes.has('x-bind:type')) nType = $attributes.get('x-bind:type');
        if($attributes.has('x-bind:message')) nMessage = $attributes.get('x-bind:message');
        setTimeout(() => show = false, 5000)
    "
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-4"
    :class="`fixed bottom-4 right-4 z-50 max-w-sm w-full ${config[nType].bg} border-l-4 ${config[nType].border} rounded-r-lg shadow-lg p-4 flex items-start gap-3 transition-all duration-300`"
    role="alert"
>
    <span class="material-symbols-outlined text-xl" :class="config[nType].icon_color" x-text="config[nType].icon"></span>
    <div class="flex-1">
        <p class="text-sm font-bold" :class="config[nType].text_bold" x-text="config[nType].title"></p>
        <p class="text-sm" :class="config[nType].text_dim" x-text="nMessage"></p>
    </div>
    <button 
        @click="show = false"
        class="focus:outline-none focus:ring-2 rounded" :class="config[nType].btn_color"
        aria-label="Tutup pesan"
    >
        <span class="material-symbols-outlined text-lg">close</span>
    </button>
</div>
