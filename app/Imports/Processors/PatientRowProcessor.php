<?php

namespace App\Imports\Processors;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Services\NutritionCalculatorService;
use Carbon\Carbon;

/**
 * Processes a single data row from an import file:
 *  1. Validates required fields (name, birth date).
 *  2. Detects duplicate patients (by NIK or name + birth date).
 *  3. Creates or updates a Patient record.
 *  4. Creates a MedicalRecord for the row's measurement data (if present).
 *
 * All counters and errors are accumulated and readable after processing.
 */
class PatientRowProcessor
{
    public int $imported = 0;

    public int $skipped = 0;

    public int $recordsImported = 0;

    public array $errors = [];

    private int $posyanduId;

    private int $userId;

    private NutritionCalculatorService $nutritionService;

    public function __construct(int $posyanduId, int $userId)
    {
        $this->posyanduId = $posyanduId;
        $this->userId = $userId;
        $this->nutritionService = app(NutritionCalculatorService::class);
    }

    // ── Public API ────────────────────────────────────────────────────

    /**
     * Process all data rows.
     *
     * @param  array<int, array<int, string>>  $rows
     * @param  array<string, int>  $colMap  Column-name → index map
     */
    public function processRows(array $rows, array $colMap): void
    {
        foreach ($rows as $index => $row) {
            $this->processRow($row, $colMap, $index + 2);
        }
    }

    // ── Row processing ────────────────────────────────────────────────

    public function processSingleRow(array $row, array $colMap, int $rowNum, ?Carbon $customVisitDate = null): void
    {
        $this->processRow($row, $colMap, $rowNum, $customVisitDate);
    }

    private function processRow(array $row, array $colMap, int $rowNum, ?Carbon $customVisitDate = null): void
    {
        $get = $this->makeGetter($row, $colMap);

        // Extract fields
        $nama = $get('nama_anak');
        $nik = $get('nik');
        $tglLahir = $get('tgl_lahir');
        $jk = $get('jk');
        $namaOrtu = $get('nm_ortu');
        // rt and rw: try canonical key first, then fallback to direct key
        $rt = $get('rt_domisili') ?: $get('rt');
        $rw = $get('dusun_rt_rw') ?: $get('rw');
        $alamat = $get('alamat');

        // New fields
        $categoryInput = $get('category');
        $husbandName = $get('husband_name');
        $fatherName = $get('father_name');
        $motherName = $get('mother_name');
        $placeOfBirth = $get('place_of_birth');
        $phoneNumber = $get('phone_number');
        $historicalDiseases = $get('historical_diseases');
        $isPregnantInput = $get('is_pregnant');
        $umur = $get('umur');
        $umurBulan = $get('umur_bulan');
        // Balita-specific registration fields
        $motherNik = $get('mother_nik');
        $kiaBookOwnership = $get('kia_book_ownership');
        $weightAtBirth = $get('weight_at_birth');
        $heightAtBirth = $get('height_at_birth');
        // Location fields
        $desaKelurahan = $get('desa_kelurahan');
        $kecamatan = $get('kecamatan');

        // Medical fields
        $tglUkur = $get('tanggal_ukur');
        $berat = $get('berat');
        $tinggi = $get('tinggi');
        $lingkarKepala = $get('lingkar_kepala');
        $vitamin = $get('vitamin');
        $imunisasi = $get('imunisasi');
        $tensi = $get('tensi');
        $gds = $get('blood_sugar');
        $asamUrat = $get('uric_acid');
        $kolesterol = $get('cholesterol');

        // Validate required fields
        if ($nama === '' && $nik === '') {
            $this->skipped++;

            return;
        }
        if ($nama === '') {
            $this->errors[] = "Baris {$rowNum}: Nama anak kosong, dilewati.";
            $this->skipped++;

            return;
        }

        $birthDate = $this->parseDate($tglLahir);
        if ($birthDate === false) {
            $this->errors[] = "Baris {$rowNum}: Format tanggal lahir '{$tglLahir}' tidak valid untuk '{$nama}'.";
            $this->skipped++;

            return;
        }

        $gender = $this->normalizeGender($jk);
        if ($gender === null) {
            // Gender tidak dikenali — gunakan fallback berdasarkan kategori
            if (in_array(strtolower($categoryInput), ['ibu_hamil', 'hamil', 'pregnant'])) {
                $gender = 'P'; // Ibu hamil pasti perempuan
            } else {
                $this->errors[] = "Baris {$rowNum}: Jenis kelamin '{$jk}' tidak dikenali untuk '{$nama}'. Baris dilewati. (Gunakan L, Laki-laki, MALE, P, Perempuan, FEMALE).";
                $this->skipped++;

                return;
            }
        }

        \Illuminate\Support\Facades\Log::info("PatientImport - Row {$rowNum} parsed:", [
            'name' => $nama,
            'raw_gender_input' => $jk,
            'normalized_gender' => $gender,
            'category_input' => $categoryInput,
        ]);

        $fullAddress = $this->buildAddress($alamat, $rt, $rw);
        $nikClean = preg_replace('/[^0-9]/', '', $nik); // Strip everything except digits
        $hasValidNik = strlen($nikClean) >= 15 && strlen($nikClean) <= 17; // More lenient length check

        if (! $hasValidNik) {
            if ($nik === '') {
                $this->errors[] = "Baris {$rowNum}: NIK kosong untuk '{$nama}'. Sistem otomatis membuatkan NIK sementara.";
            } else {
                $this->errors[] = "Baris {$rowNum}: NIK '{$nik}' tidak sesuai format 16 digit untuk '{$nama}'. Sistem otomatis membuatkan NIK sementara.";
            }
        }

        // Extract extra pregnancy/postpartum fields
        $extraFields = [
            'pregnancy_number' => $get('pregnancy_number') !== '' ? (int) $get('pregnancy_number') : null,
            'pregnancy_spacing' => $get('pregnancy_spacing') ?: null,
            'starting_weight' => $this->parseDecimal($get('starting_weight')),
            'starting_height' => $this->parseDecimal($get('starting_height')),
            'delivery_date' => $this->parseDate($get('delivery_date'))?->format('Y-m-d'),
            'delivery_method' => $get('delivery_method') ?: null,
            
            'gestational_age' => $get('gestational_age') ?: null,
            'upper_arm_circumference' => $this->parseDecimal($get('upper_arm_circumference') ?: $get('lila')),
            'imt_plotting_status' => $get('imt_plotting_status') ?: null,
            'lila_plotting_status' => $get('lila_plotting_status') ?: null,
            'bp_plotting_status' => $get('bp_plotting_status') ?: null,
            
            'tbc_screening_cough' => $get('tbc_screening_cough') !== '' ? $this->parseBool($get('tbc_screening_cough')) : null,
            'tbc_screening_fever' => $get('tbc_screening_fever') !== '' ? $this->parseBool($get('tbc_screening_fever')) : null,
            'tbc_screening_weight_loss' => $get('tbc_screening_weight_loss') !== '' ? $this->parseBool($get('tbc_screening_weight_loss')) : null,
            'tbc_screening_contact' => $get('tbc_screening_contact') !== '' ? $this->parseBool($get('tbc_screening_contact')) : null,
            
            'nakes_gives_fe_mms' => $get('nakes_gives_fe_mms') ?: null,
            'consumes_fe_mms_regularly' => $get('consumes_fe_mms_regularly') ?: null,
            'nakes_gives_mt_kek' => $get('nakes_gives_mt_kek') ?: null,
            'mt_package_details' => $get('mt_package_details') ?: null,
            'consumes_mt_kek_regularly' => $get('consumes_mt_kek_regularly') ?: null,
            'counseling_topic' => $get('counseling_topic') ?: null,
            'joins_pregnant_class' => $get('joins_pregnant_class') ?: null,
            'anc_referral' => $get('anc_referral') ?: null,
            
            'postpartum_period' => $get('postpartum_period') ?: null,
            'postpartum_imt_plotting' => $get('postpartum_imt_plotting') ?: null,
            'postpartum_bp_plotting' => $get('postpartum_bp_plotting') ?: null,
            'nakes_gives_vit_a' => $get('nakes_gives_vit_a') ?: null,
            'vit_a_capsule_count' => $get('vit_a_capsule_count') ?: null,
            'consumes_vit_a_regularly' => $get('consumes_vit_a_regularly') ?: null,
            'is_breastfeeding' => $get('is_breastfeeding') ?: null,
            'postpartum_kb' => $get('postpartum_kb') ?: null,
            'postpartum_counseling_topic' => $get('postpartum_counseling_topic') ?: null,
            'postpartum_referral' => $get('postpartum_referral') ?: null,

            // Field khusus Lansia (Posbindu)
            'waist_circumference' => $this->parseDecimal($get('waist_circumference')),
            'blood_pressure' => $get('blood_pressure') ?: null,
            'eye_test' => $get('eye_test') ?: null,
            'ear_test' => $get('ear_test') ?: null,
            'puma_screening' => $get('puma_screening') ?: null,
            'tbc_screening_status' => $get('tbc_screening_status') ?: null,
            'mental_screening' => $get('mental_screening') ?: null,
            'contraception' => $get('contraception') ?: null,
            'education' => $get('education') ?: null,
            'referral_type' => $get('referral_type') ?: null,
            'risk_behaviors' => $get('risk_behaviors') ?: null,
            'family_disease_history' => $get('family_disease_history') ?: null,
            'imt' => $this->parseDecimal($get('imt')),

            // Field tambahan Balita & Umum
            'kpsp_status' => $get('kpsp_status') ?: null,
            'tbc_screening_lethargy' => $get('tbc_screening_lethargy') !== '' ? $this->parseBool($get('tbc_screening_lethargy')) : null,
            'tbc_screening_lumps' => $get('tbc_screening_lumps') !== '' ? $this->parseBool($get('tbc_screening_lumps')) : null,
            'is_exclusive_breastfeeding' => $get('is_exclusive_breastfeeding') !== '' ? $this->parseBool($get('is_exclusive_breastfeeding')) : null,
            'mp_asi' => $get('mp_asi') !== '' ? $this->parseBool($get('mp_asi')) : null,
            'deworming_medicine' => $get('deworming_medicine') !== '' ? $this->parseBool($get('deworming_medicine')) : null,
            'is_basic_immunization_complete' => $get('is_basic_immunization_complete') !== '' ? $this->parseBool($get('is_basic_immunization_complete')) : null,
            'pmt_given' => $get('pmt_given') ?: null,
            'counseling_notes' => $get('counseling_notes') ?: null,
            'complaint' => $get('complaint') ?: null,
            'disease_history' => $get('disease_history') ?: null,
            'health_note' => $get('health_note') ?: null,
            'measurement_method' => $get('measurement_method') ?: null,
        ];

        try {
            $patient = $this->resolvePatient(
                $hasValidNik, $nikClean, $nama, $birthDate, $namaOrtu, $fullAddress, $gender,
                $categoryInput, $husbandName, $fatherName, $motherName, $placeOfBirth, $phoneNumber,
                $historicalDiseases, $isPregnantInput, $rt, $rw, $umur, $umurBulan,
                $motherNik, $kiaBookOwnership, $weightAtBirth, $heightAtBirth, $desaKelurahan, $kecamatan
            );

            $hasMedicalData = $berat !== '' || $tinggi !== '' || $tensi !== '' || $gds !== '' || $asamUrat !== '' || $kolesterol !== ''
                || collect($extraFields)->filter(fn($v) => $v !== null && $v !== '')->isNotEmpty();

            if ($hasMedicalData) {
                $this->saveMedicalRecord($patient, $berat, $tinggi, $lingkarKepala, $vitamin, $imunisasi, $birthDate, $tglUkur, $gender, $rowNum, $customVisitDate, $tensi, $gds, $asamUrat, $kolesterol, $extraFields);
            }
        } catch (\Exception $e) {
            $this->errors[] = "Baris {$rowNum}: Gagal menyimpan '{$nama}' — ".$e->getMessage();
            $this->skipped++;
        }
    }

    // ── Patient resolution ────────────────────────────────────────────

    private function resolvePatient(
        bool $hasValidNik,
        string $nikClean,
        string $nama,
        ?Carbon $birthDate,
        string $namaOrtu,
        string $fullAddress,
        ?string $gender,
        string $categoryInput = '',
        string $husbandName = '',
        string $fatherName = '',
        string $motherName = '',
        string $placeOfBirth = '',
        string $phoneNumber = '',
        string $historicalDiseases = '',
        string $isPregnantInput = '',
        string $rt = '',
        string $rw = '',
        string $umur = '',
        string $umurBulan = '',
        string $motherNik = '',
        string $kiaBookOwnership = '',
        string $weightAtBirth = '',
        string $heightAtBirth = '',
        string $desaKelurahan = '',
        string $kecamatan = ''
    ): Patient {
        // Resolve birth date from age/umur if missing (crucial for Lansia sheets)
        $resolvedBirthDate = $birthDate;
        if (! $resolvedBirthDate) {
            $umurVal = $this->parseDecimal($umur);
            $umurBulanVal = $this->parseDecimal($umurBulan);
            if ($umurVal !== null && $umurVal > 0) {
                $resolvedBirthDate = now()->subYears((int) $umurVal)->startOfYear();
            } elseif ($umurBulanVal !== null && $umurBulanVal > 0) {
                $resolvedBirthDate = now()->subMonths((int) $umurBulanVal)->startOfMonth();
            } else {
                $resolvedBirthDate = now()->subYears(30)->startOfYear(); // Safe default
            }
        }

        $existing = $this->findExistingPatient($hasValidNik, $nikClean, $nama, $resolvedBirthDate, $namaOrtu);

        // Normalize pregnant status
        $isPregnant = false;
        if ($isPregnantInput !== '') {
            $isPregnant = $this->parseBool($isPregnantInput);
        }

        // Determine category
        $category = $this->normalizeCategory($categoryInput, $resolvedBirthDate, $isPregnant);

        if ($existing) {
            \Illuminate\Support\Facades\Log::info("PatientImport - Existing patient matched (ID {$existing->id}):", [
                'name' => $existing->full_name,
                'db_gender_before' => $existing->gender,
                'incoming_gender' => $gender,
            ]);

            $updateData = [
                'posyandu_id' => $this->posyanduId, // Update posyandu_id to currently selected posyandu
                'full_name' => $nama ?: $existing->full_name, // Update name if present
                'parent_name' => $namaOrtu ?: $existing->parent_name,
                'address' => $fullAddress ?: $existing->address,
                'gender' => $gender ?? $existing->gender,
                'category' => $category,
                'is_pregnant' => $isPregnant ?: $existing->is_pregnant,
                'birth_date' => $resolvedBirthDate, // Sync birth date if it was resolved
            ];

            if ($husbandName !== '') {
                $updateData['husband_name'] = $husbandName;
            }
            if ($fatherName !== '') {
                $updateData['father_name'] = $fatherName;
            }
            if ($motherName !== '') {
                $updateData['mother_name'] = $motherName;
            }
            if ($placeOfBirth !== '') {
                $updateData['place_of_birth'] = $placeOfBirth;
            }
            if ($phoneNumber !== '') {
                $updateData['phone_number'] = $phoneNumber;
            }
            if ($historicalDiseases !== '') {
                $updateData['historical_diseases'] = $historicalDiseases;
            }
            if ($rt !== '') {
                $updateData['rt_domisili'] = $rt;
            }
            if ($rw !== '') {
                $updateData['dusun_rt_rw'] = $rw;
            }
            if ($desaKelurahan !== '') {
                $updateData['desa_kelurahan'] = $desaKelurahan;
            }
            if ($kecamatan !== '') {
                $updateData['kecamatan'] = $kecamatan;
            }
            if ($motherNik !== '') {
                $updateData['mother_nik'] = $motherNik;
            }
            if ($kiaBookOwnership !== '') {
                $updateData['kia_book_ownership'] = $this->parseBool($kiaBookOwnership) ? 1 : 0;
            }
            if ($weightAtBirth !== '') {
                $updateData['weight_at_birth'] = $this->parseDecimal($weightAtBirth);
            }
            if ($heightAtBirth !== '') {
                $updateData['height_at_birth'] = $this->parseDecimal($heightAtBirth);
            }

            // If existing has a placeholder NIK (9999...) and we now have a valid one, update it
            if (str_starts_with($existing->id_number, '9999') && $hasValidNik) {
                $updateData['id_number'] = $nikClean;
            }

            $existing->update($updateData);

            return $existing;
        }

        if (! $hasValidNik) {
            $nikClean = $this->generatePlaceholderNik();
        }

        $createData = [
            'posyandu_id' => $this->posyanduId,
            'id_number' => $nikClean,
            'full_name' => $nama,
            'birth_date' => $resolvedBirthDate,
            'gender' => $gender,
            'category' => $category,
            'parent_name' => $namaOrtu,
            'address' => $fullAddress,
            'phone_number' => $phoneNumber,
            'husband_name' => $husbandName,
            'father_name' => $fatherName,
            'mother_name' => $motherName,
            'place_of_birth' => $placeOfBirth,
            'historical_diseases' => $historicalDiseases,
            'is_pregnant' => $isPregnant,
            'rt_domisili' => $rt,
            'dusun_rt_rw' => $rw,
            'desa_kelurahan' => $desaKelurahan ?: null,
            'kecamatan' => $kecamatan ?: null,
            'mother_nik' => $motherNik ?: null,
            'kia_book_ownership' => $kiaBookOwnership !== '' ? ($this->parseBool($kiaBookOwnership) ? 1 : 0) : null,
            'weight_at_birth' => $weightAtBirth !== '' ? $this->parseDecimal($weightAtBirth) : null,
            'height_at_birth' => $heightAtBirth !== '' ? $this->parseDecimal($heightAtBirth) : null,
        ];

        \Illuminate\Support\Facades\Log::info("PatientImport - Creating new patient:", [
            'name' => $nama,
            'gender' => $gender,
            'category' => $category,
        ]);

        $patient = Patient::create($createData);

        $this->imported++;

        return $patient;
    }

    private function findExistingPatient(
        bool $hasValidNik,
        string $nikClean,
        string $nama,
        ?Carbon $birthDate,
        string $namaOrtu = ''
    ): ?Patient {
        if ($hasValidNik) {
            // NIK is database-wide unique, so check system-wide to avoid duplicate key errors
            $found = Patient::where('id_number_hash', Patient::generateBlindIndex($nikClean))
                ->first();
            if ($found) {
                return $found;
            }
        }

        if ($birthDate instanceof Carbon) {
            // Try exact name match first
            $found = Patient::where('full_name', $nama)
                ->where('birth_date', $birthDate->format('Y-m-d'))
                ->where('posyandu_id', $this->posyanduId)
                ->first();
            if ($found) {
                return $found;
            }

            // Fallback: try normalized name comparison to match spelling variations (e.g. trailing dots, casing, spaces)
            $normalizedNamaInput = $this->normalizeName($nama);
            $candidates = Patient::where('birth_date', $birthDate->format('Y-m-d'))
                ->where('posyandu_id', $this->posyanduId)
                ->get();
            foreach ($candidates as $cand) {
                if ($this->normalizeName($cand->full_name) === $normalizedNamaInput) {
                    return $cand;
                }
            }
        }

        // Fallback 2: Name-based matching within the same posyandu (even if birth date is different/unmatched)
        $normalizedNamaInput = $this->normalizeName($nama);
        $candidatesByName = Patient::where('posyandu_id', $this->posyanduId)->get()->filter(function ($cand) use ($normalizedNamaInput) {
            return $this->normalizeName($cand->full_name) === $normalizedNamaInput;
        });

        if ($candidatesByName->isNotEmpty()) {
            // A. If parent's name matches (normalized)
            if ($namaOrtu !== '') {
                $normalizedOrtuInput = $this->normalizeName($namaOrtu);
                foreach ($candidatesByName as $cand) {
                    if ($cand->parent_name && $this->normalizeName($cand->parent_name) === $normalizedOrtuInput) {
                        return $cand;
                    }
                }
            }

            // B. If no parent matches, or parent name is empty, reuse the first candidate with the same name to prevent duplication
            return $candidatesByName->first();
        }

        return null;
    }

