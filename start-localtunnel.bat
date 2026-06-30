@echo off
title LocalTunnel - Kenanga Posyandu
cls
echo =============================================================
echo               LOCALTUNNEL DEPLOYMENT (CUSTOM SUBDOMAIN)
echo =============================================================
echo.
echo Script ini akan mengekspos server lokal Anda menggunakan LocalTunnel.
echo Anda dapat memilih nama subdomain Anda sendiri!
echo.
echo Pastikan:
echo 1. Server Laravel sudah aktif (misal: "php artisan serve" di port 8000)
echo.
echo -------------------------------------------------------------
set /p SUBDOMAIN="Masukkan nama subdomain pilihan Anda (contoh: posyandu-kenanga): "
set /p PORT="Masukkan port lokal (default 8000): "

if "%PORT%"=="" set PORT=8000
if "%SUBDOMAIN%"=="" set SUBDOMAIN=posyandu-kenanga

echo.
echo -------------------------------------------------------------
echo Menghubungkan ke LocalTunnel dengan subdomain: %SUBDOMAIN%
echo Menuju port lokal: %PORT%
echo.
echo PENTING:
echo Jika browser meminta "Tunnel Password" saat pertama kali dibuka,
echo kunjungi https://whatsmyip.org untuk melihat IP Publik internet Anda,
echo lalu masukkan IP tersebut pada kolom yang disediakan.
echo -------------------------------------------------------------
echo.
echo Menjalankan tunnel... Tekan Ctrl+C untuk menghentikan.
echo.

npx localtunnel --port %PORT% --subdomain %SUBDOMAIN%
pause
