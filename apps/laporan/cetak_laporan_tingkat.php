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
if(!empty($_GET[jenis])){
 $tk=mysql_query("select  * from kelas where tingkat='$_GET[kelas]' and tahun_ajaran='$tahun_aktif'");   
 while($dk=mysql_fetch_array($tk)){
             	
?>
<p align="center"><strong>LAPORAN NILAI KELAS <?php echo strtoupper($dk[nama_kelas]); echo"<br>";
echo"MATAPELAJARAN ";  echo strtoupper($row[pembelajaran]); echo"<br>";
echo strtoupper($row[nama_ujian]);
?> </strong></p>

<table border="1" style="border-collapse: collapse; color: #000;" width="100%">
  <tr>
    <td width="30px" height="35" align="center" bgcolor="#FFFF00" ><strong>NO</strong></td>
    <td width="100px" align="center" bgcolor="#FFFF00" ><strong>NIS </strong></td>
    <td width="270px" align="center" bgcolor="#FFFF00" ><strong>NAMA</strong></td>
    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>BENAR</strong></td>
    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>SALAH</strong></td>
    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>KOSONG</strong></td>
    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>NILAI</strong></td>


  </tr>
      <?php
	  $no=0;
           $m=mysql_query("select  * from siswa where kelas='$dk[nama_kelas]' and kelas!='' order by nama asc");   
		
				$ujiand=mysql_query("select  * from ujian where id='$_GET[ujian]'")or die("ss".mysql_error());   
                $dujiand=mysql_fetch_array($ujiand); 					
				while($d=mysql_fetch_array($m)){
                $nn=mysql_query("select  * from hasil_jwb where nis='$d[nis]' and id_ujian='$_GET[ujian]' order by nilai desc");   
                $dn=mysql_fetch_array($nn);
            $no++;     
            $nialais=$dn[benar]/$djsoal[jum]*$dujiand[skala];
            
            
            ?>      
           
                  <tr>
				<td align="center"><?php echo"$no";?> </td>

				<td align="center"><?php echo"$d[nis]";?> </td>
				<td><?php echo"$d[nama]";?> </td>
				  <td align="center"><?php echo"$dn[benar]";?> </td>
				    <td align="center"><?php echo"$dn[salah]";?> </td>
				    <td align="center"><?php echo"$dn[kosong]";?> </td>
                  <td align="center"><?php echo"$dn[nilai]";?> </td>
                                       
                                        </tr>
                    <?php } ?>                    
                                       
                                </table>
<pagebreak>
 <?php } ?>
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