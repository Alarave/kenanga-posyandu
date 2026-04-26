# Dokumen Persyaratan
## Fitur: Penyesuaian Sistem Posyandu dengan SRS (posyandu-system-alignment)

## Pendahuluan

Fitur ini mencakup serangkaian penyesuaian dan penambahan pada sistem `posyandu-admin-dashboard` (Laravel + Livewire + Tailwind CSS) agar sepenuhnya sesuai dengan **SRS Sistem Pengelolaan Data Posyandu Bekasi Timur**. Kode yang sudah ada memiliki fondasi model data yang baik (`Patient`, `MedicalRecord`, `User`, `Posyandu`, `Pedukuhan`, `Schedule`, `Gallery`, `Article`), namun terdapat sejumlah kesenjangan fungsional dan non-fungsional yang perlu dipenuhi.

Penyesuaian meliputi: pemetaan ulang role pengguna, penambahan log aktivitas, auto-logout, kalkulasi status gizi otomatis, visualisasi grafik pertumbuhan, ekspor laporan, statistik dashboard, halaman publik, pembatasan akses data per unit posyandu, dan antarmuka yang ramah pengguna usia 50+.

---

## Glosarium

- **Sistem**: Aplikasi web `posyandu-admin-dashboard` berbasis Laravel + Livewire + Tailwind CSS.
- **Admin_RW**: Pengguna dengan role `coordinator` — koordinator tingkat RW, memiliki akses baca lintas posyandu dalam satu wilayah RW.
- **Admin_Posyandu**: Pengguna dengan role `admin` atau `superadmin` — memiliki akses penuh (CRUD) terhadap data unit posyandu yang dikelolanya.
- **Kader**: Pengguna dengan role `staff` atau `medical` — memiliki akses terbatas: input data penimbangan dan melihat data warga binaan.
- **Publik**: Pengguna tanpa autentikasi — hanya dapat mengakses halaman informasi publik.
- **Sasaran**: Warga yang terdaftar sebagai peserta posyandu, terdiri dari empat kategori: Balita, Ibu_Hamil, Remaja, dan Lansia.
- **Balita**: Anak usia 0–59 bulan yang terdaftar sebagai sasaran posyandu.
- **Rekam_Medis**: Catatan hasil pemeriksaan kesehatan satu kunjungan, tersimpan dalam model `MedicalRecord`.
- **Status_Gizi**: Klasifikasi kondisi gizi Balita berdasarkan standar WHO/Kemenkes (Normal, Waspada, Gizi_Buruk/Stunting).
- **Grafik_Pertumbuhan**: Visualisasi perkembangan Berat Badan, Tinggi Badan, dan Lingkar Kepala Balita dari waktu ke waktu.
- **Log_Aktivitas**: Catatan digital setiap aksi kritis yang dilakukan pengguna terautentikasi.
- **Laporan_Bulanan**: Rekapitulasi data kunjungan dan kesehatan seluruh Sasaran dalam satu bulan kalender.
- **NIK**: Nomor Induk Kependudukan — identitas unik warga Indonesia (16 digit).
- **KMS**: Kartu Menuju Sehat — kartu pemantauan pertumbuhan Balita yang digantikan oleh sistem digital ini.
- **PMT**: Pemberian Makanan Tambahan — program suplementasi gizi untuk Balita dan Ibu_Hamil.
- **Vitamin_A**: Suplemen vitamin A yang didistribusikan dua kali setahun (Februari dan Agustus).
- **Pill_FE**: Tablet tambah darah (zat besi) untuk Ibu_Hamil dan Remaja putri.
- **Pedukuhan**: Satuan wilayah administratif di bawah kelurahan tempat posyandu beroperasi.
- **Auto_Logout**: Mekanisme penghentian sesi otomatis setelah periode tidak aktif tertentu.
- **Ekspor**: Proses mengunduh data laporan dalam format berkas digital (Excel atau PDF).

---

## Persyaratan

---

### Persyaratan 1: Pemetaan Role Pengguna

**User Story:** Sebagai Admin_Posyandu, saya ingin sistem memiliki role yang terdefinisi jelas sesuai SRS, agar setiap pengguna hanya dapat mengakses fitur yang sesuai dengan tanggung jawabnya.

