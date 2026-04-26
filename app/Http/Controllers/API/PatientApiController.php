<?php

namespace App\Http\Controllers\API;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PatientApiController extends Controller
{
    public function index()
    {
        $patients = Patient::accessibleBy(auth()->user())->get();
        return response()->json($patients);
    }

    public function store(\App\Http\Requests\PatientRequest $request, \App\Services\PatientService $patientService)
    {
        $patient = $patientService->createPatient($request->validated());
        return response()->json($patient, 201);
    }
    
    public function show(Patient $patient)
    {
        // Check access using policy or scope
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isCoordinator() && $patient->posyandu_id !== auth()->user()->posyandu_id) {
             return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        return response()->json($patient);
    }

    public function update(\App\Http\Requests\PatientRequest $request, Patient $patient, \App\Services\PatientService $patientService)
    {
        // Check access
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isCoordinator() && $patient->posyandu_id !== auth()->user()->posyandu_id) {
             return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        $patientService->updatePatient($patient, $request->validated());
        return response()->json($patient);
    }

    public function destroy(Patient $patient, \App\Services\PatientService $patientService)
    {
        // Check access
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isCoordinator() && $patient->posyandu_id !== auth()->user()->posyandu_id) {
             return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        $patientService->deletePatient($patient);
        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
