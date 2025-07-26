<?php

namespace App\Http\Controllers\Web;

use App\Models\MedicalRecord;
use App\Http\Requests\MedicalRecordRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::all();
        return view('admin.medical-record-management.index', compact('records'));
    }

    public function create()
    {
        return view('admin.medical-record-management.create');
    }

    public function store(MedicalRecordRequest $request)
    {
        MedicalRecord::create($request->validated());
        return redirect()->route('medical-records.index')->with('success', 'Medical record created successfully.');
    }

    public function show(MedicalRecord $record)
    {
        return view('admin.medical-record-management.details', compact('record'));
    }

    public function edit(MedicalRecord $record)
    {
        return view('admin.medical-record-management.update', compact('record'));
    }

    public function update(MedicalRecordRequest $request, MedicalRecord $record)
    {
        $record->update($request->validated());
        return redirect()->route('medical-records.index')->with('success', 'Medical record updated successfully.');
    }

    public function destroy(MedicalRecord $record)
    {
        $record->delete();
        return redirect()->route('medical-records.index')->with('success', 'Medical record deleted successfully.');
    }
}
