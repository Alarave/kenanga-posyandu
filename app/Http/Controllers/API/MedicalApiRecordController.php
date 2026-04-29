<?php

namespace App\Http\Controllers\API;

use App\Models\MedicalRecord;
use App\Http\Requests\MedicalRecordRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicalApiRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::accessibleBy(auth()->user())
            ->with(['patient', 'user'])
            ->get();
        
        return response()->json($records);
    }

    public function store(MedicalRecordRequest $request, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $medicalRecord = $medicalRecordService->createMedicalRecord($request->validated(), auth()->user());
        return response()->json($medicalRecord->load(['patient', 'user']), 201);
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $this->authorizeAccess($medicalRecord);
        
        return response()->json($medicalRecord->load(['patient', 'user']));
    }

    public function update(MedicalRecordRequest $request, MedicalRecord $medicalRecord, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $this->authorizeAccess($medicalRecord);
        
        $medicalRecord = $medicalRecordService->updateMedicalRecord($medicalRecord, $request->validated(), auth()->user());
        return response()->json($medicalRecord->load(['patient', 'user']));
    }

    public function destroy(MedicalRecord $medicalRecord, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $this->authorizeAccess($medicalRecord);
        
        $medicalRecordService->deleteMedicalRecord($medicalRecord);
        return response()->json(['message' => 'Medical record deleted successfully']);
    }

    /**
     * Authorize user access to medical record resource
     */
    private function authorizeAccess(MedicalRecord $medicalRecord): void
    {
        $user = auth()->user();
        
        if ($user->isSuperAdmin()) {
            return;
        }

        if ($user->isCoordinator()) {
            $pedukuhanId = $user->getPedukuhanId();
            abort_unless(
                $pedukuhanId && $medicalRecord->patient->posyandu->pedukuhan_id === $pedukuhanId,
                403,
                'Unauthorized access.'
            );
            return;
        }

        abort_unless(
            $medicalRecord->patient->posyandu_id === $user->posyandu_id,
            403,
            'Unauthorized access.'
        );
    }
}