    private function normalizeName(string $name): string
    {
        $name = strtolower($name);

        return preg_replace('/[^a-z0-9]/', '', $name); // Keep only alphanumeric
    }

    // ── Medical record ────────────────────────────────────────────────

    private function saveMedicalRecord(
        Patient $patient,
        string $berat,
        string $tinggi,
        string $lingkarKepala,
        string $vitamin,
        string $imunisasi,
        ?Carbon $birthDate,
        string $tglUkur,
        ?string $gender,
        int $rowNum,
        ?Carbon $customVisitDate = null,
        string $tensi = '',
        string $gds = '',
        string $asamUrat = '',
        string $kolesterol = '',
        array $extraFields = []
    ): void {
        $visitDate = $customVisitDate;
        if (! ($visitDate instanceof Carbon)) {
            $visitDate = $this->parseDate($tglUkur);
            if (! ($visitDate instanceof Carbon)) {
                $visitDate = $this->defaultVisitDate ?? now();
            }
        }

        $weightVal = $this->parseDecimal($berat);
        $heightVal = $this->parseDecimal($tinggi);
        $lkVal = $this->parseDecimal($lingkarKepala);
        $vitaminA = $this->parseBool($vitamin);

        $systolic = null;
        $diastolic = null;
        if ($tensi !== '') {
            $parts = explode('/', $tensi);
            if (count($parts) === 2) {
                $systolic = is_numeric(trim($parts[0])) ? (int) trim($parts[0]) : null;
                $diastolic = is_numeric(trim($parts[1])) ? (int) trim($parts[1]) : null;
            }
        }

        $gdsVal = $this->parseDecimal($gds);
        $asamUratVal = $this->parseDecimal($asamUrat);
        $kolesterolVal = $this->parseDecimal($kolesterol);

        [$zScore, $nutritionStatus] = $this->calcNutrition($weightVal, $heightVal, $birthDate, $visitDate, $gender);

        $existingRecord = MedicalRecord::where('patient_id', $patient->id)
            ->where('visit_date', $visitDate->format('Y-m-d'))
            ->first();

        $recordData = [
            'weight' => $weightVal,
            'height' => $heightVal,
            'head_circumference' => $lkVal,
            'immunization' => $imunisasi,
            'vitamin_a' => $vitaminA,
            'systolic_bp' => $systolic,
            'diastolic_bp' => $diastolic,
            'blood_sugar' => $gdsVal,
            'uric_acid' => $asamUratVal,
            'cholesterol' => $kolesterolVal,
            'z_score' => $zScore,
            'nutrition_status' => $nutritionStatus,
        ];

        // Merge pregnancy / postpartum details if passed
        if (!empty($extraFields)) {
            foreach ($extraFields as $field => $val) {
                if ($val !== null && $val !== '') {
                    $recordData[$field] = $val;
                }
            }
        }

        if ($existingRecord) {
            // Update the existing medical record with new values instead of skipping
            // Clean null values so we don't overwrite existing values with null if not in import
            $filteredData = array_filter($recordData, fn($v) => $v !== null && $v !== '');
            $existingRecord->update($filteredData);
        } else {
            // Create a new medical record
            $newData = array_merge([
                'patient_id' => $patient->id,
                'user_id' => $this->userId,
                'visit_date' => $visitDate->format('Y-m-d'),
                'pill_fe' => false,
                'complaint' => '—',
                'diagnosis' => 'Sehat',
            ], $recordData);
            MedicalRecord::create($newData);
        }

        $this->recordsImported++;
    }

