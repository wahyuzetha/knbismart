<?php
error_reporting(0);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/mysql_shim.php';

// Detect local environment (Herd / localhost / CLI)
$http_host = $_SERVER['HTTP_HOST'] ?? '';
$is_local = (
    strpos($http_host, 'localhost') !== false ||
    strpos($http_host, '127.0.0.1') !== false ||
    strpos($http_host, '.test') !== false ||
    php_sapi_name() === 'cli'
);

if ($is_local) {
    $server = "127.0.0.1";
    $user = "root";
    $passwd = "";
    $dbs = "admin_apps_belajar";
} else {
    // Production VPS Configuration
    $server = "localhost";
    $user = "admin_apps";
    $passwd = "xo2sciLAZA";
    $dbs = "admin_apps_belajar";
}

$konek = mysql_connect($server, $user, $passwd)
    or die("Gagal Koneksi dengan Database: " . mysql_error()); 
$bukadb = mysql_select_db($dbs, $konek)
    or die("Gagal membuka Database: " . mysql_error());

date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');

$thn = mysql_query("select * from tahun_ajaran where aktif='1'"); 
$dthn = mysql_fetch_array($thn);
$smt = mysql_query("select * from semester where aktif='1'"); 
$dsmt = mysql_fetch_array($smt);   
                 
$tahun_aktif = $dthn['namathn'] ?? '';
$semester_aktif = $dsmt['semester'] ?? '';
			
$jam_selesai_pelajaran_tutup = "16:00";			
$tanggal_pelajaran_aktif_s = date('Y-m-d');			
   
$jam_aktif_server = date('H:i:s');			
?>
