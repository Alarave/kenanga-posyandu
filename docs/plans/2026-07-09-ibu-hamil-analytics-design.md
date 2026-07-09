# Desain Peningkatan Kartu Analitik Ibu Hamil (Posyandu Kenanga)

**Tanggal:** 2026-07-09  
**Status:** Disetujui oleh User

---

## 1. Latar Belakang & Masalah
Dashboard analitik Ibu Hamil sebelumnya menampilkan data kuantitatif kasus berisiko (misal: jumlah risiko tinggi, kasus anemia, belum menerima TTD) sebagai angka utama. Wording dan visualisasi ini kurang menarik secara teks dan tidak menunjukkan "pencapaian" atau tingkat keberhasilan (achievement) dari program kesehatan posyandu.

## 2. Tujuan Perubahan
*   Mengubah cara penyajian data dengan berfokus pada **pencapaian positif** (skoring kesehatan & pencapaian target) sebagai angka utama.
*   Menyajikan data kasus berisiko sebagai sub-indikator/perhatian (attention) di bagian bawah kartu.
*   Meningkatkan estetika frontend menggunakan micro-progress bar dan visualisasi pill status yang lebih premium.

## 3. Detail Perubahan Komponen & Logika Data

### A. Kartu 1: Tingkat Keamanan Kehamilan (Pregnancy Safety Level)
*   **Sebelumnya:** Menampilkan jumlah ibu berisiko tinggi (`$riskStats['highRisk']`) sebagai angka utama.
*   **Baru:** Menampilkan jumlah ibu berisiko rendah/normal (`$riskStats['normal']`) sebagai angka utama.
*   **Aksentuasi Pencapaian:** Menambahkan badge persentase aman (misal: `60% Aman`) di sudut kanan atas.
*   **Sub-indikator bawah:** Menampilkan jumlah risiko tinggi (misal: `2 Ibu Risiko Tinggi`) sebagai perhatian khusus.

### B. Kartu 2: Indeks Hemoglobin Sehat (Healthy Hb Index)
*   **Sebelumnya:** Menampilkan jumlah kasus anemia (`$anemiaCount`) sebagai angka utama.
*   **Baru:** Menampilkan jumlah ibu dengan kadar Hb normal (`$normalHb` atau total dikurangi anemia) sebagai angka utama.
*   **Aksentuasi Pencapaian:** Menambahkan badge persentase bebas anemia (misal: `80% Bebas Anemia`).
*   **Sub-indikator bawah:** Menampilkan jumlah kasus anemia aktif (misal: `1 Kasus Anemia`) sebagai perhatian khusus.

### C. Kartu 3: Cakupan Suplemen Fe & MMS (Fe/MMS Supplement Coverage)
*   **Sebelumnya:** Menampilkan jumlah ibu yang sudah menerima suplemen (`$ttdStats['received']`) dengan counter statis.
*   **Baru:** Menampilkan persentase cakupan distribusi suplemen (`80%`) sebagai angka utama.
*   **Aksentuasi Pencapaian:** Menambahkan mini progress bar visual di dalam kartu yang merepresentasikan persentase cakupan.
*   **Sub-indikator bawah:** Menampilkan jumlah ibu yang belum menerima suplemen (misal: `Belum Menerima: 1 Ibu`) sebagai atensi untuk dikirimkan intervensi.

---

## 4. Rencana Implementasi Frontend (Tailwind/CSS & Blade)
*   Modifikasi [IbuHamilAnalytics.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/app/Livewire/Admin/Analytics/IbuHamilAnalytics.php) untuk menghitung statistik tambahan seperti persentase cakupan dan jumlah Hb Normal.
*   Modifikasi [ibu-hamil-analytics.blade.php](file:///c:/Users/evaej/Downloads/posyandu-kenangaa/resources/views/livewire/admin/analytics/ibu-hamil-analytics.blade.php) untuk mengimplementasikan elemen visual baru:
    *   Sleek progress bar untuk cakupan TTD.
    *   Warna background & border yang disesuaikan secara dinamis (misal border emerald-200/rose-200 sesuai kondisi data).
    *   Hover effect dan micro-animation untuk menonjolkan interaktivitas.