    private function calcNutrition(
        ?float $weight,
        ?float $height,
        ?Carbon $birthDate,
        Carbon $visitDate,
        ?string $gender
    ): array {
        if (! $weight || ! ($birthDate instanceof Carbon)) {
            return [null, null];
        }

        $ageMonths = (int) $birthDate->diffInMonths($visitDate);
        if ($ageMonths < 0 || $ageMonths > 59) {
            return [null, null];
        }

        $result = $this->nutritionService->calculate(
            $weight,
            $height ?? 0,
            $ageMonths,
            $gender ?? 'L'
        );

        return [$result['z_score'], $result['status']];
    }

    // ── Scalar helpers ────────────────────────────────────────────────

    /**
     * Build a getter closure that reads a named column from a row.
     *
     * @param  array<int, string>  $row
     * @param  array<string, int>  $colMap
     */
    private function makeGetter(array $row, array $colMap): \Closure
    {
        return static function (string $key) use ($row, $colMap): string {
            $idx = $colMap[$key] ?? null;
            if ($idx === null) {
                return '';
            }

            $val = $row[$idx] ?? '';

            // Handle scientific notation (e.g. 3.27E+15) commonly found in Excel for NIK
            // We use number_format without decimals to get the full string representation
            if (is_numeric($val) && (str_contains(strtoupper((string) $val), 'E') || strlen((string) $val) >= 15)) {
                $val = number_format((float) $val, 0, '', '');
            }

            return trim((string) $val);
        };
    }

