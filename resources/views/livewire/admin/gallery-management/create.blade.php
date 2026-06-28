@extends('layouts.admin-layout')

@section('admin-title')
    Unggah Media - {{ $folder->name }}
@endsection

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Unggah Media Baru</h2>
        <p class="text-sm text-slate-400 font-medium mt-1">Tambahkan foto atau video dokumentasi ke dalam folder <span class="font-bold text-slate-700">"{{ $folder->name }}"</span>.</p>
    </div>
    <x-breadcrumb :items="[
        ['label' => 'Galeri', 'url' => route('admin.gallery.index')],
        ['label' => $folder->name, 'url' => route('admin.gallery.show', $folder->id)],
        ['label' => 'Unggah', 'active' => true]
    ]" />
</div>

<div class="bg-white rounded-[32px] border border-slate-100 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
    <form action="{{ route('admin.gallery.media.store', $folder->id) }}" method="POST" enctype="multipart/form-data">
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
                        <p class="text-xs text-slate-400 mt-2 font-bold uppercase tracking-wider">Format: JPG, JPEG, PNG, WEBP, MP4, MOV (Maks. 20MB)</p>
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
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Judul Media / Foto</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Kegiatan Timbang Berat Badan Balita" class="w-full h-12 bg-slate-50 border-transparent rounded-2xl px-5 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-0 focus:border-teal-500 transition-all border-2 border-slate-100" required>
                    @error('title') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Keterangan Tambahan (Opsional)</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan detail singkat mengenai foto/video kegiatan ini..." class="w-full bg-slate-50 border-transparent rounded-2xl px-5 py-4 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-0 focus:border-teal-500 transition-all border-2 border-slate-100">{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-12 gap-4">
            <a href="{{ route('admin.gallery.show', $folder->id) }}" class="px-8 py-3.5 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all text-xs uppercase tracking-widest">Batal</a>
            <button type="submit" class="px-8 py-3.5 bg-slate-900 text-white font-black rounded-2xl hover:bg-teal-600 transition-all shadow-lg shadow-slate-900/10 text-xs uppercase tracking-widest flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">publish</span>
                Unggah Media
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