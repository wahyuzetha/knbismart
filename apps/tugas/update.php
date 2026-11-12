<?php
include "../../inc/koneksi.php";
include "../../inc/aman.php";
if(isset($_POST["id"]))
{
 $value =$_POST["value"];
 $query = "UPDATE hasil_jwb_tugas SET ".$_POST["column_name"]."='".$value."' WHERE id = '".$_POST["id"]."'";
 if(mysql_query($query))
 {
  echo 'Data Updated';
 }
}
?>
