@extends('layouts.admin-layout')

@section('title', 'Tambah Pengguna Baru')

@section('admin-content')
<div class="max-w-4xl mx-auto py-8">
    <!-- Error Alert Block -->
    @if ($errors->any())
    <div class="mb-8 bg-error-container text-on-error-container p-4 rounded-xl border border-error/20 flex gap-4 animate-in fade-in duration-500">
        <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">error</span>
        <div>
            <h4 class="font-headline-sm text-[16px] font-bold mb-1">TERJADI KESALAHAN</h4>
            <ul class="text-label-md list-disc list-inside opacity-90">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <section class="bg-surface-container-lowest rounded-2xl border border-outline-variant shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-outline-variant flex justify-between items-start">
            <div>
                <h2 class="text-display-sm text-on-surface">Tambah Pengguna Baru</h2>
                <p class="font-body-md text-on-surface-variant mt-1">Lengkapi formulir di bawah untuk mendaftarkan akun baru ke sistem.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="p-2 hover:bg-surface-container-high rounded-full transition-colors text-on-surface-variant">
                <span class="material-symbols-outlined">close</span>
            </a>
        </div>
        
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-10" x-data="{ role: '{{ old('role', '') }}' }">
            @csrf
            
            <!-- Basic Info Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="font-label-md text-on-surface-variant block font-semibold">Nama Lengkap</label>
                    <input name="name" value="{{ old('name') }}" required class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Contoh: Siti Aminah" type="text"/>
                </div>
                <div class="space-y-2">
                    <label class="font-label-md text-on-surface-variant block font-semibold">Nama Pengguna (Username)</label>
                    <input name="username" value="{{ old('username') }}" required class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="username_kader" type="text"/>
                </div>
                <div class="space-y-2">
                    <label class="font-label-md text-on-surface-variant block font-semibold">Alamat Surat Elektronik</label>
                    <input name="email" value="{{ old('email') }}" required class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="email@posyandu.id" type="email"/>
                </div>
                <div class="space-y-2">
                    <label class="font-label-md text-on-surface-variant block font-semibold">Peran / Role</label>
                    <select name="role" required x-model="role" class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all cursor-pointer">
                        <option value="">Pilih Peran</option>
                        <option value="admin1" {{ old('role') == 'admin1' ? 'selected' : '' }}>Admin 1 (Kenanga 1)</option>
                        <option value="admin2" {{ old('role') == 'admin2' ? 'selected' : '' }}>Admin 2 (Kenanga 2)</option>
                        <option value="kader1" {{ old('role') == 'kader1' ? 'selected' : '' }}>Kader 1 (Kenanga 1)</option>
                        <option value="kader2" {{ old('role') == 'kader2' ? 'selected' : '' }}>Kader 2 (Kenanga 2)</option>
                        <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Admin RW</option>
                    </select>
                </div>
            </div>

            <!-- Conditional Profile Section -->
            <div x-show="role.includes('admin') || role.includes('kader')" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="bg-blue-50/50 rounded-xl p-6 border border-outline-variant/30 space-y-8" style="display: none;">
                 
                <div class="flex items-center gap-3 text-primary border-b border-primary/20 pb-4 mb-4 -ml-0.5">
                    <span class="material-symbols-outlined">account_circle</span>
                    <h3 class="text-headline-sm font-semibold">Informasi Profil Kader</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Profile Photo Upload -->
                    <div class="md:col-span-1 space-y-4">
                        <label class="font-label-md text-on-surface-variant block font-semibold">Foto Profil</label>
                        <div class="relative group">
                            <div class="w-full aspect-square rounded-xl bg-surface-container-highest flex items-center justify-center border-2 border-dashed border-outline-variant overflow-hidden">
                                <img id="previewImage" class="w-full h-full object-cover" src="{{ asset('assets/img/kaders/placeholder.svg') }}" />
                            </div>
                            <div class="absolute inset-0 bg-on-surface/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-xl cursor-pointer" onclick="document.getElementById('image-upload').click()">
                                <span class="text-white font-label-md">Ubah Foto</span>
                            </div>
                        </div>
                        <input type="file" name="image" id="image-upload" class="hidden" accept="image/*" 
                               onchange="const file = this.files[0]; if(file){ const reader = new FileReader(); reader.onload = e => document.getElementById('previewImage').src = e.target.result; reader.readAsDataURL(file); }">
                        <button onclick="document.getElementById('image-upload').click()" class="w-full py-2 px-4 bg-white border border-outline-variant text-primary font-bold rounded-lg hover:bg-primary/5 transition-colors" type="button">
                            Pilih Foto Kader
                        </button>
                    </div>
                    
                    <!-- Profile Fields -->
                    <div class="md:col-span-2 space-y-6">
                        <div class="space-y-2">
                            <label class="font-label-md text-on-surface-variant block font-semibold">Nomor Induk Kependudukan (16 Digit)</label>
                            <input name="nik" value="{{ old('nik') }}" class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" maxlength="16" placeholder="320xxxxxxxxxxxxx" type="text"/>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- In original system it's one field "ttl", but adapting to the split layout visually -->
                            <div class="space-y-2 col-span-2 md:col-span-1">
                                <label class="font-label-md text-on-surface-variant block font-semibold">Tempat Lahir</label>
                                <input name="tempat_lahir" class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Bandung" type="text"/>
                            </div>
                            <div class="space-y-2 col-span-2 md:col-span-1">
                                <label class="font-label-md text-on-surface-variant block font-semibold">Tanggal Lahir</label>
                                <input name="tanggal_lahir" class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" type="date"/>
                            </div>
                            <!-- To not break the backend, we will keep the 'ttl' hidden input that concatenates them before submit, or just revert to single field if backend relies on it. For safety, let's keep one input named 'ttl' but label it Tempat, Tanggal Lahir as before -->
                            <div class="space-y-2 col-span-2 hidden">
                                <input name="ttl" id="ttl_hidden" value="{{ old('ttl') }}">
                            </div>
                        </div>
                        <script>
                            // Auto concat if they use the separate fields
                            document.querySelectorAll('input[name="tempat_lahir"], input[name="tanggal_lahir"]').forEach(el => {
                                el.addEventListener('input', () => {
                                    const tempat = document.querySelector('input[name="tempat_lahir"]').value;
                                    const tanggal = document.querySelector('input[name="tanggal_lahir"]').value;
                                    document.getElementById('ttl_hidden').value = tempat + (tempat && tanggal ? ', ' : '') + tanggal;
                                });
                            });
                        </script>
                        
                        <div class="space-y-2">
                            <label class="font-label-md text-on-surface-variant block font-semibold">Jabatan Struktural Posyandu</label>
                            <input name="cadre_role" value="{{ old('cadre_role') }}" class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Sekretaris / Bendahara" type="text"/>
                        </div>
                    </div>
                </div>

                <!-- Education Selection -->
                <div class="space-y-3">
                    <label class="font-label-md text-on-surface-variant block font-semibold">Jenjang Pendidikan Terakhir</label>
                    <input type="hidden" name="pendidikan" id="pendidikan" value="{{ old('pendidikan') }}" x-ref="pendidikan">
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2" x-data="{ selected: '{{ old('pendidikan') }}' }">
                        @foreach(['SD', 'SMP', 'SLTA', 'Diploma', 'Sarjana', 'Magister', 'Doktor'] as $edu)
                            <button type="button" 
                                    @click="selected = '{{ $edu }}'; $refs.pendidikan.value = '{{ $edu }}'"
                                    :class="selected === '{{ $edu }}' ? 'border-primary text-primary bg-primary/5' : 'border-outline-variant text-on-surface hover:border-primary hover:text-primary'"
                                    class="py-2 px-3 bg-white border rounded-lg text-label-sm font-bold transition-all">
                                {{ $edu }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Address -->
                <div class="space-y-2">
                    <label class="font-label-md text-on-surface-variant block font-semibold">Alamat Domisili Lengkap</label>
                    <textarea name="alamat" class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all resize-none" placeholder="Jl. Kedamaian No. 123, Kelurahan Bahagia..." rows="3">{{ old('alamat') }}</textarea>
                </div>
            </div>

            <!-- Security Section -->
            <div class="space-y-6 pt-6 border-t border-outline-variant">
                <h3 class="text-headline-sm font-semibold flex items-center gap-3 -ml-0.5">
                    <span class="material-symbols-outlined text-secondary">lock</span>
                    Keamanan Akun
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ showPass: false, showConfirm: false }">
                    <div class="space-y-2">
                        <label class="font-label-md text-on-surface-variant block font-semibold">Kata Sandi (Password)</label>
                        <div class="relative">
                            <input name="password" :type="showPass ? 'text' : 'password'" required class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all pr-12" placeholder="••••••••" />
                            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-outline-variant hover:text-outline transition-colors">
                                <span class="material-symbols-outlined" x-text="showPass ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="font-label-md text-on-surface-variant block font-semibold">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input name="password_confirmation" :type="showConfirm ? 'text' : 'password'" required class="w-full bg-white border border-outline-variant rounded-lg px-4 py-3 font-body-md focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all pr-12" placeholder="••••••••" />
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-outline-variant hover:text-outline transition-colors">
                                <span class="material-symbols-outlined" x-text="showConfirm ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Section -->
            <div class="bg-blue-50/50 rounded-xl p-5 flex items-center justify-between border border-outline-variant/20">
                <div class="flex items-center gap-4 -ml-0.5">
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <span class="material-symbols-outlined text-primary">verified_user</span>
                    </div>
                    <div>
                        <p class="font-label-md text-on-surface font-bold">Status Aktivitas Akun</p>
                        <p class="text-label-sm text-on-surface-variant">Aktifkan untuk mengizinkan akses login pengguna ke sistem</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer" />
                    <div class="w-11 h-6 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                </label>
            </div>

            <!-- Footer Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-outline-variant">
                <a href="{{ route('admin.users.index') }}" class="flex-1 order-2 sm:order-1 py-4 px-6 border border-secondary text-secondary font-bold rounded-xl hover:bg-secondary/5 transition-all active:scale-95 duration-150 text-center">
                    Batalkan
                </a>
                <button type="submit" class="flex-[2] order-1 sm:order-2 py-4 px-6 bg-primary text-white font-bold rounded-xl shadow-md hover:shadow-xl hover:bg-primary/90 transition-all active:scale-95 duration-150 flex items-center justify-center gap-2 group">
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform" style="font-variation-settings: 'FILL' 0, 'wght' 700;">check</span>
                    SIMPAN PENGGUNA
                </button>
            </div>
        </form>
    </section>
    
    <p class="text-center text-label-sm text-on-surface-variant mt-8 opacity-60">
        © 2024 Posyandu Care System. Hak Cipta Dilindungi.
    </p>
</div>
@endsection