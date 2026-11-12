<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";

error_reporting(0);
if($_POST[view]==2){
	$update_query = "UPDATE hasil_jwb SET komentar = ''  where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' ";
    mysql_query($update_query);

}

$status_query = "select * from hasil_jwb where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' and komentar!=''";
$result_query = mysql_query($status_query);
$ps = mysql_fetch_array($result_query);
$pesan=$ps[komentar];
$count = mysql_num_rows($result_query);
$data = array(
    'notification' => $pesan,
    'unseen_notification'  => $count
);
echo json_encode($data);

      

 ?>