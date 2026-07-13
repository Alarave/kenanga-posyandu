<?php

namespace App\Livewire\Admin\Management;

use App\Models\Posyandu;
use App\Models\Schedule;
use App\Models\User;
use App\Services\ScheduleService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Komponen untuk membuat jadwal baru (OOP & Clean Code).
 */
#[Layout('layouts.admin-layout')]
class ScheduleCreate extends Component
{
    public string $title = '';

    public string $description = '';

    public string $start_time = '';

    public string $end_time = '';

    public string $location = '';

    public string $status = 'upcoming';

    public ?int $posyandu_id = null;

    public bool $is_recurring = false;

    public int $repeat_months = 12;

    /**
     * Inisialisasi komponen.
     */
    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->isSuperAdmin()) {
            $this->posyandu_id = $user->posyandu_id;
        }
    }

    /**
     * Aturan validasi.
     */
    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'posyandu_id' => 'required|exists:posyandus,id',
            'is_recurring' => 'boolean',
            'repeat_months' => 'required_if:is_recurring,true|integer|min:1|max:36',
        ];
    }

    /**
     * Simpan jadwal baru menggunakan Service.
     */
    public function save(ScheduleService $service)
    {
        Gate::authorize('create', Schedule::class);
        $validated = $this->validate();

        /** @var User $user */
        $user = Auth::user();

        if ($this->is_recurring) {
            $start = Carbon::parse($this->start_time);
            $end = Carbon::parse($this->end_time);

            for ($i = 0; $i < $this->repeat_months; $i++) {
                $currentStart = $start->copy()->addMonths($i);
                $currentEnd = $end->copy()->addMonths($i);

                $singleData = $validated;
                $singleData['start_time'] = $currentStart->toDateTimeString();
                $singleData['end_time'] = $currentEnd->toDateTimeString();

                $service->createSchedule($singleData, $user);
            }
        } else {
            $service->createSchedule($validated, $user);
        }

        session()->flash('success', 'Jadwal kegiatan berhasil ditambahkan.');

        return $this->redirectRoute('admin.schedules.index', navigate: true);
    }

    /**
     * Render view.
     */
    public function render(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $posyandus = $user->isSuperAdmin()
            ? Posyandu::orderBy('name')->get()
            : Posyandu::where('id', $user->posyandu_id)->get();

        return view('livewire.admin.schedule-management.create', [
            'posyandus' => $posyandus,
        ]);
    }
}
