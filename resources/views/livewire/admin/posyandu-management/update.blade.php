@extends('layouts.app')

@section('title', 'Edit Posyandu')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Edit Data Posyandu</h1>
            <p class="text-sm text-slate-500 mt-0.5">Perbarui informasi unit posyandu</p>
        </div>
        <a href="{{ route('admin.posyandu.index') }}"
           class="flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <span class="material-symbols-outlined text-[20px]">edit</span>
            </div>
            <div>
                <h2 class="text-sm font-bold text-slate-900">{{ $posyandu->name }}</h2>
                <p class="text-xs text-slate-400">Edit informasi posyandu</p>
            </div>
        </div>

        <form action="{{ route('admin.posyandu.update', $posyandu->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            @if($errors->any())
            <div class="flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
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
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                    Nama Posyandu <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-[18px]">home_health</span>
                    <input type="text" name="name" value="{{ old('name', $posyandu->name) }}"
                           placeholder="Nama posyandu"
                           class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 placeholder:text-slate-400
                                  focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition
                                  @error('name') border-red-400 bg-red-50 @enderror">
                </div>
                @error('name')
                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Pedukuhan --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                    Pedukuhan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-[18px]">location_city</span>
                    <x-forms.select-input name="pedukuhan_id" placeholder="Pilih Pedukuhan" :placeholderDisabled="true" value="{{ old('pedukuhan_id', $posyandu->pedukuhan_id) }}" class="!pl-10 !h-11 !rounded-xl !border-slate-300 focus:!border-teal-500 focus:!ring-teal-500/20 !shadow-none" :error="$errors->has('pedukuhan_id')">
                        @foreach($pedukuhans as $ped)
                            <option value="{{ $ped->id }}" {{ old('pedukuhan_id', $posyandu->pedukuhan_id) == $ped->id ? 'selected' : '' }}>
                                {{ $ped->name }}
                            </option>
                        @endforeach
                    </x-forms.select-input>
                </div>
                @error('pedukuhan_id')
                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Kode Unik & Logo --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                        Kode Unik
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-[18px]">tag</span>
                        <input type="text" name="unique_code" value="{{ old('unique_code', $posyandu->unique_code) }}"
                               placeholder="Contoh: KENANGA1"
                               class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 placeholder:text-slate-400
                                      focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                        Logo / Foto (Opsional)
                    </label>
                    @if($posyandu->logo_photo)
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ asset('storage/' . $posyandu->logo_photo) }}"
                             class="w-10 h-10 rounded-xl object-cover border border-slate-200">
                        <span class="text-xs text-slate-400">Logo saat ini</span>
                    </div>
                    @endif
                    <input type="file" name="logo_photo" accept="image/*"
                           class="w-full h-11 px-3 py-2 border border-slate-300 rounded-xl text-sm text-slate-600
                                  file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold
                                  file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition">
                </div>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                    Alamat Lengkap <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 material-symbols-outlined text-slate-400 text-[18px]">location_on</span>
                    <textarea name="address" rows="3"
                              placeholder="Alamat lengkap unit posyandu..."
                              class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 placeholder:text-slate-400
                                     focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition resize-none
                                     @error('address') border-red-400 bg-red-50 @enderror">{{ old('address', $posyandu->address) }}</textarea>
                </div>
                @error('address')
                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="border-t border-slate-100 pt-5 flex items-center justify-between gap-3">
                <a href="{{ route('admin.posyandu.index') }}"
                   class="h-11 px-6 flex items-center gap-2 rounded-xl border border-slate-300 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                    Batal
                </a>
                <button type="submit"
                        class="h-11 px-8 bg-teal-600 text-white rounded-xl text-sm font-bold hover:bg-teal-700 active:scale-95 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">check</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
