<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
if($_SESSION[levelu]==1){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Data Siswa</title>
<?php
header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=Data Siswa.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

?>
</head>

<body>
<p><strong>DATA SISWA </strong></p>
<table width="100%" border="1">
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>NIS</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>USERNAME</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>NAMA</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>KELAS</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>PASSWORD</strong></td>
  </tr>
<?php
$empQuery = "SELECT siswa.*,kelas_siswa.kelas as nm_kelas from kelas_siswa,siswa
WHERE siswa.nis=kelas_siswa.nis ".$searchQuery." 
order by siswa.nis asc";
$empRecords = mysql_query($empQuery);

while ($row = mysql_fetch_assoc($empRecords)) {
	$m2=mysql_query("select  * from users where id_pengguna='$row[nis]'");
$dusr=mysql_fetch_array($m2); 

?>	
  <tr>
    <td align="center"><?php echo"$row[nis] &nbsp";?></td>
    <td align="center"><?php echo"$dusr[username] &nbsp";?></td>
    <td><?php echo"$row[nama]";?></td>
    <td align="center"><?php echo"$row[kelas]";?></td>
    <td align="center"><?php echo"$row[pas]";?></td>
  </tr>
<?php } ?>
</table>
</body>
</html>
<?php } ?>