<div x-show="open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-inverse-surface/60 backdrop-blur-sm"
     x-cloak>
    
    <div @click.away="open = false" class="bg-white rounded-[2.5rem] w-full max-w-md overflow-hidden shadow-2xl">
        <div class="p-10 text-center">
            {{-- Icon --}}
            <div class="w-20 h-20 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 mx-auto mb-6 border border-red-100">
                <span class="material-symbols-outlined text-[40px]">delete_forever</span>
            </div>

            {{-- Text --}}
            <h3 class="text-headline-sm font-black text-on-surface mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-outline font-medium leading-relaxed mb-8">
                Apakah Anda yakin ingin menghapus artikel <span class="font-black text-on-surface">"{{ $article->title }}"</span>? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
            </p>

            {{-- Actions --}}
            <div class="flex flex-col gap-3">
                <button type="button" 
                        wire:click="deleteArticle({{ $article->id }})"
                        @click="open = false"
                        class="w-full h-14 bg-error text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg shadow-red-500/20 active:scale-[0.98]">
                    Ya, Hapus Permanen
                </button>
                <button type="button" 
                        @click="open = false"
                        class="w-full h-14 bg-surface-container-low text-outline-variant rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-surface-container transition-all">
                    Batalkan
                </button>
            </div>
        </div>
    </div>
</div>
