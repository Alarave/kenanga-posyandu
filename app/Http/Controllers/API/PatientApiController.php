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
        $patients = Patient::accessibleBy(auth()->user())
            ->with(['posyandu', 'medicalRecords'])
            ->get();
        
        return response()->json($patients);
    }

    public function store(\App\Http\Requests\PatientRequest $request, \App\Services\PatientService $patientService)
    {
        $patient = $patientService->createPatient($request->validated(), auth()->user());
        return response()->json($patient->load(['posyandu']), 201);
    }
    
    public function show(Patient $patient)
    {
        $this->authorizeAccess($patient);
        
        return response()->json($patient->load(['posyandu', 'medicalRecords']));
    }

    public function update(\App\Http\Requests\PatientRequest $request, Patient $patient, \App\Services\PatientService $patientService)
    {
        $this->authorizeAccess($patient);

        $patient = $patientService->updatePatient($patient, $request->validated(), auth()->user());
        return response()->json($patient->load(['posyandu']));
    }

    public function destroy(Patient $patient, \App\Services\PatientService $patientService)
    {
        $this->authorizeAccess($patient);

        $patientService->deletePatient($patient);
        return response()->json(['message' => 'Patient deleted successfully']);
    }

    /**
     * Authorize user access to patient resource
     */
    private function authorizeAccess(Patient $patient): void
    {
        abort_unless(
            auth()->user()->isSuperAdmin() || 
            auth()->user()->isCoordinator() || 
            $patient->posyandu_id === auth()->user()->posyandu_id,
            403,
            'Unauthorized access.'
        );
    }
}
