<?php

namespace App\Services;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GalleryService
{
    /**
     * Create a new gallery entry.
     */
    public function createGallery(array $data, User $user): array
    {
        if (! $user->isSuperAdmin()) {
            $data['posyandu_id'] = $user->posyandu_id;
        }

        $data['user_id'] = $user->id;
        $galleries = [];

        $photos = $data['photos'] ?? [];
        unset($data['photos']);

        foreach ($photos as $photo) {
            if ($photo instanceof UploadedFile) {
                $mimeType = $photo->getMimeType();
                $fileData = $data;
                $fileData['type'] = str_starts_with($mimeType, 'video/') ? 'video' : 'image';
                $fileData['photo'] = $photo->store('galleries', 'public');
                $galleries[] = Gallery::create($fileData);
            }
        }

        return $galleries;
    }

    /**
     * Update an existing gallery entry.
     */
    public function updateGallery(Gallery $gallery, array $data): Gallery
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            if ($gallery->photo) {
                Storage::disk('public')->delete($gallery->photo);
            }
            $mimeType = $data['photo']->getMimeType();
            $data['type'] = str_starts_with($mimeType, 'video/') ? 'video' : 'image';
            $data['photo'] = $data['photo']->store('galleries', 'public');
        }

        $gallery->update($data);

        return $gallery;
    }

    /**
     * Delete a gallery entry.
     */
    public function deleteGallery(Gallery $gallery): void
    {
        if ($gallery->photo) {
            Storage::disk('public')->delete($gallery->photo);
        }
        $gallery->delete();
    }
}
