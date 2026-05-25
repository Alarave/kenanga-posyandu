@extends('layouts.admin-layout')

@section('admin-title')
    Tambah File ke Galeri
@endsection

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Unggah Media Baru</h2>
        <p class="text-sm text-slate-400 font-medium mt-1">Dokumentasikan momen berupa foto atau video ke galeri Posyandu.</p>
    </div>
    <x-breadcrumb :items="[
        ['label' => 'Galeri', 'url' => route('admin.gallery.index')],
        ['label' => 'Tambah', 'active' => true]
    ]" />
</div>

<div class="bg-white rounded-[32px] border border-slate-100 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-8">
            <!-- Upload Area -->
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Pilih File Media</label>
                <div class="flex flex-col items-center p-10 bg-slate-50 border-3 border-dashed border-slate-200 rounded-[2rem] hover:border-teal-500 hover:bg-slate-50/50 transition-all group relative cursor-pointer">
                    
                    {{-- Media Previews --}}
                    <div id="imagePreview" class="hidden mb-4 max-w-full">
                        <img src="" alt="Preview" class="h-64 rounded-2xl shadow-xl border-4 border-white object-cover mx-auto">
                    </div>
                    
                    <div id="videoPreview" class="hidden mb-4 w-full max-w-md">
                        <video src="" controls class="h-64 w-full rounded-2xl shadow-xl border-4 border-white object-contain mx-auto bg-slate-950"></video>
                    </div>

                    <div id="placeholder" class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center text-teal-600 shadow-md mb-4 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[36px]">photo_camera_back</span>
                        </div>
                        <p class="text-base font-black text-slate-700">Klik atau geser file gambar/video ke sini</p>
                        <p class="text-xs text-slate-400 mt-2 font-bold uppercase tracking-wider">Format: JPG, PNG, WEBP, MP4, MOV (Maks. 20MB)</p>
                    </div>

                    <input type="file" name="photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="imageUpload" accept="image/*,video/*" required onchange="previewFile(event)">
                </div>
                @error('photo') 
                    <p class="mt-3 text-xs text-red-500 font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        {{ $message }}
                    </p> 
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Judul Kegiatan</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Imunisasi Bayi & Balita Rutin" class="w-full h-12 bg-slate-50 border-transparent rounded-2xl px-5 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-0 focus:border-teal-500 transition-all border-2 border-slate-100" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan detail singkat mengenai dokumentasi kegiatan ini..." class="w-full bg-slate-50 border-transparent rounded-2xl px-5 py-4 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-0 focus:border-teal-500 transition-all border-2 border-slate-100">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Unit Posyandu</label>
                    <x-forms.select-input name="posyandu_id" placeholder="Pilih Posyandu (opsional)" :placeholderDisabled="false" value="{{ old('posyandu_id') }}" class="!bg-slate-50 !border-slate-100 !rounded-2xl !h-12 focus:!ring-0 focus:!border-teal-500 focus:!bg-white !shadow-none !border-2">
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ old('posyandu_id') == $posyandu->id ? 'selected' : '' }}>{{ $posyandu->name }}</option>
                        @endforeach
                    </x-forms.select-input>
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out bg-slate-200 rounded-full cursor-pointer focus-within:ring-2 focus-within:ring-teal-500">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured" class="absolute w-0 h-0 opacity-0 peer" {{ old('is_featured') ? 'checked' : '' }}>
                        <label for="is_featured" class="block h-6 overflow-hidden bg-slate-300 rounded-full cursor-pointer peer-checked:bg-teal-600 transition-colors"></label>
                        <span class="absolute block w-4 h-4 mt-1 ml-1 transition-transform duration-200 ease-in-out bg-white rounded-full peer-checked:translate-x-6"></span>
                    </div>
                    <label for="is_featured" class="text-sm font-black text-slate-700 cursor-pointer">Tampilkan sebagai Unggulan</label>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-12 gap-4">
            <a href="{{ route('admin.gallery.index') }}" class="px-8 py-3.5 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all text-xs uppercase tracking-widest">Batal</a>
            <button type="submit" class="px-8 py-3.5 bg-slate-900 text-white font-black rounded-2xl hover:bg-teal-600 transition-all shadow-lg shadow-slate-900/10 text-xs uppercase tracking-widest flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">publish</span>
                Simpan Media
            </button>
        </div>
    </form>
</div>

<script>
    function previewFile(event) {
        const input = event.target;
        const reader = new FileReader();
        const imagePreview = document.getElementById('imagePreview');
        const videoPreview = document.getElementById('videoPreview');
        const placeholder = document.getElementById('placeholder');

        if(input.files[0]) {
            const file = input.files[0];
            const isVideo = file.type.startsWith('video/');

            reader.onload = function(){
                if (isVideo) {
                    const video = videoPreview.querySelector('video');
                    video.src = reader.result;
                    videoPreview.classList.remove('hidden');
                    imagePreview.classList.add('hidden');
                } else {
                    const img = imagePreview.querySelector('img');
                    img.src = reader.result;
                    imagePreview.classList.remove('hidden');
                    videoPreview.classList.add('hidden');
                }
                placeholder.classList.add('hidden');
            };

            reader.readAsDataURL(file);
        }
    }
</script>
@endsection