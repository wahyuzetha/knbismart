<?php
error_reporting(0);

session_start();
if($_SESSION[login_ujianonline]==0){
  header('location:../../login');
}
if($_SESSION[levelu]==3){
$cak=mysql_query("SELECT * FROM siswa WHERE nis='$_SESSION[id_pengguna]'");
$dcak=mysql_fetch_array($cak);
if($dcak[aktif]==2){
//	session_destroy();
 // header('Location: ../../login?h=nonaktif');

}
}
function ambil_ip() {
foreach (array('HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'REMOTE_ADDR', 'HTTP_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED') as $key) {
    if (array_key_exists($key, $_SERVER) === true) {
      foreach (explode(',', $_SERVER[$key]) as $ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
          return $ip;
        }
      }
    }
  }
}
$ip = ambil_ip();
?>