#### Kriteria Penerimaan

1. THE Sistem SHALL memetakan role `superadmin` dan `admin` sebagai Admin_Posyandu dengan hak akses penuh (CRUD) terhadap seluruh data unit posyandu yang dikelolanya.
2. THE Sistem SHALL memetakan role `coordinator` sebagai Admin_RW dengan hak akses baca (read-only) terhadap data seluruh posyandu dalam wilayah RW yang dikoordinasinya.
3. THE Sistem SHALL memetakan role `staff` dan `medical` sebagai Kader dengan hak akses input data penimbangan dan melihat data Sasaran pada posyandu yang ditugaskan.
4. THE Sistem SHALL memetakan akses tanpa autentikasi sebagai Publik yang hanya dapat mengakses halaman informasi publik.
5. WHEN seorang pengguna mencoba mengakses halaman yang tidak sesuai dengan rolenya, THE Sistem SHALL menampilkan halaman error 403 (Akses Ditolak) dan mencatat percobaan akses tersebut dalam Log_Aktivitas.
6. THE Sistem SHALL menampilkan menu navigasi yang berbeda untuk setiap role, hanya menampilkan fitur yang diizinkan untuk role tersebut.

---

### Persyaratan 2: Autentikasi dan Keamanan Sesi

**User Story:** Sebagai Admin_Posyandu, saya ingin sistem memiliki mekanisme autentikasi yang aman, agar data warga terlindungi dari akses tidak sah.

#### Kriteria Penerimaan

1. WHEN seorang pengguna memasukkan email dan password yang valid, THE Sistem SHALL mengautentikasi pengguna dan mengarahkan ke dashboard sesuai rolenya dalam waktu kurang dari 3 detik.
2. WHEN seorang pengguna memasukkan email atau password yang tidak valid, THE Sistem SHALL menampilkan pesan kesalahan "Email atau password tidak valid" tanpa mengungkap informasi spesifik tentang akun.
3. THE Sistem SHALL menyimpan password pengguna menggunakan algoritma hashing bcrypt atau Argon2 dan tidak pernah menyimpan password dalam bentuk teks biasa.
4. WHILE seorang pengguna terautentikasi tidak melakukan aktivitas apapun selama 15 menit, THE Sistem SHALL secara otomatis mengakhiri sesi (Auto_Logout) dan mengarahkan ke halaman login dengan pesan "Sesi Anda telah berakhir karena tidak aktif."
5. WHEN seorang pengguna berhasil login, THE Sistem SHALL mencatat Log_Aktivitas yang memuat: ID pengguna, nama pengguna, role, waktu login, dan alamat IP.
6. WHEN seorang pengguna berhasil logout, THE Sistem SHALL mencatat Log_Aktivitas yang memuat: ID pengguna, nama pengguna, waktu logout.
7. IF seorang pengguna gagal login sebanyak 5 kali berturut-turut, THEN THE Sistem SHALL memblokir percobaan login dari akun tersebut selama 15 menit dan menampilkan pesan "Akun sementara dikunci. Coba lagi dalam 15 menit."

---

### Persyaratan 3: Log Aktivitas Kritis

**User Story:** Sebagai Admin_Posyandu, saya ingin setiap aksi penting tercatat secara otomatis, agar ada jejak audit yang dapat diperiksa jika terjadi kesalahan atau penyalahgunaan data.

#### Kriteria Penerimaan

1. THE Sistem SHALL mencatat Log_Aktivitas untuk setiap aksi kritis berikut: login, logout, penambahan data Sasaran, perubahan data Sasaran, penghapusan data Sasaran, penambahan Rekam_Medis, perubahan Rekam_Medis, ekspor laporan, dan perubahan hak akses pengguna.
2. THE Sistem SHALL menyimpan setiap entri Log_Aktivitas dengan atribut: ID log, ID pengguna, nama pengguna, role, jenis aksi, deskripsi aksi, ID entitas yang terpengaruh, waktu aksi (timestamp), dan alamat IP.
3. WHEN Admin_Posyandu mengakses halaman log aktivitas, THE Sistem SHALL menampilkan daftar Log_Aktivitas yang dapat difilter berdasarkan: rentang tanggal, jenis aksi, dan nama pengguna.
4. THE Sistem SHALL menyimpan Log_Aktivitas selama minimal 12 bulan sebelum dapat dihapus oleh superadmin.
5. WHEN sebuah entri Log_Aktivitas berhasil dibuat, THE Sistem SHALL memastikan entri tersebut tidak dapat diubah atau dihapus oleh pengguna dengan role selain superadmin.

