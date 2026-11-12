<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
$file = anti_injection($_GET['jfile']);
$full = anti_injection($_GET['full']);
$id_tugas = anti_injection($_GET['id_tugas']);
$id_pembelajaran = anti_injection($_GET['id_pembelajaran']);

$hp=unlink("../../tugas/$file");
$jfile=str_replace($file,"",$full);
if($hp){
      $tgl_s=date('Y-m-d');
     $his_jam=date('H:i:s');
 $q=mysql_query("update  hasil_jwb_tugas set jfile='$jfile',tanggal='$tgl_s',jam='$his_jam',timestmp=NOW(),ip='$ip' 
                where nis='$_SESSION[namauser]' and id_tugas='$id_tugas' and id_pembelajaran='$id_pembelajaran'") or die("gagal".mysql_error());
    
 }   

 if($q) {
  header('Location: detail_tugas_2?d='.$id_tugas.'&id_pembelajaran='.$id_pembelajaran); 
} 

?>