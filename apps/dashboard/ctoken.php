<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";



$status_query = mysql_query("select * from rtoken where rtoken='$_POST[token]'");
$ps = mysql_fetch_array($status_query);

      if(!empty($ps[id])) {
echo"sukses";
}
else {
echo"Token tidak ditemukan'";
 } 
 

 ?>