---

### Persyaratan 4: Pembatasan Akses Data Per Unit Posyandu

**User Story:** 
- Sebagai Superadmin, saya ingin dapat melihat seluruh data dari semua unit posyandu, sehingga saya bisa melakukan monitoring secara menyeluruh.
- Sebagai Admin_Posyandu, saya ingin hanya dapat mengakses data dari unit posyandu yang saya kelola, sehingga data tetap terisolasi dan aman.

#### Kriteria Penerimaan

1. WHEN pengguna dengan role `superadmin` mengakses daftar Sasaran, THE Sistem SHALL menampilkan seluruh data Sasaran dari semua unit posyandu tanpa pembatasan.
2. WHEN pengguna dengan role `superadmin` mengakses daftar Rekam_Medis, THE Sistem SHALL menampilkan seluruh Rekam_Medis dari semua unit posyandu tanpa pembatasan.
3. WHEN pengguna dengan role `superadmin` melakukan operasi CRUD (Create, Read, Update, Delete) pada data posyandu, THE Sistem SHALL mengizinkan operasi tersebut pada semua unit posyandu.
4. WHEN Admin_Posyandu mengakses daftar Sasaran, THE Sistem SHALL hanya menampilkan Sasaran yang terdaftar pada unit posyandu yang dikelola oleh Admin_Posyandu tersebut berdasarkan relasi `posyandu_id`.
5. WHEN Admin_Posyandu mengakses daftar Rekam_Medis, THE Sistem SHALL hanya menampilkan Rekam_Medis yang terkait dengan Sasaran pada unit posyandu yang dikelola oleh Admin_Posyandu tersebut.
6. WHEN Admin_Posyandu melakukan operasi CRUD pada data Sasaran atau Rekam_Medis, THE Sistem SHALL membatasi operasi tersebut hanya pada data yang terkait dengan unit posyandu yang dikelola oleh Admin_Posyandu tersebut.
7. WHEN Kader mengakses daftar Sasaran, THE Sistem SHALL hanya menampilkan Sasaran yang terdaftar pada posyandu tempat Kader tersebut ditugaskan berdasarkan relasi `posyandu_id`.
8. WHEN Kader melakukan input atau update Rekam_Medis, THE Sistem SHALL membatasi operasi tersebut hanya pada Sasaran yang terdaftar pada posyandu tempat Kader tersebut ditugaskan.
9. WHEN Admin_RW mengakses daftar Sasaran, THE Sistem SHALL menampilkan Sasaran dari seluruh posyandu dalam wilayah RW yang dikoordinasinya, namun tidak dapat melakukan perubahan data (read-only).
10. IF seorang pengguna dengan role Admin_Posyandu atau Kader mencoba mengakses data Sasaran dari posyandu lain melalui manipulasi URL atau parameter, THEN THE Sistem SHALL menolak permintaan tersebut dengan respons 403 dan mencatat percobaan tersebut dalam Log_Aktivitas.
11. THE Sistem SHALL mengaitkan setiap pengguna dengan role Admin_Posyandu atau Kader ke tepat satu unit posyandu melalui relasi `posyandu_id` pada tabel `users`.
12. THE Sistem SHALL memvalidasi bahwa setiap operasi data (query, insert, update, delete) pada tabel Sasaran dan Rekam_Medis menyertakan filter `posyandu_id` yang sesuai dengan unit posyandu pengguna, kecuali untuk role `superadmin`.

---

### Persyaratan 5: Manajemen Data Sasaran

**User Story:** Sebagai Kader, saya ingin dapat mendaftarkan dan mengelola data warga sasaran posyandu, agar semua peserta posyandu tercatat dengan lengkap dan akurat.

#### Kriteria Penerimaan

