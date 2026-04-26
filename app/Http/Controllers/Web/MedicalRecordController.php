<?php

namespace App\Http\Controllers\Web;

use App\Models\MedicalRecord;
use App\Http\Requests\MedicalRecordRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', MedicalRecord::class);

        $medicalRecords = MedicalRecord::with(['patient', 'user'])
            ->accessibleBy(auth()->user())
            ->paginate(10);

        return view('livewire.admin.medical-record-management.index', compact('medicalRecords'));
    }

    public function create(\App\Services\MedicalRecordService $medicalRecordService)
    {
        $this->authorize('create', MedicalRecord::class);

        // Scope patients based on user role
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            $patients = \App\Models\Patient::all();
        } else {
            // Admin and Kader can only create records for their posyandu's patients
            $patients = \App\Models\Patient::where('posyandu_id', $user->posyandu_id)->get();
        }

        // Check for duplicate Vitamin A and Pill FE in current month if patient_id is provided
        $duplicateWarnings = null;
        if (request()->has('patient_id')) {
            $duplicateWarnings = $medicalRecordService->getDuplicateWarnings((int) request()->get('patient_id'));
        }

        return view('livewire.admin.medical-record-management.create', compact('patients', 'duplicateWarnings'));
    }

    public function store(MedicalRecordRequest $request, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $this->authorize('create', MedicalRecord::class);

        $medicalRecordService->createRecord($request->validated(), auth()->user());

        return redirect()->route('admin.medical-records.index')->with('success', 'Medical record created successfully.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $this->authorize('view', $medicalRecord);

        return view('livewire.admin.medical-record-management.details', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $this->authorize('update', $medicalRecord);

        // Scope patients based on user role
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            $patients = \App\Models\Patient::all();
        } else {
            // Admin and Kader can only edit records for their posyandu's patients
            $patients = \App\Models\Patient::where('posyandu_id', $user->posyandu_id)->get();
        }

        // Check for duplicate Vitamin A and Pill FE in current month (excluding current record)
        $duplicateWarnings = null;
        if ($medicalRecord->visit_date) {
            $duplicateWarnings = $medicalRecordService->getDuplicateWarnings(
                $medicalRecord->patient_id, 
                $medicalRecord->visit_date, 
                $medicalRecord->id
            );
        }

        return view('livewire.admin.medical-record-management.update', ['record' => $medicalRecord, 'patients' => $patients, 'duplicateWarnings' => $duplicateWarnings]);
    }

    public function update(MedicalRecordRequest $request, MedicalRecord $medicalRecord, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $this->authorize('update', $medicalRecord);

        $medicalRecordService->updateRecord($medicalRecord, $request->validated(), auth()->user());

        return redirect()->route('admin.medical-records.index')->with('success', 'Medical record updated successfully.');
    }

    public function destroy(MedicalRecord $medicalRecord, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $this->authorize('delete', $medicalRecord);

        $medicalRecordService->deleteRecord($medicalRecord);

        return redirect()->route('admin.medical-records.index')->with('success', 'Medical record deleted successfully.');
    }
}
