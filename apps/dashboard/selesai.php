<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
date_default_timezone_set("Asia/Jakarta");

$m=mysql_query("SELECT * from hasil_jwb where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]'");   
$d=mysql_fetch_array($m);

$mp=mysql_query("SELECT * from pengaturan");   
$dp=mysql_fetch_array($mp);

$lama=$dp[minimal_keluar_ujian];
$waktu_selesai_ujian=date('H:i:s',strtotime('-'.$lama.' seconds',strtotime($d[waktu_selesai])));

$waktus=date('H:i:s');         

if($waktus<$waktu_selesai_ujian){
$ok="$waktu_selesai_ujian";
}	
else {
$ok="sukses";
}
echo"$ok";
?>
