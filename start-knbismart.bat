@echo off
title KNBI SMART - Sistem Pembelajaran Online
echo ========================================================
echo   MEMULAI SISTEM KNBI SMART SMK KARYA NUGRAHA
echo ========================================================

:: 1. Cek & Jalankan MySQL jika belum aktif
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] Database MySQL sudah berjalan aktif.
) else (
    echo [..] Menjalankan MySQL dari C:\xamppqu...
    start /B "" "C:\xamppqu\mysql\bin\mysqld.exe" --defaults-file="C:\xamppqu\mysql\bin\my.ini" --standalone
    timeout /t 2 >nul
    echo [OK] Database MySQL berhasil diaktifkan.
)

echo.
echo ========================================================
echo  Situs KNBI SMART berjalan di: http://knbismart.test
echo  Halaman Login: http://knbismart.test/login
echo ========================================================
echo.
start http://knbismart.test
pause
