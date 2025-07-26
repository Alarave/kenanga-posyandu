<?php

namespace App\Http\Controllers\Web;

use App\Models\Patient;
use App\Http\Requests\PatientRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('admin.patient-management.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patient-management.create');
    }

    public function store(PatientRequest $request)
    {
        Patient::create($request->validated());
        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        return view('admin.patient-management.details', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('admin.patient-management.update', compact('patient'));
    }

    public function update(PatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