1. THE Sistem SHALL mendukung pencatatan data Sasaran untuk empat kategori: Balita, Ibu_Hamil, Remaja, dan Lansia.
2. WHEN Admin_Posyandu atau Kader menambahkan data Sasaran baru, THE Sistem SHALL memvalidasi bahwa field berikut tidak kosong: NIK, nama lengkap, tanggal lahir, jenis kelamin, kategori, dan alamat.
3. WHEN Admin_Posyandu atau Kader memasukkan NIK yang sudah terdaftar dalam sistem, THE Sistem SHALL menolak penyimpanan dan menampilkan pesan "NIK sudah terdaftar dalam sistem."
4. THE Sistem SHALL memvalidasi bahwa NIK terdiri dari tepat 16 digit angka.
5. WHEN data Sasaran berhasil disimpan, THE Sistem SHALL mencatat Log_Aktivitas penambahan data tersebut.
6. WHEN Admin_Posyandu atau Kader mengubah data Sasaran, THE Sistem SHALL mencatat Log_Aktivitas perubahan data tersebut beserta nilai sebelum dan sesudah perubahan.
7. WHEN Admin_Posyandu menghapus data Sasaran, THE Sistem SHALL menampilkan konfirmasi "Apakah Anda yakin ingin menghapus data ini? Seluruh riwayat kesehatan terkait juga akan dihapus." sebelum eksekusi penghapusan.
8. THE Sistem SHALL menghitung dan menampilkan usia Sasaran secara otomatis berdasarkan tanggal lahir dan tanggal hari ini.

---

### Persyaratan 6: Pencatatan Rekam Medis dan Penimbangan

**User Story:** Sebagai Kader, saya ingin dapat mencatat hasil penimbangan dan pemeriksaan kesehatan warga dengan mudah, agar riwayat kesehatan setiap individu tersimpan secara digital.

#### Kriteria Penerimaan

1. WHEN Kader atau Admin_Posyandu menambahkan Rekam_Medis baru, THE Sistem SHALL memvalidasi bahwa field berikut tidak kosong: ID Sasaran, tanggal kunjungan, berat badan, dan tinggi badan.
2. THE Sistem SHALL memvalidasi bahwa nilai berat badan adalah angka desimal positif dalam rentang 0,5 kg hingga 200 kg.
3. THE Sistem SHALL memvalidasi bahwa nilai tinggi badan adalah angka desimal positif dalam rentang 30 cm hingga 250 cm.
4. THE Sistem SHALL memvalidasi bahwa nilai lingkar kepala, jika diisi, adalah angka desimal positif dalam rentang 20 cm hingga 70 cm.
5. WHEN Kader memasukkan tanggal kunjungan yang melebihi tanggal hari ini, THE Sistem SHALL menolak penyimpanan dan menampilkan pesan "Tanggal kunjungan tidak boleh melebihi tanggal hari ini."
6. THE Sistem SHALL menampilkan riwayat Rekam_Medis per individu Sasaran, diurutkan dari kunjungan terbaru ke terlama.
7. WHEN Rekam_Medis baru berhasil disimpan, THE Sistem SHALL secara otomatis menghitung dan menyimpan Status_Gizi berdasarkan data berat badan, tinggi badan, usia, dan jenis kelamin Sasaran sesuai standar WHO/Kemenkes.
8. THE Sistem SHALL mencatat pemberian Vitamin_A (boolean) dan Pill_FE (boolean) pada setiap entri Rekam_Medis untuk mencegah pemberian ganda dalam satu periode.

---

### Persyaratan 7: Kalkulasi Status Gizi Otomatis

**User Story:** Sebagai Kader, saya ingin sistem menghitung status gizi Balita secara otomatis, agar saya tidak perlu menghitung manual dan risiko kesalahan berkurang.

#### Kriteria Penerimaan

