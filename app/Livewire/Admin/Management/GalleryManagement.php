<?php

namespace App\Livewire\Admin\Management;

use App\Models\GalleryFolder;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-layout')]
class GalleryManagement extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = GalleryFolder::query()
            ->with(['posyandu'])
            ->accessibleBy(auth()->user())
            ->withCount('galleries')
            ->when($this->search, function ($q) {
                $searchTerm = '%'.strtolower($this->search).'%';
                $q->whereRaw('LOWER(name) LIKE ?', [$searchTerm]);
            })
            ->latest();

        return view('livewire.admin.gallery-management.index', [
            'folders' => $query->paginate(12),
        ]);
    }
}
