# Implementation Tasks
## Fitur: Penyesuaian Sistem Posyandu (posyandu-system-alignment)

## Tasks

- [x] 1. Persiapan Database & Migrasi
  - [x] 1.1 Buat migration untuk menambah kolom `posyandu_id` (nullable, FK ke posyandus) ke tabel `users`
  - [x] 1.2 Buat migration untuk menambah kolom `z_score` (decimal 5,2) dan `nutrition_trend` (enum: naik/turun/tetap) ke tabel `medical_records`
  - [x] 1.3 Buat migration untuk membuat tabel `activity_logs` (id, user_id, user_name, role, action_type, description, entity_type, entity_id, old_values JSON, new_values JSON, ip_address, created_at — tanpa updated_at)
  - [x] 1.4 Buat migration untuk membuat tabel `who_weight_for_age` (id, gender, age_months, sd_minus3, sd_minus2, median, sd_plus2, sd_plus3)
  - [x] 1.5 Buat `WhoWeightForAgeSeeder` yang mengisi tabel `who_weight_for_age` dengan data referensi WHO/Kemenkes untuk usia 0–59 bulan (laki-laki dan perempuan)
  - [x] 1.6 Jalankan migrasi dan seeder, verifikasi struktur tabel di database

- [x] 2. Model & Relasi
  - [x] 2.1 Update `app/Models/User.php` — tambah `posyandu_id` ke `$fillable`, tambah relasi `posyandu()` (belongsTo), tambah helper method `isKader()` yang return true jika role staff atau medical
  - [x] 2.2 Buat `app/Models/ActivityLog.php` — fillable semua kolom, cast `old_values` dan `new_values` sebagai array, relasi `user()` (belongsTo)
  - [x] 2.3 Buat `app/Models/WhoWeightForAge.php` — fillable semua kolom, static method `getReference(string $gender, int $ageMonths): ?self`
  - [x] 2.4 Update `app/Models/MedicalRecord.php` — tambah `z_score` dan `nutrition_trend` ke `$fillable` dan `$casts`
  - [x] 2.5 Update `app/Models/Patient.php` — tambah scope `scopeByPosyandu(Builder $query, int $posyanduId)` untuk filter berdasarkan posyandu

- [x] 3. Services
  - [x] 3.1 Buat `app/Services/ActivityLogService.php` dengan method `log(string $actionType, string $description, ?int $entityId, ?string $entityType, ?array $oldValues, ?array $newValues): ActivityLog` — ambil user dan IP dari Auth dan Request secara otomatis
  - [x] 3.2 Buat `app/Services/NutritionCalculatorService.php` dengan method `calculateZScore(float $weight, int $ageInMonths, string $gender): ?float` menggunakan data dari tabel `who_weight_for_age`, dan method `classifyNutritionStatus(?float $zScore): string` yang mengembalikan salah satu dari: 'Gizi Lebih', 'Normal', 'Gizi Kurang', 'Gizi Buruk/Stunting', 'Tidak Dapat Dihitung'
  - [x] 3.3 Buat `app/Services/ReportService.php` dengan method `generateMonthlyReport(int $posyanduId, int $month, int $year): array` yang mengumpulkan data kunjungan per kategori, distribusi status gizi, pemberian vitamin A & FE, dan jadwal kegiatan
  - [x] 3.4 Tambahkan method `exportToExcel(array $reportData, string $posyanduName): string` ke `ReportService` menggunakan `maatwebsite/excel` — install package terlebih dahulu via composer
  - [x] 3.5 Tambahkan method `exportToPdf(array $reportData, string $posyanduName): string` ke `ReportService` menggunakan `barryvdh/laravel-dompdf`

