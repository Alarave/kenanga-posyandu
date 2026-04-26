<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Livewire\Shared\BaseAdminComponent;
use Illuminate\Support\Facades\Gate;

class ActivityLogViewer extends BaseAdminComponent
{
    public string $startDate = '';
    public string $endDate = '';
    public string $actionType = '';
    public string $userName = '';

    public array $actionTypes = [
        'login', 'logout', 'auto_logout',
        'create_patient', 'update_patient', 'delete_patient',
        'create_medical_record', 'update_medical_record',
        'export_report', 'change_user_access', 'unauthorized_access',
    ];

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'actionType' => ['except' => ''],
        'userName' => ['except' => ''],
    ];

    public function mount(): void
    {
        if (!Gate::allows('viewAny', ActivityLog::class)) {
            abort(403, 'Anda tidak memiliki akses untuk melihat log aktivitas.');
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['startDate', 'endDate', 'actionType', 'userName']);
        $this->resetPage();
    }

    public function render()
    {
        $query = ActivityLog::query()
            ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate,   fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->when($this->actionType, fn($q) => $q->where('action_type', $this->actionType))
            ->when($this->userName,   fn($q) => $q->where('user_name', 'like', '%' . $this->userName . '%'))
            ->latest();

        return view('livewire.admin.activity-log-viewer', [
            'activityLogs' => $query->paginate(20),
        ]);
    }
}
