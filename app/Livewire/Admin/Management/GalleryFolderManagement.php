<?php

namespace App\Livewire\Admin\Management;

use App\Livewire\Shared\BaseAdminComponent;
use App\Models\GalleryFolder;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin-layout')]
class GalleryFolderManagement extends BaseAdminComponent
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public $cover_image;

    // Modal state
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';
    public string $description = '';

    protected function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['name', 'description', 'cover_image', 'editingId']);
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $folder = GalleryFolder::findOrFail($id);
        $this->editingId = $folder->id;
        $this->name = $folder->name;
        $this->description = $folder->description ?? '';
        $this->cover_image = null;
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $data = [
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'posyandu_id' => auth()->user()->posyandu_id,
            'created_by'  => auth()->id(),
        ];

        if ($this->cover_image) {
            $data['cover_image'] = $this->cover_image->store('gallery-folders', 'public');
        }

        if ($this->editingId) {
            GalleryFolder::findOrFail($this->editingId)->update($data);
            $this->notify('Folder berhasil diperbarui.', 'success');
        } else {
            GalleryFolder::create($data);
            $this->notify('Folder berhasil dibuat.', 'success');
        }

        $this->showModal = false;
        $this->reset(['name', 'description', 'cover_image', 'editingId']);
    }

    public function delete(int $id): void
    {
        $folder = GalleryFolder::findOrFail($id);
        $folder->galleries()->update(['folder_id' => null]);
        $folder->delete();
        $this->notify('Folder berhasil dihapus.', 'success');
    }

    public function render(): View
    {
        $folders = GalleryFolder::query()
            ->withCount('galleries')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when(!auth()->user()->isSuperAdmin(), fn($q) => $q->where('posyandu_id', auth()->user()->posyandu_id))
            ->latest()
            ->paginate(12);

        return view('livewire.admin.gallery-management.folder', compact('folders'));
    }
}