    private function buildAddress(string $alamat, string $rt, string $rw): string
    {
        if ($rt === '' && $rw === '') {
            return $alamat;
        }

        $rtRw = 'RT '.str_pad($rt, 2, '0', STR_PAD_LEFT)
              .' / RW '.str_pad($rw, 2, '0', STR_PAD_LEFT);

        return $alamat !== '' ? "{$alamat}, {$rtRw}" : $rtRw;
    }

    private function parseDate(mixed $value): Carbon|null|false
    {
        if ($value === null || trim((string) $value) === '' || trim((string) $value) === '-') {
            return null;
        }
        $str = trim((string) $value);

        try {
            // Excel serial number (e.g. 44380)
            if (is_numeric($str) && (float) $str > 1000) {
                $unixTs = ((float) $str - 25569) * 86400;

                return Carbon::createFromTimestamp((int) $unixTs)->startOfDay();
            }

            // Custom parse for mixed separator formats like d/m-yy, d/m-yyyy, d-m-yy, etc.
            if (preg_match('/^\s*(\d{1,2})\s*[\/\-\.]\s*(\d{1,2})\s*[\/\-\.]\s*(\d{2,4})\s*$/', $str, $matches)) {
                $day = (int) $matches[1];
                $month = (int) $matches[2];
                $year = (int) $matches[3];

                if ($year < 100) {
                    $currentYear = (int) date('Y');
                    $currentShort = $currentYear % 100;
                    $threshold = $currentShort + 10; // e.g. 36 if current year is 2026

                    if ($year <= $threshold) {
                        $year += 2000;
                    } else {
                        $year += 1900;
                    }
                }

                if (checkdate($month, $day, $year)) {
                    return Carbon::createFromDate($year, $month, $day)->startOfDay();
                }
            }

            // "6 Aug 2022" / "6 August 2022"
            if (preg_match('/^\d{1,2}\s+\w+\s+\d{4}$/', $str)) {
                foreach (['j M Y', 'j F Y', 'd M Y', 'd F Y'] as $fmt) {
                    try {
                        return Carbon::createFromFormat($fmt, $str)->startOfDay();
                    } catch (\Exception) {
                    }
                }
            }

            return Carbon::parse($str)->startOfDay();
        } catch (\Exception) {
            return false;
        }
    }

    private function parseDecimal(string $value): ?float
    {
        $value = trim($value);
        if ($value === '' || $value === '-') {
            return null;
        }
        $clean = str_replace(',', '.', $value);

        return is_numeric($clean) ? (float) $clean : null;
    }

