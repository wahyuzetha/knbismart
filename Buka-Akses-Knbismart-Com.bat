@echo off
:: ========================================================
:: Auto-elevate to Administrator (UAC Prompt)
:: ========================================================
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Meminta izin Administrator...
    powershell -Command "Start-Process '%~f0' -Verb RunAs"
    exit /b
)

title Pengaktifan Akses knbismart.com di Komputer Lokal
echo ========================================================
echo    PENGATURAN AKSES NORMAL KNBISMART.COM
echo ========================================================
echo.

:: 1. Cek & Daftarkan ke file hosts Windows
findstr /I /C:"knbismart.com" "%SystemRoot%\System32\drivers\etc\hosts" >nul
if %errorLevel% neq 0 (
    echo [..] Mendaftarkan domain knbismart.com ke komputer lokal...
    echo. >> "%SystemRoot%\System32\drivers\etc\hosts"
    echo 127.0.0.1 knbismart.com >> "%SystemRoot%\System32\drivers\etc\hosts"
    echo 127.0.0.1 www.knbismart.com >> "%SystemRoot%\System32\drivers\etc\hosts"
    echo [OK] Domain knbismart.com berhasil didaftarkan ke 127.0.0.1
) else (
    echo [OK] Domain knbismart.com sudah terdaftar di file hosts.
)

:: 2. Flush DNS Cache
echo [..] Membersihkan cache DNS Windows...
ipconfig /flushdns >nul
echo [OK] Cache DNS Windows telah diperbarui.

:: 3. Pastikan MySQL Lokal Aktif
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] Database MySQL sudah aktif.
) else (
    echo [..] Menjalankan MySQL lokal...
    start /B "" "C:\xamppqu\mysql\bin\mysqld.exe" --defaults-file="C:\xamppqu\mysql\bin\my.ini" --standalone
    timeout /t 2 >nul
    echo [OK] Database MySQL berhasil diaktifkan.
)

echo.
echo ========================================================
echo   SELESAI! Anda sekarang bisa membuka:
echo   - http://knbismart.com
echo   - http://knbismart.com/login
echo ========================================================
echo.
timeout /t 1 >nul
start http://knbismart.com/login
pause
