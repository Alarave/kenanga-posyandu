### Struktur Folder:

```
/posyandu
├── .github                        # Folder untuk konfigurasi GitHub Actions
│   └── workflows                  # File workflow untuk GitHub Actions
├── app
│   ├── Console                     # Folder untuk Artisan Commands (perintah custom dari Artisan CLI)
│   ├── Exceptions                  # Folder untuk menangani exceptions (error)
│   ├── Http
│   │   ├── Controllers             # Folder untuk Controller yang menangani request dan response
│   │   │   ├── UserController.php       # Controller untuk aksi terkait User (manajemen user) memiliki role 'superadmin', 'admin', 'coordinator', 'staff', 'medical', 'patient', 'partner'
│   │   │   ├── PatientController.php     # Controller untuk mengelola data pasien (CRUD)
│   │   │   ├── ScheduleController.php    # Controller untuk mengelola jadwal (CRUD)
│   │   │   ├── GalleryController.php     # Controller untuk mengelola galeri gambar (CRUD)
│   │   │   ├── ArticleController.php     # Controller untuk mengelola artikel (CRUD)
│   │   │   ├── MedicalRecordController.php # Controller untuk mengelola catatan medis (CRUD)
│   │   │   ├── PosyanduController.php    # Controller untuk mengelola data Posyandu (CRUD)
│   │   │   └── PedukuhanController.php   # Controller untuk mengelola data Pedukuhan
│   │   ├── Livewire                   # Folder untuk Livewire component
│   │   │   ├── UserDashboard.php         # Komponen Livewire untuk Dashboard User (pengelolaan user) memiliki role 'superadmin', 'admin', 'coordinator', 'staff', 'medical', 'patient', 'partner'
│   │   │   ├── PatientManagement.php     # Komponen Livewire untuk mengelola pasien
│   │   │   ├── ScheduleManagement.php    # Komponen Livewire untuk mengelola jadwal
│   │   │   ├── GalleryManagement.php     # Komponen Livewire untuk mengelola galeri
│   │   │   ├── ArticleManagement.php     # Komponen Livewire untuk mengelola artikel
│   │   │   ├── MedicalRecordManagement.php # Komponen Livewire untuk mengelola catatan medis
│   │   │   ├── PedukuhanManagement.php   # Komponen Livewire untuk mengelola Pedukuhan
│   │   │   └── SearchComponent.php       # Komponen Livewire untuk pencarian dinamis
│   │   ├── Middleware                 # Folder untuk middleware (fungsi perantara)
│   │   │   ├── UserMiddleware.php       # Middleware untuk akses User (akses terbatas) memiliki role 'superadmin', 'admin', 'coordinator', 'staff', 'medical', 'patient', 'partner'
│   │   │   ├── PatientMiddleware.php     # Middleware untuk akses data pasien (akses terbatas)
│   │   │   ├── Authenticate.php         # Middleware untuk otentikasi (login, autentikasi pengguna)
│   │   │   ├── CheckUserStatus.php      # Middleware untuk memeriksa status akun pengguna (aktif/tidak aktif)
│   │   │   ├── VerifyEmailMiddleware.php # Middleware untuk verifikasi email pengguna
│   │   │   └── PedukuhanMiddleware.php   # Middleware untuk akses data Pedukuhan
│   │   └── Requests                    # Folder untuk file validasi request (menjaga integritas data)
│   │       ├── UserRequest.php          # Validasi data User memiliki role 'superadmin', 'admin', 'coordinator', 'staff', 'medical', 'patient', 'partner'
│   │       ├── PatientRequest.php        # Validasi data pasien
│   │       ├── ScheduleRequest.php       # Validasi data jadwal
│   │       ├── GalleryRequest.php        # Validasi data galeri
│   │       ├── ArticleRequest.php        # Validasi data artikel
│   │       ├── MedicalRecordRequest.php  # Validasi data catatan medis
│   │       └── PedukuhanRequest.php      # Validasi data Pedukuhan
│   ├── Models                          # Folder untuk model (struktur data yang terhubung dengan database)
│   │   ├── User.php                      # Model untuk User, mewakili data pengguna aplikasi memiliki role 'superadmin', 'admin', 'coordinator', 'staff', 'medical', 'patient', 'partner'
│   │   ├── Posyandu.php                 # Model untuk Posyandu, mewakili data posyandu
│   │   ├── Pedukuhan.php                # Model untuk Pedukuhan, mewakili data pedukuhan
│   │   ├── Schedule.php                 # Model untuk Jadwal, mewakili data jadwal layanan
│   │   ├── Gallery.php                  # Model untuk Galeri, mewakili data galeri gambar
│   │   ├── Patient.php                  # Model untuk Pasien, mewakili data pasien
│   │   ├── Article.php                  # Model untuk Artikel, mewakili data artikel edukasi
│   │   ├── MedicalRecord.php            # Model untuk Catatan Medis, mewakili data catatan medis pasien
│   ├── Providers                       # Folder untuk Service Provider (pengaturan dan penyedia layanan aplikasi)
│   ├── Services                        # Folder untuk Services (logika bisnis aplikasi)
│   └── Policies                        # Folder untuk policy (kebijakan akses dan kontrol aplikasi)
├── bootstrap                         # Folder untuk bootstrap aplikasi (pengaturan awal aplikasi)
├── config
│   ├── app.php                         # File konfigurasi aplikasi (pengaturan umum)
│   ├── auth.php                         # File konfigurasi autentikasi (login, register)
│   ├── database.php                     # File konfigurasi database
│   ├── livewire.php                     # File konfigurasi Livewire
│   ├── volt.php                         # File konfigurasi integrasi Volt (untuk frontend)
│   └── filesystems.php                  # File konfigurasi untuk cloud storage (Backblaze B2)
├── database
│   ├── migrations                     # Folder untuk migration (struktur tabel database)
│   │   ├── create_users_table.php       # Migration untuk tabel users memiliki role 'superadmin', 'admin', 'coordinator', 'staff', 'medical', 'patient', 'partner'
│   │   ├── create_posyandus_table.php   # Migration untuk tabel posyandu
│   │   ├── create_schedules_table.php   # Migration untuk tabel jadwal
│   │   ├── create_galleries_table.php   # Migration untuk tabel galeri
│   │   ├── create_patients_table.php    # Migration untuk tabel pasien
│   │   ├── create_articles_table.php    # Migration untuk tabel artikel
│   │   ├── create_medical_records_table.php # Migration untuk tabel catatan medis
│   │   ├── create_pedukuhans_table.php  # Migration untuk tabel pedukuhan (penambahan)
│   ├── factories                       # Folder untuk factory data palsu (dummy data)
│   └── seeders                         # Folder untuk seeders (untuk mengisi data awal)
│   │   ├── UserSeeder.php               # Seeder untuk tabel users
│   │   ├── PosyanduSeeder.php           # Seeder untuk tabel posyandu
│   │   ├── PedukuhanSeeder.php          # Seeder untuk tabel pedukuhan
│   │   ├── ScheduleSeeder.php           # Seeder untuk tabel jadwal
│   │   ├── GallerySeeder.php            # Seeder untuk tabel galeri
│   │   ├── ArticleSeeder.php            # Seeder untuk tabel artikel
│   │   ├── MedicalRecordSeeder.php      # Seeder untuk tabel catatan medis
│   │   └── DatabaseSeeder.php           # Seeder utama yang memanggil semua seeder individual
├── public
│   ├── css
│   │   └── app.css                      # File CSS utama untuk font dan warna global
│   ├── js                               # Folder untuk file JavaScript
│   └── storage                           # Folder untuk penyimpanan statis yang jarang berubah
│   │   ├── icons                        # Folder untuk ikon statis yang jarang berubah
│   │   └── images                     # Folder untuk gambar statis yang jarang berubah
├── resources
│   ├── sass
│   │   ├── app.scss                     # SCSS utama yang memuat variabel font dan warna
│   │   └── _variables.scss              # File untuk mendefinisikan variabel warna dan font
│   ├── views
│   │   ├── auth
│   │   │   ├── login.blade.php          # View untuk halaman login
│   │   │   ├── register.blade.php       # View untuk halaman register
│   │   │   ├── reset-password.blade.php # Halaman untuk reset password
│   │   │   ├── verify-email.blade.php   # Halaman verifikasi email
│   │   │   └── confirm-password.blade.php   # Halaman konfirmasi password
│   │   ├── livewire
│   │   │   ├── admin-dashboard.blade.php # Komponen Livewire untuk dashboard admin
│   │   │   ├── patient-management.blade.php # Komponen Livewire untuk mengelola pasien
│   │   │   ├── schedule-management.blade.php # Komponen Livewire untuk mengelola jadwal
│   │   │   ├── gallery-management.blade.php # Komponen Livewire untuk mengelola galeri
│   │   │   ├── article-management.blade.php # Komponen Livewire untuk mengelola artikel
│   │   │   ├── medical-record-management.blade.php # Komponen Livewire untuk mengelola catatan medis
│   │   │   ├── pedukuhan-management.blade.php # Komponen Livewire untuk mengelola Pedukuhan
│   │   │   └── search.blade.php           # Komponen Livewire untuk pencarian dinamis
│   │   ├── admin
│   │   │   ├── dashboard.blade.php       # Halaman utama Dashboard Admin
│   │   │   ├── patient-management
│   │   │   │   ├── index.blade.php      # Daftar pasien
│   │   │   │   ├── create.blade.php     # Formulir untuk menambah pasien
│   │   │   │   ├── update.blade.php     # Formulir untuk memperbarui data pasien
│   │   │   │   ├── details.blade.php    # Tampilan detail pasien
│   │   │   │   ├── delete.blade.php     # Konfirmasi penghapusan pasien
│   │   │   │   ├── search.blade.php     # Hapus halaman pencarian
│   │   │   ├── pedukuhan-management
│   │   │   │   ├── index.blade.php      # Daftar pedukuhan
│   │   │   │   ├── create.blade.php     # Formulir untuk menambah pedukuhan
│   │   │   │   ├── update.blade.php     # Formulir untuk memperbarui pedukuhan
│   │   │   │   ├── delete.blade.php     # Konfirmasi penghapusan pedukuhan
│   │   │   ├── schedule-management
│   │   │   │   ├── index.blade.php      # Daftar jadwal
│   │   │   │   ├── create.blade.php     # Formulir untuk menambah jadwal
│   │   │   │   ├── update.blade.php     # Formulir untuk memperbarui jadwal
│   │   │   │   ├── details.blade.php    # Tampilan detail jadwal
│   │   │   │   ├── delete.blade.php     # Konfirmasi penghapusan jadwal
│   │   │   ├── gallery-management
│   │   │   │   ├── index.blade.php      # Daftar galeri
│   │   │   │   ├── create.blade.php     # Formulir untuk menambah gambar ke galeri
│   │   │   │   ├── update.blade.php     # Formulir untuk memperbarui galeri
│   │   │   │   ├── delete.blade.php     # Konfirmasi penghapusan gambar dari galeri
│   │   │   ├── article-management
│   │   │   │   ├── index.blade.php      # Daftar artikel
│   │   │   │   ├── create.blade.php     # Formulir untuk menambah artikel
│   │   │   │   ├── update.blade.php     # Formulir untuk memperbarui artikel
│   │   │   │   ├── delete.blade.php     # Konfirmasi penghapusan artikel
│   │   │   ├── medical-record-management
│   │   │   │   ├── index.blade.php      # Daftar catatan medis
│   │   │   │   ├── details.blade.php    # Tampilan detail catatan medis
│   │   │   │   ├── create.blade.php     # Formulir untuk menambah catatan medis
│   │   │   │   ├── update.blade.php     # Formulir untuk memperbarui catatan medis
│   │   │   │   ├── delete.blade.php     # Konfirmasi penghapusan catatan medis
│   │   │   ├── user-management
│   │   │   │   ├── index.blade.php      # Daftar pengguna
│   │   │   │   ├── create.blade.php     # Formulir untuk menambah pengguna
│   │   │   │   ├── update.blade.php     # Formulir untuk memperbarui data pengguna
│   │   │   │   ├── delete.blade.php     # Konfirmasi penghapusan pengguna
│   │   ├── components
│   │   │   ├── sidebar.blade.php        # Sidebar untuk dashboard admin
│   │   │   ├── navbar.blade.php         # Navbar untuk navigasi
│   │   │   ├── footer.blade.php         # Komponen footer
│   │   │   ├── pagination.blade.php     # Komponen pagination
│   │   │   ├── breadcrumbs.blade.php    # Komponen breadcrumbs
│   │   │   ├── datacard.blade.php       # Komponen untuk menampilkan data statistik
│   │   │   ├── modal.blade.php          # Komponen modal untuk formulir tambah/ubah
│   │   │   ├── alert.blade.php          # Komponen alert untuk pesan error/sukses
│   │   │   ├── search-bar.blade.php     # Komponen pencarian
│   │   │   ├── notifications.blade.php  # Komponen untuk menampilkan notifikasi
│   │   │   ├── button.blade.php         # Komponen button reusable (primary, secondary, outline, disabled)
│   │   │   ├── tooltip.blade.php        # Komponen tooltip
│   │   │   ├── card.blade.php           # Komponen card untuk menampilkan informasi
│   │   │   ├── table.blade.php          # Komponen table untuk data dengan sorting dan pagination
│   │   │   ├── progress-bar.blade.php   # Komponen progress bar
│   │   │   ├── rating.blade.php         # Komponen rating (star rating)
│   │   │   ├── switch.blade.php         # Komponen switch (toggle)
│   │   │   ├── tabs.blade.php           # Komponen tabbed navigation
│   │   │   ├── avatar.blade.php         # Komponen avatar untuk profil
│   │   │   └── dropdown.blade.php       # Komponen dropdown menu
│   │   ├── layouts
│   │   │   ├── app.blade.php            # Layout utama (memuat sidebar, navbar, footer)
│   │   │   ├── guest.blade.php          # Layout untuk pengguna tamu (login, register)
│   │   │   ├── modal-layout.blade.php   # Layout untuk tampilan modal
│   │   │   └── admin-layout.blade.php   # Layout khusus untuk halaman admin
│   │   ├── vendor
│   │   │   ├── volt.blade.php           # Layout untuk komponen eksternal dari Volt
│   │   │   └── livewire-scripts.blade.php # Skrip khusus untuk Livewire
│   │   ├── welcome.blade.php            # Halaman pertama setelah login
│   ├── lang
│   ├── notifications                   # Folder untuk tampilan notifikasi
│   │   ├── info.blade.php              # Tampilan untuk notifikasi informasi
│   │   ├── success.blade.php           # Tampilan untuk notifikasi sukses
│   │   ├── warning.blade.php           # Tampilan untuk notifikasi warning
│   │   └── error.blade.php             # Tampilan untuk notifikasi error
├── routes
│   ├── api.php
│   ├── channels.php
│   ├── console.php
│   ├── web.php
│   └── auth.php                # Rute untuk autentikasi (login, register, logout)
├── storage
│   ├── app
│   ├── framework
│   └── logs
├── tests
│   ├── Feature
│   │   ├── AdminTest.php
│   │   ├── PatientTest.php
│   │   ├── ScheduleTest.php
│   │   ├── GalleryTest.php
│   │   ├── ArticleTest.php
│   │   ├── MedicalRecordTest.php
│   │   └── PosyanduTest.php
│   └── Pest
│       └── AdminManagementTest.php
├── .env
├── artisan
├── composer.json
├── docker-compose.yml
└── Dockerfile
```

