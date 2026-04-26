@extends('layouts.admin-layout')

@section('admin-title')
    Edit Data Warga
@endsection

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Edit Data Warga</h2>
    <x-breadcrumb :items="[
        ['label' => 'Data Warga', 'url' => route('admin.patients.index')],
        ['label' => 'Edit', 'active' => true]
    ]" />
</div>

<x-card>
    <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- === KATEGORI SASARAN === --}}
        <div class="mb-8 p-4 rounded-xl bg-blue-50 border border-blue-200">
            <label class="block text-sm font-semibold text-blue-800 mb-3">
                <i class="fas fa-users mr-1"></i> Kategori Sasaran Posyandu <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach([
                    'balita'    => ['label'=>'Balita','desc'=>'0–59 bulan','icon'=>'baby','color'=>'blue'],
                    'ibu_hamil' => ['label'=>'Ibu Hamil','desc'=>'Masa kehamilan','icon'=>'heart','color'=>'pink'],
                    'remaja'    => ['label'=>'Remaja','desc'=>'10–24 tahun','icon'=>'user-graduate','color'=>'purple'],
                    'lansia'    => ['label'=>'Lansia','desc'=>'60+ tahun','icon'=>'user-clock','color'=>'orange'],
                ] as $val => $cat)
                <label class="cursor-pointer">
                    <input type="radio" name="category" value="{{ $val }}"
                        class="sr-only peer"
                        {{ old('category', $patient->category) == $val ? 'checked' : '' }}>
                    <div class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 
                        peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300 transition-all">
                        <i class="fas fa-{{ $cat['icon'] }} text-2xl text-{{ $cat['color'] }}-500 mb-2"></i>
                        <span class="font-semibold text-gray-800 text-sm">{{ $cat['label'] }}</span>
                        <span class="text-xs text-gray-400 text-center mt-0.5">{{ $cat['desc'] }}</span>
                    </div>
                </label>
                @endforeach
            </div>
            @error('category') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- === KOLOM 1: Data Pribadi === --}}
            <div class="space-y-5">
                <h3 class="text-base font-semibold text-gray-700 border-b pb-2">
                    <i class="fas fa-id-card mr-1 text-gray-500"></i> Data Pribadi
                </h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="id_number" value="{{ old('id_number', $patient->id_number) }}" maxlength="16"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none @error('id_number') border-red-500 @enderror"
                        placeholder="16 digit NIK" required>
                    @error('id_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name', $patient->full_name) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none @error('full_name') border-red-500 @enderror"
                        required>
                    @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div id="parent-name-field">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Orang Tua / Wali</label>
                    <input type="text" name="parent_name" value="{{ old('parent_name', $patient->parent_name) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Nama orang tua / wali">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $patient->birth_date?->format('Y-m-d')) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                        required>
                    @error('birth_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <option value="">-- Pilih --</option>
                        <option value="M" {{ old('gender', $patient->gender) == 'M' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="F" {{ old('gender', $patient->gender) == 'F' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            {{-- === KOLOM 2 === --}}
            <div class="space-y-5">
                <h3 class="text-base font-semibold text-gray-700 border-b pb-2">
                    <i class="fas fa-map-marker-alt mr-1 text-gray-500"></i> Kontak & Penempatan
                </h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone_number" value="{{ old('phone_number', $patient->phone_number) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                        required>{{ old('address', $patient->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Posyandu <span class="text-red-500">*</span></label>
                    <select name="posyandu_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <option value="">-- Pilih Posyandu --</option>
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $patient->posyandu_id) == $posyandu->id ? 'selected' : '' }}>
                                {{ $posyandu->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil (Opsional)</label>
                    @if($patient->profile_photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $patient->profile_photo) }}" class="h-16 w-16 rounded-full object-cover">
                        </div>
                    @endif
                    <input type="file" name="profile_photo" accept="image/*"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700">
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-8 space-x-3">
            <a href="{{ route('admin.patients.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                <i class="fas fa-save mr-2"></i>Update Data Warga
            </button>
        </div>
    </form>
</x-card>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="category"]');
        const parentField = document.getElementById('parent-name-field');
        function toggleParentField() {
            const selected = document.querySelector('input[name="category"]:checked');
            parentField.style.display = (selected && selected.value === 'balita') ? 'block' : 'none';
        }
        radios.forEach(r => r.addEventListener('change', toggleParentField));
        toggleParentField();
    });
</script>
@endsection