# Blackbox Testing - Halaman Login

## Daftar Test Case (20 Test Cases)

### A. Positive Test Cases (10 Test Cases)

| ID | Test Case | Langkah-langkah | Data Input | Expected Result | Actual Result | Pass/Fail |
|----|-----------|-----------------|------------|-----------------|---------------|-----------|
| TC001 | Login berhasil dengan kredensial valid | 1. Buka halaman login<br>2. Masukkan username yang valid<br>3. Masukkan password yang valid<br>4. Klik tombol "Login" | Username: `user@example.com`<br>Password: `Password123!` | User berhasil login dan diarahkan ke dashboard/halaman utama |  |  |
| TC002 | Login berhasil dengan username email format | 1. Buka halaman login<br>2. Masukkan email dalam format yang benar<br>3. Masukkan password yang valid<br>4. Klik tombol "Login" | Username: `admin@company.com`<br>Password: `SecurePass456!` | User berhasil login dan diarahkan ke dashboard |  |  |
| TC003 | Login berhasil dengan tombol Enter | 1. Buka halaman login<br>2. Masukkan username yang valid<br>3. Masukkan password yang valid<br>4. Tekan tombol Enter pada keyboard | Username: `testuser@example.com`<br>Password: `TestPass789!` | User berhasil login dan diarahkan ke dashboard |  |  |
| TC004 | Login berhasil dengan username case-insensitive | 1. Buka halaman login<br>2. Masukkan username dengan huruf kapital/campur<br>3. Masukkan password yang valid<br>4. Klik tombol "Login" | Username: `USER@EXAMPLE.COM`<br>Password: `Password123!` | User berhasil login (sistem tidak case-sensitive untuk username) |  |  |
| TC005 | Login berhasil dengan password mengandung special character | 1. Buka halaman login<br>2. Masukkan username yang valid<br>3. Masukkan password dengan karakter khusus<br>4. Klik tombol "Login" | Username: `user@example.com`<br>Password: `P@ssw0rd!#$%` | User berhasil login dengan password yang mengandung special character |  |  |
| TC006 | Login berhasil dengan remember me checkbox | 1. Buka halaman login<br>2. Masukkan kredensial valid<br>3. Centang "Remember Me"<br>4. Klik tombol "Login" | Username: `user@example.com`<br>Password: `Password123!` | User berhasil login dan session tersimpan untuk login berikutnya |  |  |
| TC007 | Login berhasil dengan spasi di awal/akhir username | 1. Buka halaman login<br>2. Masukkan username dengan spasi di awal/akhir<br>3. Masukkan password yang valid<br>4. Klik tombol "Login" | Username: `  user@example.com  `<br>Password: `Password123!` | Sistem otomatis trim spasi dan user berhasil login |  |  |
| TC008 | Login berhasil dengan password panjang maksimal | 1. Buka halaman login<br>2. Masukkan username yang valid<br>3. Masukkan password dengan panjang maksimal (misal 128 karakter)<br>4. Klik tombol "Login" | Username: `user@example.com`<br>Password: `[128 karakter]` | User berhasil login dengan password panjang maksimal |  |  |
| TC009 | Login berhasil setelah reset password | 1. Buka halaman login<br>2. Masukkan username yang baru direset passwordnya<br>3. Masukkan password baru yang valid<br>4. Klik tombol "Login" | Username: `user@example.com`<br>Password: `NewPassword123!` | User berhasil login dengan password yang baru direset |  |  |
| TC010 | Login berhasil dengan multi-factor authentication (jika ada) | 1. Buka halaman login<br>2. Masukkan kredensial valid<br>3. Masukkan kode OTP/MFA yang benar<br>4. Klik tombol "Verify" | Username: `user@example.com`<br>Password: `Password123!`<br>OTP: `123456` | User berhasil login setelah verifikasi MFA |  |  |

---

### B. Negative Test Cases (10 Test Cases)

