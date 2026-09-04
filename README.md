# Posyandu Kenanga - Sistem Informasi & Rekam Medis

Sistem informasi berbasis web untuk operasional Posyandu Kenanga (Bekasi Timur). Menggabungkan portal informasi publik untuk warga dengan dashboard administratif untuk kader dan tenaga kesehatan dalam pencatatan antropometri, rekam medis balita & ibu hamil, serta pelaporan bulanan.

---

## Modul & Fitur Utama

### 1. Portal Publik
* **Beranda Publik**: Jadwal kegiatan posyandu terdekat, statistik layanan, profil kader, dan galeri kegiatan.
* **Artikel Kesehatan**: Edukasi gizi, imunisasi, dan kesehatan keluarga dengan filter kategori dan pencarian.
* **Kontak & Pengaduan**: Kanal komunikasi langsung dengan kader via form kontak dan tautan WhatsApp.

### 2. Rekam Medis & Antropometri Balita
* **Grafik Pertumbuhan WHO (KMS Digital)**: Visualisasi kurva pertumbuhan berat badan, tinggi badan, dan lingkar kepala sesuai standar antropometri WHO.
* **Pencatatan Masal (Bulk Entry)**: Input cepat pengukuran antropometri saat hari pelaksanaan posyandu tanpa harus membuka profil satu per satu.
* **Riwayat Imunisasi & Vitamin**: Pencatatan pemberian vaksin dasar dan suplemen (Vitamin A, obat cacing).

### 3. Manajemen Data Master
* **Data Pasien**: Pengelolaan data anak, ibu hamil, dan lansia. Mendukung import/export via file Excel (`.xlsx`) lengkap dengan validasi template.
* **Jadwal Posyandu**: Penjadwalan tanggal kegiatan, lokasi pos penimbangan, dan jenis layanan yang disediakan.
* **Struktur Wilayah**: Pengelompokan data berdasarkan pos posyandu dan pedukuhan/RT/RW.
* **Galeri Dokumentasi**: Pengelolaan foto dan album kegiatan posyandu.

### 4. Pelaporan & Rekapitulasi
* **Laporan Bulanan**: Rekapitulasi status gizi (stunting, wasting, gizi kurang) dan kehadiran balita.
* **Export PDF & Excel**: Cetak rekap bulanan dan rekam medis individual dalam format siap cetak (A4/PDF) atau spreadsheet untuk arsip puskesmas.

### 5. Keamanan & Hak Akses (RBAC)
* **Tiga Tingkat Peran**: `superadmin`, `admin`, dan `kader`.
* **Activity Log**: Pencatatan riwayat perubahan data krusial untuk audit internal.
* **Proteksi Brute-Force**: Rate limiting pada endpoint login.

---

## Tech Stack

| Layer | Teknologi |
| --- | --- |
| **Framework** | Laravel 12.x (PHP ^8.2) |
| **Frontend** | Tailwind CSS, Blade, Livewire 3 (Volt & Flux) |
| **Database** | MySQL 8.x (dapat menggunakan SQLite untuk testing) |
| **Export/Import**| PhpSpreadsheet (`.xlsx`), Barryvdh Laravel DomPDF (`.pdf`) |
| **Asset Bundler**| Vite |
| **Test Suite** | Pest PHP / PHPUnit |

---

## Panduan Instalasi Lokal

### Kebutuhan Sistem
* PHP >= 8.2 (dengan ekstensi `gd`, `zip`, `fileinfo`, `mbstring`, `pdo_mysql`)
* Composer >= 2.x
* Node.js >= 18.x & NPM
* MySQL / MariaDB (misal: via XAMPP atau Laragon)

### Langkah Instalasi

1. **Clone repository**:
   ```bash
   git clone https://github.com/Alarave/kenanga-posyandu.git
   cd kenanga-posyandu
   ```

2. **Buat database**:
   Buat database baru di MySQL dengan nama `posyandu_db` (atau sesuaikan di `.env`).

3. **Jalankan script setup otomatis**:
   ```bash
   composer install
   composer setup
   ```
   *Script `composer setup` otomatis menyalin `.env.example`, generate `APP_KEY`, menjalankan migrasi + seed data awal (termasuk data referensi standar WHO), menginstal dependensi npm, dan melakukan build aset.*

4. **Jalankan server pengembangan**:
   ```bash
   # Opsi A: Jalankan semua service sekaligus (server, queue, logs, vite)
   composer dev

   # Opsi B: Jalankan manual di terminal terpisah
   php artisan serve
   npm run dev
   ```

Aplikasi dapat diakses melalui browser di `http://127.0.0.1:8000`.

### Kredensial Default (Seeder)
* **Email**: `admin@posyandu.local`
* **Password**: `password`

---

## Helper Scripts (Pengembangan Lokal)

Tersedia batch script di root direktori untuk mempermudah operasional tim:

| Script | Fungsi |
| --- | --- |
| `db-export.bat` | Backup database `posyandu_db` ke `database/db_snapshot.sql` |
| `db-import.bat` | Restore database dari `database/db_snapshot.sql` ke database lokal |
| `start-cloudflare-tunnel.bat` | Ekspos server lokal ke internet via Cloudflare Tunnel |
| `start-localtunnel.bat` | Ekspos server lokal ke internet via LocalTunnel |

---

## Struktur Direktori Utama

```
kenanga-posyandu/
├── app/
│   ├── Http/Controllers/   # Controller web publik, admin, dan auth
│   ├── Livewire/           # Komponen interaktif (Volt/Flux untuk rekam medis, galeri, dll)
│   ├── Models/             # Model Eloquent (Patient, MedicalRecord, Article, Posyandu, dll)
│   ├── Services/           # Business logic (ArticleService, ReportService, dll)
│   └── Traits/             # Shared traits (LogsActivity)
├── database/
│   ├── migrations/         # Skema database
│   └── seeders/            # Seeder data awal & referensi antropometri WHO
├── resources/
│   ├── views/              # Blade template (portal publik, layout admin, print template)
│   └── css/                # Styling Tailwind CSS
├── routes/
│   └── web.php             # Routing publik dan admin
└── storage/                # File upload (thumbnail artikel, galeri, foto pasien)
```