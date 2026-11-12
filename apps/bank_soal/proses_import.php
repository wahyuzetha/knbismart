<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "excel_reader2.php";
include "akses.php";


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

$id=$_POST[id_ujian];
//echo"$id";
// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
$no_soal=mysql_real_escape_string($data->val($i,1));
$soal=mysql_real_escape_string($data->val($i,2));
$opsia=mysql_real_escape_string($data->val($i,3));
$opsib=mysql_real_escape_string($data->val($i,4));
$opsic=mysql_real_escape_string($data->val($i,5));
$opsid=mysql_real_escape_string($data->val($i,6));
$opsie=mysql_real_escape_string($data->val($i,7));
$point=mysql_real_escape_string($data->val($i,8));
$kunci=mysql_real_escape_string($data->val($i,9));

//echo"soal $soal";

if(!empty($soal)){


//soal
$m3=mysql_query("select  * from bank_soal where id_ujian='$id' and no_soal='$no_soal'");
$d3=mysql_fetch_array($m3);

if(empty($d3[soal]) ){

$q2=mysql_query("INSERT INTO bank_soal(id_ujian,soal,kunci,point,pila,pilb,pilc,pild,pile,no_soal) 
VALUES('$id','$soal','$kunci','$point','$opsia','$opsib','$opsic','$opsid','$opsie','$no_soal')") or die("gagal".mysql_error());



}
else {

$q2=mysql_query("update bank_soal set soal='$soal',kunci='$kunci',point='$point',
				pila='$opsia',
				pilb='$opsib',
				pilc='$opsic',
				pild='$opsid',
				pile='$opsie'
				where no_soal='$no_soal' and id_ujian='$id'") or die("gagal".mysql_error());




}




}

if ($q2) { $sukses++;
?><!--<font color="#00CC33"><?php echo"$soal Sukses  atau berhasili di import <br>";?></font>--><?php
}
  else { $gagal++; ?><!--<font color="#FF0000"> <?php echo"Gagal import $soal, cek data<br>"; ?></font>--><?php }
}
if(!empty($_POST[id_ujian])){
// tampilan status sukses dan gagal
echo "<h3>Proses import data selesai.</h3>";
echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
echo "Jumlah data yang gagal diimport : ".$gagal."</p>";




}



