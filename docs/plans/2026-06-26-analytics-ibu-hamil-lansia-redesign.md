# Design Doc: Redesign Analytics Ibu Hamil & Lansia (Fokus Rekam Medis)

**Tanggal:** 2026-06-26  
**Status:** Approved  

## 1. Latar Belakang & Tujuan
Dasbor analitik Posyandu pada bagian Ibu Hamil dan Lansia saat ini masih menggunakan perhitungan statis dari profil pasien (`Patient`) dan tidak merefleksikan filter waktu (tahun/bulan) kunjungan secara dinamis. Tujuannya adalah merancang ulang visualisasi grafik dan data analitik agar sepenuhnya bersumber dari kunjungan aktif (`medical_records`) pada periode terpilih untuk menjamin akurasi klinis yang tepat.

## 2. Perubahan Logika Data

### A. Ibu Hamil Analytics
* **Populasi Aktif**: Filter rekam medis (`medical_records`) sesuai Tahun, Bulan, dan Posyandu terpilih untuk kategori pasien `ibu_hamil`.
* **Trimester**: Klasifikasi `gestational_age` dari rekam medis terbaru masing-masing pasien di periode terpilih:
  * Trimester I: 1 - 13 minggu
  * Trimester II: 14 - 27 minggu
  * Trimester III: >= 28 minggu
* **Risiko 4T**: Diambil dari data umur pasien dan tinggi badan (`height` < 145 cm) pada rekam medis di periode tersebut.
* **Kasus Anemia**: Rekam medis periode terpilih dengan `hemoglobin < 11`.
* **Kekurangan Energi Kronis (KEK)**: Rekam medis periode terpilih dengan lingkar lengan atas (`upper_arm_circumference` / LiLA) < 23.5 cm.
* **Kepatuhan TTD (Tablet Fe)**: Persentase rekam medis dengan `nakes_gives_fe_mms = 1`.
* **Kepatuhan ANC**: Jumlah rekam medis kumulatif per pasien (K1 - K6).

### B. Lansia Analytics
* **Populasi Aktif**: Filter rekam medis kategori `lansia` sesuai Tahun, Bulan, dan Posyandu terpilih.
* **Kategori Usia**: Umur pasien saat kunjungan di periode terpilih:
  * Pra-Lansia: 45 - 59 tahun
  * Lansia: 60 - 69 tahun
  * Lansia Risti: >= 70 tahun
* **IMT (Indeks Massa Tubuh)**: Dihitung dari `weight` and `height` rekam medis terbaru lansia di periode terpilih:
  * Kurang: IMT < 18.5
  * Normal: 18.5 <= IMT < 25
  * Lebih: 25 <= IMT < 27
  * Obesitas: IMT >= 27
* **Kemandirian**: Mengambil status `independence_status` dari profil lansia yang berkunjung di periode terpilih.
* **Kasus Risiko Metabolik**:
  * Hipertensi: `systolic_bp >= 140` atau `diastolic_bp >= 90`
  * Gula Darah: `blood_sugar >= 200`
  * Kolesterol: `cholesterol >= 200`
  * Asam Urat: `uric_acid >= 7.0`

## 3. Proposal Visual UI/UX & Chart
* **Ibu Hamil**:
  * Card grid 4 kolom: Risiko Tinggi (4T), Kasus Anemia, Pemberian Tablet Fe, Risiko KEK.
  * Bagan visual horizontal bar untuk Trimester.
  * Step-down flow progress untuk kepatuhan ANC K1-K6.
  * Line Chart dengan efek area gradasi untuk tren Fe vs Hipertensi.
* **Lansia**:
  * Card grid 4 kolom untuk masing-masing risiko metabolik (Hipertensi, Gula Darah, Kolesterol, Asam Urat).
  * Panel progress horizontal bar untuk Usia, IMT, dan Kemandirian.
  * Rounded Bar Chart untuk komparasi kasus metabolik tahunan.
