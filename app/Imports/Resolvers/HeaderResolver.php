<?php

namespace App\Imports\Resolvers;

/**
 * Responsible for:
 * 1. Detecting the header row index inside a raw 2-D data array.
 * 2. Normalizing raw header strings to clean snake_case keys.
 * 3. Building a column-index map that also resolves known column aliases.
 */
class HeaderResolver
{
    /**
     * Known aliases for canonical column names.
     * Key = canonical name; value = list of acceptable alternatives.
     *
     * @var array<string, list<string>>
     */
    private const ALIASES = [
        'nama_anak' => ['nama', 'full_name', 'nama_lengkap', 'nama_balita', 'nama_bayi', 'nama_anak'],
        'nik' => ['nomor_nik', 'no_nik', 'nik_balita', 'nomor_induk_kependudukan', 'id_number', 'nik_16_digit'],
        'tgl_lahir' => ['tanggal_lahir', 'birth_date', 'tgl_lahir_anak'],
        'jk' => [
            'jenis_kelamin', 'gender', 'kelamin', 'l_p', 'lp', 'p_l', 'pl', 'sex',
            'jns_kelamin', 'jns_kel', 'jnskel', 'jeniskelamin', 'jk',
            'jenis_kelamin_l_p', 'jenis_kelamin_laki_laki_perempuan',
            'laki_perempuan', 'laki_laki_perempuan', 'l_p_laki_laki_perempuan',
            'jns_kelamin_l_p', 'jns_kelamin_laki_laki_perempuan',
            'jenis_kelamin_l_p_laki_laki_perempuan', 'l/p', 'p/l', 'm/f', 'f/m', 'Jenis_Kelamin', 'Jenis Kelamin',
        ],
        'nm_ortu' => ['nama_ortu', 'parent_name', 'orang_tua', 'nama_orang_tua'],
        'tanggal_ukur' => ['tgl_ukur', 'tanggalukur', 'tanggal_periksa', 'tgl_periksa'],
        'berat' => ['berat_badan', 'bb', 'weight', 'bb_kg', 'bb_dalam_kg'],
        'tinggi' => ['tinggi_badan', 'tb', 'height', 'panjang', 'tb_cm', 'tb_dalam_cm'],
        'lingkar_kepala' => ['lk', 'head_circumference', 'lingkarkepala'],
        'vitamin' => ['vitamin_a', 'vita', 'vit_a'],
        'imunisasi' => ['immunization', 'vaksin', 'vaksinasi', 'vaccination', 'vax',
            'suntik anak',
            'suntik imun',
            'imunisasi dasar',
            'booster',
            'bias',
            'bpi'],
        'category' => ['category', 'kategori', 'tipe', 'type', 'golongan', 'status_warga'],
        'husband_name' => ['husband_name', 'nama_suami', 'suami', 'nm_suami'],
        'measurement_method' => ['measurement_method', 'cara_ukur', 'cara ukur', 'metode_ukur', 'posisi_ukur'],
        'upper_arm_circumference' => ['upper_arm_circumference', 'lila', 'lingkar_lengan', 'lingkar_lengan_atas'],
        'father_name' => ['father_name', 'nama_ayah', 'ayah', 'nama_ayah_kandung', 'nm_ayah'],
        'mother_name' => ['mother_name', 'nama_ibu', 'ibu', 'nama_ibu_kandung', 'nm_ibu'],
        'place_of_birth' => ['place_of_birth', 'tempat_lahir', 'tmp_lahir', 'kota_lahir'],
        'phone_number' => ['phone_number', 'no_telp', 'no_hp', 'whatsapp', 'telepon', 'telp'],
        'rt_domisili' => ['rt_domisili', 'rt', 'rt_dom'],
        'dusun_rt_rw' => ['dusun_rt_rw', 'rw', 'dusun', 'rw_domisili', 'rw_dom'],
        'rt_rw' => ['rt_rw', 'rt/rw', 'rtrw'],
        'historical_diseases' => ['historical_diseases', 'riwayat_penyakit', 'riwayat_penyakit_keluarga', 'penyakit', 'riwayat_kesehatan'],
        'is_pregnant' => ['is_pregnant', 'apakah_hamil', 'hamil', 'status_kehamilan'],
        'umur' => ['umur', 'age', 'usia'],
        'umur_bulan' => ['umur_bulan', 'umur_dalam_bulan', 'usia_bulan'],
        'blood_sugar' => ['gds', 'gula_darah', 'gula_darah_sewaktu', 'blood_sugar', 'gula'],
        'uric_acid' => ['asam_urat', 'uric_acid', 'asamurat'],
        'cholesterol' => ['kolesterol', 'cholesterol', 'chol'],
        // Field registrasi warga baru
        'mother_nik' => ['mother_nik', 'nik_ibu', 'nik_ibu_kandung', 'NIK_ibu', 'nik_mother'],
        'kia_book_ownership' => ['kia_book_ownership', 'kepemilikan_buku_kia', 'buku_kia', 'memiliki_kia'],
        'weight_at_birth' => ['weight_at_birth', 'bb_lahir', 'BB_lahir', 'berat_lahir', 'berat_badan_lahir'],
        'height_at_birth' => ['height_at_birth', 'pb_lahir', 'PB_lahir', 'tinggi_lahir', 'panjang_lahir', 'panjang_badan_lahir'],
        'desa_kelurahan' => ['desa_kelurahan', 'desa', 'kelurahan', 'village'],
        'kecamatan' => ['kecamatan', 'district', 'kec'],
        // Field khusus Lansia
        'waist_circumference' => ['lingkar_perut', 'waist_circumference', 'abdominal_circumference', 'lp', 'lingkar_abdomen'],
        'blood_pressure' => ['tekanan_darah', 'blood_pressure', 'td', 'tensi_darah'],
        'eye_test' => ['tes_mata', 'eye_test', 'pemeriksaan_mata', 'visus'],
        'ear_test' => ['tes_telinga', 'ear_test', 'pemeriksaan_telinga', 'pendengaran'],
        'puma_screening' => ['skrining_puma', 'puma_screening', 'puma', 'skrining_puma_lansia'],
        'mental_screening' => ['skrining_jiwa', 'mental_screening', 'jiwa', 'kesehatan_jiwa'],
        'tbc_screening_status' => ['skrining_tbc', 'tbc_screening_status', 'tbc', 'skrining_tb'],
        'contraception' => ['kontrasepsi', 'contraception', 'kb', 'alat_kontrasepsi'],
        'education' => ['edukasi', 'education', 'penyuluhan', 'catatan_edukasi'],
        'referral_type' => ['rujuk', 'referral_type', 'rujukan', 'catatan_rujukan'],
        'risk_behaviors' => ['perilaku_berisiko', 'risk_behaviors', 'perilaku_risiko'],
        'family_disease_history' => ['riwayat_penyakit_keluarga', 'family_disease_history', 'penyakit_keluarga'],
        'imt' => ['imt', 'bmi', 'indeks_massa_tubuh'],

        // Field tambahan Balita & Umum
        'kpsp_status' => ['kpsp_status', 'kpsp', 'status_perkembangan'],
        'tbc_screening_lethargy' => ['tbc_screening_lethargy', 'lesu', 'skrining_tbc_lesu'],
        'tbc_screening_lumps' => ['tbc_screening_lumps', 'benjolan', 'skrining_tbc_benjolan'],
        'is_exclusive_breastfeeding' => ['is_exclusive_breastfeeding', 'asi_eksklusif', 'asi_saja'],
        'mp_asi' => ['mp_asi', 'mpasi', 'makanan_pendamping_asi'],
        'deworming_medicine' => ['deworming_medicine', 'obat_cacing', 'obat_cacing_diberikan'],
        'is_basic_immunization_complete' => ['is_basic_immunization_complete', 'imunisasi_dasar_lengkap', 'idl', 'imunisasi_lengkap'],
        'pmt_given' => ['pmt_given', 'pmt', 'pemberian_makanan_tambahan'],
        'counseling_notes' => ['counseling_notes', 'catatan_penyuluhan', 'konseling'],
        'complaint' => ['complaint', 'keluhan', 'keluhan_utama'],
        'disease_history' => ['disease_history', 'riwayat_sakit', 'penyakit_sekarang'],
        'health_note' => ['health_note', 'catatan_kesehatan', 'catatan_medis'],
        
        // Pregnancy Details
        'pregnancy_number' => ['pregnancy_number', 'anak_ke', 'kehamilan_ke', 'anak_ke_'],
        'pregnancy_spacing' => ['pregnancy_spacing', 'jarak_kehamilan', 'jarak_kehamilan_sebelumnya'],
        'starting_weight' => ['starting_weight', 'berat_badan_awal', 'bb_awal', 'bb_sebelum_hamil'],
        'starting_height' => ['starting_height', 'tinggi_badan_awal', 'tb_awal'],
        'delivery_date' => ['delivery_date', 'tanggal_bersalin', 'hpl', 'tanggal_hpl'],
        'delivery_method' => ['delivery_method', 'cara_bersalin', 'metode_bersalin'],
        
        // ANC details
        'gestational_age' => ['gestational_age', 'usia_kehamilan', 'usia_kehamilan_minggu'],
        'imt_plotting_status' => ['imt_plotting_status', 'plotting_imt', 'plotting_imt_kia', 'status_imt'],
        'lila_plotting_status' => ['lila_plotting_status', 'plotting_lila', 'plotting_lila_kia', 'status_lila'],
        'bp_plotting_status' => ['bp_plotting_status', 'plotting_td', 'plotting_td_kia', 'status_td'],
        'tbc_screening_cough' => ['tbc_screening_cough', 'batuk_terus', 'skrining_tbc_batuk'],
        'tbc_screening_fever' => ['tbc_screening_fever', 'demam_2_minggu', 'demam_lebih_2_minggu', 'skrining_tbc_demam'],
        'tbc_screening_weight_loss' => ['tbc_screening_weight_loss', 'bb_turun', 'bb_turun_2_bulan', 'skrining_tbc_bb_turun'],
        'tbc_screening_contact' => ['tbc_screening_contact', 'kontak_pasien_tbc', 'kontak_tbc', 'skrining_tbc_kontak'],
        'nakes_gives_fe_mms' => ['nakes_gives_fe_mms', 'nakes_beri_ttd_mms', 'nakes_beri_ttd', 'nakes_memberi_tablet_fe'],
        'consumes_fe_mms_regularly' => ['consumes_fe_mms_regularly', 'konsumsi_ttd_mms_rutin', 'konsumsi_ttd_rutin', 'konsumsi_fe_rutin'],
        'nakes_gives_mt_kek' => ['nakes_gives_mt_kek', 'nakes_beri_mt_bumil_kek', 'nakes_beri_mt_kek', 'nakes_memberi_makanan_tambahan'],
        'mt_package_details' => ['mt_package_details', 'komposisi_jumlah_paket', 'detail_paket_mt', 'komposisi_paket'],
        'consumes_mt_kek_regularly' => ['consumes_mt_kek_regularly', 'rutin_konsumsi_mt_bumil_kek', 'rutin_konsumsi_mt_kek', 'konsumsi_mt_rutin'],
        'counseling_topic' => ['counseling_topic', 'topik_penyuluhan', 'materi_penyuluhan', 'topik_konseling'],
        'joins_pregnant_class' => ['joins_pregnant_class', 'ikut_kelas_ibu_hamil', 'kelas_ibu_hamil', 'mengikuti_kelas_ibu_hamil'],
        'anc_referral' => ['anc_referral', 'rujukan_anc', 'catatan_rujukan_anc', 'rujukan'],
        
        // Postpartum details
        'postpartum_period' => ['postpartum_period', 'periode_pemeriksaan_nifas', 'periode_nifas'],
        'postpartum_imt_plotting' => ['postpartum_imt_plotting', 'plotting_imt_nifas', 'imt_nifas'],
        'postpartum_bp_plotting' => ['postpartum_bp_plotting', 'plotting_td_nifas', 'td_nifas'],
        'nakes_gives_vit_a' => ['nakes_gives_vit_a', 'nakes_beri_vit_a', 'nakes_memberi_vitamin_a'],
        'vit_a_capsule_count' => ['vit_a_capsule_count', 'jumlah_kapsul_vit_a', 'jumlah_kapsul_vitamin_a'],
        'consumes_vit_a_regularly' => ['consumes_vit_a_regularly', 'konsumsi_vit_a_rutin', 'konsumsi_vitamin_a_rutin'],
        'is_breastfeeding' => ['is_breastfeeding', 'menyusui', 'apakah_menyusui', 'status_menyusui'],
        'postpartum_kb' => ['postpartum_kb', 'pelayanan_kb_nifas', 'kb_nifas'],
        'postpartum_counseling_topic' => ['postpartum_counseling_topic', 'topik_penyuluhan_nifas', 'penyuluhan_nifas'],
        'postpartum_referral' => ['postpartum_referral', 'catatan_rujukan_nifas', 'rujukan_nifas'],
    ];

