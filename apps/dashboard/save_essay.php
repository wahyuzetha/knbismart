<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$essay = anti_injection($_POST['jessay']);
$download = anti_injection($_POST['download']);



                   
$upd=mysql_query("update hasil_jwb set essay='$essay',file='$download'
                 where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]'") or die("gagal save 2".mysql_error());    









    

   
?>