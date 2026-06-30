@echo off
title Cloudflare Tunnel - Kenanga Posyandu
cls
echo =============================================================
echo               CLOUDFLARE TUNNEL DEPLOYMENT
echo =============================================================
echo.
echo Script ini akan mengekspos server lokal Anda ke internet.
echo.
echo Pastikan Anda telah melakukan hal-hal berikut:
echo 1. Menjalankan server lokal Anda (misal: "php artisan serve" 
echo    atau Apache XAMPP).
echo 2. Menjalankan "npm run build" agar asset CSS/JS dikompilasi 
echo    dan bisa diakses via HTTPS secara aman.
echo.
echo -------------------------------------------------------------
echo Pilih port/URL lokal yang ingin diekspos:
echo 1. php artisan serve (http://localhost:8000) [Rekomendasi]
echo 2. XAMPP Apache (http://localhost:80)
echo 3. Docker Compose Nginx (http://localhost:8181)
echo 4. Kustom URL/Port (Anda akan diminta memasukkan URL)
echo -------------------------------------------------------------
set /p pilihan="Masukkan pilihan (1-4, default 1): "

if "%pilihan%"=="" set pilihan=1
if "%pilihan%"=="1" set TARGET_URL=http://localhost:8000
if "%pilihan%"=="2" set TARGET_URL=http://localhost:80
if "%pilihan%"=="3" set TARGET_URL=http://localhost:8181
if "%pilihan%"=="4" (
    set /p TARGET_URL="Masukkan URL lokal lengkap (contoh: http://localhost:8080): "
)

echo.
echo Menghubungkan %TARGET_URL% ke Cloudflare...
echo Salin alamat URL *.trycloudflare.com yang muncul di bawah nanti.
echo Tekan Ctrl+C untuk menghentikan tunnel.
echo.
.\cloudflared.exe tunnel --url %TARGET_URL%
pause