    /** Keywords used to detect which row is the header. */
    private const HEADER_KEYWORDS = [
        'nama_anak', 'nama anak', 'nama', 'full_name', 'nik', 'tgl_lahir', 'tgl lahir',
    ];

    // ── Public API ────────────────────────────────────────────────────

    /**
     * Find the first row index that looks like a header row.
     * Returns null when no header can be reliably detected.
     *
     * @param  array<int, array<int, string>>  $rows
     */
    public function findHeaderRowIndex(array $rows): ?int
    {
        foreach ($rows as $i => $row) {
            foreach ($row as $cell) {
                $cellLower = strtolower(trim((string) $cell));
                foreach (self::HEADER_KEYWORDS as $keyword) {
                    if ($cellLower === $keyword || str_contains($cellLower, $keyword)) {
                        return $i;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Normalize raw header strings to clean snake_case identifiers.
     *
     * @param  array<int, string>  $rawHeaders
     * @return array<int, string>
     */
    public function normalizeHeaders(array $rawHeaders): array
    {
        return array_map(function (string $h): string {
            $h = trim($h);
            $h = strtolower($h);
            $h = preg_replace('/[\s\-\.\/]+/', '_', $h);  // spaces/dashes/dots/slashes → _
            $h = preg_replace('/[^a-z0-9_]/', '', $h);   // strip non-alphanumeric

            return trim($h, '_');
        }, $rawHeaders);
    }

    /**
     * Build a column-index map from normalized headers, then patch it
     * by resolving canonical aliases.
     *
     * @param  array<int, string>  $normalizedHeaders
     * @return array<string, int> Map of column name → zero-based column index.
     */
    public function buildColumnMap(array $normalizedHeaders): array
    {
        $map = array_flip($normalizedHeaders);

        foreach (self::ALIASES as $canonical => $alternatives) {
            if (! isset($map[$canonical])) {
                foreach ($alternatives as $alt) {
                    if (isset($map[$alt])) {
                        $map[$canonical] = $map[$alt];
                        break;
                    }
                }
            }
        }
        // Fallback for 'jk' (Jenis Kelamin) using substring match if not matched yet
        if (! isset($map['jk'])) {
            foreach ($normalizedHeaders as $idx => $hdr) {
                if (str_contains($hdr, 'kelamin') || str_contains($hdr, 'gender') || str_contains($hdr, 'l_p') || $hdr === 'lp' || $hdr === 'pl' || $hdr === 'sex') {
                    $map['jk'] = $idx;
                    break;
                }
            }
        }

        return $map;
    }
}
