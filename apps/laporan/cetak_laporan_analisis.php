<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
ini_set('max_execution_time', '0'); // for infinite time of execution 
ini_set("memory_limit","-1");
 $query1 = "select * from pembelajaran where id = '$_GET[pembelajaran]'";
	$results1 	= mysql_query( $query1);
	$row1=mysql_fetch_assoc($results1);
	
	$query = "select pembelajaran.pembelajaran,ujian.* from pembelajaran,ujian 
    where ujian.id_pembelajaran=pembelajaran.id and ujian.id = '$_GET[ujian]'";
	$results 	= mysql_query( $query);
	$row=mysql_fetch_assoc($results);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Laporan Nilai</title>
<?php
if($_GET[jenis]=="excel"){
header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=Laporan Nilai Kelas '.$_GET[kelas].' Mapel '.$row[pembelajaran].' '.$row[nama_ujian].' .xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
}
else if($_GET[jenis]=="pdf"){
   ob_start();
   $nama_dokumen='Laporan Nilai Kelas '.$_GET[kelas].' Mapel '.$row[pembelajaran].' '.$row[nama_ujian].''; //Beri nama file PDF hasil.
define('_MPDF_PATH','../../MPDF57/');
include(_MPDF_PATH . "mpdf.php");
 
$mpdf=new mPDF('c', 'A4');  // Create new mPDF Document

$tgl=date('d/m/Y H:i:s');
$mpdf->SetFooter('Laporan Nilai |'.$tgl.'|{PAGENO}');

 } 
else if($_GET[jenis]=="normal"){
}

 ?>
<style type="text/css">
<!--
.style1 {font-size: 16px}
-->
</style>
</head>

<body>
<?php

function plainText($text)
{
    $text = strip_tags($text);
    $text = trim(preg_replace(['/<[^>]*>/','/\s+/'],' ', $text));

    return $text;
}

