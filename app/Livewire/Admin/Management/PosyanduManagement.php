<?php

namespace App\Livewire\Admin\Management;

use App\Livewire\Shared\BaseAdminComponent;
use App\Models\Patient;
use App\Models\Posyandu;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-layout')]
class PosyanduManagement extends BaseAdminComponent
{
    public string $search = '';

    public bool $showDeleteModal = false;

    public ?int $selectedId = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function confirmDelete(int $id): void
    {
        $this->selectedId = $id;
        $this->showDeleteModal = true;
    }

    public function closeModal(): void
    {
        $this->showDeleteModal = false;
        $this->selectedId = null;
    }

    public function deletePosyandu(): void
    {
        if ($this->selectedId) {
            $posyandu = Posyandu::find($this->selectedId);
            if ($posyandu) {
                // Check if posyandu has active data (optional but recommended for safety)
                if ($posyandu->users()->count() > 0 || $posyandu->patients()->count() > 0) {
                    $this->notify('Tidak bisa menghapus Posyandu yang masih memiliki data Kader atau Warga.', 'error');
                } else {
                    $posyandu->delete();
                    $this->notify('Data Posyandu berhasil dihapus.');
                }
            }
        }
        $this->closeModal();
    }

    public function render()
    {
        $balitaCategories = ['balita', 'bayi', 'baduta'];

        $posyandus = Posyandu::withCount([
            'patients' => fn ($q) => $q->where('status_mutasi', 'aktif'),
            'patients as balita_count'       => fn ($q) => $q->where('status_mutasi', 'aktif')->whereIn('category', $balitaCategories),
            'patients as ibu_hamil_count'    => fn ($q) => $q->where('status_mutasi', 'aktif')->where('category', 'ibu_hamil'),
            'patients as lansia_count'       => fn ($q) => $q->where('status_mutasi', 'aktif')->where('category', 'lansia'),
            'patients as anak_sekolah_count' => fn ($q) => $q->where('status_mutasi', 'aktif')->where('category', 'anak_sekolah'),
            'patients as remaja_count'       => fn ($q) => $q->where('status_mutasi', 'aktif')->where('category', 'remaja'),
            'patients as umum_count'         => fn ($q) => $q->where('status_mutasi', 'aktif')->where('category', 'umum'),
        ])
            ->when($this->search, function ($q) {
                $searchTerm = '%'.strtolower($this->search).'%';
                $q->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(unique_code) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(address) LIKE ?', [$searchTerm]);
            })
            ->latest()
            ->paginate(10);

        $totalBalita      = Patient::where('status_mutasi', 'aktif')->whereIn('category', $balitaCategories)->count();
        $totalBumil       = Patient::where('status_mutasi', 'aktif')->where('category', 'ibu_hamil')->count();
        $totalLansia      = Patient::where('status_mutasi', 'aktif')->where('category', 'lansia')->count();
        $totalAnakSekolah = Patient::where('status_mutasi', 'aktif')->where('category', 'anak_sekolah')->count();
        $totalRemaja      = Patient::where('status_mutasi', 'aktif')->where('category', 'remaja')->count();
        $totalUmum        = Patient::where('status_mutasi', 'aktif')->where('category', 'umum')->count();

        return view('livewire.admin.posyandu-management.index', [
            'posyandus'        => $posyandus,
            'totalPosyandu'    => $posyandus->total(),
            'totalBalita'      => $totalBalita,
            'totalBumil'       => $totalBumil,
            'totalLansia'      => $totalLansia,
            'totalAnakSekolah' => $totalAnakSekolah,
            'totalRemaja'      => $totalRemaja,
            'totalUmum'        => $totalUmum,
            'totalWarga'       => Patient::where('status_mutasi', 'aktif')->count(),
        ]);
    }
}
