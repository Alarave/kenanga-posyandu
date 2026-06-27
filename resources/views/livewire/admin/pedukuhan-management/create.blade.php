@extends('layouts.app')

@section('title', 'Tambah Pedukuhan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-headline-sm font-bold text-on-surface">Tambah Pedukuhan Baru</h1>
            <p class="text-sm text-outline mt-0.5">Daftarkan wilayah pedukuhan baru ke sistem</p>
        </div>
        <a href="{{ route('admin.pedukuhans.index') }}"
           class="flex items-center gap-2 text-sm font-medium text-outline hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant flex items-center gap-3">
            <div class="w-9 h-9 bg-primary-container rounded-xl flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">add_location</span>
            </div>
            <div>
                <h2 class="text-sm font-bold text-on-surface">Informasi Pedukuhan</h2>
                <p class="text-xs text-outline-variant">Lengkapi semua field yang diperlukan</p>
            </div>
        </div>

        <form action="{{ route('admin.pedukuhans.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            @if($errors->any())
            <div class="flex items-start gap-3 px-4 py-3 bg-red-50 border border-error text-red-800 rounded-xl text-sm">
                <span class="material-symbols-outlined text-red-500 text-[20px] flex-shrink-0 mt-0.5">error</span>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Nama Pedukuhan --}}
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1.5">
                    Nama Pedukuhan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline-variant text-[18px]">location_city</span>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Contoh: Pedukuhan Margahayu"
                           @class([
    'w-full h-11 pl-10 pr-4 rounded-xl border border-outline-variant text-sm font-medium text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition',
    'border-red-400 bg-red-50' => $errors->has('name')
])>
                </div>
                @error('name')
                    <p class="mt-1 text-xs text-error flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Kode Pos --}}
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1.5">
                    Kode Pos <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline-variant text-[18px]">markunread_mailbox</span>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                           placeholder="Contoh: 17113"
                           maxlength="5"
                           @class([
    'w-full h-11 pl-10 pr-4 rounded-xl border border-outline-variant text-sm font-medium text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition',
    'border-red-400 bg-red-50' => $errors->has('postal_code')
])>
                </div>
                @error('postal_code')
                    <p class="mt-1 text-xs text-error flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Lokasi / Alamat --}}
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1.5">
                    Alamat / Lokasi
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 material-symbols-outlined text-outline-variant text-[18px]">location_on</span>
                    <textarea name="geo_location" rows="3"
                              placeholder="Deskripsi lokasi atau alamat wilayah pedukuhan..."
                              @class([
    'w-full pl-10 pr-4 py-3 rounded-xl border border-outline-variant text-sm font-medium text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition resize-none',
    'border-red-400 bg-red-50' => $errors->has('geo_location')
])>{{ old('geo_location') }}</textarea>
                </div>
                @error('geo_location')
                    <p class="mt-1 text-xs text-error flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="border-t border-slate-100 pt-5 flex items-center justify-between gap-3">
                <a href="{{ route('admin.pedukuhans.index') }}"
                   class="h-11 px-6 flex items-center gap-2 rounded-xl border border-outline-variant text-sm font-semibold text-on-surface-variant hover:bg-surface-container-low transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                    Batal
                </a>
                <button type="submit"
                        class="h-11 px-8 bg-primary text-white rounded-xl text-sm font-bold hover:bg-teal-700 active:scale-95 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">check</span>
                    Simpan Pedukuhan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
