# Design - Halaman Pemilihan Kategori Warga Baru

Halaman pemilihan kategori dirancang agar muncul saat tombol "Tambah Warga" ditekan, memungkinkan pengguna memilih antara **Balita**, **Ibu Hamil**, atau **Lansia** sebelum masuk ke formulir input data.

## Arsitektur & Alur Data

1. Pengguna mengeklik tombol **Tambah Warga** yang mengarah ke route `admin.patients.create`.
2. `PatientController@create` memeriksa keberadaan parameter query `category`:
   - Jika **tidak ada**, controller akan mengembalikan view pemilihan kategori `select-category.blade.php`.
   - Jika **ada**, controller akan mengembalikan view form pendaftaran warga `create.blade.php` seperti biasa.
3. Halaman pemilihan kategori menampilkan 3 kartu pilihan (Balita, Ibu Hamil, Lansia) dengan tautan dinamis yang membawa parameter query `category` (dan menyertakan `posyandu_id` jika ada di request awal).
4. Formulir pendaftaran menggunakan parameter query `category` tersebut untuk inisialisasi state Alpine.js dan memfilter kolom-kolom yang relevan.

## Rincian Perubahan File

1. **[PatientController.php](file:///c:/Users/HP/kenanga-posyandu/app/Http/Controllers/Web/PatientController.php)**:
   - Tambah parameter `Request $request` pada method `create()`.
   - Tambahkan percabangan pengecekan parameter `category`.

2. **[select-category.blade.php](file:///c:/Users/HP/kenanga-posyandu/resources/views/livewire/admin/patient-management/select-category.blade.php)** (NEW):
   - Blade view baru dengan template layout admin dan kartu pilihan kategori.

3. **[create.blade.php](file:///c:/Users/HP/kenanga-posyandu/resources/views/livewire/admin/patient-management/create.blade.php)**:
   - Sesuaikan inisialisasi `category` di Alpine.js agar membaca dari parameter request.
