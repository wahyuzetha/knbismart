<?php
include"../../inc/koneksi.php";
include"../../inc/aman.php";


$jum=mysql_query("select count(id) as jum from koment_sub_forum where id_komen='$_POST[id_komen]'");
$djum=mysql_fetch_array($jum);

echo"$djum[jum]";
?>