1. WHEN Rekam_Medis Balita baru disimpan, THE Sistem SHALL menghitung Status_Gizi secara otomatis menggunakan indeks BB/U (Berat Badan per Umur) sesuai tabel standar WHO/Kemenkes.
2. THE Sistem SHALL mengklasifikasikan Status_Gizi Balita ke dalam empat kategori: "Gizi Lebih" (z-score > +2), "Normal" (-2 ≤ z-score ≤ +2), "Gizi Kurang" (-3 ≤ z-score < -2), dan "Gizi Buruk/Stunting" (z-score < -3).
3. THE Sistem SHALL menampilkan Status_Gizi dengan kode warna: hijau untuk "Normal", kuning untuk "Gizi Kurang" dan "Gizi Lebih", merah untuk "Gizi Buruk/Stunting".
4. WHEN Status_Gizi Balita terklasifikasi sebagai "Gizi Buruk/Stunting", THE Sistem SHALL menampilkan peringatan visual yang menonjol pada halaman detail Sasaran tersebut.
5. THE Sistem SHALL menampilkan perbandingan Status_Gizi bulan ini dengan bulan sebelumnya (Naik, Turun, atau Tetap) pada halaman detail Sasaran.
6. FOR ALL Rekam_Medis Balita yang tersimpan, THE Sistem SHALL menghasilkan Status_Gizi yang konsisten untuk input berat badan, tinggi badan, usia, dan jenis kelamin yang sama (sifat deterministik kalkulasi).

---

### Persyaratan 8: Visualisasi Grafik Pertumbuhan Balita

**User Story:** Sebagai Admin_Posyandu, saya ingin melihat grafik pertumbuhan Balita secara visual, agar saya dapat dengan cepat mengidentifikasi Balita yang memerlukan perhatian khusus.

#### Kriteria Penerimaan

1. WHEN Admin_Posyandu atau Kader membuka halaman detail Sasaran dengan kategori Balita, THE Sistem SHALL menampilkan Grafik_Pertumbuhan yang memuat tiga kurva: Berat Badan per bulan, Tinggi Badan per bulan, dan Lingkar Kepala per bulan.
2. THE Sistem SHALL menampilkan garis referensi standar WHO/Kemenkes (batas normal, waspada, dan kritis) pada setiap Grafik_Pertumbuhan.
3. THE Sistem SHALL menampilkan titik data pada grafik dengan kode warna sesuai Status_Gizi: hijau untuk Normal, kuning untuk Waspada, merah untuk Gizi Buruk/Stunting.
4. WHEN data Rekam_Medis baru berhasil disimpan, THE Sistem SHALL memperbarui Grafik_Pertumbuhan dalam waktu kurang dari 2 detik tanpa perlu memuat ulang halaman secara penuh.
5. THE Sistem SHALL menampilkan Grafik_Pertumbuhan yang dapat dibaca pada layar dengan lebar minimal 320 piksel (perangkat mobile).

---

### Persyaratan 9: Dashboard Statistik

**User Story:** Sebagai Admin_Posyandu, saya ingin melihat ringkasan statistik di dashboard, agar saya dapat memantau kondisi posyandu secara sekilas tanpa harus membuka setiap menu.

#### Kriteria Penerimaan

1. WHEN Admin_Posyandu atau Kader membuka halaman dashboard, THE Sistem SHALL menampilkan kartu statistik yang memuat: total Balita terdaftar, total Ibu_Hamil terdaftar, jumlah jadwal aktif bulan ini, dan jumlah kunjungan baru bulan ini.
2. WHEN Admin_RW membuka halaman dashboard, THE Sistem SHALL menampilkan statistik agregat dari seluruh posyandu dalam wilayah RW yang dikoordinasinya.
3. THE Sistem SHALL memuat data statistik dashboard dalam waktu kurang dari 3 detik.
4. THE Sistem SHALL menampilkan daftar Balita dengan Status_Gizi "Gizi Buruk/Stunting" pada dashboard sebagai bagian dari peringatan prioritas.
5. WHEN superadmin membuka halaman dashboard, THE Sistem SHALL menampilkan statistik agregat dari seluruh posyandu yang terdaftar dalam sistem.

---

### Persyaratan 10: Penjadwalan Kegiatan Posyandu

**User Story:** Sebagai Admin_Posyandu, saya ingin dapat membuat dan mengelola jadwal kegiatan posyandu, agar warga dan kader mengetahui kapan kegiatan posyandu berlangsung.

#### Kriteria Penerimaan