- [x] 4. Middleware
  - [x] 4.1 Buat `app/Http/Middleware/SessionTimeout.php` — cek `session('last_activity')`, jika lebih dari 900 detik (15 menit) maka logout user, catat log aktivitas 'auto_logout', dan redirect ke login dengan pesan "Sesi Anda telah berakhir karena tidak aktif."; update `session('last_activity')` pada setiap request yang valid
  - [x] 4.2 Buat `app/Http/Middleware/PosyanduScopeMiddleware.php` — set `app()->instance('current_posyandu_id', auth()->user()?->posyandu_id)` untuk digunakan oleh query scoping
  - [x] 4.3 Daftarkan kedua middleware baru di `bootstrap/app.php` dengan alias `session.timeout` dan `posyandu.scope`
  - [x] 4.4 Update `app/Http/Middleware/CheckUserStatus.php` — pastikan cek `block_expires` sudah berfungsi untuk memblokir akun yang dikunci

- [x] 5. Autentikasi & Keamanan Sesi
  - [x] 5.1 Update `app/Http/Controllers/Auth/LoginController.php` — tambah logika blokir akun setelah 5 kali gagal login (set `block_expires = now() + 15 menit`), tampilkan pesan "Akun sementara dikunci. Coba lagi dalam 15 menit."
  - [x] 5.2 Update `LoginController@login` — setelah login berhasil, reset `attempt_login = 0`, set `session('last_activity', now())`, dan panggil `ActivityLogService::log('login', ...)`
  - [x] 5.3 Update `LoginController@logout` — panggil `ActivityLogService::log('logout', ...)` sebelum logout
  - [x] 5.4 Update `routes/web.php` — tambahkan middleware `session.timeout` dan `posyandu.scope` ke semua route yang memerlukan autentikasi
  - [x] 5.5 Buat Livewire component `app/Livewire/Shared/AutoLogout.php` dengan JavaScript timer 14 menit yang menampilkan modal peringatan "Sesi Anda akan berakhir dalam 1 menit" dan timer 15 menit yang memanggil logout otomatis
  - [x] 5.6 Pasang komponen `<livewire:shared.auto-logout />` di layout utama admin (`resources/views/layouts/app.blade.php` atau layout yang digunakan dashboard)

- [x] 6. Kontrol Akses & Scoping Data Per Posyandu
  - [x] 6.1 Buat `app/Policies/PatientPolicy.php` — method `viewAny`, `view`, `create`, `update`, `delete` yang memvalidasi role dan posyandu_id pengguna vs posyandu_id pasien
  - [x] 6.2 Buat `app/Policies/MedicalRecordPolicy.php` — method `viewAny`, `view`, `create`, `update`, `delete` dengan logika serupa PatientPolicy
  - [x] 6.3 Buat `app/Policies/ActivityLogPolicy.php` — hanya superadmin dan admin yang dapat melihat; hanya superadmin yang dapat menghapus
  - [x] 6.4 Buat `app/Policies/ReportPolicy.php` — superadmin, admin, dan coordinator dapat mengakses dan mengekspor laporan
  - [x] 6.5 Daftarkan semua policy di `app/Providers/AppServiceProvider.php`
  - [x] 6.6 Update `app/Http/Controllers/Web/PatientController.php` — tambahkan `$this->authorize(...)` di setiap method, dan filter query berdasarkan `posyandu_id` pengguna untuk role non-superadmin
  - [x] 6.7 Update `app/Http/Controllers/Web/MedicalRecordController.php` — tambahkan otorisasi dan scoping serupa PatientController
  - [x] 6.8 Update sidebar navigation (`resources/views/components/layouts/app/sidebar.blade.php`) — tampilkan menu berbeda berdasarkan role pengguna menggunakan `@can` atau `@if(auth()->user()->role === ...)`

