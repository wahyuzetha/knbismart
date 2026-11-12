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
	
	$query = "select pembelajaran.pembelajaran,materi.* from pembelajaran,materi 
    where materi.id_pembelajaran=pembelajaran.id and materi.id = '$_GET[ujian]'";
	$results 	= mysql_query( $query);
	$row=mysql_fetch_assoc($results);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Laporan Keaktifan Siswa</title>
<?php
if($_GET[jenis]=="excel"){
header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=Laporan Keaktifan Siswa Kelas '.$_GET[kelas].' Mapel '.$row[pembelajaran].' '.$row[nama_materi].' .xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
}
else if($_GET[jenis]=="pdf"){
   ob_start();
   $nama_dokumen='Laporan Keaktifan Siswa Kelas '.$_GET[kelas].' Mapel '.$row[pembelajaran].' '.$row[nama_materi].''; //Beri nama file PDF hasil.
define('_MPDF_PATH','../../MPDF57/');
include(_MPDF_PATH . "mpdf.php");
 
$mpdf=new mPDF('c', 'A4');  // Create new mPDF Document

$tgl=date('d/m/Y H:i:s');
$mpdf->SetFooter('Laporan Keaktifan Siswa |'.$tgl.'|{PAGENO}');

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

            $tgl_absen=date('d/m/Y', strtotime($_GET[tanggal]));

if(!empty($_GET[jenis])){
if(!empty($_GET[kelas])){
    $k=" and nama_kelas='$_GET[kelas]'";
}    
else {
    $k="";
}

 if(!empty($_SESSION[wali_kelas_k])){
        $wk=" and nama_kelas='$_SESSION[wali_kelas_k]'";
    }
    else {
        $wk="";
    }
 $tk=mysql_query("select  * from kelas where tingkat='$_GET[tingkat]' and tahun_ajaran='$tahun_aktif' $k $wk");   
// $tk=mysql_query("select  * from kelas where tingkat='$_GET[tingkat]' $k");   
 while($dk=mysql_fetch_array($tk)){
             	
?>
<p align="center"><strong>REKAP ABSENSI  KELAS <?php echo strtoupper($dk[nama_kelas]); echo"<br> ";

echo"TANGGAL $tgl_absen";
?> </strong></p>

<table border="1" style="border-collapse: collapse; color: #000;" width="100%">
  <tr>
    <td width="30px" height="35" align="center" bgcolor="#FFFF00"><strong>NO</strong></td>
    <td width="100px" align="center" bgcolor="#FFFF00" ><strong>NIS </strong></td>
    <td width="270px" align="center" bgcolor="#FFFF00" ><strong>NAMA</strong></td>


    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>WAKTU</strong></td>
    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>HADIR/TIDAK</strong></td>

  </tr>
      <?php
	  $no=0;
	  
	   
           $m=mysql_query("select  * from siswa where kelas='$dk[nama_kelas]' and kelas!='' order by nama asc");   
		
				while($d=mysql_fetch_array($m)){
				    
				$no++;         
                $nn=mysql_query("select  * from log_akses_materi where id_user='$d[nis]' and tanggal='$_GET[tanggal]' order by id desc");   
                $dn=mysql_fetch_array($nn);
            
         
            
				    
				
           
           if(!empty($dn[tanggal])) {
            $tgl=date('d/m/Y H:i:s', strtotime($dn[timestmp]));
			
           }
           
           else {
               $tgl="";
           }
           
		   if($_GET[kehadiran]=="semua"){
		   $cetak=1;
		   }
		   else if($_GET[kehadiran]=="hadir"){
			if(!empty($dn[ip])){
		   $cetak=1;
				   } else { 
		   $cetak=0;
				   }
		   }
		   else if($_GET[kehadiran]=="tidak"){
if(!empty($dn[ip])){
		   $cetak=0;
				   } else { 
		   $cetak=1;
				   }		   }
		   
		   
		   
		   if($cetak==1){
		   
            ?>      
           
                  <tr>
				<td align="center"><?php echo"$no";?> </td>

				<td align="center"><?php echo"$d[nis]";?> </td>
				<td><?php echo"$d[nama]";?> </td>

				    <td align="center"><?php echo"$tgl";?> </td>
				    <td align="center"><?php if(!empty($dn[ip])){echo"Hadir"; } else { echo"Tidak"; }?> </td>
                                        </tr>
				<?php } 
				else { }				
				}?>                    
                                       
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