1. THE Sistem SHALL memungkinkan Admin_Posyandu untuk membuat, mengubah, dan menghapus jadwal kegiatan posyandu dengan atribut: nama kegiatan, tanggal, waktu mulai, waktu selesai, lokasi, dan deskripsi.
2. WHEN Admin_Posyandu menyimpan jadwal baru, THE Sistem SHALL memvalidasi bahwa tanggal kegiatan tidak berada di masa lalu.
3. THE Sistem SHALL menampilkan jadwal kegiatan yang akan datang pada halaman dashboard dalam urutan kronologis.
4. THE Sistem SHALL menampilkan jadwal kegiatan posyandu pada halaman publik tanpa memerlukan autentikasi.

---

### Persyaratan 11: Laporan Bulanan dan Ekspor

**User Story:** Sebagai Admin_Posyandu, saya ingin dapat menghasilkan dan mengunduh laporan bulanan secara otomatis, agar proses pelaporan ke Puskesmas menjadi lebih cepat dan akurat.

#### Kriteria Penerimaan

1. WHEN Admin_Posyandu memilih bulan dan tahun pada fitur laporan, THE Sistem SHALL menghasilkan Laporan_Bulanan yang memuat: rekapitulasi kunjungan per kategori Sasaran, distribusi Status_Gizi Balita, daftar pemberian Vitamin_A dan Pill_FE, dan ringkasan kegiatan posyandu.
2. WHEN Admin_Posyandu mengklik tombol "Ekspor Excel", THE Sistem SHALL menghasilkan berkas `.xlsx` yang berisi Laporan_Bulanan dalam waktu kurang dari 10 detik.
3. WHEN Admin_Posyandu mengklik tombol "Ekspor PDF", THE Sistem SHALL menghasilkan berkas `.pdf` yang berisi Laporan_Bulanan dalam waktu kurang dari 10 detik.
4. WHEN proses ekspor berhasil diselesaikan, THE Sistem SHALL menampilkan notifikasi "Ekspor berhasil. Berkas sedang diunduh." dan mencatat aksi ekspor tersebut dalam Log_Aktivitas.
5. IF proses ekspor gagal karena kesalahan sistem, THEN THE Sistem SHALL menampilkan pesan "Ekspor gagal. Silakan coba lagi." tanpa menampilkan pesan error teknis kepada pengguna.
6. THE Sistem SHALL membatasi akses fitur ekspor hanya untuk pengguna dengan role Admin_Posyandu, Admin_RW, dan superadmin.

---

### Persyaratan 12: Halaman Publik

**User Story:** Sebagai warga masyarakat, saya ingin dapat mengakses informasi tentang posyandu tanpa harus login, agar saya dapat mengetahui jadwal dan artikel kesehatan dengan mudah.

#### Kriteria Penerimaan

1. THE Sistem SHALL menyediakan halaman beranda publik yang dapat diakses tanpa autentikasi, menampilkan: profil singkat posyandu, jadwal kegiatan terdekat, dan artikel kesehatan terbaru.
2. THE Sistem SHALL menyediakan halaman daftar artikel kesehatan yang dapat diakses tanpa autentikasi.
3. THE Sistem SHALL menyediakan halaman detail artikel yang dapat diakses tanpa autentikasi.
4. THE Sistem SHALL menyediakan halaman "Tentang Kami" yang menampilkan informasi profil posyandu tanpa memerlukan autentikasi.
5. THE Sistem SHALL menyediakan halaman "Kontak" yang menampilkan informasi kontak posyandu tanpa memerlukan autentikasi.
6. THE Sistem SHALL memastikan halaman publik tidak menampilkan data pribadi Sasaran (NIK, data kesehatan, alamat lengkap).

---

### Persyaratan 13: Antarmuka Ramah Pengguna (Aksesibilitas Kader)

**User Story:** Sebagai Kader berusia 50 tahun ke atas, saya ingin antarmuka sistem mudah digunakan, agar saya dapat menginput data dengan benar tanpa memerlukan bantuan teknis.

#### Kriteria Penerimaan