- [x] 7. Log Aktivitas
  - [x] 7.1 Update `app/Http/Controllers/Web/PatientController.php` — panggil `ActivityLogService::log(...)` di method `store` (create_patient), `update` (update_patient), dan `destroy` (delete_patient) dengan menyertakan old_values dan new_values
  - [x] 7.2 Update `app/Http/Controllers/Web/MedicalRecordController.php` — panggil `ActivityLogService::log(...)` di method `store` dan `update`
  - [x] 7.3 Update `app/Http/Controllers/Web/UserController.php` — panggil `ActivityLogService::log('change_user_access', ...)` saat mengubah role pengguna
  - [x] 7.4 Tambahkan logging 'unauthorized_access' di `RoleMiddleware` dan `PatientPolicy`/`MedicalRecordPolicy` saat akses ditolak
  - [x] 7.5 Buat Livewire component `app/Livewire/Admin/ActivityLogViewer.php` dengan fitur filter (rentang tanggal, jenis aksi, nama pengguna) dan pagination
  - [x] 7.6 Buat view `resources/views/livewire/admin/activity-log-viewer.blade.php` untuk menampilkan tabel log aktivitas
  - [x] 7.7 Tambahkan route `GET /admin/activity-logs` ke `routes/web.php` dengan middleware `role:superadmin,admin`

- [x] 8. Kalkulasi Status Gizi Otomatis
  - [x] 8.1 Update `app/Http/Controllers/Web/MedicalRecordController.php@store` — setelah validasi, ambil data pasien (birth_date, gender), hitung usia dalam bulan, panggil `NutritionCalculatorService::calculate(weight, ageInMonths, gender)`, simpan `z_score` dan `nutrition_status` ke rekam medis
  - [x] 8.2 Update `app/Http/Controllers/Web/MedicalRecordController.php@update` — lakukan kalkulasi ulang status gizi saat data berat badan atau tinggi badan diubah
  - [x] 8.3 Hitung `nutrition_trend` saat menyimpan rekam medis baru — bandingkan `nutrition_status` rekam medis baru dengan rekam medis bulan sebelumnya untuk pasien yang sama
  - [x] 8.4 Update view detail pasien (`resources/views/livewire/admin/patient-management/details.blade.php`) — tampilkan badge status gizi dengan warna: hijau (Normal), kuning (Gizi Kurang/Gizi Lebih), merah (Gizi Buruk/Stunting), dan indikator tren (↑ Naik, ↓ Turun, → Tetap)
  - [x] 8.5 Tambahkan peringatan visual menonjol (banner merah) di halaman detail pasien jika status gizi adalah 'Gizi Buruk/Stunting'

- [x] 9. Visualisasi Grafik Pertumbuhan Balita
  - [x] 9.1 Buat Livewire component `app/Livewire/Admin/PatientManagement/GrowthChart.php` — props: `$patientId`, ambil semua MedicalRecord pasien diurutkan berdasarkan visit_date, siapkan data untuk Chart.js (labels bulan, dataset BB, TB, Lingkar Kepala)
  - [x] 9.2 Buat view `resources/views/livewire/admin/patient-management/growth-chart.blade.php` — render canvas Chart.js dengan tiga dataset (BB, TB, Lingkar Kepala), garis referensi WHO/Kemenkes (SD -3, SD -2, Median, SD +2), dan kode warna titik data sesuai status gizi
  - [x] 9.3 Pasang Chart.js via CDN atau npm di layout admin, pastikan tersedia di halaman detail pasien
  - [x] 9.4 Integrasikan komponen `<livewire:admin.patient-management.growth-chart :patient-id="$patient->id" />` di halaman detail pasien, hanya tampilkan untuk kategori Balita
  - [x] 9.5 Pastikan grafik responsif (min-width 320px) menggunakan opsi `responsive: true` di Chart.js

