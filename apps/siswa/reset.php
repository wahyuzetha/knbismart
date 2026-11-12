<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include"../../inc/meta.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
    $del=mysql_query("delete from tingkat");
    $del=mysql_query("delete from kelas");


$q=mysql_query("select siswa.*,kelas_siswa.kelas as nm_kelas from kelas_siswa,siswa
WHERE siswa.nis=kelas_siswa.nis and kelas_siswa.tahun_ajaran='$_SESSION[thn_ajarann]'") ; 
while($dq=mysql_fetch_array($q)){
    $del=mysql_query("delete from siswa where nis='$dq[nis]'");
    $del=mysql_query("delete from kelas_siswa where nis='$dq[nis]' and tahun_ajaran='$_SESSION[thn_ajarann]'");
    $del=mysql_query("delete from users where id_pengguna='$dq[nis]'");

}
//$q=mysql_query("delete from kelas where tahun_ajaran='$_SESSION[thn_ajarann]'");

 if($q) {
 header('Location: data?h=suskesh');
} 
?>