1. THE Sistem SHALL menampilkan seluruh teks antarmuka, label, pesan, dan notifikasi dalam Bahasa Indonesia.
2. THE Sistem SHALL memastikan setiap tombol aksi utama memiliki ukuran minimal 44×44 piksel agar mudah disentuh pada perangkat layar sentuh.
3. THE Sistem SHALL memastikan setiap fitur utama (input data, lihat riwayat, cetak laporan) dapat dicapai dalam maksimal 3 langkah navigasi dari halaman dashboard.
4. THE Sistem SHALL menampilkan label yang jelas dan deskriptif pada setiap field formulir input.
5. THE Sistem SHALL menampilkan pesan validasi yang spesifik dan mudah dipahami (bukan kode error teknis) ketika pengguna memasukkan data yang tidak valid.
6. THE Sistem SHALL menggunakan kontras warna yang memadai (rasio kontras minimal 4,5:1 antara teks dan latar belakang) untuk memastikan keterbacaan bagi pengguna dengan keterbatasan penglihatan.

---

### Persyaratan 14: Kinerja Sistem

**User Story:** Sebagai Kader, saya ingin sistem merespons dengan cepat meskipun koneksi internet tidak stabil, agar kegiatan posyandu tidak terhambat.

#### Kriteria Penerimaan

1. THE Sistem SHALL merespons setiap permintaan halaman dalam waktu kurang dari 3 detik pada kondisi jaringan normal (bandwidth minimal 1 Mbps).
2. THE Sistem SHALL mendukung minimal 20 pengguna aktif secara bersamaan tanpa penurunan waktu respons melebihi 3 detik.
3. WHEN data Rekam_Medis baru disimpan, THE Sistem SHALL memperbarui Grafik_Pertumbuhan dalam waktu kurang dari 2 detik.
4. WHEN Admin_Posyandu meminta ekspor laporan, THE Sistem SHALL menyelesaikan proses ekspor dalam waktu kurang dari 10 detik untuk data hingga 500 entri Rekam_Medis.
5. THE Sistem SHALL memiliki tingkat ketersediaan (uptime) minimal 95% dalam satu bulan kalender.

---

### Persyaratan 15: Keamanan Data dan Backup

**User Story:** Sebagai Admin_Posyandu, saya ingin data posyandu tersimpan dengan aman dan terlindungi dari kehilangan, agar data warga tidak hilang meskipun terjadi gangguan teknis.

#### Kriteria Penerimaan

1. THE Sistem SHALL melakukan backup database secara otomatis setiap hari pada pukul 02.00 WIB.
2. THE Sistem SHALL menyimpan minimal 7 salinan backup harian terakhir sebelum salinan terlama dihapus secara otomatis.
3. THE Sistem SHALL memastikan data pribadi Sasaran (NIK, data kesehatan) hanya dapat diakses oleh pengguna yang memiliki izin sesuai role dan unit posyandu.
4. IF proses backup otomatis gagal, THEN THE Sistem SHALL mencatat kegagalan tersebut dalam log sistem dan mengirimkan notifikasi kepada superadmin.
5. THE Sistem SHALL menggunakan koneksi HTTPS untuk seluruh komunikasi antara klien dan server guna melindungi data dalam transit.

---

### Persyaratan 16: Penyimpanan Sementara Offline (Opsional — Phase 2)

**User Story:** Sebagai Kader, saya ingin dapat tetap menginput data penimbangan meskipun koneksi internet terputus, agar kegiatan posyandu tidak terhenti karena masalah jaringan.

#### Kriteria Penerimaan

1. WHERE fitur offline diaktifkan, THE Sistem SHALL menyimpan data input penimbangan secara sementara di penyimpanan lokal perangkat (localStorage atau IndexedDB) ketika koneksi internet tidak tersedia.
2. WHERE fitur offline diaktifkan, WHEN koneksi internet kembali tersedia, THE Sistem SHALL secara otomatis menyinkronkan data yang tersimpan secara lokal ke server dan menampilkan notifikasi "Data berhasil disinkronkan."
3. WHERE fitur offline diaktifkan, IF terjadi konflik data antara data lokal dan data server saat sinkronisasi, THEN THE Sistem SHALL menampilkan notifikasi konflik kepada Admin_Posyandu untuk diselesaikan secara manual.
4. WHERE fitur offline diaktifkan, THE Sistem SHALL menampilkan indikator status koneksi yang jelas (online/offline) pada setiap halaman.

