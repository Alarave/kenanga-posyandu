@extends('layouts.admin-layout')

@section('title', 'Tambah Pengguna Baru')

@section('admin-content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div class="flex flex-col gap-2">
            <h2 class="text-display-sm text-on-surface tracking-tight">Tambah Pengguna Baru</h2>
            <p class="text-body-md text-outline">Lengkapi formulir di bawah untuk mendaftarkan akun baru ke sistem.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="w-12 h-12 rounded-lg bg-surface-container-lowest border border-outline-variant flex items-center justify-center text-outline-variant hover:text-primary hover:bg-surface-container-low transition-all shadow-sm">
            <span class="material-symbols-outlined text-[24px]">close</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="p-6 bg-error-container border border-error rounded-2xl flex items-start space-x-4 animate-in fade-in duration-300">
            <div class="w-10 h-10 bg-error rounded-lg flex items-center justify-center text-on-error flex-shrink-0 shadow-sm">
                <span class="material-symbols-outlined text-[24px]">error</span>
            </div>
            <div>
                <h4 class="text-on-error-container font-black text-label-md mb-2">TERJADI KESALAHAN</h4>
                <ul class="list-disc list-inside text-error text-label-md space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ role: '{{ old('role', '') }}' }">
        @csrf
        
        <!-- Main Form Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-8 md:p-10 shadow-card border border-outline-variant relative overflow-hidden">
            <div class="relative grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <!-- Name -->
                <x-forms.form-group label="Nama Lengkap" for="name" required>
                    <x-forms.text-input name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required />
                </x-forms.form-group>

                <!-- Username -->
                <x-forms.form-group label="Username" for="username" required>
                    <x-forms.text-input name="username" placeholder="Contoh: bidansari" value="{{ old('username') }}" required />
                </x-forms.form-group>

                <!-- Email -->
                <x-forms.form-group label="Alamat Email" for="email" required>
                    <x-forms.text-input type="email" name="email" placeholder="email@posyandu.com" value="{{ old('email') }}" required />
                </x-forms.form-group>

                <!-- Role -->
                <x-forms.form-group label="Peran / Role" for="role" required>
                    <x-forms.select-input name="role" placeholder="Pilih Peran" required @change="role = $event.target.value">
                        <option value="admin1" {{ old('role') == 'admin1' ? 'selected' : '' }}>Admin 1 (Kenanga 1)</option>
                        <option value="admin2" {{ old('role') == 'admin2' ? 'selected' : '' }}>Admin 2 (Kenanga 2)</option>
                        <option value="kader1" {{ old('role') == 'kader1' ? 'selected' : '' }}>Kader 1 (Kenanga 1)</option>
                        <option value="kader2" {{ old('role') == 'kader2' ? 'selected' : '' }}>Kader 2 (Kenanga 2)</option>
                        <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Admin RW</option>
                    </x-forms.select-input>
                </x-forms.form-group>

                <!-- Cadre Profile Section (Conditionally Visible) -->
                <div x-show="role.includes('admin') || role.includes('kader')" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="md:col-span-2 mt-4 p-8 bg-surface-container-low rounded-2xl border border-outline-variant space-y-6">
                    
                    <h3 class="text-headline-sm font-bold text-primary flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined">badge</span>
                        Informasi Profil Kader
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NIK -->
                        <x-forms.form-group label="NIK (Nomor Induk Kependudukan)" for="nik">
                            <x-forms.text-input name="nik" placeholder="Masukkan 16 digit NIK" value="{{ old('nik') }}" maxlength="16" />
                        </x-forms.form-group>

                        <!-- TTL -->
                        <x-forms.form-group label="Tempat, Tanggal Lahir" for="ttl">
                            <x-forms.text-input name="ttl" placeholder="Contoh: Bekasi, 12 April 1990" value="{{ old('ttl') }}" />
                        </x-forms.form-group>

                        <!-- Jabatan / Peran Spesifik Kader -->
                        <x-forms.form-group label="Jabatan di Posyandu" for="cadre_role">
                            <x-forms.text-input name="cadre_role" placeholder="Contoh: Ketua Kader, Bendahara, Anggota" value="{{ old('cadre_role') }}" />
                        </x-forms.form-group>

                        <!-- Pendidikan (Selectable Cards) -->
                        <div class="md:col-span-2">
                            <label class="block text-label-sm text-outline-variant mb-3">Pendidikan Terakhir</label>
                            <input type="hidden" name="pendidikan" id="pendidikan" value="{{ old('pendidikan') }}">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" x-data="{ selected: '{{ old('pendidikan') }}' }">
                                @foreach(['SD', 'SMP', 'SLTA', 'Diploma', 'Sarjana', 'Magister', 'Doktor'] as $edu)
                                    <button type="button" 
                                            @click="selected = '{{ $edu }}'; document.getElementById('pendidikan').value = '{{ $edu }}'"
                                            :class="selected === '{{ $edu }}' ? 'bg-primary text-on-primary border-primary shadow-sm' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant hover:bg-surface-container-low'"
                                            class="px-4 py-3 rounded-lg border text-center font-bold text-label-md transition-all focus:outline-none">
                                        {{ $edu }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label class="block text-label-sm text-outline-variant mb-3">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap..." class="w-full px-5 py-4 bg-surface-container-lowest border border-outline-variant rounded-lg text-on-surface text-body-md placeholder-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">{{ old('alamat') }}</textarea>
                        </div>

                        <!-- Foto Profil / Image Upload with Instant Live Preview -->
                        <div class="md:col-span-2 flex flex-col md:flex-row items-center gap-6 p-6 bg-surface-container-lowest rounded-2xl border border-outline-variant mt-2">
                            <div class="w-24 h-24 rounded-lg overflow-hidden border border-outline-variant bg-surface-container-low flex-shrink-0 relative">
                                <img id="image-preview" 
                                     src="{{ asset('assets/img/kaders/placeholder.svg') }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow text-center md:text-left">
                                <h4 class="text-label-md font-bold text-on-surface mb-1">Foto Profil Kader</h4>
                                <p class="text-label-sm text-outline mb-4">Gunakan foto wajah yang jelas dengan format JPG/PNG (Maks. 2MB)</p>
                                <input type="file" name="image" id="image-upload" class="hidden" accept="image/*" 
                                       onchange="const file = this.files[0]; if(file){ const reader = new FileReader(); reader.onload = e => document.getElementById('image-preview').src = e.target.result; reader.readAsDataURL(file); }">
                                <x-button type="button" variant="outline" size="sm" onclick="document.getElementById('image-upload').click()">
                                    Pilih Foto Kader
                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Separator -->
                <div class="md:col-span-2 py-2">
                    <div class="h-px bg-outline-variant/30 w-full"></div>
                </div>

                <!-- Password -->
                <x-forms.form-group label="Password" for="password" required>
                    <x-forms.text-input type="password" name="password" placeholder="Minimal 8 karakter" required />
                </x-forms.form-group>

                <!-- Password Confirmation -->
                <x-forms.form-group label="Konfirmasi Password" for="password_confirmation" required>
                    <x-forms.text-input type="password" name="password_confirmation" placeholder="Ulangi password" required />
                </x-forms.form-group>

                <!-- Active Status -->
                <div class="md:col-span-2 flex items-center justify-between p-6 bg-surface-container-low rounded-2xl border border-outline-variant mt-2">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-surface-container-lowest rounded-lg border border-outline-variant flex items-center justify-center text-primary shadow-sm">
                            <span class="material-symbols-outlined text-[24px]">verified_user</span>
                        </div>
                        <div>
                            <h4 class="text-label-md font-bold text-on-surface">Status Akun</h4>
                            <p class="text-label-sm text-outline mt-0.5">Aktifkan untuk memberikan akses masuk ke sistem.</p>
                        </div>
                    </div>
                    <x-forms.switch name="is_active" checked />
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <x-button href="{{ route('admin.users.index') }}" variant="ghost" size="lg">Batalkan</x-button>
            <x-button type="submit" variant="primary" size="lg" icon="check">
                SIMPAN PENGGUNA
            </x-button>
        </div>
    </form>
</div>
@endsection