<?php

namespace App\Livewire\Admin\MedicalRecord;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Posyandu;
use App\Services\NutritionCalculatorService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BulkMeasurementEntry extends Component
{
    public $posyandu_id;

    public $visit_date;

    public $measurements = [];

    public $search = '';

    public $searchResults = [];
    public $isLoadingAll = false;

    protected $rules = [
        'posyandu_id' => 'required|exists:posyandus,id',
        'visit_date' => 'required|date',
        'measurements.*.weight' => 'nullable|numeric|min:0.1|max:80',
        'measurements.*.height' => 'nullable|numeric|min:30|max:150',
        'measurements.*.measurement_method' => 'required|in:standing,recumbent',
    ];

    public function mount()
    {
        $this->authorize('create', MedicalRecord::class);
        
        $this->visit_date = now()->format('Y-m-d');

        // If user is a Kader, set their posyandu_id
        if (Auth::user()->posyandu_id) {
            $this->posyandu_id = Auth::user()->posyandu_id;
        }
    }

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->searchResults = [];

            return;
        }

        $query = Patient::query();

        if ($this->posyandu_id) {
            $query->where('posyandu_id', $this->posyandu_id);
        }

        $this->searchResults = $query->where(function ($q) {
            $q->where('full_name', 'like', '%'.$this->search.'%')
                ->orWhere('id_number', 'like', '%'.$this->search.'%');
        })
            ->limit(5)
            ->get();
    }

    public function addPatient($id)
    {
        // Check if already in list
        if (collect($this->measurements)->contains('patient_id', $id)) {
            $this->search = '';
            $this->searchResults = [];

            return;
        }

        $patient = Patient::find($id);
        if ($patient) {
            $lastRecord = $patient->medicalRecords()->latest()->first();
            $this->measurements[] = [
                'patient_id' => $patient->id,
                'full_name' => $patient->full_name,
                'parent_name' => $patient->parent_name,
                'age_months' => $patient->age_in_months,
                'gender' => $patient->gender,
                'last_weight' => $lastRecord?->weight ?? '-',
                'last_height' => $lastRecord?->height ?? '-',
                'weight' => '',
                'height' => '',
                'measurement_method' => $patient->age_in_months >= 24 ? 'standing' : 'recumbent',
            ];
        }

        $this->search = '';
        $this->searchResults = [];
    }

    public function loadAllPatients()
    {
        if (!$this->posyandu_id) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Pilih Posyandu terlebih dahulu.']);
            return;
        }

        $this->isLoadingAll = true;

        $patients = Patient::where('posyandu_id', $this->posyandu_id)
            ->with(['medicalRecords' => function($query) {
                $query->latest()->limit(1);
            }])
            ->get();

        foreach ($patients as $patient) {
            // Skip if already in list
            if (collect($this->measurements)->contains('patient_id', $patient->id)) {
                continue;
            }

            // Check if already has record for this date
            $hasRecord = MedicalRecord::where('patient_id', $patient->id)
                ->whereDate('visit_date', $this->visit_date)
                ->exists();

            if ($hasRecord) continue;

            $lastRecord = $patient->medicalRecords->first();
            
            $this->measurements[] = [
                'patient_id' => $patient->id,
                'full_name' => $patient->full_name,
                'parent_name' => $patient->parent_name,
                'age_months' => $patient->age_in_months,
                'gender' => $patient->gender,
                'last_weight' => $lastRecord?->weight ?? '-',
                'last_height' => $lastRecord?->height ?? '-',
                'weight' => '',
                'height' => '',
                'measurement_method' => $patient->age_in_months >= 24 ? 'standing' : 'recumbent',
            ];
        }

        $this->isLoadingAll = false;
        $this->dispatch('notify', ['type' => 'success', 'message' => count($patients) . ' Balita dimuat ke daftar.']);
    }

    public function removePatient($index)
    {
        unset($this->measurements[$index]);
        $this->measurements = array_values($this->measurements);
    }

    public function updatedMeasurements($value, $key)
    {
        // Format key: "index.field" (contoh: "0.weight")
        $parts = explode('.', $key);
        if (count($parts) < 2) {
            return;
        }

        $index = $parts[0];
        $field = $parts[1];

        if ($field === 'weight' || $field === 'height') {
            $m = $this->measurements[$index];

            if (! empty($m['weight']) || ! empty($m['height'])) {
                $nutritionService = new NutritionCalculatorService;

                $results = $nutritionService->calculateAll(
                    (float) ($m['weight'] ?: 0),
                    (float) ($m['height'] ?: 0),
                    (int) $m['age_months'],
                    $m['gender']
                );

                $this->measurements[$index]['status_bbu'] = !empty($m['weight']) ? $results->nutrition_status : null;
                $this->measurements[$index]['status_bbtb'] = (!empty($m['weight']) && !empty($m['height'])) ? $results->wasting_status : null;
                $this->measurements[$index]['status_tbu'] = !empty($m['height']) ? $results->stunting_status : null;
                $this->measurements[$index]['z_score_hfa'] = $results->z_score_hfa;
            } else {
                $this->measurements[$index]['status_bbu'] = null;
                $this->measurements[$index]['status_bbtb'] = null;
                $this->measurements[$index]['status_tbu'] = null;
            }
        }
    }

    public function save()
    {
        $this->validate();

        $count = 0;
        $nutritionService = new NutritionCalculatorService;

        foreach ($this->measurements as $m) {
            if (empty($m['weight']) || empty($m['height'])) {
                continue;
            }

            // SECURITY: Verify patient belongs to the authorized posyandu to prevent IDOR
            $patient = Patient::where('id', $m['patient_id'])
                ->where('posyandu_id', $this->posyandu_id)
                ->first();

            if (!$patient) {
                continue;
            }

            $results = $nutritionService->calculateAll(
                (float) ($m['weight'] ?: 0),
                (float) ($m['height'] ?: 0),
                (int) $m['age_months'],
                $m['gender']
            )->toArray();

            MedicalRecord::updateOrCreate(
                [
                    'patient_id' => $m['patient_id'],
                    'visit_date' => $this->visit_date,
                ],
                [
                    'user_id' => Auth::id(),
                    'weight' => $m['weight'] ?: null,
                    'height' => $m['height'] ?: null,
                    'measurement_method' => $m['measurement_method'],
                    'nutrition_status' => !empty($m['weight']) ? $results['nutrition_status'] : null,
                    'z_score' => !empty($m['weight']) ? $results['z_score'] : null,
                    'stunting_status' => !empty($m['height']) ? $results['stunting_status'] : null,
                    'z_score_hfa' => !empty($m['height']) ? $results['z_score_hfa'] : null,
                    'wasting_status' => (!empty($m['weight']) && !empty($m['height'])) ? $results['wasting_status'] : null,
                    'z_score_wfh' => (!empty($m['weight']) && !empty($m['height'])) ? $results['z_score_wfh'] : null,
                ]
            );
            $count++;
        }

        if ($count > 0) {
            session()->flash('success', "$count data penimbangan berhasil disimpan.");

            return redirect()->route('admin.medical-records.index');
        } else {
            $this->dispatch('notify', ['type' => 'warning', 'message' => 'Tidak ada data baru yang disimpan.']);
        }
    }

    public function render()
    {
        $posyandus = Auth::user()->posyandu_id
            ? Posyandu::where('id', Auth::user()->posyandu_id)->get()
            : Posyandu::all();

        return view('livewire.admin.medical-record.bulk-measurement-entry', [
            'posyandus' => $posyandus,
        ])->layout('layouts.admin-layout');
    }
}
