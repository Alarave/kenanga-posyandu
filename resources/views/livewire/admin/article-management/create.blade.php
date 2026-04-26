@extends('layouts.admin-layout')

@section('admin-title') Buat Artikel Baru @endsection

@section('admin-content')
<div class="max-w-5xl mx-auto py-10 px-6 sm:px-8">
    <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-sm overflow-hidden">
        {{-- Header --}}
        <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-indigo-50 rounded-3xl flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100">
                    <span class="material-symbols-outlined text-[28px]">post_add</span>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight leading-tight">Tulis Edukasi Baru</h2>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">Publikasi Konten Informasi & Kesehatan</p>
                </div>
            </div>
            <a href="{{ route('admin.articles.index') }}" 
               class="w-10 h-10 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </a>
        </div>

        <form wire:submit.prevent="save" class="p-10 space-y-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                {{-- Left Content: Main Editor --}}
                <div class="lg:col-span-8 space-y-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Judul Artikel <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="title" placeholder="Masukan judul artikel yang menarik..."
                               class="w-full h-16 px-8 rounded-3xl border border-slate-100 bg-slate-50/50 text-lg font-black text-slate-800 placeholder:text-slate-300 focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 transition-all">
                        @error('title') <p class="text-[10px] text-red-500 font-bold ml-2 uppercase tracking-wider">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-3" wire:ignore>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Isi Konten Artikel <span class="text-red-500">*</span></label>
                        <textarea wire:model="content" id="article-editor" rows="12" placeholder="Tuliskan isi artikel Anda di sini..."
                                  class="w-full px-8 py-6 rounded-[2rem] border border-slate-100 bg-slate-50/50 text-base font-medium text-slate-700 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all resize-none"></textarea>
                    </div>
                    @error('content') <p class="text-[10px] text-red-500 font-bold ml-2 uppercase tracking-wider">{{ $message }}</p> @enderror
                </div>

                {{-- Right Content: Settings & Thumbnail --}}
                <div class="lg:col-span-4 space-y-10">
                    {{-- Thumbnail Upload --}}
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Thumbnail Gambar</label>
                        <div class="relative group">
                            <div class="w-full aspect-video rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-indigo-300">
                                @if($thumbnail)
                                    <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-[48px] text-slate-200 mb-2">add_photo_alternate</span>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Pilih Gambar</p>
                                @endif
                                <input type="file" wire:model="thumbnail" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 font-medium italic text-center">Format: JPG, PNG, WEBP (Max 2MB)</p>
                        @error('thumbnail') <p class="text-[10px] text-red-500 font-bold text-center uppercase tracking-wider">{{ $message }}</p> @enderror
                    </div>

                    {{-- Category & Status --}}
                    <div class="space-y-8 p-8 bg-slate-50/50 rounded-[2rem] border border-slate-100">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Kategori <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select wire:model="category_id"
                                        class="w-full h-12 px-6 rounded-2xl border border-slate-100 bg-white text-xs font-black uppercase tracking-widest text-slate-700 focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">expand_more</span>
                            </div>
                            @error('category_id') <p class="text-[10px] text-red-500 font-bold ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Status Publikasi</label>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" wire:model="status" value="published" class="sr-only peer">
                                    <div class="w-full h-12 flex items-center justify-center rounded-2xl border border-slate-100 bg-white text-[10px] font-black uppercase tracking-widest text-slate-400 peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600 transition-all">
                                        Published
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" wire:model="status" value="draft" class="sr-only peer">
                                    <div class="w-full h-12 flex items-center justify-center rounded-2xl border border-slate-100 bg-white text-[10px] font-black uppercase tracking-widest text-slate-400 peer-checked:bg-slate-900 peer-checked:text-white peer-checked:border-slate-900 transition-all">
                                        Draft
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="pt-10 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-4 p-5 bg-indigo-50/50 rounded-2xl border border-indigo-100/30 max-w-lg">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-600 shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">lightbulb</span>
                    </div>
                    <p class="text-[10px] font-bold text-indigo-800 uppercase tracking-widest leading-relaxed">
                        Gunakan judul yang ringkas dan gambar thumbnail yang berkualitas tinggi untuk menarik perhatian pembaca.
                    </p>
                </div>
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <a href="{{ route('admin.articles.index') }}" 
                       class="flex-1 sm:flex-none h-14 px-10 flex items-center justify-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-slate-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit" wire:loading.attr="disabled"
                            class="flex-1 sm:flex-none h-14 px-12 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-4 active:scale-[0.98]">
                        <span wire:loading.remove class="material-symbols-outlined text-[20px]">send</span>
                        <div wire:loading class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                        <span>Terbitkan Artikel</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection