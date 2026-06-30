@echo off
title Import Database - Kenanga Posyandu
cls
echo =============================================================
echo                 IMPORT DATABASE POSYANDU
echo =============================================================
echo.
echo Script ini akan mengimpor file 'database/db_snapshot.sql'
echo ke database lokal 'posyandu_db' Anda.
echo.
echo WARNING: Tindakan ini akan menimpa data database lokal Anda saat ini!
echo.
set /p CONFIRM="Apakah Anda yakin ingin melanjutkan? (y/n, default n): "
if /i "%CONFIRM%" neq "y" goto end

echo.
echo Mencari mysql di XAMPP...
if exist C:\xampp\mysql\bin\mysql.exe (
    set MYSQL=C:\xampp\mysql\bin\mysql.exe
) else (
    set MYSQL=mysql
)

echo Mengimpor database...
"%MYSQL%" -u root -e "CREATE DATABASE IF NOT EXISTS posyandu_db;"
"%MYSQL%" -u root posyandu_db < database/db_snapshot.sql

if %ERRORLEVEL% equ 0 (
    echo.
    echo [SUKSES] Berhasil mengimpor database dari: database/db_snapshot.sql
    echo Data lokal Anda sekarang sama dengan data teman Anda!
) else (
    echo.
    echo [ERROR] Gagal mengimpor database.
    echo Pastikan MySQL di XAMPP Anda aktif dan file 'database/db_snapshot.sql' sudah ada.
)

:end
echo.
pause
