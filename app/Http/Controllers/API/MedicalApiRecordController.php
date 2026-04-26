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
        $records = MedicalRecord::accessibleBy(auth()->user())->get();
        return response()->json($records);
    }

    public function store(MedicalRecordRequest $request, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $medicalRecord = $medicalRecordService->createMedicalRecord($request->validated());
        return response()->json($medicalRecord, 201);
    }

    public function show(MedicalRecord $medicalRecord)
    {
        return response()->json($medicalRecord);
    }

    public function update(MedicalRecordRequest $request, MedicalRecord $medicalRecord, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $medicalRecordService->updateMedicalRecord($medicalRecord, $request->validated());
        return response()->json($medicalRecord);
    }

    public function destroy(MedicalRecord $medicalRecord, \App\Services\MedicalRecordService $medicalRecordService)
    {
        $medicalRecordService->deleteMedicalRecord($medicalRecord);
        return response()->json(['message' => 'Medical record deleted successfully']);
    }
}
