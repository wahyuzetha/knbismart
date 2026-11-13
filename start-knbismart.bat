@echo off
title KNBI SMART - Komputer Lokal (Localhost)
echo ========================================================
echo   MEMULAI SISTEM KNBI SMART SMK KARYA NUGRAHA (LOKAL)
echo ========================================================
echo.

:: 1. Cek & Jalankan Database MySQL Lokal
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] Database MySQL Lokal sudah berjalan aktif.
) else (
    echo [..] Menjalankan MySQL Lokal dari C:\xamppqu...
    start /B "" "C:\xamppqu\mysql\bin\mysqld.exe" --defaults-file="C:\xamppqu\mysql\bin\my.ini" --standalone
    timeout /t 2 >nul
    echo [OK] Database MySQL Lokal berhasil diaktifkan.
)

:: 2. Info Alamat Akses
echo.
echo ========================================================
echo  STATUS SISTEM LOKAL:
echo  - Alamat Utama : http://localhost:8080
echo  - Halaman Login: http://localhost:8080/login
echo  - Alamat Alternatif: http://knbismart.test
echo  - Database     : admin_apps_belajar (MySQL Lokal)
echo  - Server VPS   : Aman, sama sekali tidak tersentuh
echo ========================================================
echo.
echo Membuka browser ke http://localhost:8080 ...
timeout /t 1 >nul
start http://localhost:8080
pause
