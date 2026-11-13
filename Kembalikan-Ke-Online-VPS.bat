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

title Kembalikan Domain knbismart.com ke Server Online VPS
echo ========================================================
echo   MENGEMBALIKAN KNBISMART.COM KE SERVER ONLINE VPS
echo ========================================================
echo.

powershell -Command "(Get-Content '%SystemRoot%\System32\drivers\etc\hosts') | Where-Object { $_ -notmatch 'knbismart\.com' } | Set-Content '%SystemRoot%\System32\drivers\etc\hosts'"
ipconfig /flushdns >nul

echo [OK] Pengalihan lokal telah dihapus.
echo [OK] Sekarang domain knbismart.com kembali mengarah ke VPS Online (76.13.20.119).
echo.
pause
