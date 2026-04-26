@extends('layouts.admin-layout')

@section('admin-title') Tambah Sasaran Warga Baru @endsection

@section('admin-content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- ── Form Card ── --}}
    <x-card>
        <form action="{{ route('admin.patients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- 1. Kategori Sasaran (Chip Selection Style) --}}
            <section>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">category</span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest">Kategori Sasaran <span class="text-red-500">*</span></h3>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach([
                        'balita'    => ['label'=>'Balita','desc'=>'0–5 bln','icon'=>'child_care','color'=>'blue'],
                        'ibu_hamil' => ['label'=>'Ibu Hamil','desc'=>'Kehamilan','icon'=>'pregnant_woman','color'=>'pink'],
                        'remaja'    => ['label'=>'Remaja','desc'=>'Pelajar','icon'=>'school','color'=>'indigo'],
                        'lansia'    => ['label'=>'Lansia','desc'=>'Lanjut Usia','icon'=>'elderly','color'=>'orange'],
                    ] as $val => $cat)
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="category" value="{{ $val }}" class="sr-only peer" {{ old('category') == $val || (!old('category') && $val == 'balita') ? 'checked' : '' }}>
                        <div class="p-4 rounded-2xl border-2 border-slate-100 bg-white hover:border-slate-200 transition-all peer-checked:border-teal-500 peer-checked:bg-teal-50/30 peer-checked:shadow-sm">
                            <span class="material-symbols-outlined group-hover:scale-110 transition-transform mb-2 block {{ 'text-'.$cat['color'].'-500' }}" style="font-size:32px;">{{ $cat['icon'] }}</span>
                            <div class="font-black text-slate-900 text-sm">{{ $cat['label'] }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $cat['desc'] }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('category') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
            </section>

            {{-- 2. Data Identitas --}}
            <section class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 pt-8 border-t border-slate-100">
                <div class="md:col-span-2 flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">id_card</span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest">Identitas Pribadi</h3>
                </div>

                {{-- NIK --}}
                <div class="space-y-1.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">NIK (16 Digit) <span class="text-red-500">*</span></label>
                    <input type="text" name="id_number" value="{{ old('id_number') }}" maxlength="16" required
                           class="w-full h-12 px-4 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all">
                    @error('id_number') <p class="text-[11px] text-red-500 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Nama Lengkap --}}
                <div class="space-y-1.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required
                           class="w-full h-12 px-4 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all">
                </div>

                {{-- Tanggal Lahir --}}
                <div class="space-y-1.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                           class="w-full h-12 px-4 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all">
                </div>

                {{-- Jenis Kelamin --}}
                <div class="space-y-1.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="gender" required
                            class="w-full h-12 px-4 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all appearance-none cursor-pointer bg-white">
                        <option value="">Pilih</option>
                        <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Nama Orang Tua (conditional) --}}
                <div id="parent-name-field" class="md:col-span-2 space-y-1.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Orang Tua / Wali</label>
                    <input type="text" name="parent_name" value="{{ old('parent_name') }}"
                           class="w-full h-12 px-4 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all">
                </div>
            </section>

            {{-- 3. Alamat & Kontak --}}
            <section class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 pt-8 border-t border-slate-100">
                <div class="md:col-span-2 flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">home</span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest">Alamat & Kontak</h3>
                </div>

                {{-- Telepon --}}
                <div class="space-y-1.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required
                           class="w-full h-12 px-4 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all">
                </div>

                {{-- Posyandu --}}
                <div class="space-y-1.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Posyandu <span class="text-red-500">*</span></label>
                    <select name="posyandu_id" required
                            class="w-full h-12 px-4 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all appearance-none cursor-pointer bg-white">
                        <option value="">Pilih Posyandu</option>
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ old('posyandu_id') == $posyandu->id ? 'selected' : '' }}>
                                {{ $posyandu->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Alamat Lengkap --}}
                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="3" required
                              class="w-full p-4 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/5 transition-all resize-none">{{ old('address') }}</textarea>
                </div>
            </section>

            {{-- 4. Submit Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <x-button href="{{ route('admin.patients.index') }}" variant="ghost">Batal</x-button>
                <x-button type="submit" variant="secondary" icon="save">Simpan Data Warga</x-button>
            </div>
        </form>
    </x-card>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="category"]');
        const parentField = document.getElementById('parent-name-field');

        function toggleParentField() {
            const selected = document.querySelector('input[name="category"]:checked');
            if (selected && selected.value === 'balita') {
                parentField.style.display = 'block';
            } else {
                parentField.style.display = 'none';
            }
        }

        radios.forEach(r => r.addEventListener('change', toggleParentField));
        toggleParentField(); // run on load
    });
</script>
@endpush
@endsection