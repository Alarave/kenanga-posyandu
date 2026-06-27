@extends('layouts.admin-layout')

@section('admin-title', 'Perbarui Pengguna')

@section('admin-content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h2 class="text-display-sm text-on-surface tracking-tight mb-2">Perbarui Pengguna</h2>
            <p class="text-outline font-medium">Ubah informasi akun untuk <span class="text-secondary font-bold">{{ $user->name }}</span>.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="w-12 h-12 rounded-2xl bg-surface-container-lowest border border-outline-variant flex items-center justify-center text-outline-variant hover:text-secondary hover:border-blue-100 hover:bg-blue-50 transition-all shadow-sm">
            <i class="fas fa-times text-body-lg"></i>
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-6 bg-error-container border border-error rounded-[2rem] flex items-start space-x-4">
            <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center text-white flex-shrink-0">
                <i class="fas fa-exclamation-circle text-body-lg"></i>
            </div>
            <div>
                <h4 class="text-red-800 font-black text-sm uppercase tracking-widest mb-2">Terjadi Kesalahan</h4>
                <ul class="list-disc list-inside text-error text-sm font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ role: '{{ old('role', $user->display_role_name) }}' }">
        @csrf
        @method('PUT')
        
        <!-- Main Form Card -->
        <div class="bg-surface-container-lowest rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-slate-200/60 border border-slate-50 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-secondary-container/50 rounded-lg blur-3xl -mr-32 -mt-32"></div>
            
            <div class="relative grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                <!-- Name -->
                <x-forms.form-group label="Nama Lengkap" for="name" required>
                    <x-forms.text-input name="name" placeholder="Masukkan nama lengkap" value="{{ old('name', $user->name) }}" required />
                </x-forms.form-group>

                <!-- Username -->
                <x-forms.form-group label="Username" for="username" required>
                    <x-forms.text-input name="username" placeholder="Contoh: bidansari" value="{{ old('username', $user->username) }}" required />
                </x-forms.form-group>

                <!-- Email -->
                <x-forms.form-group label="Alamat Email" for="email" required>
                    <x-forms.text-input type="email" name="email" placeholder="email@posyandu.com" value="{{ old('email', $user->email) }}" required />
                </x-forms.form-group>

                <!-- Role -->
                <x-forms.form-group label="Peran / Role" for="role" required>
                    <x-forms.select-input name="role" placeholder="Pilih Peran" required @change="role = $event.target.value">
                        @php
                            $currentDisplayRole = $user->display_role_name;
                            $availableRoles = [
                                'admin1' => 'Admin 1 (Kenanga 1)',
                                'admin2' => 'Admin 2 (Kenanga 2)',
                                'kader1' => 'Kader 1 (Kenanga 1)',
                                'kader2' => 'Kader 2 (Kenanga 2)',
                                'superadmin' => 'Admin RW',
                            ];
                        @endphp
                        @foreach($availableRoles as $val => $label)
                            <option value="{{ $val }}" {{ old('role', $currentDisplayRole) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </x-forms.select-input>
                </x-forms.form-group>

                <!-- Cadre Profile Section (Conditionally Visible) -->
                <div x-show="role.includes('admin') || role.includes('kader')" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="md:col-span-2 mt-2 p-8 bg-gradient-to-br from-indigo-50/40 to-slate-50/20 dark:from-slate-800/40 dark:to-slate-900/30 rounded-[2rem] border border-indigo-100/50 dark:border-slate-800 space-y-6">
                    
                    <h3 class="text-body-lg font-black text-indigo-800 dark:text-indigo-400 flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined">badge</span>
                        Informasi Profil Kader
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NIK -->
                        <x-forms.form-group label="NIK (Nomor Induk Kependudukan)" for="nik">
                            <x-forms.text-input name="nik" placeholder="Masukkan 16 digit NIK" value="{{ old('nik', $user->nik) }}" maxlength="16" />
                        </x-forms.form-group>

                        <!-- TTL -->
                        <x-forms.form-group label="Tempat, Tanggal Lahir" for="ttl">
                            <x-forms.text-input name="ttl" placeholder="Contoh: Bekasi, 12 April 1990" value="{{ old('ttl', $user->ttl) }}" />
                        </x-forms.form-group>

                        <!-- Jabatan / Peran Spesifik Kader -->
                        <x-forms.form-group label="Jabatan di Posyandu" for="cadre_role">
                            <x-forms.text-input name="cadre_role" placeholder="Contoh: Ketua Kader, Bendahara, Anggota" value="{{ old('cadre_role', $user->cadre_role) }}" />
                        </x-forms.form-group>

                        <!-- Pendidikan (Selectable Cards) -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-outline-variant dark:text-gray-300 uppercase tracking-widest mb-3">Pendidikan Terakhir</label>
                            <input type="hidden" name="pendidikan" id="pendidikan" value="{{ old('pendidikan', $user->pendidikan) }}">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" x-data="{ selected: '{{ old('pendidikan', $user->pendidikan) }}' }">
                                @foreach(['SD', 'SMP', 'SLTA', 'Diploma', 'Sarjana', 'Magister', 'Doktor'] as $edu)
                                    <button type="button" 
                                            @click="selected = '{{ $edu }}'; document.getElementById('pendidikan').value = '{{ $edu }}'"
                                            :class="selected === '{{ $edu }}' ? 'bg-secondary text-white border-indigo-600 shadow-lg shadow-indigo-600/20' : 'bg-surface-container-lowest dark:bg-inverse-surface text-on-surface-variant dark:text-slate-350 border-outline-variant dark:border-outline hover:border-outline-variant'"
                                            class="px-4 py-3 rounded-2xl border text-center font-bold text-sm transition-all focus:outline-none">
                                        {{ $edu }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-outline-variant dark:text-gray-300 uppercase tracking-widest mb-3">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap..." class="w-full px-5 py-4 bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-2xl text-on-surface dark:text-slate-100 font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        <!-- Foto Profil / Image Upload with Instant Live Preview -->
                        <div class="md:col-span-2 flex flex-col md:flex-row items-center gap-6 p-6 bg-surface-container-lowest dark:bg-inverse-surface rounded-2xl border border-outline-variant dark:border-outline mt-4">
                            <div class="w-24 h-24 rounded-lg overflow-hidden border-2 border-outline-variant dark:border-slate-600 bg-surface-container-low flex-shrink-0 relative">
                                <img id="image-preview" 
                                     src="{{ $user->image ? (str_starts_with($user->image, 'assets/') ? asset($user->image) : \Illuminate\Support\Facades\Storage::url('kaders/' . $user->image)) : asset('assets/img/kaders/placeholder.svg') }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow text-center md:text-left">
                                <h4 class="text-sm font-bold text-slate-850 dark:text-gray-200">Foto Profil Kader</h4>
                                <p class="text-xs text-outline dark:text-gray-400 mb-3">Gunakan foto wajah yang jelas dengan format JPG/PNG (Maks. 2MB)</p>
                                <input type="file" name="image" id="image-upload" class="hidden" accept="image/*" 
                                       onchange="const file = this.files[0]; if(file){ const reader = new FileReader(); reader.onload = e => document.getElementById('image-preview').src = e.target.result; reader.readAsDataURL(file); }">
                                <button type="button" onclick="document.getElementById('image-upload').click()" class="px-5 py-2.5 bg-surface-container hover:bg-surface-container-high dark:bg-slate-700 dark:hover:bg-slate-600 text-on-surface-variant dark:text-slate-200 font-bold text-xs rounded-xl transition-all uppercase tracking-wider">
                                    Pilih Foto Kader
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Separator -->
                <div class="md:col-span-2 py-4">
                    <div class="h-px bg-surface-container w-full"></div>
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mt-4 text-center">Biarkan password kosong jika tidak ingin diubah</p>
                </div>

                <!-- Password -->
                <x-forms.form-group label="Password Baru" for="password">
                    <x-forms.text-input type="password" name="password" placeholder="Minimal 8 karakter" />
                </x-forms.form-group>

                <!-- Password Confirmation -->
                <x-forms.form-group label="Konfirmasi Password Baru" for="password_confirmation">
                    <x-forms.text-input type="password" name="password_confirmation" placeholder="Ulangi password" />
                </x-forms.form-group>

                <!-- Active Status -->
                <div class="md:col-span-2 flex items-center justify-between p-6 bg-surface-container-low dark:bg-inverse-surface rounded-2xl mt-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-surface-container-lowest dark:bg-gray-800 rounded-2xl flex items-center justify-center text-secondary shadow-sm">
                            <i class="fas fa-user-shield text-body-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-on-surface dark:text-gray-200">Status Akun</h4>
                            <p class="text-xs text-outline dark:text-gray-400">Ubah status akses pengguna ke sistem.</p>
                        </div>
                    </div>
                    <x-forms.switch name="is_active" :checked="$user->is_active" />
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4 pt-4">
            <a href="{{ route('admin.users.index') }}" class="px-10 py-4 bg-surface-container-lowest border border-outline-variant text-outline text-xs font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-surface-container-low transition-all">Batalkan</a>
            <button type="submit" class="px-10 py-4 bg-secondary text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 active:scale-95 flex items-center">
                <i class="fas fa-save mr-3"></i> SIMPAN PERUBAHAN
            </button>
        </div>
    </form>
</div>
@endsection