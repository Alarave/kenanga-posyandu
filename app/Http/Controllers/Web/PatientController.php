<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Imports\PatientImport;
use App\Models\Patient;
use App\Models\Pedukuhan;
use App\Models\Posyandu;
use App\Services\ActivityLogService;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService,
        private ActivityLogService $activityLogService
    ) {}

    /**
     * Show the form for creating a new patient.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Patient::class);

        if (! $request->has('category')) {
            return view('livewire.admin.patient-management.select-category');
        }

        $pedukuhans = Pedukuhan::all();
        $posyandus = $this->getAvailablePosyandus();

        return view('livewire.admin.patient-management.create', compact('pedukuhans', 'posyandus'));
    }

    /**
     * Store a newly created patient.
     */
    public function store(PatientRequest $request)
    {
        $this->authorize('create', Patient::class);

        try {
            $this->patientService->createPatient($request->validated(), auth()->user());

            return redirect()->route('admin.patients.index')->with('success', 'Data warga berhasil disimpan.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }

    /**
     * Display the specified patient with medical records history.
     */
    public function show(Patient $patient, Request $request)
    {
        $this->authorize('view', $patient);

        $patient->load([
            'posyandu',
            'medicalRecords' => function ($q) {
                $q->reorder('visit_date', 'asc');
            },
            'medicalRecords.user',
        ]);

        $medicalRecords = $patient->medicalRecords()
            ->with('user')
            ->when($request->history_search, function ($q) use ($request) {
                $q->where(function ($sq) use ($request) {
                    $sq->where('diagnosis', 'like', '%'.$request->history_search.'%')
                        ->orWhere('immunization', 'like', '%'.$request->history_search.'%')
                        ->orWhere('visit_date', 'like', '%'.$request->history_search.'%');
                });
            })
            ->latest('visit_date')
            ->paginate(10)
            ->withQueryString();

        return view('livewire.admin.patient-management.details', compact('patient', 'medicalRecords'));
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient)
    {
        $this->authorize('update', $patient);

        $pedukuhans = Pedukuhan::all();
        $posyandus = $this->getAvailablePosyandus();

        return view('livewire.admin.patient-management.update', compact('patient', 'pedukuhans', 'posyandus'));
    }

    /**
     * Update the specified patient.
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        $this->authorize('update', $patient);

        try {
            $this->patientService->updatePatient($patient, $request->validated(), auth()->user());

            return redirect()->route('admin.patients.index')->with('success', 'Data warga berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified patient.
     */
    public function destroy(Patient $patient)
    {
        $this->authorize('delete', $patient);

        try {
            $this->patientService->deletePatient($patient);

            return redirect()->route('admin.patients.index')->with('success', 'Data warga berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.patients.index')->with('error', 'Gagal menghapus data: '.$e->getMessage());
        }
    }

    /**
     * Show import form.
     */
    public function importForm()
    {
        $this->authorize('create', Patient::class);

        $posyandus = $this->getAvailablePosyandus();

        return view('livewire.admin.patient-management.import', compact('posyandus'));
    }

    /**
     * Process CSV/Excel import.
     */
    public function import(Request $request)
    {
        $this->authorize('create', Patient::class);

        $request->validate([
            'file' => [
                'required',
                'file',
                'max:5120',
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    if (!in_array($extension, ['csv', 'xlsx', 'xls'])) {
                        $fail('Format file harus CSV, XLSX, atau XLS (Excel lama).');
                    }
                }
            ],
            'posyandu_id' => 'required|exists:posyandus,id',
        ], [
            'file.required' => 'File wajib diunggah.',
            'file.max' => 'Ukuran file maksimal 5 MB.',
            'posyandu_id.required' => 'Posyandu wajib dipilih.',
        ]);

        $user = auth()->user();
        $posyanduId = $user->isSuperAdmin() ? (int) $request->posyandu_id : $user->posyandu_id;

        try {
            $import = new PatientImport($posyanduId, $user->id);
            $import->import($request->file('file'));

            $this->logImportActivity($import, $posyanduId);

            return redirect()->route('admin.patients.index')
                ->with('success', $this->buildImportSuccessMessage($import))
                ->with('import_errors', $this->buildImportErrors($import));

        } catch (\Exception $e) {
            \Log::error('Patient import failed: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Import gagal: '.$e->getMessage());
        }
    }

    public function downloadTemplate(Request $request)
    {
        $category = $request->query('category', 'balita');

        $filename = match ($category) {
            'ibu_hamil' => 'template_import_ibu_hamil.csv',
            'lansia' => 'template_import_lansia.csv',
            default => 'template_import_balita.csv',
        };

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $rows = $this->getTemplateRowsForCategory($category);

        return response()->stream(function () use ($rows) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF"); // BOM UTF-8
            fwrite($file, "sep=,\n"); // Force Excel to use comma separator
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, 200, $headers);
    }

    /**
     * Get available posyandus based on user role.
     */
    private function getAvailablePosyandus()
    {
        $user = auth()->user();

        return $user->isSuperAdmin()
            ? Posyandu::orderBy('name')->get()
            : Posyandu::where('id', $user->posyandu_id)->get();
    }

    /**
     * Log import activity.
     */
    private function logImportActivity($import, int $posyanduId): void
    {
        $posyandu = Posyandu::find($posyanduId);

        $this->activityLogService->log(
            'create_patient',
            "Import data warga: {$import->imported} berhasil, {$import->skipped} dilewati — Posyandu {$posyandu?->name}",
            $posyanduId,
            'Patient'
        );
    }

    /**
     * Build success message for import.
     */
    private function buildImportSuccessMessage($import): string
    {
        $message = "Import selesai: {$import->imported} warga berhasil diimpor";

        if ($import->recordsImported > 0) {
            $message .= ", {$import->recordsImported} rekam medis tersimpan";
        }

        $message .= '.';

        if ($import->skipped > 0) {
            $message .= " {$import->skipped} baris dilewati.";
        }

        return $message;
    }

    /**
     * Build errors array for import.
     */
    private function buildImportErrors($import): array
    {
        return $import->errors;
    }

    /**
     * Get template rows for CSV download based on category.
     */
    private function getTemplateRowsForCategory(string $category): array
    {
        if ($category === 'ibu_hamil') {
            return [
                // Baris Header
                [
                    'NIK', 'nama', 'tgl_lahir', 'jk', 'tempat_lahir', 'phone_number',
                    'suami', 'apakah_hamil',
                    'RT', 'RW', 'desa_kelurahan', 'kecamatan', 'ALAMAT',
                ],
                // Baris Contoh
                [
                    '3275011234567890', 'Siti Rahayu', '1995-08-15', 'P', 'Bandung', '08123456789',
                    'Budi Santoso', 'Ya',
                    '003', '001', 'Cigondewah', 'Bandung Barat', 'Jl. Contoh No. 1 RT 003/001',
                ],
            ];
        }

        if ($category === 'lansia') {
            return [
                // Baris Header
                [
                    'NIK', 'nama', 'tgl_lahir', 'jk', 'tempat_lahir', 'phone_number',
                    'RT', 'RW', 'desa_kelurahan', 'kecamatan', 'ALAMAT',
                ],
                // Baris Contoh
                [
                    '3275019876543210', 'Hj. Sumiyati', '1955-03-20', 'P', 'Yogyakarta', '08987654321',
                    '002', '001', 'Mawar', 'Melati', 'Jl. Mawar No. 5 RT 002/001',
                ],
            ];
        }

        // Default: balita / bayi / baduta / anak
        return [
            // Baris Header
            [
                'NIK', 'nama_anak', 'tempat_lahir', 'tgl_lahir', 'jk',
                'ayah', 'ibu', 'BB_lahir', 'PB_lahir', 'NIK_ibu', 'kepemilikan_buku_kia',
                'phone_number', 'RT', 'RW', 'desa_kelurahan', 'kecamatan', 'ALAMAT',
            ],
            // Baris Contoh
            [
                '3275011112223334', 'Anak Sehat', 'Bandung', '2022-06-10', 'L',
                'Budi Santoso', 'Siti Rahayu', '3.2', '50.5', '3275011234567890', '1',
                '08123456789', '003', '001', 'Cigondewah', 'Bandung Barat', 'Jl. Contoh No. 1 RT 003/001',
            ],
        ];
    }
}
