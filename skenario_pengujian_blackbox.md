# Skenario Pengujian Blackbox (Blackbox Testing)

Berikut adalah skenario pengujian blackbox untuk fitur **Bulan Penimbangan (Penimbangan Massal)** dan **Log Aktivitas**, termasuk di dalamnya skenario *happy path* (Positive Case) dan skenario pengecualian/kegagalan (Negative Case). Setiap fitur dibatasi maksimal 30 kasus uji agar fokus pada poin-poin kritikal.

---

## 1. Fitur Bulan Penimbangan (Penimbangan Massal Balita)

Fitur ini memungkinkan admin/kader untuk memilih Posyandu, tanggal, memuat daftar seluruh balita, menambahkan balita secara manual via pencarian, mengisi form pengukuran (Berat dan Tinggi), serta memantau progres pengisian.

### Positive Cases (Happy Path)
| ID | Skenario Pengujian | Langkah-Langkah | Hasil yang Diharapkan (Expected Result) |
|---|---|---|---|
| BP-01 | Memuat daftar balita berdasarkan Posyandu | Pilih Tanggal -> Pilih Posyandu valid -> Klik "Muat Semua Balita" | Menampilkan daftar seluruh balita yang terdaftar pada Posyandu tersebut. |
| BP-02 | Mencari balita spesifik di luar yang termuat | Ketik nama balita yang valid di kolom pencarian -> Klik tombol Tambah (+) | Balita berhasil ditambahkan ke dalam daftar (list baris) di bawah. |
| BP-03 | Mengisi data Berat Badan (BB) yang valid | Input nilai numerik valid pada kolom BB (misal: `12.5`) | Nilai berhasil diinput dan *progress bar* jumlah terisi otomatis bertambah. |
| BP-04 | Mengisi data Tinggi Badan (TB) yang valid | Input nilai numerik valid pada kolom TB (misal: `85`) | Nilai berhasil diinput dan divalidasi sistem. |
| BP-05 | Menyimpan data penimbangan secara utuh | Isi BB dan TB seluruh balita di list -> Klik "Simpan Data" | Muncul notifikasi sukses, data tersimpan di *database* (Medical Records). |
| BP-06 | Menampilkan *Progress Bar* terisi dengan benar | Isi data BB/TB pada 1 balita dari total 10 balita | Progress bar berubah menjadi 10% (1/10 balita sudah terisi). |
| BP-07 | Mengubah tanggal kunjungan sebelum menyimpan | Pilih Tanggal '12 Jan 2026' -> Ubah ke '14 Jan 2026' -> Simpan | Data penimbangan tersimpan dengan tanggal '14 Jan 2026'. |
| BP-08 | Mengganti pilihan Posyandu (Reset data) | Pilih Posyandu A -> Daftar dimuat -> Ganti ke Posyandu B | Muncul konfirmasi reset/daftar langsung berubah menyesuaikan Posyandu B. |
| BP-09 | Memasukkan angka desimal dengan koma/titik | Input BB dengan format `12,5` atau `12.5` | Sistem dapat menerima dan mem-parsing angka desimal dengan benar. |

### Negative Cases (Error Handling & Edge Cases)
| ID | Skenario Pengujian | Langkah-Langkah | Hasil yang Diharapkan (Expected Result) |
|---|---|---|---|
| BP-10 | Memuat daftar balita tanpa memilih Posyandu | Kosongkan *dropdown* Posyandu -> Klik "Muat Semua Balita" | Tombol tidak aktif atau sistem memunculkan pesan error "Harap pilih posyandu". |
| BP-11 | Memuat daftar balita tanpa tanggal kunjungan | Kosongkan input Tanggal -> Pilih Posyandu -> Klik "Muat..." | Muncul validasi "Tanggal Kunjungan harus diisi". |
| BP-12 | Menginput BB dengan karakter alfabet/simbol | Ketik `abc` atau `@#$` di input Berat Badan | Sistem menolak input (hanya menerima numerik) atau muncul validasi "Format tidak valid". |
| BP-13 | Menginput nilai minus (negatif) pada BB/TB | Ketik `-5` pada Berat Badan atau Tinggi Badan | Sistem memunculkan error validasi "Nilai tidak boleh minus". |
| BP-14 | Menginput nilai BB tidak masuk akal (Terlalu besar) | Ketik `500` (kg) pada kolom Berat Badan anak balita | Muncul *warning*/error validasi (misal: "Berat badan melebihi batas rasional"). |
| BP-15 | Menyimpan form penimbangan kosong tanpa isi BB/TB | Muat daftar -> Tidak isi apapun -> Klik "Simpan Data" | Sistem memunculkan pesan error "Tidak ada data yang diubah/diisi" atau mengabaikan baris kosong. |
| BP-16 | Menyimpan data hanya Tinggi Badan tanpa Berat Badan | Kosongkan BB -> Isi TB -> Klik "Simpan Data" | Sistem menolak dengan alert "Berat badan wajib diisi jika tinggi badan diisi". |
| BP-17 | Mencari nama balita yang tidak ada/tidak terdaftar | Ketik "BalitaTidakAda123" pada kolom pencarian | *Dropdown* pencarian kosong atau muncul tulisan "Balita tidak ditemukan". |
| BP-18 | Mencari nama balita dengan *special characters* | Ketik `%^&*` di form pencarian | Aplikasi tidak *crash*, menampilkan hasil kosong dengan aman (mencegah SQL Injection). |
| BP-19 | Mengklik "Simpan Data" dua kali dengan sangat cepat (Double click) | Isi data -> Klik tombol "Simpan Data" 2x atau lebih | Sistem men-*disable* tombol (loading state) dan mencegah duplikasi data (tidak *double submit*). |
| BP-20 | Balita yang sudah memiliki data pada tanggal tersebut dimuat ulang | Pilih tanggal hari ini -> Muat Posyandu yang balitanya sudah diukur hari ini | Baris balita tersebut sudah terisi otomatis (mode *update*) atau muncul *badge* "Sudah Diukur". |
| BP-21 | Koneksi terputus saat klik "Simpan Data" | Matikan internet/Network *offline* -> Klik Simpan | Menampilkan notifikasi "Koneksi terputus, gagal menyimpan data". |

