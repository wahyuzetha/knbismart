<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);


$q=mysql_query("DELETE FROM users WHERE id='$id'") ; 

 if($q) {
header('Location: data?h=suksesh');
}
else {
echo"gagal"; } 
  
?> 

