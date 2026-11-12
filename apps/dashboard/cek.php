<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m=mysql_query("select  * from ujian where id='$_SESSION[id_ujian]'");   
$d=mysql_fetch_array($m);

    $right_answer=0;
    $wrong_answer=0;
    $unanswered=0; 
   $keys=array_keys($_POST);
   $order=join(",",$keys);
     $nilai_akhir=0;

$sql = array(); 
$response=mysql_query("select * from bank_soal limit 40")   or die(mysql_error());
  
   while($result=mysql_fetch_array($response)){
      
    $sql[] = $result[id];


   }
   $c=implode(',', $sql);


 $save_ins=mysql_query("insert into hasil_jwb (id_ujian,nis,waktu_mulai,waktu_selesai,tanggal,ip,pengacak) 
    values('$id_ujian','$nis','$waktu_ujian_start','$waktu_selesai_ujian','$tgl_ini','$ip','$c')") or die("gagal save".mysql_error());



 ?>