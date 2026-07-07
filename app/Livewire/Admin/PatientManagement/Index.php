<?php

namespace App\Livewire\Admin\PatientManagement;

use App\Livewire\Shared\BaseAdminComponent;
use App\Models\Patient;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Index extends BaseAdminComponent
{
    public string $search = '';

    public string $status = 'all';

    public string $category = 'all';

    public string $sortBy = 'name';

    public string $sortDirection = 'asc';

    public bool $showDeleteModal = false;

    public ?int $selectedId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'category' => ['except' => 'all'],
    ];

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'category', 'status']);
        $this->resetPage();
    }

    public function sortByField(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

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

    public function deletePatient(): void
    {
        if ($this->selectedId) {
            $patient = Patient::find($this->selectedId);
            if ($patient) {
                $this->authorize('delete', $patient);
                $patient->delete();
                $this->notify('Data warga berhasil dihapus.');
            }
        }
        $this->closeModal();
    }

    public function render()
    {
        // Base query for counts (respecting the posyandu scope)
        $baseQuery = $this->applyPosyanduScope(Patient::query());

        // Fetch scoped counts for summary cards
        $stats = [
            'bayi' => (clone $baseQuery)->where(function ($q) {
                $q->where('category', 'bayi')
                    ->orWhere(function ($q2) {
                        $q2->where('category', 'balita')
                            ->where('birth_date', '>=', now()->subMonths(12));
                    });
            })->count(),

            'baduta' => (clone $baseQuery)->where(function ($q) {
                $q->where('category', 'baduta')
                    ->orWhere(function ($q2) {
                        $q2->where('category', 'balita')
                            ->where('birth_date', '<', now()->subMonths(12))
                            ->where('birth_date', '>=', now()->subMonths(24));
                    });
            })->count(),

            'balita' => (clone $baseQuery)->where('category', 'balita')
                ->where(function ($q) {
                    $q->whereNull('birth_date')
                        ->orWhere('birth_date', '<', now()->subMonths(24));
                })->count(),

            'anak_sekolah' => (clone $baseQuery)->where('category', 'anak_sekolah')->count(),
            'ibu_hamil' => (clone $baseQuery)->where('category', 'ibu_hamil')->count(),
            'remaja' => (clone $baseQuery)->where('category', 'remaja')->count(),
            'lansia' => (clone $baseQuery)->where('category', 'lansia')->count(),
            'umum' => (clone $baseQuery)->where('category', 'umum')->count(),
        ];

        // Terapkan scope posyandu secara otomatis untuk list utama
        $query = $this->applyPosyanduScope(Patient::with('posyandu'))
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('full_name', 'like', '%'.$this->search.'%')
                        ->orWhere('id_number_hash', Patient::generateBlindIndex($this->search));
                });
            })
            ->when($this->category !== 'all', function ($q) {
                if ($this->category === 'bayi') {
                    $q->where(function ($sq) {
                        $sq->where('category', 'bayi')
                            ->orWhere(function ($q2) {
                                $q2->where('category', 'balita')
                                    ->where('birth_date', '>=', now()->subMonths(12));
                            });
                    });
                } elseif ($this->category === 'baduta') {
                    $q->where(function ($sq) {
                        $sq->where('category', 'baduta')
                            ->orWhere(function ($q2) {
                                $q2->where('category', 'balita')
                                    ->where('birth_date', '<', now()->subMonths(12))
                                    ->where('birth_date', '>=', now()->subMonths(24));
                            });
                    });
                } elseif ($this->category === 'balita') {
                    $q->where(function ($sq) {
                        $sq->where('category', 'balita')
                            ->where(function ($q2) {
                                $q2->whereNull('birth_date')
                                    ->orWhere('birth_date', '<', now()->subMonths(24));
                            });
                    });
                } else {
                    $q->where('category', $this->category);
                }
            })
            ->orderBy($this->sortBy === 'name' ? 'full_name' : $this->sortBy, $this->sortDirection);

        return view('livewire.admin.patient-management.index', [
            'patients' => $query->paginate(10),
            'stats' => $stats,
        ])->title('Data Warga Terdaftar');
    }
}
