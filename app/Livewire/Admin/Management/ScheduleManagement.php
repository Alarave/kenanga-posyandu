<?php

namespace App\Livewire\Admin\Management;

use App\Models\Schedule;
use App\Livewire\Shared\BaseAdminComponent;
use App\Services\ScheduleService;
use Illuminate\View\View;
use Livewire\WithPagination;

/**
 * Komponen Manajemen Jadwal (OOP & Clean Code).
 * Menangani tampilan daftar, filtering, dan penghapusan jadwal.
 */
class ScheduleManagement extends BaseAdminComponent
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $posyandu_id = '';

    // Form properties for Create
    public string $title = '';
    public string $description = '';
    public string $start_time = '';
    public string $end_time = '';
    public string $location = '';
    public string $new_status = 'upcoming';
    public ?int $selected_posyandu_id = null;

    public bool $showCreateModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'posyandu_id' => ['except' => ''],
    ];

    /**
     * Inisialisasi komponen.
     */
    public function mount(): void
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            $this->selected_posyandu_id = $user->posyandu_id;
        }
    }

    /**
     * Simpan jadwal baru.
     */
    public function save(ScheduleService $service)
    {
        $this->authorize('create', Schedule::class);
        
        $validated = $this->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
            'location'    => 'required|string|max:255',
            'new_status'  => 'required|in:upcoming,ongoing,completed',
            'selected_posyandu_id' => 'required|exists:posyandus,id',
        ]);

        // Map UI names to model names
        $data = [
            'title'       => $this->title,
            'description' => $this->description,
            'start_time'  => $this->start_time,
            'end_time'    => $this->end_time,
            'location'    => $this->location,
            'status'      => $this->new_status,
            'posyandu_id' => $this->selected_posyandu_id,
        ];

        $service->createSchedule($data, auth()->user());

        $this->reset(['title', 'description', 'start_time', 'end_time', 'location', 'new_status', 'showCreateModal']);
        $this->notify('Jadwal baru berhasil ditambahkan.');
    }

    /**
     * Render halaman manajemen jadwal.
     */
    public function render(): View
    {
        $now = now();
        $baseQuery = $this->applyPosyanduScope(Schedule::with('posyandu'));

        $schedules = (clone $baseQuery)
            ->when($this->search, fn($q) => $q->search($this->search))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->posyandu_id, fn($q) => $q->where('posyandu_id', $this->posyandu_id))
            ->orderBy('start_time', 'asc')
            ->paginate(10);

        return view('livewire.admin.schedule-management.index', [
            'schedules'      => $schedules,
            'stats'          => $this->getStats($baseQuery),
            'agendaTerdekat' => $this->getUpcomingAgenda($baseQuery),
            'posyandus'      => $this->getAllowedPosyandus(),
        ]);
    }

    /**
     * Menghitung statistik untuk Dashboard Jadwal.
     */
    private function getStats($query): array
    {
        $now = now();
        return [
            'total_month' => (clone $query)->whereMonth('start_time', $now->month)->whereYear('start_time', $now->year)->count(),
            'completed'   => (clone $query)->where('status', 'completed')->count(),
            'upcoming'    => (clone $query)->where('status', 'upcoming')->count(),
            'ongoing'     => (clone $query)->where('status', 'ongoing')->count(),
        ];
    }

    /**
     * Mendapatkan agenda mendatang paling dekat.
     */
    private function getUpcomingAgenda($query): ?Schedule
    {
        return (clone $query)
            ->where('status', 'upcoming')
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->first();
    }

    /**
     * Hapus jadwal dengan autorisasi.
     */
    public function deleteSchedule(int $id, ScheduleService $service): void
    {
        $schedule = Schedule::findOrFail($id);
        $this->authorize('delete', $schedule);
        
        $service->deleteSchedule($schedule);
        $this->notify('Jadwal kegiatan berhasil dihapus.');
    }
}
