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
        $records = MedicalRecord::all();
        return response()->json($records);
    }

    public function store(MedicalRecordRequest $request)
    {
        $medicalRecord = MedicalRecord::create($request->validated());
        return response()->json($medicalRecord, 201);
    }

    public function show(MedicalRecord $medicalRecord)
    {
        return response()->json($medicalRecord);
    }

    public function update(MedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $medicalRecord->update($request->validated());
        return response()->json($medicalRecord);
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();
        return response()->json(['message' => 'Medical record deleted successfully']);
    }
}
