<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Models\GalleryFolder;
use App\Models\Posyandu;
use App\Services\GalleryService;

class GalleryController extends Controller
{
    /**
     * Show form to upload new media into a folder.
     */
    public function create(GalleryFolder $folder)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && $folder->posyandu_id !== $user->posyandu_id) {
            abort(403, 'Anda tidak memiliki akses ke folder ini.');
        }

        return view('livewire.admin.gallery-management.create', compact('folder'));
    }

    /**
     * Store uploaded media into a folder.
     */
    public function store(GalleryRequest $request, GalleryFolder $folder, GalleryService $galleryService)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && $folder->posyandu_id !== $user->posyandu_id) {
            abort(403, 'Anda tidak memiliki akses ke folder ini.');
        }

        $data = $request->validated();
        // Bind media ke folder & posyandu folder
        $data['gallery_folder_id'] = $folder->id;
        $data['posyandu_id'] = $folder->posyandu_id;

        $galleryService->createGallery($data, $user);

        return redirect()->route('admin.gallery.show', $folder->id)->with('success', 'Media berhasil ditambahkan ke folder.');
    }

    /**
     * Delete media inside a folder.
     */
    public function destroy(GalleryFolder $folder, Gallery $gallery, GalleryService $galleryService)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && $folder->posyandu_id !== $user->posyandu_id) {
            abort(403, 'Anda tidak memiliki akses ke folder ini.');
        }

        // Pastikan media memang berada di dalam folder tersebut
        if ($gallery->gallery_folder_id !== $folder->id) {
            abort(404, 'Media tidak ditemukan di folder ini.');
        }

        $galleryService->deleteGallery($gallery);

        return redirect()->route('admin.gallery.show', $folder->id)->with('success', 'Media berhasil dihapus.');
    }
}
