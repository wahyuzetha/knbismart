<?php
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}

$idk=anti_injection($_POST['no_id']);
  $nm=mysql_query("SELECT * from koment_sub_forum where id='$idk'");
    $dnm=mysql_fetch_array($nm);
    unlink("../../imgforum/$dnm[gambar]");
    unlink("../../fileforum/$dnm[file]");

$q=mysql_query("DELETE FROM koment_sub_forum WHERE id='$idk'")  ; 

 if($q){
 echo"sukses";
 }
 

?> 

