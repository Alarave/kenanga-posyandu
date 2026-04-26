@extends('layouts.admin-layout')

@section('admin-title') Detail Artikel: {{ $article->title }} @endsection

@section('admin-actions')
    <div class="flex items-center gap-3">
        <x-button href="{{ route('admin.articles.index') }}" variant="outline" icon="arrow_back">
            Kembali
        </x-button>
        @can('update', $article)
        <x-button href="{{ route('admin.articles.edit', $article->id) }}" variant="secondary" icon="edit">
            Edit Artikel
        </x-button>
        @endcan
    </div>
@endsection

@section('admin-content')
<div class="max-w-6xl mx-auto py-10 px-6 sm:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        {{-- Left: Article Content --}}
        <div class="lg:col-span-8 space-y-10">
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
                {{-- Thumbnail Hero --}}
                @if($article->thumbnail)
                    <div class="w-full aspect-video relative">
                        <img src="{{ asset('storage/'.$article->thumbnail) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <div class="absolute bottom-10 left-10 right-10">
                            <span class="px-4 py-2 rounded-xl bg-teal-500 text-white text-[10px] font-black uppercase tracking-widest mb-4 inline-block shadow-lg shadow-teal-500/20">
                                {{ $article->category->name ?? 'Uncategorized' }}
                            </span>
                            <h1 class="text-3xl md:text-5xl font-black text-white leading-tight tracking-tight">{{ $article->title }}</h1>
                        </div>
                    </div>
                @else
                    <div class="p-12 border-b border-slate-50 bg-slate-50/30">
                        <span class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest mb-4 inline-block border border-indigo-100">
                            {{ $article->category->name ?? 'Uncategorized' }}
                        </span>
                        <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight tracking-tight">{{ $article->title }}</h1>
                    </div>
                @endif

                {{-- Article Body --}}
                <div class="p-10 md:p-14">
                    <div class="flex items-center gap-8 mb-12 py-8 border-y border-slate-50">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-[11px] font-black text-slate-500 uppercase border border-slate-200">
                                {{ substr($article->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Diterbitkan Oleh</p>
                                <p class="text-sm font-black text-slate-900">{{ $article->user->name ?? 'Administrator' }}</p>
                            </div>
                        </div>
                        <div class="h-8 w-px bg-slate-100 hidden md:block"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Publikasi</p>
                            <p class="text-sm font-black text-slate-900">{{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="prose prose-slate prose-lg max-w-none text-slate-600 font-medium leading-relaxed">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Sidebar Info --}}
        <div class="lg:col-span-4 space-y-8">
            {{-- Status Card --}}
            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-xl shadow-slate-200 relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center backdrop-blur-md">
                            <span class="material-symbols-outlined text-[24px] text-teal-400">verified</span>
                        </div>
                        <span class="text-[10px] font-black text-teal-400 uppercase tracking-widest">Status Konten</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kondisi Saat Ini</p>
                    <h3 class="text-4xl font-black mb-10 tracking-tight uppercase">{{ $article->status }}</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-400">
                            <span>Visibilitas Publik</span>
                            <span class="text-teal-400">{{ $article->status === 'published' ? 'Aktif' : 'Tersembunyi' }}</span>
                        </div>
                        <div class="h-1.5 w-full bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-teal-500 rounded-full" style="width: {{ $article->status === 'published' ? '100' : '30' }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
            </div>

            {{-- Metadata Card --}}
            <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Metadata Informasi</h4>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-[20px] text-slate-300">link</span>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Slug URL</p>
                            <p class="text-xs font-bold text-slate-700 break-all leading-relaxed">{{ $article->slug }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-[20px] text-slate-300">history</span>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Dibuat Pada</p>
                            <p class="text-xs font-bold text-slate-700">{{ $article->created_at->translatedFormat('d F Y H:i') }} WIB</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-[20px] text-slate-300">update</span>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pembaruan Terakhir</p>
                            <p class="text-xs font-bold text-slate-700">{{ $article->updated_at->translatedFormat('d F Y H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10 pt-8 border-t border-slate-50">
                    <button class="w-full h-12 rounded-2xl bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">
                        Salin Tautan Artikel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
