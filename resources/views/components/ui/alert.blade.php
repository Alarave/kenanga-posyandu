@props(['type' => 'success', 'message' => '', 'messages' => []])

@php
    $config = [
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-200',
            'text' => 'text-green-700',
            'icon' => 'check_circle',
            'title' => 'Berhasil!'
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'text' => 'text-red-700',
            'icon' => 'error',
            'title' => 'Ada Kesalahan!'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-200',
            'text' => 'text-yellow-700',
            'icon' => 'warning',
            'title' => 'Peringatan!'
        ],
        'status' => [
            'bg' => 'bg-teal-50',
            'border' => 'border-teal-200',
            'text' => 'text-teal-700',
            'icon' => 'info',
            'title' => 'Informasi'
        ]
    ][$type];
@endphp

<div {{ $attributes->merge(['class' => "mb-8 p-6 {$config['bg']} border {$config['border']} rounded-[2rem] shadow-sm"]) }} role="alert">
    <div class="flex items-center gap-3 {{ $config['text'] }} font-black text-lg mb-2">
        <span class="material-symbols-outlined">{{ $config['icon'] }}</span>
        {{ $config['title'] }}
    </div>
    
    @if($message)
        <p class="{{ $config['text'] }} text-base font-bold opacity-90">{{ $message }}</p>
    @endif

    @if(count($messages) > 0)
        <ul class="mt-2 space-y-1">
            @foreach ($messages as $msg)
                <li class="{{ $config['text'] }} text-sm font-semibold flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-50"></span>
                    {{ $msg }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
