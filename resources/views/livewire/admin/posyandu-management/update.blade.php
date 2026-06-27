@extends('layouts.app')

@section('title', 'Edit Posyandu')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-headline-sm font-bold text-on-surface">Edit Data Posyandu</h1>
            <p class="text-sm text-outline mt-0.5">Perbarui informasi unit posyandu</p>
        </div>
        <a href="{{ route('admin.posyandu.index') }}"
           class="flex items-center gap-2 text-sm font-medium text-outline hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[20px]">edit</span>
            </div>
            <div>
                <h2 class="text-sm font-bold text-on-surface">{{ $posyandu->name }}</h2>
                <p class="text-xs text-outline-variant">Edit informasi posyandu</p>
            </div>
        </div>

        <form action="{{ route('admin.posyandu.update', $posyandu->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PUT')

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

            {{-- Nama Posyandu --}}
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1.5">
                    Nama Posyandu <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline-variant text-[18px]">home_health</span>
                    <input type="text" name="name" value="{{ old('name', $posyandu->name) }}"
                           placeholder="Nama posyandu"
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

            {{-- Pedukuhan --}}
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1.5">
                    Pedukuhan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline-variant text-[18px]">location_city</span>
                    <x-forms.select-input name="pedukuhan_id" placeholder="Pilih Pedukuhan" :placeholderDisabled="true" value="{{ old('pedukuhan_id', $posyandu->pedukuhan_id) }}" class="!pl-10 !h-11 !rounded-xl !border-outline-variant focus:!border-primary focus:!ring-primary/20 !shadow-none" :error="$errors->has('pedukuhan_id')">
                        @foreach($pedukuhans as $ped)
                            <option value="{{ $ped->id }}" {{ old('pedukuhan_id', $posyandu->pedukuhan_id) == $ped->id ? 'selected' : '' }}>
                                {{ $ped->name }}
                            </option>
                        @endforeach
                    </x-forms.select-input>
                </div>
                @error('pedukuhan_id')
                    <p class="mt-1 text-xs text-error flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Kode Unik & Logo --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1.5">
                        Kode Unik
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline-variant text-[18px]">tag</span>
                        <input type="text" name="unique_code" value="{{ old('unique_code', $posyandu->unique_code) }}"
                               placeholder="Contoh: KENANGA1"
                               class="w-full h-11 pl-10 pr-4 rounded-xl border border-outline-variant text-sm font-medium text-on-surface placeholder:text-outline-variant
                                      focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1.5">
                        Logo / Foto (Opsional)
                    </label>
                    @if($posyandu->logo_photo)
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ asset('storage/' . $posyandu->logo_photo) }}"
                             class="w-10 h-10 rounded-xl object-cover border border-outline-variant">
                        <span class="text-xs text-outline-variant">Logo saat ini</span>
                    </div>
                    @endif
                    <input type="file" name="logo_photo" accept="image/*"
                           class="w-full h-11 px-3 py-2 border border-outline-variant rounded-xl text-sm text-on-surface-variant
                                  file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold
                                  file:bg-primary-container file:text-on-primary-container hover:file:bg-teal-100 transition">
                </div>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1.5">
                    Alamat Lengkap <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 material-symbols-outlined text-outline-variant text-[18px]">location_on</span>
                    <textarea name="address" rows="3"
                              placeholder="Alamat lengkap unit posyandu..."
                              @class([
    'w-full pl-10 pr-4 py-3 rounded-xl border border-outline-variant text-sm font-medium text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition resize-none',
    'border-red-400 bg-red-50' => $errors->has('address')
])>{{ old('address', $posyandu->address) }}</textarea>
                </div>
                @error('address')
                    <p class="mt-1 text-xs text-error flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="border-t border-slate-100 pt-5 flex items-center justify-between gap-3">
                <a href="{{ route('admin.posyandu.index') }}"
                   class="h-11 px-6 flex items-center gap-2 rounded-xl border border-outline-variant text-sm font-semibold text-on-surface-variant hover:bg-surface-container-low transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                    Batal
                </a>
                <button type="submit"
                        class="h-11 px-8 bg-primary text-white rounded-xl text-sm font-bold hover:bg-teal-700 active:scale-95 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">check</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
