<div class="max-w-[1440px] mx-auto space-y-10 pb-20">
    @section('admin-title') Detail Artikel: {{ $article->title }} @endsection

    {{-- ── Header Section with Actions ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <nav class="flex text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 gap-2 items-center">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <a href="{{ route('admin.articles.index') }}" class="hover:text-indigo-600 transition-colors">Manajemen Artikel</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-indigo-600">Detail Konten</span>
            </nav>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Pratinjau Artikel</h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.articles.index') }}"
               class="h-14 px-6 flex items-center gap-3 bg-white border border-slate-200 text-slate-600 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Kembali
            </a>
            @can('update', $article)
            <a href="{{ route('admin.articles.edit', $article->id) }}"
               class="h-14 px-8 flex items-center gap-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-xl shadow-indigo-600/20 transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">edit</span>
                Ubah Artikel
            </a>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        {{-- Left Column: Main Content --}}
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
                {{-- Hero Cover --}}
                @if($article->thumbnail && Storage::disk('public')->exists($article->thumbnail))
                    <div class="w-full aspect-video relative group overflow-hidden">
                        <img src="{{ asset('storage/'.$article->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                        <div class="absolute bottom-10 left-10 right-10 space-y-4">
                            <span class="px-4 py-2 rounded-xl bg-indigo-500 text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-500/20 inline-block">
                                {{ $article->category->name ?? 'Informasi Umum' }}
                            </span>
                            <h2 class="text-3xl md:text-5xl font-black text-white leading-tight tracking-tight">{{ $article->title }}</h2>
                        </div>
                    </div>
                @else
                    <div class="p-12 md:p-16 bg-slate-50 border-b border-slate-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-100/50 rounded-full blur-3xl -mr-20 -mt-20"></div>
                        <span class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-[0.2em] mb-6 inline-block border border-indigo-100 relative z-10">
                            {{ $article->category->name ?? 'Informasi Umum' }}
                        </span>
                        <h2 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight tracking-tight relative z-10">{{ $article->title }}</h2>
                    </div>
                @endif

                {{-- Content Body --}}
                <div class="p-10 md:p-16">
                    <div class="flex flex-wrap items-center gap-10 mb-12 py-8 border-y border-slate-50">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-[12px] font-black text-slate-500 uppercase border border-slate-200">
                                {{ substr($article->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Penulis Konten</p>
                                <p class="text-lg font-black text-slate-900">{{ $article->user->name ?? 'Administrator' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                <span class="material-symbols-outlined">event</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Rilis</p>
                                <p class="text-lg font-black text-slate-900">{{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="prose prose-slate prose-xl max-w-none text-slate-700 font-medium leading-relaxed senior-friendly-content">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Side Info --}}
        <div class="lg:col-span-4 space-y-10">
            {{-- Status Bento Card --}}
            <div class="bg-slate-900 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-[80px]"></div>
                
                <div class="relative z-10 space-y-8">
                    <div class="flex items-center justify-between">
                        <div class="w-16 h-16 rounded-[1.5rem] bg-white/10 flex items-center justify-center backdrop-blur-xl border border-white/10">
                            <span class="material-symbols-outlined text-[32px] {{ $article->status === 'published' ? 'text-emerald-400' : 'text-amber-400' }}">
                                {{ $article->status === 'published' ? 'verified' : 'pending' }}
                            </span>
                        </div>
                        @if($article->status === 'published')
                            <span class="text-[11px] font-black text-emerald-400 uppercase tracking-[0.2em]">Terbit Ke Publik</span>
                        @else
                            <span class="text-[11px] font-black text-amber-400 uppercase tracking-[0.2em]">Masih Draf</span>
                        @endif
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2">Status Saat Ini</p>
                        <h3 class="text-5xl font-black tracking-tighter uppercase leading-none">{{ $article->status }}</h3>
                    </div>

                    <div class="space-y-4 pt-4">
                        <div class="flex items-center justify-between text-[11px] font-black uppercase tracking-widest text-slate-400">
                            <span>Kesiapan Konten</span>
                            <span class="{{ $article->status === 'published' ? 'text-emerald-400' : 'text-amber-400' }}">
                                {{ $article->status === 'published' ? '100%' : '40%' }}
                            </span>
                        </div>
                        <div class="h-3 w-full bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full {{ $article->status === 'published' ? 'bg-emerald-400' : 'bg-amber-400 shadow-[0_0_20px_rgba(245,158,11,0.3)]' }} rounded-full transition-all duration-1000" 
                                 style="width: {{ $article->status === 'published' ? '100' : '40' }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Metadata Info --}}
            <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] space-y-8">
                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50 pb-6">Informasi Teknis</h4>
                
                <div class="space-y-8">
                    <div class="flex gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100">
                            <span class="material-symbols-outlined">link</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Slug Konten</p>
                            <p class="text-xs font-black text-slate-800 break-all leading-relaxed">{{ $article->slug }}</p>
                        </div>
                    </div>

                    <div class="flex gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100">
                            <span class="material-symbols-outlined">history</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Dibuat Pertama Kali</p>
                            <p class="text-sm font-black text-slate-800">{{ $article->created_at->translatedFormat('d F Y') }}</p>
                            <p class="text-[11px] font-bold text-slate-400 uppercase mt-1">{{ $article->created_at->translatedFormat('H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="flex gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100">
                            <span class="material-symbols-outlined">update</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Update Terakhir</p>
                            <p class="text-sm font-black text-slate-800">{{ $article->updated_at->translatedFormat('d F Y') }}</p>
                            <p class="text-[11px] font-bold text-slate-400 uppercase mt-1">{{ $article->updated_at->translatedFormat('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <div class="pt-8 mt-4">
                    <button class="w-full h-16 rounded-[1.5rem] bg-slate-50 border-2 border-dashed border-slate-200 text-slate-400 text-[11px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined text-[20px]">content_copy</span>
                        Salin Tautan Artikel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .senior-friendly-content p {
            margin-bottom: 2rem;
            line-height: 2;
            font-size: 1.25rem;
            color: #334155;
        }
    </style>
</div>
