<?php 

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include"../../inc/meta.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
ini_set('date.timezone', 'Asia/Jakarta');
$tgl=date("Ymdhis");
$jenis = "A.$tgl";
$q=mysql_query("DELETE FROM pengawas_ujian WHERE id_peg='$_POST[nuptk]'") ; 

$t=$_POST[tanggal];
$tanggal = explode(',',$t);
foreach($tanggal as $tgl_k) {    
$q=mysql_query("INSERT INTO pengawas_ujian(tanggal,id_peg) 
                                 
                         VALUES('$tgl_k','$_POST[nuptk]')") or die("gagal".mysql_error());
}

 if($q) {
header('Location: pengawas?h=sukses&d='.$_POST[nuptk]);
     
 } 

?>