### **Penjelasan Komentar:**

* **Controllers**: Menangani permintaan HTTP (CRUD) untuk entitas seperti **Admin**, **Pasien**, **Jadwal**, **Galeri**, **Artikel**, dan **Catatan Medis**.
* **Livewire**: Komponen untuk memperbarui tampilan secara dinamis menggunakan **Livewire** tanpa memuat ulang halaman.
* **Middleware**: Menyaring permintaan dan memverifikasi hak akses pengguna (misalnya **Admin**, **SuperAdmin**, **Pasien**).
* **Models**: Model Eloquent untuk berinteraksi dengan database. Mewakili entitas dan relasinya.
* **Requests**: Memvalidasi data yang dikirimkan oleh pengguna untuk memastikan data yang diterima sah.
* **Migrations**: Struktur tabel database yang diperlukan untuk aplikasi.
* **Seeders**: Mengisi database dengan data dummy atau data awal.
* **Views**: Menyimpan template tampilan aplikasi, dengan folder berbeda untuk halaman **admin**, **auth**, **livewire**, dan **components**.
* **Routes**: Menyimpan definisi rute aplikasi untuk **API**, **web**, dan **auth**.
* **Notifications**: Menyediakan notifikasi untuk pengguna aplikasi, seperti notifikasi sukses atau error.

Struktur ini telah diatur agar setiap bagian aplikasi dapat dikembangkan dan dipelihara dengan mudah, memungkinkan fleksibilitas dalam penambahan fitur atau pembaruan.

