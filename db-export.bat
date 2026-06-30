@echo off
title Export Database - Kenanga Posyandu
cls
echo =============================================================
echo                 EXPORT DATABASE POSYANDU
echo =============================================================
echo.
echo Script ini akan mengekspor database lokal 'posyandu_db' 
echo ke file 'database/db_snapshot.sql'.
echo.
echo Mencari mysqldump di XAMPP...
if exist C:\xampp\mysql\bin\mysqldump.exe (
    set MYSQLDUMP=C:\xampp\mysql\bin\mysqldump.exe
) else (
    set MYSQLDUMP=mysqldump
)

echo Mengekspor database...
"%MYSQLDUMP%" -u root posyandu_db > database/db_snapshot.sql

if %ERRORLEVEL% equ 0 (
    echo.
    echo [SUKSES] Berhasil mengekspor database ke: database/db_snapshot.sql
    echo.
    echo Langkah selanjutnya:
    echo 1. Lakukan git add, commit, dan push file database/db_snapshot.sql.
    echo 2. Teman Anda tinggal pull dan jalankan "db-import.bat".
) else (
    echo.
    echo [ERROR] Gagal mengekspor database.
    echo Pastikan MySQL di XAMPP Anda aktif dan berjalan.
)
echo.
pause
