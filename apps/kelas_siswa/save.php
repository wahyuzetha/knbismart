<?php 

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include"../../inc/meta.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$nis=anti_injection($_POST[siswa]);
$m2=mysql_query("select  * from kelas_siswa where nis='$nis' and kelas='$_SESSION[kelas_c]' and tahun_ajaran='$tahun_aktif'");
$d2=mysql_fetch_array($m2);
if(!empty($d2[nis])){
  header('Location: add?h=gagal&pesan=Duplikat Siswa ');
}

else {
if(!empty($nis)){


$q=mysql_query("INSERT INTO kelas_siswa(nis,kelas,tahun_ajaran) 
                                 
                         VALUES('$nis','$_SESSION[kelas_c]','$tahun_aktif')") or die("gagal".mysql_error());


}
else {
 
  header('Location: add?h=gagal');
}
 if($q) {
   
   header('Location: data?h=sukses');

}
}
?>