| ID | Test Case | Langkah-langkah | Data Input | Expected Result | Actual Result | Pass/Fail |
|----|-----------|-----------------|------------|-----------------|---------------|-----------|
| TC011 | Login gagal dengan username tidak terdaftar | 1. Buka halaman login<br>2. Masukkan username yang tidak terdaftar<br>3. Masukkan password apapun<br>4. Klik tombol "Login" | Username: `unknown@example.com`<br>Password: `Password123!` | Muncul pesan error "Username tidak ditemukan" atau serupa, user tetap di halaman login |  |  |
| TC012 | Login gagal dengan password salah | 1. Buka halaman login<br>2. Masukkan username yang valid<br>3. Masukkan password yang salah<br>4. Klik tombol "Login" | Username: `user@example.com`<br>Password: `WrongPassword123!` | Muncul pesan error "Password salah", user tetap di halaman login |  |  |
| TC013 | Login gagal dengan username kosong | 1. Buka halaman login<br>2. Biarkan field username kosong<br>3. Masukkan password apapun<br>4. Klik tombol "Login" | Username: `[kosong]`<br>Password: `Password123!` | Muncul pesan error "Username harus diisi", form tidak submit |  |  |
| TC014 | Login gagal dengan password kosong | 1. Buka halaman login<br>2. Masukkan username yang valid<br>3. Biarkan field password kosong<br>4. Klik tombol "Login" | Username: `user@example.com`<br>Password: `[kosong]` | Muncul pesan error "Password harus diisi", form tidak submit |  |  |
| TC015 | Login gagal dengan kedua field kosong | 1. Buka halaman login<br>2. Biarkan kedua field kosong<br>3. Klik tombol "Login" | Username: `[kosong]`<br>Password: `[kosong]` | Muncul pesan error untuk kedua field, form tidak submit |  |  |
| TC016 | Login gagal dengan SQL Injection attempt | 1. Buka halaman login<br>2. Masukkan script SQL injection di username<br>3. Masukkan password apapun<br>4. Klik tombol "Login" | Username: `' OR '1'='1`<br>Password: `anything` | Sistem menolak input, muncul pesan error atau tidak terjadi SQL injection |  |  |
| TC017 | Login gagal dengan XSS script attempt | 1. Buka halaman login<br>2. Masukkan script XSS di field username/password<br>3. Klik tombol "Login" | Username: `<script>alert('XSS')</script>`<br>Password: `Password123!` | Sistem menolak input atau script tidak dieksekusi, tidak ada alert muncul |  |  |
| TC018 | Login gagal dengan password case-sensitive | 1. Buka halaman login<br>2. Masukkan username yang valid<br>3. Masukkan password dengan huruf kecil semua (padahal seharusnya campuran)<br>4. Klik tombol "Login" | Username: `user@example.com`<br>Password: `password123!` (seharusnya `Password123!`) | Muncul pesan error "Password salah" (password bersifat case-sensitive) |  |  |
| TC019 | Login gagal dengan akun terkunci/ternonaktifkan | 1. Buka halaman login<br>2. Masukkan kredensial akun yang terkunci/nonaktif<br>3. Klik tombol "Login" | Username: `locked@example.com`<br>Password: `Password123!` | Muncul pesan error "Akun Anda terkunci" atau "Akun tidak aktif", user tidak bisa login |  |  |
| TC020 | Login gagal setelah multiple failed attempts (account lockout) | 1. Buka halaman login<br>2. Lakukan 5x login gagal berturut-turut dengan kredensial salah<br>3. Coba login lagi pada percobaan ke-6 | Username: `user@example.com`<br>Password: `WrongPassword` (5x berturut-turut) | Akun terkunci sementara, muncul pesan "Terlalu banyak percobaan gagal, coba lagi dalam X menit" |  |  |

---

## Kriteria Pengujian

### Prerequisites (Prasyarat)
1. Aplikasi web sudah deployed dan dapat diakses
2. Database sudah berisi data user untuk testing
3. Browser modern tersedia (Chrome, Firefox, Safari, Edge)
4. Koneksi internet stabil (jika aplikasi online)

### Test Environment
- **Browser**: Chrome v120+, Firefox v121+, Safari v17+
- **OS**: Windows 10/11, macOS, Linux
- **Network**: WiFi/Ethernet dengan kecepatan minimal 10 Mbps

### Defect Severity Levels
- **Critical**: Sistem crash, SQL injection berhasil, data bocor
- **High**: Login tidak berfungsi sama sekali, error handling buruk
- **Medium**: Pesan error tidak jelas, UI tidak responsif
- **Low**: Typo pada pesan error, minor UI issues

### Exit Criteria
- Semua 20 test cases telah dieksekusi
- Minimal 95% test cases pass (19/20)
- Tidak ada defect dengan severity Critical atau High yang terbuka
- Semua defect yang ditemukan telah didokumentasikan

---

## Template Laporan Bug

```markdown
**Bug ID**: [BUG-LOGIN-001]
**Title**: [Judul singkat deskriptif]
**Severity**: [Critical/High/Medium/Low]
**Priority**: [High/Medium/Low]
**Test Case ID**: [TCXXX]

**Description**:
[Deskripsi detail tentang bug]

**Steps to Reproduce**:
1. [Langkah 1]
2. [Langkah 2]
3. [Langkah 3]

**Expected Result**:
[Hasil yang seharusnya terjadi]

**Actual Result**:
[Hasil yang sebenarnya terjadi]

**Environment**:
- Browser: [Nama dan versi]
- OS: [Sistem operasi]
- URL: [URL halaman login]

**Screenshot/Video**:
[Lampirkan jika ada]

**Reported By**: [Nama tester]
**Date**: [Tanggal pelaporan]
```

---

## Catatan Tambahan

1. **Security Testing**: Pastikan untuk tidak melakukan testing SQL injection atau XSS yang agresif di production environment
2. **Data Privacy**: Gunakan data dummy untuk testing, jangan gunakan kredensial real user
3. **Rate Limiting**: Hati-hati dengan test case TC020, pastikan tidak mengunci akun production secara tidak sengaja
4. **Session Management**: Verifikasi bahwa session management bekerja dengan baik setelah login berhasil
5. **Responsive Design**: Testing juga harus dilakukan di berbagai ukuran layar (desktop, tablet, mobile)

---

*Dokumen ini dibuat untuk keperluan blackbox testing halaman login dengan total 20 test cases (10 positive dan 10 negative)*
