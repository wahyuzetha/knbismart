# KNBI SMART - Sistem Pembelajaran Online SMK Karya Nugraha

Sistem Pembelajaran Online & Computer Based Testing (CBT) SMK Karya Nugraha.

## Persyaratan Sistem
- Web Server: Nginx (Laravel Herd) / Apache
- PHP: PHP 7.4 (atau PHP 8.x dengan `inc/mysql_shim.php`)
- Database: MySQL / MariaDB (Port 3306)

## Cara Menjalankan di Lokal (Komputer Lokal)
1. **Jalankan Database MySQL**:
   Klik dua kali file `start-knbismart.bat` atau jalankan MySQL melalui XAMPP / MariaDB.
2. **Akses Web**:
   Buka browser dan kunjungi:
   - URL Utama: [http://knbismart.test](http://knbismart.test)
   - Halaman Login: [http://knbismart.test/login](http://knbismart.test/login)

## Konfigurasi Database
File konfigurasi database berada di `inc/koneksi.php`. Sistem secara otomatis mendeteksi apakah aplikasi berjalan di server produksi atau komputer lokal:
- **Lokal**: Menggunakan user `root` (tanpa password) dengan database `admin_apps_belajar`.
- **Produksi (VPS)**: Menggunakan user `admin_apps` dengan password produksi.
