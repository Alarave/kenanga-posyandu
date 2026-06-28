@extends('layouts.admin-layout')

@section('admin-title')
    Edit Folder Galeri
@endsection

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Edit Folder</h2>
        <p class="text-sm text-slate-400 font-medium mt-1">Ubah nama, deskripsi, atau sampul untuk folder kegiatan ini.</p>
    </div>
    <x-breadcrumb :items="[
        ['label' => 'Galeri', 'url' => route('admin.gallery.index')],
        ['label' => 'Edit Folder', 'active' => true]
    ]" />
</div>

<div class="bg-white rounded-[32px] border border-slate-100 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
    <form action="{{ route('admin.gallery.update', $folder->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-8">
            <!-- Cover Photo Upload (Optional) -->
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Foto Sampul Folder</label>
                <div class="flex flex-col items-center p-8 bg-slate-50 border-3 border-dashed border-slate-200 rounded-[2rem] hover:border-teal-500 hover:bg-slate-50/50 transition-all group relative cursor-pointer" style="min-height: 180px;">
                    
                    <div id="imagePreview" class="{{ $folder->cover_photo ? '' : 'hidden' }} mb-4 max-w-full">
                        <img src="{{ $folder->cover_photo ? asset('storage/' . $folder->cover_photo) : '' }}" alt="Preview" class="h-40 rounded-2xl shadow-md border-4 border-white object-cover mx-auto">
                    </div>

                    <div id="placeholder" class="{{ $folder->cover_photo ? 'hidden' : '' }} flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-teal-600 shadow-sm mb-3 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[32px]">folder_special</span>
                        </div>
                        <p class="text-sm font-black text-slate-700">Pilih Foto Sampul Baru</p>
                        <p class="text-xs text-slate-400 mt-1 font-bold uppercase tracking-wider">Format: JPG, PNG, WEBP (Maks. 10MB)</p>
                    </div>

                    <input type="file" name="cover_photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="coverUpload" accept="image/*" onchange="previewFile(event)">
                </div>
                @error('cover_photo') 
                    <p class="mt-3 text-xs text-red-500 font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        {{ $message }}
                    </p> 
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Nama Folder / Kegiatan</label>
                    <input type="text" name="name" value="{{ old('name', $folder->name) }}" placeholder="Contoh: Kegiatan Imunisasi Imela Balita 2026" class="w-full h-12 bg-slate-50 border-transparent rounded-2xl px-5 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-0 focus:border-teal-500 transition-all border-2 border-slate-100" required>
                    @error('name') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Deskripsi Singkat Folder</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan singkat mengenai kegiatan-kegiatan atau tujuan pendokumentasian di folder ini..." class="w-full bg-slate-50 border-transparent rounded-2xl px-5 py-4 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-0 focus:border-teal-500 transition-all border-2 border-slate-100">{{ old('description', $folder->description) }}</textarea>
                    @error('description') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                @if(auth()->user()->isSuperAdmin())
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Unit Posyandu</label>
                        <x-forms.select-input name="posyandu_id" placeholder="Pilih Posyandu (Opsional)" :placeholderDisabled="false" value="{{ old('posyandu_id', $folder->posyandu_id) }}" class="!bg-slate-50 !border-slate-100 !rounded-2xl !h-12 focus:!ring-0 focus:!border-teal-500 focus:!bg-white !shadow-none !border-2">
                            <option value="">Semua Posyandu (Global)</option>
                            @foreach($posyandus as $posyandu)
                                <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $folder->posyandu_id) == $posyandu->id ? 'selected' : '' }}>{{ $posyandu->name }}</option>
                            @endforeach
                        </x-forms.select-input>
                        @error('posyandu_id') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end mt-12 gap-4">
            <a href="{{ route('admin.gallery.index') }}" class="px-8 py-3.5 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all text-xs uppercase tracking-widest">Batal</a>
            <button type="submit" class="px-8 py-3.5 bg-slate-900 text-white font-black rounded-2xl hover:bg-teal-600 transition-all shadow-lg shadow-slate-900/10 text-xs uppercase tracking-widest flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function previewFile(event) {
        const input = event.target;
        const reader = new FileReader();
        const imagePreview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('placeholder');

        if(input.files[0]) {
            reader.onload = function(){
                const img = imagePreview.querySelector('img');
                img.src = reader.result;
                imagePreview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