- [x] 10. Dashboard Statistik
  - [x] 10.1 Update `app/Livewire/Admin/AdminDashboard.php` — tambahkan properties dan computed data: `$totalBalita`, `$totalIbuHamil`, `$jadwalAktif` (jadwal bulan ini), `$kunjunganBaru` (kunjungan bulan ini), `$balitaStunting` (daftar balita dengan status gizi Gizi Buruk/Stunting)
  - [x] 10.2 Implementasikan scoping di AdminDashboard — untuk superadmin tampilkan semua data, untuk coordinator tampilkan data posyandu dalam RW-nya, untuk admin/staff/medical tampilkan data posyandu mereka saja
  - [x] 10.3 Update view `resources/views/livewire/admin/admin-dashboard.blade.php` — tambahkan 4 kartu statistik (Total Balita, Total Ibu Hamil, Jadwal Aktif, Kunjungan Baru), grafik donat status gizi, dan tabel peringatan balita stunting
  - [x] 10.4 Tambahkan grafik tren penimbangan bulanan (Chart.js line chart) di dashboard menggunakan data MedicalRecord 12 bulan terakhir
  - [x] 10.5 Update `app/Http/Controllers/DashboardController.php` — pastikan redirect ke view yang benar berdasarkan role pengguna

- [x] 11. Manajemen Data Sasaran (Validasi & Penyempurnaan)
  - [x] 11.1 Update `app/Http/Requests/PatientRequest.php` — tambahkan validasi: NIK wajib 16 digit angka (`digits:16`), nama lengkap wajib, tanggal lahir wajib dan tidak boleh di masa depan, jenis kelamin wajib (L/P), kategori wajib (balita/ibu_hamil/remaja/lansia), alamat wajib; semua pesan error dalam Bahasa Indonesia
  - [x] 11.2 Update `app/Http/Controllers/Web/PatientController.php@store` — tambahkan validasi unik NIK per posyandu, tampilkan pesan "NIK sudah terdaftar dalam sistem." jika duplikat
  - [x] 11.3 Update view form tambah/edit pasien — tambahkan konfirmasi modal sebelum menghapus pasien dengan pesan "Apakah Anda yakin ingin menghapus data ini? Seluruh riwayat kesehatan terkait juga akan dihapus."
  - [x] 11.4 Pastikan usia pasien dihitung dan ditampilkan otomatis di tabel daftar pasien dan halaman detail menggunakan accessor `getAgeAttribute()` yang sudah ada di model Patient

- [x] 12. Pencatatan Rekam Medis (Validasi & Penyempurnaan)
  - [x] 12.1 Update `app/Http/Requests/MedicalRecordRequest.php` — tambahkan validasi: berat badan antara 0.5–200 kg, tinggi badan antara 30–250 cm, lingkar kepala antara 20–70 cm (nullable), tanggal kunjungan tidak boleh melebihi hari ini; semua pesan error dalam Bahasa Indonesia
  - [x] 12.2 Update view form rekam medis — tampilkan riwayat rekam medis pasien diurutkan dari terbaru ke terlama di halaman detail pasien
  - [x] 12.3 Tambahkan indikator visual di form rekam medis untuk mencegah pemberian Vitamin A atau Pill FE ganda — cek apakah sudah diberikan di bulan yang sama

- [x] 13. Laporan Bulanan & Ekspor
  - [x] 13.1 Install package `maatwebsite/excel` via composer: `composer require maatwebsite/excel`
  - [x] 13.2 Buat `app/Http/Controllers/Web/ReportController.php` dengan method `index` (tampilkan halaman laporan), `generate` (generate preview laporan), `exportExcel` (download .xlsx), `exportPdf` (download .pdf)
  - [x] 13.3 Buat class export `app/Exports/MonthlyReportExport.php` menggunakan `maatwebsite/excel` — sheet berisi: rekapitulasi kunjungan per kategori, distribusi status gizi, daftar pemberian vitamin A & FE
  - [x] 13.4 Buat Blade template PDF `resources/views/reports/monthly-report-pdf.blade.php` untuk digunakan oleh dompdf — format tabel yang rapi dengan header posyandu dan periode laporan
  - [x] 13.5 Buat Livewire component `app/Livewire/Admin/Reports/MonthlyReport.php` — pilih bulan/tahun, preview data laporan, tombol Ekspor Excel dan Ekspor PDF
  - [x] 13.6 Buat view `resources/views/livewire/admin/reports/monthly-report.blade.php`
  - [x] 13.7 Tambahkan routes laporan ke `routes/web.php` dengan middleware `role:superadmin,admin,coordinator`
  - [x] 13.8 Tambahkan menu "Laporan" ke sidebar navigasi admin

