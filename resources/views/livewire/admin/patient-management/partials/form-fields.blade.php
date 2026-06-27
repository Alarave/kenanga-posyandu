{{-- Shared Form Fields for Patient Management (Create & Edit) --}}
@php
    $isEdit = isset($patient);
@endphp
{{-- Main Form Columns --}}
<div class="flex-1 space-y-8">

    {{-- 1. Identitas Pribadi --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <div class="flex items-center gap-4 mb-10">
            <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-slate-700 to-slate-900 text-white flex items-center justify-center shadow-lg shadow-slate-200">
                <span class="material-symbols-outlined text-[24px]">id_card</span>
            </div>
            <div>
                <h3 class="text-sm font-black text-on-surface uppercase tracking-[0.2em]">Identitas Pribadi</h3>
                <p class="text-xs font-bold text-outline-variant mt-0.5">Informasi utama sesuai kartu identitas</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            {{-- Foto Profil --}}
            <div class="lg:col-span-3 flex flex-col items-center">
                <div class="relative group">
                    <div class="rounded-[3rem] border-2 border-dashed border-outline-variant bg-surface-container-low/50 flex items-center justify-center overflow-hidden transition-all duration-500 group-hover:border-primary group-hover:bg-primary-container/5 shadow-inner" style="width: 192px; height: 192px; shrink-0;">
                        @if($isEdit && $patient->profile_photo)
                            <img id="photo-preview" src="{{ asset('storage/' . $patient->profile_photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div id="photo-placeholder" class="hidden text-center">
                                <span class="material-symbols-outlined text-slate-300 text-[64px]" style="font-variation-settings: 'wght' 200;">account_circle</span>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mt-2">Belum Ada Foto</p>
                            </div>
                        @else
                            <img id="photo-preview" src="" style="width: 100%; height: 100%; object-fit: cover;" class="hidden">
                            <div id="photo-placeholder" class="text-center">
                                <span class="material-symbols-outlined text-slate-300 text-[64px]" style="font-variation-settings: 'wght' 200;">account_circle</span>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mt-2">Belum Ada Foto</p>
                            </div>
                        @endif
                    </div>
                    <label for="profile_photo" class="absolute -bottom-3 -right-3 w-14 h-14 bg-white border border-slate-100 text-on-surface-variant rounded-2xl flex items-center justify-center cursor-pointer shadow-xl hover:text-primary hover:scale-110 transition-all active:scale-95 group/btn">
                        <span class="material-symbols-outlined text-[24px]">add_a_photo</span>
                        <div class="absolute inset-0 rounded-2xl bg-primary/10 scale-0 group-hover/btn:scale-100 transition-transform duration-300"></div>
                    </label>
                    <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                </div>
                <div class="mt-8 text-center">
                    <p class="text-[10px] font-black text-outline-variant uppercase tracking-[0.2em]">{{ $isEdit ? 'Ubah Foto Profil' : 'Format Gambar' }}</p>
                    <p class="text-[10px] font-bold text-slate-300 mt-1">JPG, PNG atau WEBP<br>Maksimal 2.0 MB</p>
                </div>
            </div>

            {{-- Input Fields --}}
            <div class="lg:col-span-9 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest">NIK / No. Identitas <span class="text-teal-500">*</span></label>
                        <span class="text-[10px] font-bold text-slate-300 px-3 py-1 bg-surface-container-low rounded-lg border border-slate-100" :class="nikCount == 16 ? 'text-primary bg-primary-container border-teal-100' : ''" x-text="nikCount + ' / 16 digit'"></span>
                    </div>
                    <input type="text" name="id_number" value="{{ old('id_number', $patient->id_number ?? '') }}" maxlength="16" required
                           x-on:input="nikCount = $el.value.length"
                           placeholder="Contoh: 327501..."
                           class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
                </div>

                <div class="space-y-3">
                    <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Nama Lengkap <span class="text-teal-500">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name', $patient->full_name ?? '') }}" required
                           :placeholder="['ibu_hamil', 'lansia'].includes(category) ? 'Nama sesuai KTP...' : 'Nama sesuai KTP/KIA...'"
                           class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
                </div>

                <!-- Nama Suami (Hanya untuk Ibu Hamil) -->
                <div class="space-y-3" x-show="category === 'ibu_hamil'">
                    <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Nama Suami <span class="text-teal-500">*</span></label>
                    <input type="text" name="husband_name" value="{{ old('husband_name', $patient->husband_name ?? '') }}" x-bind:required="category === 'ibu_hamil'"
                           placeholder="Nama suami..."
                           class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
                </div>

                <div class="space-y-3">
                    <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Tempat Lahir</label>
                    <input type="text" name="place_of_birth" value="{{ old('place_of_birth', $patient->place_of_birth ?? '') }}"
                           placeholder="Contoh: Bekasi..."
                           class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
                </div>

                <div class="space-y-3">
                    <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Tanggal Lahir <span class="text-teal-500">*</span></label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $isEdit && $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '') }}" required
                           onchange="typeof autoDetectCategory === 'function' && autoDetectCategory(this.value)"
                           class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
                </div>

                <div class="space-y-3">
                    <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Jenis Kelamin <span class="text-teal-500">*</span></label>
                    
                    <!-- Tampilan statis jika Ibu Hamil -->
                    <div x-show="category === 'ibu_hamil'">
                        <div class="w-full h-16 px-6 bg-surface-container border border-outline-variant rounded-2xl flex items-center text-sm font-bold text-outline">
                            Perempuan
                        </div>
                        <input type="hidden" name="gender" value="F" x-bind:disabled="category !== 'ibu_hamil'">
                    </div>
                    
                    <!-- Dropdown pilihan jenis kelamin untuk kategori lain -->
                    <div x-show="category !== 'ibu_hamil'" class="relative">
                        <select name="gender" x-model="gender" x-bind:disabled="category === 'ibu_hamil'" required
                                class="appearance-none w-full h-16 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="M" {{ old('gender', $patient->gender ?? '') == 'M' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="F" {{ old('gender', $patient->gender ?? '') == 'F' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <span class="absolute right-6 top-5 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Informasi Spesifik (Berdasarkan Kategori) --}}
    
    {{-- Balita/Anak --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] transition-all duration-500"
         x-show="['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 transform translate-y-8"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        
        <div class="flex items-center gap-4 mb-10">
            <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-teal-500 to-emerald-600 text-white flex items-center justify-center shadow-lg shadow-teal-200">
                <span class="material-symbols-outlined text-[24px]">family_restroom</span>
            </div>
            <div>
                <h3 class="text-sm font-black text-on-surface uppercase tracking-[0.2em]">Informasi Keluarga & Lahir</h3>
                <p class="text-xs font-bold text-outline-variant mt-0.5">Data pendukung untuk rekam medis otomatis</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Nama Ayah</label>
                <input type="text" name="father_name" value="{{ old('father_name', $patient->father_name ?? '') }}" placeholder="Nama ayah..."
                       class="w-full h-14 px-5 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30"
                       x-bind:disabled="!['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)">
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Nama Ibu</label>
                <input type="text" name="mother_name" value="{{ old('mother_name', $patient->mother_name ?? '') }}" placeholder="Nama ibu..."
                       class="w-full h-14 px-5 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30"
                       x-bind:disabled="!['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)">
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">BB Lahir (kg)</label>
                <div class="relative">
                    <input type="number" step="0.01" name="weight_at_birth" value="{{ old('weight_at_birth', $patient->weight_at_birth ?? '') }}" placeholder="0.00"
                           class="w-full h-14 pl-5 pr-10 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30"
                           x-bind:disabled="!['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)">
                    <span class="absolute right-4 top-4 text-[10px] font-black text-slate-300">KG</span>
                </div>
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">PB Lahir (cm)</label>
                <div class="relative">
                    <input type="number" step="0.1" name="height_at_birth" value="{{ old('height_at_birth', $patient->height_at_birth ?? '') }}" placeholder="0.0"
                           class="w-full h-14 pl-5 pr-10 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30"
                           x-bind:disabled="!['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)">
                    <span class="absolute right-4 top-4 text-[10px] font-black text-slate-300">CM</span>
                </div>
            </div>

            <div class="md:col-span-2 space-y-3 pt-4">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">NIK Ibu</label>
                <input type="text" name="mother_nik" value="{{ old('mother_nik', $patient->mother_nik ?? '') }}" maxlength="16" placeholder="16 digit NIK ibu..."
                       class="w-full h-14 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30"
                       x-bind:disabled="!['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)">
            </div>

            <div class="md:col-span-2 space-y-3 pt-4">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Kepemilikan Buku KIA</label>
                <div class="relative">
                    <select name="kia_book_ownership" x-bind:disabled="!['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)"
                            class="appearance-none w-full h-14 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                        <option value="0" {{ old('kia_book_ownership', $isEdit ? ($patient->kia_book_ownership ? '1' : '0') : '0') == '0' ? 'selected' : '' }}>Tidak Memiliki</option>
                        <option value="1" {{ old('kia_book_ownership', $isEdit ? ($patient->kia_book_ownership ? '1' : '0') : '0') == '1' ? 'selected' : '' }}>Ya, Memiliki</option>
                    </select>
                    <span class="absolute right-5 top-4 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Dewasa/Umum --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] transition-all duration-500"
         x-show="['remaja', 'umum', 'ibu_hamil', 'lansia'].includes(category)"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 transform translate-y-8"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        <div class="flex items-center gap-4 mb-10">
            <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-pink-500 to-pink-700 text-white flex items-center justify-center shadow-lg shadow-pink-200">
                <span class="material-symbols-outlined text-[24px]">person_celebrate</span>
            </div>
            <div>
                <h3 class="text-sm font-black text-on-surface uppercase tracking-[0.2em]">Informasi Tambahan</h3>
                <p class="text-xs font-bold text-outline-variant mt-0.5">Status pekerjaan dan pendidikan</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Pendidikan --}}
            <div class="md:col-span-3 space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Pendidikan Terakhir</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
                    @foreach(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3', 'Tidak Sekolah'] as $edu)
                        <label class="cursor-pointer">
                            <input type="radio" name="education" value="{{ $edu }}" 
                                   {{ old('education', $patient->education ?? '') == $edu ? 'checked' : '' }} 
                                   class="hidden peer"
                                   x-bind:disabled="['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)">
                            <div class="py-3 px-2 text-center border border-outline-variant rounded-2xl peer-checked:border-teal-600 peer-checked:bg-primary-container/50 peer-checked:text-primary font-bold text-xs hover:border-outline-variant hover:bg-surface-container-low transition-all">
                                {{ $edu }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Pekerjaan --}}
            <div class="space-y-3" x-data="{ currentJob: '{{ old('job', $patient->job ?? '') }}' }">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Pekerjaan</label>
                <input type="text" name="job" x-model="currentJob" placeholder="Contoh: PNS, IRT..."
                       class="w-full h-14 px-5 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30"
                       x-bind:disabled="['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)">
                <div class="flex flex-wrap gap-1.5 mt-2">
                    @foreach(['IRT', 'PNS', 'Karyawan', 'Wiraswasta', 'Buruh', 'Tidak Bekerja'] as $jobChip)
                        <button type="button" @click="currentJob = '{{ $jobChip }}'" 
                                class="px-2.5 py-1 rounded-lg border border-outline-variant hover:border-primary hover:bg-primary-container/50 text-[10px] font-bold text-outline hover:text-primary transition-all">
                            {{ $jobChip }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Jumlah Anak --}}
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Jumlah Anak</label>
                <input type="number" name="number_of_children" value="{{ old('number_of_children', $patient->number_of_children ?? 0) }}"
                       class="w-full h-14 px-5 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30"
                       x-bind:disabled="['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)">
            </div>

            {{-- Status Kehamilan --}}
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Status Kehamilan</label>
                
                <!-- Tampilan statis jika Ibu Hamil -->
                <div x-show="category === 'ibu_hamil'">
                    <div class="w-full h-14 px-6 bg-surface-container border border-outline-variant rounded-2xl flex items-center text-sm font-bold text-outline">
                        Sedang Hamil
                    </div>
                </div>
                
                <div x-show="category !== 'ibu_hamil'" class="relative">
                    <select name="is_pregnant" x-bind:disabled="category === 'ibu_hamil' || category === 'lansia' || ['bayi', 'baduta', 'balita', 'anak_sekolah'].includes(category)"
                            class="appearance-none w-full h-14 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                        <option value="0" {{ old('is_pregnant', $patient->is_pregnant ?? '0') == '0' ? 'selected' : '' }}>Tidak Hamil</option>
                        <option value="1" {{ old('is_pregnant', $patient->is_pregnant ?? '0') == '1' ? 'selected' : '' }}>Sedang Hamil</option>
                    </select>
                    <span class="absolute right-5 top-4 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Lansia Specific --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] transition-all duration-500"
         x-show="category === 'lansia'"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 transform translate-y-8"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        <div class="flex items-center gap-4 mb-10">
            <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-amber-500 to-amber-700 text-white flex items-center justify-center shadow-lg shadow-amber-200">
                <span class="material-symbols-outlined text-[24px]">elderly</span>
            </div>
            <div>
                <h3 class="text-sm font-black text-on-surface uppercase tracking-[0.2em]">Informasi Lansia</h3>
                <p class="text-xs font-bold text-outline-variant mt-0.5">Status kemandirian dan riwayat penyakit lansia</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Status Kemandirian</label>
                <div class="relative">
                    <select name="independence_status" x-bind:disabled="category !== 'lansia'"
                            class="appearance-none w-full h-16 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                        <option value="" disabled selected>Pilih Status Kemandirian</option>
                        <option value="Mandiri" {{ old('independence_status', $patient->independence_status ?? '') == 'Mandiri' ? 'selected' : '' }}>Mandiri (Tanpa Bantuan)</option>
                        <option value="Butuh Bantuan" {{ old('independence_status', $patient->independence_status ?? '') == 'Butuh Bantuan' ? 'selected' : '' }}>Butuh Bantuan</option>
                    </select>
                    <span class="absolute right-6 top-5 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                </div>
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Status Tinggal</label>
                <div class="relative">
                    <select name="living_status" x-bind:disabled="category !== 'lansia'"
                            class="appearance-none w-full h-16 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                        <option value="" disabled selected>Pilih Status Tinggal</option>
                        <option value="Sendiri" {{ old('living_status', $patient->living_status ?? '') == 'Sendiri' ? 'selected' : '' }}>Tinggal Sendiri</option>
                        <option value="Dengan Keluarga" {{ old('living_status', $patient->living_status ?? '') == 'Dengan Keluarga' ? 'selected' : '' }}>Tinggal Bersama Keluarga</option>
                    </select>
                    <span class="absolute right-6 top-5 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                </div>
            </div>
            <div class="md:col-span-2 space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Riwayat Penyakit Dahulu</label>
                <textarea name="historical_diseases" rows="3" placeholder="Tuliskan riwayat penyakit seperti Hipertensi, Diabetes, Asam Urat..."
                          class="w-full p-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 resize-none"
                          x-bind:disabled="category !== 'lansia'">{{ old('historical_diseases', $patient->historical_diseases ?? '') }}</textarea>
            </div>
        </div>
    </div>


    {{-- 3. Kontak & Alamat --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <div class="flex items-center gap-4 mb-10">
            <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center shadow-lg shadow-blue-200">
                <span class="material-symbols-outlined text-[24px]">location_on</span>
            </div>
            <div>
                <h3 class="text-sm font-black text-on-surface uppercase tracking-[0.2em]">Domisili & Kontak</h3>
                <p class="text-xs font-bold text-outline-variant mt-0.5">Informasi lokasi dan nomor telepon aktif</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">No. HP / WhatsApp <span class="text-teal-500">*</span></label>
                <div class="relative">
                    <input type="tel" name="phone_number" value="{{ old('phone_number', $patient->phone_number ?? '') }}" required
                           placeholder="Contoh: 0812..."
                           class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
                    <span class="absolute right-6 top-5 text-slate-300 material-symbols-outlined pointer-events-none">call</span>
                </div>
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Unit Posyandu <span class="text-teal-500">*</span></label>
                <div class="relative">
                    @if(auth()->user()->isKader())
                        <div class="w-full h-16 px-6 bg-surface-container border border-outline-variant rounded-2xl flex items-center text-sm font-bold text-outline">
                            {{ auth()->user()->posyandu->name }}
                        </div>
                        <input type="hidden" name="posyandu_id" value="{{ auth()->user()->posyandu_id }}">
                    @else
                        <div class="relative">
                            <select name="posyandu_id" required
                                    class="appearance-none w-full h-16 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                                <option value="" disabled selected>Pilih Unit Posyandu</option>
                                @foreach($posyandus as $p)
                                    <option value="{{ $p->id }}" {{ old('posyandu_id', $patient->posyandu_id ?? request('posyandu_id')) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-6 top-5 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">RT Domisili</label>
                <input type="text" name="rt_domisili" value="{{ old('rt_domisili', $patient->rt_domisili ?? '') }}"
                       placeholder="Contoh: 004 atau 011..."
                       class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
            </div>
            <div class="space-y-3" x-show="['ibu_hamil', 'lansia'].includes(category)">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">RW Domisili <span class="text-teal-500">*</span></label>
                <input type="text" name="dusun_rt_rw" value="{{ old('dusun_rt_rw', $patient->dusun_rt_rw ?? '') }}" x-bind:required="['ibu_hamil', 'lansia'].includes(category)"
                       placeholder="Contoh: 011..."
                       class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30"
                       x-bind:disabled="!['ibu_hamil', 'lansia'].includes(category)">
            </div>
            <div class="space-y-3" x-show="category === 'ibu_hamil'">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Kelurahan / Desa <span class="text-teal-500">*</span></label>
                <input type="text" name="desa_kelurahan" value="{{ old('desa_kelurahan', $patient->desa_kelurahan ?? '') }}" x-bind:required="category === 'ibu_hamil'"
                       placeholder="Nama kelurahan/desa..."
                       class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
            </div>
            <div class="space-y-3" x-show="category === 'ibu_hamil'">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Kecamatan <span class="text-teal-500">*</span></label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan', $patient->kecamatan ?? '') }}" x-bind:required="category === 'ibu_hamil'"
                       placeholder="Nama kecamatan..."
                       class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
            </div>
            <div class="space-y-3" x-show="!['ibu_hamil', 'lansia'].includes(category)">
                {{-- Empty element to balance the grid --}}
            </div>
            <div class="md:col-span-2 space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Alamat Lengkap <span class="text-teal-500">*</span></label>
                <textarea name="address" rows="3" required
                          placeholder="Nama jalan, nomor rumah, RT/RW..."
                          class="w-full p-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 resize-none">{{ old('address', $patient->address ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- 4. Sosial Ekonomi & Lingkungan (Untuk Kategori Non-Anak: Remaja, Ibu Hamil, Lansia, Umum) --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] transition-all duration-500"
         x-show="['remaja', 'ibu_hamil', 'lansia', 'umum'].includes(category)"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 transform translate-y-8"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        <div class="flex items-center gap-4 mb-10">
            <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-emerald-500 to-emerald-700 text-white flex items-center justify-center shadow-lg shadow-emerald-200">
                <span class="material-symbols-outlined text-[24px]">real_estate_agent</span>
            </div>
            <div>
                <h3 class="text-sm font-black text-on-surface uppercase tracking-[0.2em]">Sosial Ekonomi & Lingkungan</h3>
                <p class="text-xs font-bold text-outline-variant mt-0.5">Kondisi tempat tinggal dan status sosial keluarga</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Nama Kepala Keluarga</label>
                <input type="text" name="head_of_family_name" value="{{ old('head_of_family_name', $patient->head_of_family_name ?? '') }}" placeholder="Nama kepala keluarga..."
                       class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Jumlah Anggota Keluarga</label>
                <input type="number" name="family_member_count" value="{{ old('family_member_count', $patient->family_member_count ?? '') }}" placeholder="Contoh: 4..." min="0"
                       class="w-full h-16 px-6 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30">
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Status Ekonomi</label>
                <div class="relative">
                    <select name="economic_status"
                            class="appearance-none w-full h-16 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                        <option value="" disabled selected>Pilih Status Ekonomi</option>
                        <option value="Mampu" {{ old('economic_status', $patient->economic_status ?? '') == 'Mampu' ? 'selected' : '' }}>Mampu</option>
                        <option value="Cukup Mampu" {{ old('economic_status', $patient->economic_status ?? '') == 'Cukup Mampu' ? 'selected' : '' }}>Cukup Mampu</option>
                        <option value="Kurang Mampu" {{ old('economic_status', $patient->economic_status ?? '') == 'Kurang Mampu' ? 'selected' : '' }}>Kurang Mampu</option>
                    </select>
                    <span class="absolute right-6 top-5 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                </div>
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Kondisi Rumah</label>
                <div class="relative">
                    <select name="house_condition"
                            class="appearance-none w-full h-16 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                        <option value="" disabled selected>Pilih Kondisi Rumah</option>
                        <option value="Permanen" {{ old('house_condition', $patient->house_condition ?? '') == 'Permanen' ? 'selected' : '' }}>Permanen (Tembok/Semen)</option>
                        <option value="Semi Permanen" {{ old('house_condition', $patient->house_condition ?? '') == 'Semi Permanen' ? 'selected' : '' }}>Semi Permanen</option>
                        <option value="Non Permanen" {{ old('house_condition', $patient->house_condition ?? '') == 'Non Permanen' ? 'selected' : '' }}>Non Permanen / Panggung</option>
                    </select>
                    <span class="absolute right-6 top-5 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                </div>
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Akses Air Bersih</label>
                <div class="relative">
                    <select name="water_access"
                            class="appearance-none w-full h-16 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                        <option value="" disabled selected>Pilih Akses Air</option>
                        <option value="PDAM" {{ old('water_access', $patient->water_access ?? '') == 'PDAM' ? 'selected' : '' }}>PDAM / Air Perpipaan</option>
                        <option value="Sumur Terlindungi" {{ old('water_access', $patient->water_access ?? '') == 'Sumur Terlindungi' ? 'selected' : '' }}>Sumur Terlindungi / Air Tanah</option>
                        <option value="Air Hujan" {{ old('water_access', $patient->water_access ?? '') == 'Air Hujan' ? 'selected' : '' }}>Penampungan Air Hujan</option>
                        <option value="Lainnya" {{ old('water_access', $patient->water_access ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <span class="absolute right-6 top-5 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                </div>
            </div>
            <div class="space-y-3">
                <label class="text-[11px] font-black text-outline-variant uppercase tracking-widest ml-1">Kepemilikan Jamban Sehat</label>
                <div class="relative">
                    <select name="has_latrine"
                            class="appearance-none w-full h-16 px-6 pr-12 border border-outline-variant rounded-2xl text-sm font-bold text-on-surface-variant focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all bg-surface-container-low/30 cursor-pointer">
                        <option value="1" {{ old('has_latrine', $isEdit ? ($patient->has_latrine ? '1' : '0') : '1') == '1' ? 'selected' : '' }}>Ya, Memiliki Jamban Sehat</option>
                        <option value="0" {{ old('has_latrine', $isEdit ? ($patient->has_latrine ? '1' : '0') : '1') == '0' ? 'selected' : '' }}>Tidak Memiliki</option>
                    </select>
                    <span class="absolute right-6 top-5 text-slate-300 material-symbols-outlined pointer-events-none">expand_more</span>
                </div>
            </div>
        </div>
    </div>

</div>
