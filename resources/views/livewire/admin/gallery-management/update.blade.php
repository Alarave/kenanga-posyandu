@extends('layouts.admin-layout')

@section('admin-title')
    Edit Foto Galeri
@endsection

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Edit Foto Galeri</h2>
    <x-breadcrumb :items="[
        ['label' => 'Galeri', 'url' => route('admin.gallery.index')],
        ['label' => $gallery->title, 'url' => route('admin.gallery.show', $gallery->id)],
        ['label' => 'Edit', 'active' => true]
    ]" />
</div>

<x-card>
    <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Upload/Preview Gambar -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Saat Ini</label>
                <div class="flex flex-col items-center p-8 bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl hover:border-blue-400 transition-colors group">
                    <div id="imagePreview" class="mb-4">
                        <img src="{{ asset('storage/' . $gallery->photo) }}" alt="{{ $gallery->title }}" class="h-64 rounded-xl shadow-lg border-4 border-white object-cover">
                    </div>
                    
                    <p id="previewHint" class="hidden text-sm font-bold text-blue-600 mb-4 animate-pulse">Foto baru terpilih!</p>

                    <input type="file" name="photo" class="hidden" id="imageUpload" accept="image/*" onchange="previewFile(event)">
                    <label for="imageUpload" class="cursor-pointer">
                        <span class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl shadow-sm hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all cursor-pointer inline-flex items-center">
                            <i class="fas fa-sync-alt mr-2"></i> Ubah Foto
                        </span>
                    </label>
                    <p class="text-xs text-gray-400 mt-4 uppercase tracking-widest font-bold">Biarkan kosong jika tidak ingin mengubah foto</p>
                </div>
                @error('photo') <p class="mt-2 text-sm text-red-600 font-bold"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Foto</label>
                    <input type="text" name="title" value="{{ old('title', $gallery->title) }}" placeholder="Contoh: Kegiatan Posyandu Januari" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:bg-white text-gray-700" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan sedikit tentang kegiatan ini..." class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:bg-white text-gray-700">{{ old('description', $gallery->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Posyandu</label>
                    <select name="posyandu_id" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:bg-white text-gray-700">
                        <option value="">Pilih Posyandu (opsional)</option>
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $gallery->posyandu_id) == $posyandu->id ? 'selected' : '' }}>{{ $posyandu->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-3 pt-6">
                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out bg-gray-200 rounded-full cursor-pointer focus-within:ring-2 focus-within:ring-blue-500">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured" class="absolute w-0 h-0 opacity-0 peer" {{ old('is_featured', $gallery->is_featured) ? 'checked' : '' }}>
                        <label for="is_featured" class="block h-6 overflow-hidden bg-gray-300 rounded-full cursor-pointer peer-checked:bg-blue-600 transition-colors"></label>
                        <span class="absolute block w-4 h-4 mt-1 ml-1 transition-transform duration-200 ease-in-out bg-white rounded-full peer-checked:translate-x-6"></span>
                    </div>
                    <label for="is_featured" class="text-sm font-bold text-gray-700 cursor-pointer">Tampilkan di Beranda</label>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-12 space-x-4">
            <a href="{{ route('admin.gallery.index') }}" class="px-8 py-3 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition-all active:scale-95">Batal</a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 active:scale-95 flex items-center">
                <i class="fas fa-check mr-2"></i> Update Foto
            </button>
        </div>
    </form>
</x-card>

<script>
    function previewFile(event) {
        const input = event.target;
        const reader = new FileReader();
        const preview = document.getElementById('imagePreview');
        const img = preview.querySelector('img');
        const hint = document.getElementById('previewHint');

        reader.onload = function(){
            img.src = reader.result;
            hint.classList.remove('hidden');
        };

        if(input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection