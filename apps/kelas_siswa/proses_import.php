<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "excel_reader2.php";
include "akses.php";
ini_set('max_execution_time', 0);


function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}




// membaca file excel yang diupload
$data = new Spreadsheet_Excel_Reader($_FILES['excel']['tmp_name']);

// membaca jumlah baris dari data excel
$baris = $data->rowcount($sheet_index=0);

$sukses = 0;
$gagal = 0;

// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{

$nis=mysql_real_escape_string($data->val($i,1));



$m2=mysql_query("select  * from kelas_siswa where nis='$nis' and kelas='$_SESSION[kelas_c]' and tahun_ajaran='$tahun_aktif'");
$d2=mysql_fetch_array($m2);
if(!empty($d2[nis])){
  $q=mysql_query("update  kelas_siswa set nis='$nis' where nis='$nis' and kelas='$_SESSION[kelas_c]' and tahun_ajaran='$tahun_aktif'") or die("gagal".mysql_error());

}

else {


$q=mysql_query("INSERT INTO kelas_siswa(nis,kelas,tahun_ajaran) 
                                 
                         VALUES('$nis','$_SESSION[kelas_c]','$tahun_aktif')") or die("gagal".mysql_error());


}
if ($q) { $sukses++;
?><font color="#00CC33"><?php //echo"$nis $nama Sukses  atau berhasili di import <br>";?></font><?php
}
  else { $gagal++; ?><font color="#FF0000"> <?php //echo"Gagal import $nis $nama, cek data<br>"; ?></font><?php }
}

if(!empty($sukses or $gagal)){
// tampilan status sukses dan gagal
echo "<h3>Proses import data selesai.</h3>";
echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
echo "Jumlah data yang gagal diimport : ".$gagal."</p>";




}