- [x] 14. Halaman Publik
  - [x] 14.1 Buat `app/Http/Controllers/Web/PublicController.php` dengan method `home` (beranda), `about` (tentang kami), `contact` (kontak)
  - [x] 14.2 Update `routes/web.php` — ubah route `/` dari redirect ke `PublicController@home`, update route `/about` dan `/contact` ke `PublicController`
  - [x] 14.3 Buat view `resources/views/public/home.blade.php` — tampilkan profil singkat posyandu, jadwal kegiatan terdekat (3 jadwal), dan artikel kesehatan terbaru (3 artikel); gunakan layout publik yang sudah ada
  - [x] 14.4 Buat view `resources/views/public/about.blade.php` — tampilkan visi & misi, struktur organisasi, dan informasi posyandu
  - [x] 14.5 Buat view `resources/views/public/contact.blade.php` — tampilkan informasi kontak posyandu
  - [x] 14.6 Pastikan semua halaman publik tidak menampilkan data pribadi sasaran (NIK, data kesehatan, alamat lengkap)
  - [x] 14.7 Update navigasi publik — pastikan menu Home, Kesehatan/Artikel, Tentang Kami, dan Kontak berfungsi dengan benar

- [x] 15. Antarmuka & Aksesibilitas
  - [x] 15.1 Audit semua label form, pesan error, dan notifikasi — pastikan seluruhnya dalam Bahasa Indonesia
  - [x] 15.2 Audit semua tombol aksi utama (Simpan, Hapus, Ekspor, Login) — pastikan ukuran minimal 44×44 piksel menggunakan Tailwind CSS (`min-h-[44px] min-w-[44px]`)
  - [x] 15.3 Verifikasi alur navigasi — pastikan fitur utama (input data, lihat riwayat, cetak laporan) dapat dicapai dalam maksimal 3 langkah dari dashboard
  - [x] 15.4 Tambahkan halaman error 403 yang ramah pengguna (`resources/views/errors/403.blade.php`) dalam Bahasa Indonesia

- [x] 16. Pengujian (Tests)
  - [x] 16.1 Buat `tests/Unit/Services/NutritionCalculatorServiceTest.php` — uji kalkulasi z-score untuk berbagai usia dan gender, uji klasifikasi status gizi untuk semua kategori, uji sifat deterministik (input sama → output sama selalu), uji edge case (usia 0 bulan, usia 59 bulan, data referensi tidak ditemukan)
  - [x] 16.2 Buat `tests/Unit/Services/ActivityLogServiceTest.php` — uji bahwa log dibuat dengan atribut lengkap, uji bahwa log tidak dapat diubah setelah dibuat
  - [x] 16.3 Buat `tests/Feature/Auth/LoginTest.php` — uji login berhasil, login gagal, blokir setelah 5x gagal, auto-logout setelah 15 menit tidak aktif, log aktivitas dibuat saat login/logout
  - [x] 16.4 Buat `tests/Feature/Admin/PatientManagementTest.php` — uji CRUD pasien, validasi NIK 16 digit, validasi NIK duplikat, scoping data per posyandu (admin hanya lihat data posyanduya), otorisasi per role
  - [x] 16.5 Buat `tests/Feature/Admin/MedicalRecordTest.php` — uji validasi rentang berat/tinggi/lingkar kepala, uji kalkulasi status gizi otomatis saat menyimpan rekam medis, uji validasi tanggal tidak boleh di masa depan
  - [x] 16.6 Buat `tests/Feature/Admin/ReportTest.php` — uji akses laporan per role, uji file Excel dan PDF berhasil dihasilkan, uji log aktivitas dibuat saat ekspor
  - [x] 16.7 Buat `tests/Feature/Public/PublicPageTest.php` — uji semua halaman publik dapat diakses tanpa login, uji halaman publik tidak menampilkan data pribadi sasaran
