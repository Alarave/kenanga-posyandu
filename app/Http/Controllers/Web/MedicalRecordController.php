<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRecordRequest;
use App\Imports\PatientImport;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Posyandu;
use App\Services\ActivityLogService;
use App\Services\MedicalRecordService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Controller untuk mengelola rekam medis pasien
 *
 * Menerapkan prinsip:
 * - Single Responsibility Principle
 * - Dependency Injection
 * - DRY (Don't Repeat Yourself)
 */
class MedicalRecordController extends Controller
{
    private MedicalRecordService $medicalRecordService;

    /**
     * Constructor dengan dependency injection
     */
    public function __construct(MedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;
    }

    /**
     * Tampilkan daftar rekam medis
     */
    public function index(): View
    {
        $this->authorize('viewAny', MedicalRecord::class);

        $medicalRecords = MedicalRecord::with(['patient', 'user'])
            ->accessibleBy(auth()->user())
            ->latest('visit_date')
            ->paginate(10);

        return view('livewire.admin.medical-record-management.index', compact('medicalRecords'));
    }

    /**
     * Tampilkan form pembuatan rekam medis baru
     */
    public function create(): View
    {
        $this->authorize('create', MedicalRecord::class);

        if (! request()->has('category')) {
            return view('livewire.admin.medical-record-management.select-category');
        }

        $patients = $this->getAvailablePatients();

        $category = request('category');
        if ($category === 'balita') {
            $patients = $patients->filter(fn ($p) => in_array($p->category, ['bayi', 'baduta', 'balita', 'anak_sekolah']));
        } elseif ($category === 'ibu_hamil') {
            $patients = $patients->filter(fn ($p) => $p->category === 'ibu_hamil');
        } elseif ($category === 'lansia') {
            $patients = $patients->filter(fn ($p) => $p->category === 'lansia');
        }

        $selectedPatient = request()->has('patient_id') ? Patient::find(request('patient_id')) : null;

        $duplicateWarnings = $this->checkDuplicateWarnings(
            request()->get('patient_id'),
            null,
            null
        );

        return view('livewire.admin.medical-record-management.create', compact('patients', 'duplicateWarnings', 'selectedPatient'));
    }

    /**
     * Simpan rekam medis baru
     */
    public function store(MedicalRecordRequest $request): RedirectResponse
    {
        $this->authorize('create', MedicalRecord::class);

        try {
            $this->medicalRecordService->createRecord($request->validated(), auth()->user());

            return redirect()
                ->route('admin.medical-records.index')
                ->with('success', 'Rekam medis berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan rekam medis: '.$e->getMessage(), [
                'user_id' => auth()->id(),
                'patient_id' => $request->patient_id,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan rekam medis: '.$e->getMessage());
        }
    }

    /**
     * Tampilkan detail rekam medis
     */
    public function show(MedicalRecord $medicalRecord): View
    {
        $this->authorize('view', $medicalRecord);

        $medicalRecord->load(['patient', 'user', 'childDevelopment']);

        return view('livewire.admin.medical-record-management.details', compact('medicalRecord'));
    }

    /**
     * Tampilkan form edit rekam medis
     */
    public function edit(MedicalRecord $medicalRecord): View
    {
        $this->authorize('update', $medicalRecord);

        $medicalRecord->load('childDevelopment');

        $patients = $this->getAvailablePatients();
        $duplicateWarnings = $this->checkDuplicateWarnings(
            $medicalRecord->patient_id,
            $medicalRecord->visit_date,
            $medicalRecord->id
        );

        return view('livewire.admin.medical-record-management.update', [
            'record' => $medicalRecord,
            'patients' => $patients,
            'duplicateWarnings' => $duplicateWarnings,
        ]);
    }

    /**
     * Update rekam medis yang sudah ada
     */
    public function update(MedicalRecordRequest $request, MedicalRecord $medicalRecord): RedirectResponse
    {
        $this->authorize('update', $medicalRecord);

        try {
            $this->medicalRecordService->updateRecord($medicalRecord, $request->validated(), auth()->user());

            return redirect()
                ->route('admin.medical-records.index')
                ->with('success', 'Rekam medis berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui rekam medis: '.$e->getMessage(), [
                'user_id' => auth()->id(),
                'record_id' => $medicalRecord->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui rekam medis. Silakan coba lagi.');
        }
    }

    /**
     * Hapus rekam medis
     */
    public function destroy(MedicalRecord $medicalRecord): RedirectResponse
    {
        $this->authorize('delete', $medicalRecord);

        try {
            $this->medicalRecordService->deleteRecord($medicalRecord);

            return redirect()
                ->route('admin.medical-records.index')
                ->with('success', 'Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus rekam medis: '.$e->getMessage(), [
                'user_id' => auth()->id(),
                'record_id' => $medicalRecord->id,
            ]);

            return redirect()
                ->route('admin.medical-records.index')
                ->with('error', 'Gagal menghapus rekam medis. Silakan coba lagi.');
        }
    }

    /**
     * Dapatkan daftar pasien yang tersedia berdasarkan role user
     *
     * @return Collection
     */
    private function getAvailablePatients()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return Patient::with(['medicalRecords'])->orderBy('full_name', 'asc')->get();
        }

        // Admin, Kader, dan Staff hanya bisa akses pasien di posyandu mereka
        return Patient::where('posyandu_id', $user->posyandu_id)
            ->orderBy('full_name', 'asc')
            ->with(['medicalRecords' => function ($q) {
                $q->orderBy('visit_date', 'desc')->limit(2);
            }])
            ->get();
    }

    /**
     * Periksa peringatan duplikasi Vitamin A dan Pill FE
     *
     * @param  Carbon|null  $visitDate
     * @return mixed
     */
    private function checkDuplicateWarnings(
        ?int $patientId = null,
        $visitDate = null,
        ?int $excludeRecordId = null
    ) {
        if (! $patientId) {
            return null;
        }

        return $this->medicalRecordService->getDuplicateWarnings(
            $patientId,
            $visitDate,
            $excludeRecordId
        );
    }

    // ── Import ────────────────────────────────────────────────────────────────

    /**
     * Tampilkan form import rekam medis via CSV/Excel.
     */
    public function importForm(): View
    {
        $this->authorize('create', MedicalRecord::class);

        $posyandus = $this->getAvailablePosyandus();

        return view('livewire.admin.medical-record-management.import', compact('posyandus'));
    }

    /**
     * Proses upload dan import file CSV/Excel rekam medis.
     */
    public function import(Request $request): RedirectResponse
    {
        $this->authorize('create', MedicalRecord::class);

        $request->validate([
            'file' => [
                'required',
                'file',
                'max:5120',
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    if (!in_array($extension, ['csv', 'xlsx', 'xls'])) {
                        $fail('Format file harus CSV, XLSX, atau XLS.');
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

            // Log activity
            $posyandu = Posyandu::find($posyanduId);
            app(ActivityLogService::class)->log(
                'create_medical_record',
                "Import rekam medis: {$import->recordsImported} rekam medis tersimpan, {$import->imported} warga baru, {$import->skipped} dilewati — Posyandu {$posyandu?->name}",
                $posyanduId,
                'MedicalRecord'
            );

            $message = "Import selesai: {$import->recordsImported} rekam medis tersimpan";
            if ($import->imported > 0) {
                $message .= ", {$import->imported} warga baru ditambahkan";
            }
            if ($import->skipped > 0) {
                $message .= ". {$import->skipped} baris dilewati";
            }
            $message .= '.';

            return redirect()
                ->route('admin.medical-records.index')
                ->with('success', $message)
                ->with('import_errors', $import->errors);

        } catch (\Exception $e) {
            Log::error('Medical record import failed: '.$e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Import gagal: '.$e->getMessage());
        }
    }

    /**
     * Download template CSV untuk import rekam medis.
     */
    public function downloadTemplate(Request $request)
    {
        $category = $request->query('category', 'balita');

        $filename = match ($category) {
            'ibu_hamil' => 'template_import_rekam_medis_ibu_hamil.csv',
            'lansia' => 'template_import_rekam_medis_lansia.csv',
            default => 'template_import_rekam_medis_balita.csv',
        };

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $rows = $this->getTemplateRowsForCategory($category);

        return response()->stream(function () use ($rows) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF"); // BOM UTF-8
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, 200, $headers);
    }

    /**
     * Dapatkan posyandu yang tersedia sesuai role user.
     */
    private function getAvailablePosyandus()
    {
        $user = auth()->user();

        return $user->isSuperAdmin()
            ? Posyandu::orderBy('name')->get()
            : Posyandu::where('id', $user->posyandu_id)->get();
    }

    /**
     * Baris template CSV berdasarkan kategori.
     */
    private function getTemplateRowsForCategory(string $category): array
    {
        if ($category === 'ibu_hamil') {
            return [
                ['NIK', 'nama', 'tgl_lahir', 'jk', 'suami', 'tempat_lahir', 'phone_number', 'RT', 'RW', 'ALAMAT', 'apakah_hamil', 'TANGGAL UKUR', 'BERAT', 'TINGGI'],
                ['3275014102920002', 'SITI AMINAH', '1992-02-14', 'P', 'BUDI SANTOSO', 'Bekasi', '082345678901', '5', '11', 'JL. CENDRAWASIH NO. 12', 'Ya', date('Y-m-d'), '65.2', '160.0'],
                ['3275014102920005', 'HANIFAH', '1995-05-20', 'P', 'AGUS WIDODO', 'Jakarta', '082345678902', '3', '11', 'JL. MERPATI NO. 5', 'Ya', date('Y-m-d'), '60.0', '158.0'],
            ];
        }

        if ($category === 'lansia') {
            return [
                ['NIK', 'nama', 'tgl_lahir', 'jk', 'tempat_lahir', 'phone_number', 'RT', 'RW', 'ALAMAT', 'riwayat_penyakit', 'TANGGAL UKUR', 'BERAT', 'TINGGI'],
                ['3275010101500003', 'KARTOSUWIRYO', '1950-01-01', 'L', 'Solo', '085678901234', '2', '11', 'JL. MATARAMAN NO. 45', 'Hipertensi', date('Y-m-d'), '70.0', '165.0'],
                ['3275014101550004', 'SUHARTINI', '1955-08-12', 'P', 'Yogyakarta', '085678901235', '4', '11', 'JL. DUKUH NO. 8', 'Diabetes', date('Y-m-d'), '55.5', '150.0'],
            ];
        }

        // Default: balita / bayi / anak
        return [
            ['NIK', 'nama_anak', 'tgl_lahir', 'jk', 'nm_ortu', 'tempat_lahir', 'phone_number', 'RT', 'RW', 'ALAMAT', 'TANGGAL UKUR', 'BERAT', 'TINGGI', 'lingkar_kepala', 'vitamin', 'Imunisasi'],
            ['3275010608224411', 'A. ZAFRAN UMAR', '2022-08-06', 'L', 'RYAN RAHARJO', 'Jakarta', '081234567890', '4', '11', 'JL. P. NUSANTARA', date('Y-m-d'), '12.5', '85.0', '48.0', 'Ya', 'DPT-HB-Hib 3'],
            ['3275015101220001', 'AISYAH HANIN', '2022-01-11', 'P', 'YUNIAR PRATIWI', 'Bekasi', '081234567891', '3', '11', 'JL. P. MADURA', date('Y-m-d'), '11.0', '82.0', '47.5', '', 'Campak MR'],
        ];
    }
}
