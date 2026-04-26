<?php

namespace App\Livewire\Admin\Management;

use App\Models\Posyandu;
use App\Livewire\Shared\BaseAdminComponent;

class PosyanduManagement extends BaseAdminComponent
{
    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $query = Posyandu::with('pedukuhan')
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('unique_code', 'like', '%' . $this->search . '%');
            })
            ->latest();

        return view('livewire.admin.posyandu-management.index', [
            'posyandus' => $query->paginate(10),
        ]);
    }
}