    private function parseBool(string $value): bool
    {
        return in_array(
            strtolower(trim($value)),
            ['1', 'ya', 'yes', 'true', 'v', '✓', 'ada', 'diberikan'],
            true
        );
    }

    private function normalizeGender(string $jk): ?string
    {
        $original = $jk;
        // Trim standard whitespaces and uppercase
        $jk = strtoupper(trim($jk));
        
        // Strip all unicode whitespaces (including NBSP \u{A0}), dashes, dots, underscores, slashes, etc.
        $clean = preg_replace('/[\s\-\.\_\/\\\|]+/u', '', $jk);

        // Exact matches - male
        if (in_array($clean, ['L', 'LK', 'LAKI', 'LAKILAKI', 'MALE', 'M', 'PRIA', 'LAKI2', 'COWOK', 'LAKIILAKI'], true)) {
            return 'L';
        }
        // Exact matches - female
        if (in_array($clean, ['P', 'PR', 'PEREMPUAN', 'FEMALE', 'F', 'WANITA', 'CEWEK', 'WAN', 'PRP'], true)) {
            return 'P';
        }

        // Substring / starts-with matching for longer values
        if (str_starts_with($clean, 'LAKI') || str_starts_with($clean, 'MALE') || str_starts_with($clean, 'PRIA')) {
            return 'L';
        }
        if (str_starts_with($clean, 'PEREMP') || str_starts_with($clean, 'FEMAL') || str_starts_with($clean, 'WANIT')) {
            return 'P';
        }

        // Handle "L/P" or "P/L" type combined values — take the first character
        if (strlen($clean) >= 1) {
            $first = $clean[0];
            if ($first === 'L') {
                return 'L';
            }
            if ($first === 'P') {
                return 'P';
            }
            if ($first === 'M') {
                return 'L';
            } // M = Male
            if ($first === 'F') {
                return 'P';
            } // F = Female
        }

        return null;
    }

    private function generatePlaceholderNik(): string
    {
        do {
            $nik = '9999'
                .str_pad((string) $this->posyanduId, 4, '0', STR_PAD_LEFT)
                .str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        } while (Patient::where('id_number_hash', Patient::generateBlindIndex($nik))->exists());

        return $nik;
    }

    private function normalizeCategory(string $catInput, ?Carbon $birthDate, bool $isPregnant): string
    {
        $cat = strtolower(trim($catInput));
        if (in_array($cat, ['ibu hamil', 'ibu_hamil', 'hamil', 'pregnant']) || $isPregnant) {
            return 'ibu_hamil';
        }
        if (in_array($cat, ['lansia', 'elderly'])) {
            return 'lansia';
        }
        if (in_array($cat, ['balita', 'toddler'])) {
            return 'balita';
        }
        if (in_array($cat, ['bayi', 'baby'])) {
            return 'bayi';
        }
        if (in_array($cat, ['baduta'])) {
            return 'baduta';
        }
        if (in_array($cat, ['anak sekolah', 'anak_sekolah', 'anak'])) {
            return 'anak_sekolah';
        }
        if (in_array($cat, ['remaja', 'teenager'])) {
            return 'remaja';
        }
        if (in_array($cat, ['umum', 'general'])) {
            return 'umum';
        }

        return $this->determineCategory($birthDate);
    }

    /**
     * Menentukan kategori berdasarkan usia anak dalam bulan.
     */
    private function determineCategory(?Carbon $birthDate): string
    {
        if (! $birthDate) {
            return 'umum';
        }

        $ageMonths = (int) $birthDate->diffInMonths(now());

        if ($ageMonths <= 11) {
            return 'bayi';
        }
        if ($ageMonths <= 23) {
            return 'baduta';
        }
        if ($ageMonths <= 59) {
            return 'balita';
        }
        if ($ageMonths <= 119) {
            return 'anak_sekolah';
        } // 5-9 tahun
        if ($ageMonths <= 227) {
            return 'remaja';
        }      // 10-18 tahun
        if ($ageMonths >= 720) {
            return 'lansia';
        }      // 60 tahun+

        return 'umum';
    }
}
