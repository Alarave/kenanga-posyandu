# Rencana Desain: Peningkatan Halaman Overview Analytics

Dokumen ini mendokumentasikan rencana peningkatan halaman Overview pada bagian Analytics di Posyandu Kenanga.

## Masalah & Tujuan
Saat ini, halaman Overview di `/admin/analytics` hanya menampilkan 4 kartu KPI utama (kunjungan total, total terdaftar balita, ibu hamil, dan lansia) serta satu grafik tren kunjungan bulanan. Hal ini dinilai kurang memberikan informasi komprehensif bagi kader dan admin untuk mengambil tindakan cepat (actionable insights).

Tujuan dari tugas ini adalah menambahkan empat visualisasi/informasi penting baru di tab Overview:
1. **Target vs Realisasi Kehadiran**: Persentase warga terdaftar yang aktif melakukan kunjungan/pemeriksaan tahun/bulan terpilih.
2. **Ringkasan Status Gizi & Imunisasi Balita**: Status stunting rate dan imunisasi dasar balita langsung terlihat di Overview.
3. **Rangkuman Risiko Kesehatan Lansia & Ibu Hamil**: Metrik vitalitas kesehatan lansia (hipertensi, gula darah tinggi, dll.) dan ibu hamil (risiko KEK, anemia, dll.).
4. **Live Health Alerts Feed**: Panel 5 kasus risiko kesehatan kritis terbaru dari semua periode secara real-time.

---

## Pendekatan Desain UI (Pendekatan A: Grid Dashboard Komprehensif)
Menyusun informasi ke dalam layout grid responsif multi-kolom yang mengelompokkan data analitis di satu sisi dan umpan tindakan cepat kader di sisi lain.

```text
+---------------------------------------------------------------------------------------+
|  [KPI: Total Kunjungan]  [KPI: Balita & Anak]  [KPI: Ibu Hamil]     [KPI: Lansia]     |
+---------------------------------------------------------------------------------------+
|  KOLOM KIRI (Desktop: Span-2)                         | KOLOM KANAN (Desktop: Span-1) |
|                                                       |                               |
|  +-------------------------------------------------+  |  +-------------------------+  |
|  | Card: Realisasi Kehadiran Warga                 |  |  | Card: Rangkuman         |  |
|  | * Balita:     [=============-------] 64% (20/31)|  |  |   Indikator Kesehatan   |  |
|  | * Ibu Hamil:  [=================---] 85% (17/20)|  |  |                         |  |
|  | * Lansia:     [==========----------] 50% (15/30)|  |  | * Balita                |  |
|  +-------------------------------------------------+  |  |   - Stunting: 12.5%     |  |
|                                                       |  |   - Imunisasi: 88.0%    |  |
|  +-------------------------------------------------+  |  | * Ibu Hamil             |  |
|  | Card: Tren Kunjungan Bulanan Gabungan           |  |  |   - Hipertensi: 10.2%   |  |
|  | (Grafik Chart.js)                               |  |  |   - Kepatuhan Fe: 75.0% |  |
|  |                                                 |  |  | * Lansia                |  |
|  |                                                 |  |  |   - Hipertensi: 24.1%   |  |
|  |                                                 |  |  |   - Kolesterol: 18.5%   |  |
|  +-------------------------------------------------+  |  +-------------------------+  |
|                                                       |  |                            |  |
|                                                       |  +-------------------------+  |
|                                                       |  | Card: Kasus Kritis Live |  |
|                                                       |  | 1. Ibu Hamil - Aisyah   |  |
|                                                       |  |    [Anemia (Hb: 9.8)]   |  |
|                                                       |  | 2. Lansia - Budi        |  |
|                                                       |  |    [Hipertensi (150/95)]|  |
|                                                       |  | 3. Balita - Dedi        |  |
|                                                       |  |    [Gizi Buruk]         |  |
|                                                       |  +-------------------------+  |
+---------------------------------------------------------------------------------------+
```

---

## Detail Teknis & Perubahan Kode

### 1. Backend: [Analytics.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Livewire/Admin/Analytics.php)
*   **Property baru**: `public array $liveHealthAlerts = [];`
*   **Method baru**: `loadLiveHealthAlerts()` untuk memproses query kasus berisiko tinggi.
    *   Query mengambil data 5 `MedicalRecord` terbaru di mana pasien terindikasi:
        *   Balita dengan `nutrition_status` / `wasting_status` 'Gizi Buruk' / 'Berat Badan Sangat Kurang' atau `stunting_status` 'Pendek' / 'Sangat Pendek'.
        *   Ibu hamil dengan tensi `>=140/90`, `0 < Hb < 11` (Anemia), atau `0 < LILA < 23.5` (KEK).
        *   Lansia dengan tensi `>=140/90`, gula darah `>=200`, kolesterol `>=200`, atau asam urat `>=7.0`.
    *   Query mematuhi `applyPosyanduScope` berdasarkan admin/kader yang masuk.
    *   Mengabaikan filter waktu (selalu terbaru secara real-time).
*   Memanggil `loadLiveHealthAlerts()` dari dalam `loadData()`.

### 2. Frontend: [analytics.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/analytics.blade.php)
*   Mengubah bagian `@if($activeTab === 'overview')` menjadi layout grid 3 kolom pada desktop (`grid-cols-1 lg:grid-cols-3 gap-6`).
*   Menambahkan komponen kartu visual baru dengan CSS premium:
    *   **Kartu Realisasi Kehadiran Warga**: Progress bar dinamis (misal: hijau jika >=75%, kuning jika 50-74%, merah jika <50%).
    *   **Kartu Rangkuman Indikator**: Daftar statistik kesehatan utama dengan warna badge yang informatif.
    *   **Kartu Live Health Alerts**: List kasus kritis berisiko dengan badge status risiko merah menyala dan tautan instan ke rekam medis pasien terkait.

---

## Rencana Verifikasi
*   **Pengujian Otomatis**: Menjalankan pengujian analitik `tests/Feature/AdminAnalyticsTest.php` untuk memastikan tidak ada fungsionalitas yang rusak.
*   **Pengujian Manual**: Memeriksa tampilan di browser pada berbagai resolusi (desktop dan mobile) untuk memastikan kerapian layout dan efektivitas navigasi tab.