---

## 2. Fitur Log Aktivitas (Activity Logs)

Fitur untuk memantau rekam jejak aktivitas user (Admin, Bidan, Kader) mencakup halaman Indeks (Daftar), Detail Log, dan Statistik (Chart).

### Positive Cases (Happy Path)
| ID | Skenario Pengujian | Langkah-Langkah | Hasil yang Diharapkan (Expected Result) |
|---|---|---|---|
| AL-01 | Menampilkan daftar (Indeks) Log Aktivitas | Akses menu "Log Aktivitas" (`/admin/activity-logs`) | Menampilkan tabel aktivitas terbaru yang dilakukan oleh pengguna, urut dari terbaru (Desc). |
| AL-02 | Melihat detail dari satu log aktivitas spesifik | Klik ikon "Mata"/Detail pada salah satu baris (Show) | Menampilkan modal/halaman detail (aktor, waktu, IP Address, data *before* & *after*). |
| AL-03 | Menampilkan Statistik Log | Buka tab/halaman "Statistik" (`/admin/activity-logs/statistics`) | Menampilkan diagram (Chart) jumlah aktivitas per periode dengan benar. |
| AL-04 | Filter log berdasarkan modul (contoh: Medical Record) | Pilih filter dropdown "Modul/Tipe" -> `Medical Record` | Tabel hanya menampilkan aktivitas yang berkaitan dengan manipulasi Medical Record. |
| AL-05 | Filter log berdasarkan User (Aktor) | Pilih filter user -> `Kader A` | Tabel hanya memunculkan log yang digenerate oleh Kader A. |
| AL-06 | Filter log berdasarkan *Date Range* (Rentang Waktu) | Pilih Tanggal Mulai dan Tanggal Akhir | Tabel menampilkan log aktivitas secara eksklusif dalam rentang waktu tersebut. |
| AL-07 | Pencarian teks pada Log Aktivitas | Ketik "Hapus pasien" di kotak pencarian | Menampilkan log dengan *description* atau nama *event* "Hapus pasien". |
| AL-08 | Pagination halaman daftar log | Klik halaman '2' atau 'Next' di bawah tabel log | Sistem berpindah halaman log dengan data log sebelumnya. |

### Negative Cases (Error Handling & Edge Cases)
| ID | Skenario Pengujian | Langkah-Langkah | Hasil yang Diharapkan (Expected Result) |
|---|---|---|---|
| AL-09 | Akses Log Aktivitas oleh User tanpa otorisasi (Bukan Admin) | Login sebagai Pasien/User Biasa -> Paksa akses `/admin/activity-logs` | Tampil halaman 403 Forbidden atau di-*redirect* ke dashboard dengan pesan error. |
| AL-10 | Set *Date Range* terbalik (Tanggal Akhir < Tanggal Mulai) | Pilih Mulai: `10 Jan 2026`, Akhir: `5 Jan 2026` | Pencarian gagal atau tombol filter *disabled*, muncul validasi "Tanggal akhir tidak boleh mendahului tanggal mulai". |
| AL-11 | Filter menggunakan kata kunci sangat panjang (>255 karakter) | Ketik teks panjang `A...` (500 karakter) di kolom *Search* | Tidak terjadi error DB/500, pencarian gagal namun dengan tampilan UI yang aman. |
| AL-12 | Mengakses URL Detail Log yang tidak ada (ID Palsu) | Ketik manual `/admin/activity-logs/9999999` di URL | Menampilkan halaman *404 Not Found* dengan *layout* aplikasi yang rapi (bukan halaman *crash* bawaan Laravel). |
| AL-13 | Modul mencatat data sensitif (Password) | Update password user -> Cek Log Aktivitas dari proses tersebut | Log Aktivitas mencatat ada perubahan, tetapi *value* dari properti `password` ter-masking (misal: `*****`) bukan *plaintext*. |
| AL-14 | Menarik statistik pada *Date Range* yang tidak memiliki aktivitas | Buka statistik -> Set filter bulan lalu yang mana aplikasi belum launching | Grafik merender tampilan "No Data" secara rapi, bukan rusak/error *divide by zero*. |
| AL-15 | Injeksi XSS pada kolom User-Agent (Simulasi) | (Via API/Header) Kirim HTTP Request dengan User Agent memuat tag `<script>` | Tabel Activity Log melakukan validasi / *escaping* saat me-render tulisan User Agent sehingga script tidak tereksekusi. |
| AL-16 | Memilih banyak filter yang berlawanan dan tidak mungkin ada | Filter Modul: `Article` TAPI Filter Event: `Created User` | Sistem tidak error, tabel sukses menampilkan tulisan "Data log tidak ditemukan" dengan bersih. |
