<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$id = anti_injection($_POST['d']);


$q=mysql_query("DELETE FROM berita WHERE id='$id'") ; 

if($q) {

header('Location: data?h=sukses');	

}
else {
    $errorg=mysql_error();
header('Location: data?h=gagal&&pesan='.$errorg); 
} 
 ?>