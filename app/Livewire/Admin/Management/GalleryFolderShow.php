<?php

namespace App\Livewire\Admin\Management;

use App\Livewire\Shared\BaseAdminComponent;
use App\Models\Gallery;
use App\Models\GalleryFolder;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin-layout')]
class GalleryFolderShow extends BaseAdminComponent
{
    use WithPagination, WithFileUploads;

    public GalleryFolder $folder;

    public function mount(GalleryFolder $folder): void
    {
        $this->folder = $folder;
    }

    public function render(): View
    {
        $galleries = Gallery::where('folder_id', $this->folder->id)
            ->latest()
            ->paginate(12);

        return view('livewire.admin.gallery-management.folder-show', [
            'galleries' => $galleries,
        ]);
    }
}