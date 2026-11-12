<?php
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}

$idk=anti_injection($_POST['no_id']);

  $nm=mysql_query("SELECT * from koment_forum where id='$idk'");
    $dnm=mysql_fetch_array($nm);
    unlink("../../imgforum/$dnm[gambar]");
    unlink("../../fileforum/$dnm[file]");
    
     $nm2=mysql_query("SELECT * from koment_sub_forum where id_komen='$idk'");
    while($dnm2=mysql_fetch_array($nm2)){
    unlink("../../imgforum/$dnm2[gambar]");
    unlink("../../fileforum/$dnm2[file]");
    }
$q=mysql_query("DELETE FROM koment_forum WHERE id='$idk'")  ; 
$q=mysql_query("DELETE FROM koment_sub_forum WHERE id_komen='$idk'")  ; 

 if($q){
 echo"sukses";
 }
 

?> 

