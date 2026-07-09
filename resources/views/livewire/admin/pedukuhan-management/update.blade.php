@extends('layouts.app')

@section('title', 'Edit Pedukuhan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Edit Data Pedukuhan</h1>
            <p class="text-sm text-slate-500 mt-0.5">Perbarui informasi wilayah pedukuhan</p>
        </div>
        <a href="{{ route('admin.pedukuhans.index') }}"
           class="flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <span class="material-symbols-outlined text-[20px]">edit_location</span>
            </div>
            <div>
                <h2 class="text-sm font-bold text-slate-900">{{ $pedukuhan->name }}</h2>
                <p class="text-xs text-slate-400">Edit informasi pedukuhan</p>
            </div>
        </div>

        <form action="{{ route('admin.pedukuhans.update', $pedukuhan->id) }}" method="POST" class="p-6 space-y-5">
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

            {{-- Nama Pedukuhan --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                    Nama Pedukuhan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-[18px]">location_city</span>
                    <input type="text" name="name" value="{{ old('name', $pedukuhan->name) }}"
                           placeholder="Nama pedukuhan"
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

            {{-- Kode Pos --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                    Kode Pos <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-[18px]">markunread_mailbox</span>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $pedukuhan->postal_code) }}"
                           placeholder="Contoh: 17113"
                           maxlength="5"
                           class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 placeholder:text-slate-400
                                  focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition
                                  @error('postal_code') border-red-400 bg-red-50 @enderror">
                </div>
                @error('postal_code')
                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Lokasi / Alamat --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                    Alamat / Lokasi
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 material-symbols-outlined text-slate-400 text-[18px]">location_on</span>
                    <textarea name="geo_location" rows="3"
                              placeholder="Deskripsi lokasi atau alamat wilayah pedukuhan..."
                              class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 placeholder:text-slate-400
                                     focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition resize-none
                                     @error('geo_location') border-red-400 bg-red-50 @enderror">{{ old('geo_location', $pedukuhan->geo_location) }}</textarea>
                </div>
                @error('geo_location')
                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="border-t border-slate-100 pt-5 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                <a href="{{ route('admin.pedukuhans.index') }}"
                   class="w-full sm:w-auto h-11 px-6 flex items-center justify-center gap-2 rounded-xl border border-slate-300 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                    <span class="material-symbols-outlined text-[18px] shrink-0">close</span>
                    Batal
                </a>
                <button type="submit"
                        class="w-full sm:w-auto h-11 px-8 justify-center bg-teal-600 text-white rounded-xl text-sm font-bold hover:bg-teal-700 active:scale-95 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[18px] shrink-0">check</span>
                    <span class="whitespace-nowrap">Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