if(!empty($_GET[jenis])){
?>
<p align="center"><strong>Laporan Nilai Kleas <?php echo strtoupper($_GET[kelas]); echo"<br>";
echo"MATAPELAJARAN ";  echo strtoupper($row[pembelajaran]); echo"<br>";
echo strtoupper($row[nama_ujian]);
?> </strong></p>

<table border="1" style="border-collapse: collapse; color: #000;" width="100%">
  <tr>
    <td width="30" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>NO</strong></td>
    <td width="100" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>NIS </strong></td>
    <td width="270" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>NAMA</strong></td>
 <?php
	$nr=0;
	$banksoalr=mysql_query("select  * from bank_soal where id_ujian='$_GET[ujian]' order by id asc")or die("ss".mysql_error());   
	while($dbanksoalr=mysql_fetch_array($banksoalr)){
	$nr++;	
	}
	?>	   
   <td height="35" colspan="<?php echo"$nr";?>" align="center" bgcolor="#FFFF00" ><strong>JAWABAN</strong></td>
	
    <td colspan="4" align="center" bgcolor="#FFFF00" ><strong>PILIHAN GANDA</strong></td>
					  	<?php if($row[status_essay_auto]==1){?>

    <td colspan="4" align="center" bgcolor="#FFFF00" ><strong>ESSAY SINGKAT </strong></td>
						<?php }
						if($row[status_essay]==1){?>

    <td width="30" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>ESSAY MANUAL </strong></td>
						<?php } ?>
    <td width="30" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>NILAI AKHIR </strong></td>
  </tr>
  <tr>
    <?php
	$n=0;
	$banksoal=mysql_query("select  * from bank_soal where id_ujian='$_GET[ujian]' order by id asc")or die("ss".mysql_error());   
	while($dbanksoal=mysql_fetch_array($banksoal)){
	$n++;	
	?>				
	<td height="35" align="center" bgcolor="#FFFF00" ><strong><?php echo"$n <br> $dbanksoal[kunci]";?></strong></td>
	<?php } ?>
	<td width="30" align="center" bgcolor="#FFFF00" ><strong>BENAR</strong></td>
	<td width="30" align="center" bgcolor="#FFFF00" ><strong>SALAH</strong></td>
	<td width="30" align="center" bgcolor="#FFFF00" ><strong>KOSONG</strong></td>
	<td width="30" align="center" bgcolor="#FFFF00" ><strong>NILAI</strong></td>
					  	<?php if($row[status_essay_auto]==1){?>

	<td align="center" bgcolor="#FFFF00" ><strong>BENAR</strong></td>
	<td align="center" bgcolor="#FFFF00" ><strong>SALAH</strong></td>
	<td align="center" bgcolor="#FFFF00" ><strong>KOSONG</strong></td>
	<td align="center" bgcolor="#FFFF00" ><strong>NILAI</strong></td>
						<?php } ?>
	
 
  </tr>
      <?php
	  $no=0;
           $m=mysql_query("select  * from siswa where kelas='$_GET[kelas]' and kelas!='' order by nama asc");   
		
				$ujiand=mysql_query("select  * from ujian where id='$_GET[ujian]'")or die("ss".mysql_error());   
                $dujiand=mysql_fetch_array($ujiand); 					
				while($d=mysql_fetch_array($m)){
                $nn=mysql_query("select  * from hasil_jwb where nis='$d[nis]' and id_ujian='$_GET[ujian]' order by nilai desc");   
                $dn=mysql_fetch_array($nn);
            $no++;     
            $nialais=$dn[benar]/$djsoal[jum]*$dujiand[skala];
            
            $na_essay=$dn[nilai]+$dn[nilai_essay_auto]+$dn[nilai_essay];
            $na_essay=number_format($na_essay,0);
            ?>      
           
                  <tr>
				<td align="center"><?php echo"$no";?> </td>

				<td align="center"><?php echo"$d[nis]";?> </td>
				<td><?php echo"$d[nama]";?> </td>
				<?php
	$banksoala=mysql_query("SELECT hasil_opsi.*,bank_soal.soal,bank_soal.kunci from bank_soal
LEFT JOIN hasil_opsi on hasil_opsi.id_soal=bank_soal.id and hasil_opsi.nis='$d[nis]'
WHERE bank_soal.id_ujian='$_GET[ujian]' order by bank_soal.id asc")or die("ss".mysql_error());   
	while($dbanksoala=mysql_fetch_array($banksoala)){
	
	
	if($dbanksoala[point]>0){
		$bg="";
	}
	else {
		$bg="red";
	}
	?>				
	<td align="center" bgcolor="<?php echo"$bg";?>" ><strong><?php echo"$dbanksoala[opsi]";?></strong></td>
	<?php } ?>
	<td align="center"><?php echo"$dn[benar]";?> </td>
	<td align="center"><?php echo"$dn[salah]";?> </td>
	<td align="center"><?php echo"$dn[kosong]";?> </td>
	<td align="center"><?php echo"$dn[nilai]";?> </td>
					  	<?php if($row[status_essay_auto]==1){?>

	<td align="center"><?php echo"$dn[benar_essay_auto]";?> </td>
	<td align="center"><?php echo"$dn[salah_essay_auto]";?> </td>
	<td align="center"><?php echo"$dn[kosong_essay_auto]";?> </td>
	<td align="center"><?php echo"$dn[nilai_essay_auto]";?> </td>
						<?php }
										   if($row[status_essay]==1){?>

	<td align="center"><?php echo"$dn[nilai_essay]";?></td>
										   <?php } ?>
	<td align="center"><?php echo"$na_essay";?> </td>
	
				                     
                                        </tr>
                    <?php } ?>                    
                                </table>
</body>
</html>
<?php
if($_GET[jenis]=="pdf"){

$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen.".pdf" ,'I');
exit;
}
else {
}
}
?>
