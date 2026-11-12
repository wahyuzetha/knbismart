<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);


$response=mysql_query("select * from bank_soal limit 1")   or die(mysql_error());
  
   while($result=mysql_fetch_array($response)){
      
    $sql[] = $result[id];






    

   }
   $c=implode(',', $sql);

echo"$c";
 
 ?>