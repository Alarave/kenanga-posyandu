{{-- ── 6. BIODATA KADER POSYANDU ── --}}
<section class="py-14 border-t border-slate-100 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="max-w-xl mx-auto sm:text-center">
            <h2 class="text-on-surface dark:text-white text-display-sm md:text-5xl font-black font-jakarta tracking-tight py-2">
                Tim Pelaksana
            </h2>
            <p class="text-gray-600 dark:text-slate-350 mt-3">
                Mengenal lebih dekat para kader pelaksana Posyandu ILP Kenanga 1 RW 011 Kelurahan Aren Jaya yang siap melayani kebutuhan kesehatan warga.
            </p>
        </div>

        <div class="mt-12">
            <ul class="grid gap-8 sm:grid-cols-2 md:grid-cols-3">
                @foreach($kaders as $k)
                <li class="cursor-pointer group bg-white dark:bg-inverse-surface border border-outline-variant/50 dark:border-slate-850 p-5 rounded-2xl shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-350 flex flex-col items-center text-center relative overflow-hidden" onclick="openKaderModal('{{ addslashes($k->name) }}', '{{ addslashes($k->role) }}', '{{ addslashes($k->pendidikan) }}', '{{ addslashes($k->alamat) }}', '{{ addslashes($k->email) }}', '{{ addslashes($k->image) }}')">
                    {{-- Decorative top hover accent bar --}}
                    <div class="absolute top-0 left-0 right-0 h-1 bg-linear-to-r from-primary to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    {{-- Image container --}}
                    <div class="w-full aspect-3/4 overflow-hidden rounded-2xl bg-surface-container dark:bg-inverse-surface relative shadow-xs">
                        <img
                            src="{{ $k->image }}"
                            class="w-full h-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500"
                            alt="{{ $k->name }}"
                        />
                        {{-- Subtle glassmorphic hover overlay --}}
                        <div class="absolute inset-0 bg-linear-to-t from-slate-950/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white/20 backdrop-blur-md rounded-lg text-white text-xs font-bold border border-white/30">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                Lihat Profil
                            </span>
                        </div>
                    </div>

                    {{-- Text content --}}
                    <div class="mt-5 flex flex-col items-center w-full">
                        <h4 class="text-body-lg md:text-headline-sm text-on-surface dark:text-white font-extrabold font-jakarta group-hover:text-primary transition-colors duration-300 line-clamp-1">
                            {{ $k->name }}
                        </h4>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black bg-primary/10 text-primary dark:bg-primary/10 dark:text-teal-400 border border-primary/20 dark:border-primary/20 uppercase tracking-widest mt-2.5">
                            {{ $k->role }}
                        </span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
