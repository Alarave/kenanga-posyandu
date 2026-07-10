<?php

namespace App\Livewire\Admin\Management;

use App\Livewire\Shared\BaseAdminComponent;
use App\Models\Patient;
use App\Models\Pedukuhan;
use App\Models\Posyandu;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-layout')]
class PedukuhanManagement extends BaseAdminComponent
{
    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $query = Pedukuhan::query()
            ->withCount(['posyandus', 'patients'])
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->latest();

        $totalPosyandu = Posyandu::count();
        $totalWarga = Patient::count();

        return view('livewire.admin.pedukuhan-management.index', [
            'pedukuhans' => $query->paginate(10),
            'totalPosyandu' => $totalPosyandu,
            'totalWarga' => $totalWarga,
        ]);
    }
}
