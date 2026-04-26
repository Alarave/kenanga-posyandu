<?php

namespace App\Http\Controllers\Web;

use App\Models\Patient;
use App\Http\Requests\PatientRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Patient::class);

        $patients = Patient::with('posyandu')
            ->accessibleBy(auth()->user())
            ->when($request->search, fn($q) => $q->where(function($q2) use ($request) {
                $q2->where('full_name', 'like', '%'.$request->search.'%')
                   ->orWhere('id_number', 'like', '%'.$request->search.'%');
            }))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.patient-management.index', compact('patients'));
    }

    public function create()
    {
        $this->authorize('create', Patient::class);

        $pedukuhans = \App\Models\Pedukuhan::all();
        
        // Scope posyandu selection based on user role
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            $posyandus = \App\Models\Posyandu::all();
        } else {
            // Admin and Kader can only create for their posyandu
            $posyandus = \App\Models\Posyandu::where('id', $user->posyandu_id)->get();
        }

        return view('livewire.admin.patient-management.create', compact('pedukuhans', 'posyandus'));
    }

    public function store(PatientRequest $request, \App\Services\PatientService $patientService)
    {
        $this->authorize('create', Patient::class);

        try {
            $patientService->createPatient($request->validated(), auth()->user());
            return redirect()->route('admin.patients.index')->with('success', 'Data warga berhasil disimpan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        }
    }

    public function show(Patient $patient)
    {
        $this->authorize('view', $patient);

        $patient->load(['posyandu']);

        // Data paginasi untuk tabel histori
        $medicalRecords = $patient->medicalRecords()
            ->with('user')
            ->latest('visit_date')
            ->paginate(10);

        return view('livewire.admin.patient-management.details', compact('patient', 'medicalRecords'));
    }

    public function edit(Patient $patient)
    {
        $this->authorize('update', $patient);

        $pedukuhans = \App\Models\Pedukuhan::all();
        
        // Scope posyandu selection based on user role
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            $posyandus = \App\Models\Posyandu::all();
        } else {
            // Admin and Kader can only edit for their posyandu
            $posyandus = \App\Models\Posyandu::where('id', $user->posyandu_id)->get();
        }

        return view('livewire.admin.patient-management.update', compact('patient', 'pedukuhans', 'posyandus'));
    }

    public function update(PatientRequest $request, Patient $patient, \App\Services\PatientService $patientService)
    {
        $this->authorize('update', $patient);

        try {
            $patientService->updatePatient($patient, $request->validated(), auth()->user());
            return redirect()->route('admin.patients.index')->with('success', 'Data warga berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        }
    }

    public function destroy(Patient $patient, \App\Services\PatientService $patientService)
    {
        $this->authorize('delete', $patient);

        $patientService->deletePatient($patient);

        return redirect()->route('admin.patients.index')->with('success', 'Data warga berhasil dihapus.');
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        $this->authorize('create', Patient::class);

        $user = auth()->user();
        $posyandus = $user->isSuperAdmin()
            ? \App\Models\Posyandu::orderBy('name')->get()
            : \App\Models\Posyandu::where('id', $user->posyandu_id)->get();

        return view('livewire.admin.patient-management.import', compact('posyandus'));
    }

    /**
     * Process CSV/Excel import
     */
    public function import(Request $request, ActivityLogService $activityLogService)
    {
        $this->authorize('create', Patient::class);

        $request->validate([
            'file'        => 'required|file|mimes:csv,xlsx|max:5120',
            'posyandu_id' => 'required|exists:posyandus,id',
        ], [
            'file.required'        => 'File wajib diunggah.',
            'file.mimes'           => 'Format file harus CSV atau XLSX. File .xls (Excel lama) tidak didukung — simpan ulang sebagai .xlsx atau .csv terlebih dahulu.',
            'file.max'             => 'Ukuran file maksimal 5 MB.',
            'posyandu_id.required' => 'Posyandu wajib dipilih.',
        ]);

        $user = auth()->user();

        // Enforce posyandu for non-superadmin
        $posyanduId = $user->isSuperAdmin()
            ? (int) $request->posyandu_id
            : $user->posyandu_id;

        try {
            $import = new \App\Imports\PatientImport($posyanduId, $user->id);
            $import->import($request->file('file'));

            // Log activity
            $posyandu = \App\Models\Posyandu::find($posyanduId);
            $activityLogService->log(
                'create_patient',
                "Import data warga: {$import->imported} berhasil, {$import->skipped} dilewati — Posyandu {$posyandu?->name}",
                $posyanduId,
                'Patient'
            );

            $message = "Import selesai: {$import->imported} warga berhasil diimpor";
            if ($import->recordsImported > 0) {
                $message .= ", {$import->recordsImported} rekam medis tersimpan";
            }
            $message .= ".";
            if ($import->skipped > 0) {
                $message .= " {$import->skipped} baris dilewati.";
            }

            // Tambahkan info header yang terdeteksi ke debug errors
            if (!empty($import->debugHeaders)) {
                $import->errors = array_merge(
                    ['[DEBUG] Header terdeteksi: ' . implode(' | ', $import->debugHeaders)],
                    $import->errors
                );
            }

            return redirect()->route('admin.patients.index')
                ->with('success', $message)
                ->with('import_errors', $import->errors);

        } catch (\Exception $e) {
            \Log::error('Patient import failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_warga_posyandu.csv"',
        ];

        $rows = [
            // Header — sesuai format Excel posyandu asli
            [
                'NIK', 'nama_anak', 'tgl_lahir', 'jk',
                'nm_ortu', 'RT', 'RW', 'ALAMAT',
                'TANGGAL UKUR', 'BERAT', 'TINGGI', 'LILA', 'lingkar_kepala',
                'CARA UKUR', 'vitamin', 'asi_bulan_0', 'Imunisasi',
            ],
            // Contoh baris 1 — balita laki-laki
            [
                '3275010608224411', 'A. ZAFRAN. U.R', '2022-08-06', 'L',
                'RYAN. R. R', '4', '11', 'JL. P. NUSANTARA',
                '2026-03-15', '12.5', '85.0', '14.5', '48.0',
                'Berdiri', 'Ya', '', 'DPT-HB-Hib 3',
            ],
            // Contoh baris 2 — balita perempuan (tanpa NIK)
            [
                '', 'AISYAH HANIN.K', '2022-01-11', 'P',
                'YUNIAR. P', '3', '11', 'JL. P. MADURA',
                '2026-03-15', '11.0', '82.0', '13.8', '47.5',
                'Berdiri', '', '', 'Campak MR',
            ],
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // BOM UTF-8 agar Excel baca dengan benar
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
