<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
ini_set('max_execution_time', '0'); // for infinite time of execution 
ini_set("memory_limit","-1");

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
header('Content-Disposition: attachment; filename=Laporan Aktifitas Guru.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
}
else if($_GET[jenis]=="pdf"){
   ob_start();
   $nama_dokumen='Laporan Aktifitas Guru'; //Beri nama file PDF hasil.
define('_MPDF_PATH','../../MPDF57/');
include(_MPDF_PATH . "mpdf.php");
 
$mpdf=new mPDF('c', 'A4');  // Create new mPDF Document

$tgl=date('d/m/Y H:i:s');
$mpdf->SetFooter('Laporan Aktiftas Guru |'.$tgl.'|{PAGENO}');

 } 
else if($_GET[jenis]=="normal"){
}

 ?></head>

<body>
<?php
 if(!empty($_GET[nuptk])){
	      $ng=" and nik='$_GET[nuptk]'";
	  }
	  else {
	      $ng="";
	  }
if(!empty($_GET[jenis])){
$tgl_awal_c=date('d/m/Y', strtotime($_GET[tgl_awal])); 
$tgl_akhir_c=date('d/m/Y', strtotime($_GET[tgl_akhir])); 
if($_GET[tampilan]=="group"){
?>
<p align="center"><strong>LAPORAN AKTIFITAS GURU <br>
<?php echo"TANGGAL $tgl_awal_c S.D $tgl_akhir_c";?> </strong></p>

<table border="1" style="border-collapse: collapse; color: #000;" width="100%">
  <tr>
    <td width="30px" height="35" align="center" bgcolor="#FFFF00" ><strong>NO</strong></td>
    <td width="100px" align="center" bgcolor="#FFFF00" ><strong>NAMA GURU </strong></td>
    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>AKTIFITAS</strong></td>
  </tr>
      <?php
	  $no=0;
	 
           $m=mysql_query("select  * from guru where 1 $ng order by nama asc");   
		
				while($d=mysql_fetch_array($m)){
               
            $no++;     
            
            
            ?>      
           
                  <tr>
				<td align="center" valign="top"><?php echo"$no";?> </td>

				<td align="left" valign="top">
				  <?php echo"$d[nama]";?></td>
				<td align="center" valign="top">
				 <table width="100%" border="1" style="border-collapse:collapse">
 <?php
 $nop=0;
  $nn=mysql_query("SELECT log_aktifitas.*, pembelajaran.pembelajaran from log_aktifitas
LEFT JOIN pembelajaran on log_aktifitas.id_pembelajaran=pembelajaran.id 
where log_aktifitas.id_user='$d[nik]' and log_aktifitas.tanggal between '$_GET[tgl_awal]' and  '$_GET[tgl_akhir]'");   
 while($dn=mysql_fetch_array($nn)){
$jam=date('H:i:s', strtotime($dn[timestmp])); 
$akses=date('d/m/Y', strtotime($dn[tanggal])); 

  $nop++;   
  ?>                
  <tr>
    <td valign="top"><?php echo"$nop. ";?></td>
    <td valign="top" width="300px"><?php echo"$dn[pembelajaran] $dn[nama_log]";?></td>
    <td valign="top"><?php echo"$akses $jam";?></td>
  </tr>
  <?php } ?>
</table>				   </td>
  </tr>
                    <?php } ?>                    
                                </table>
                                <?php } else {
                                
                            $m=mysql_query("select  * from guru where 1 $ng order by nama asc");   
		
				while($d=mysql_fetch_array($m)){
?>
<p align="center"><strong>LAPORAN AKTIFITAS  <br><?php echo strtoupper($d[nama]);?> <br>
<?php echo"TANGGAL $tgl_awal_c S.D $tgl_akhir_c";?> </strong></p>

<table border="1" style="border-collapse: collapse; color: #000;" width="100%">
  <tr>
    <td width="30px" height="35" align="center" bgcolor="#FFFF00" ><strong>NO</strong></td>
    <td width="100px" align="center" bgcolor="#FFFF00" ><strong>MAPEL  </strong></td>
    <td width="100px" align="center" bgcolor="#FFFF00" ><strong>AKTIFITAS</strong></td>
    <td width="100px" align="center" bgcolor="#FFFF00" ><strong>TANGGAL</strong></td>
    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>IP</strong></td>
  </tr>
      <?php
	  $no=0;
          
               
            $no++;     
            $nop=0;
  $nn=mysql_query("SELECT log_aktifitas.*, pembelajaran.pembelajaran from log_aktifitas
LEFT JOIN pembelajaran on log_aktifitas.id_pembelajaran=pembelajaran.id 
where log_aktifitas.id_user='$d[nik]' and log_aktifitas.tanggal between '$_GET[tgl_awal]' and  '$_GET[tgl_akhir]'");   
 while($dn=mysql_fetch_array($nn)){
$jam=date('H:i:s', strtotime($dn[timestmp])); 
$akses=date('d/m/Y', strtotime($dn[tanggal])); 

  $nop++;   
            
            ?>      
           
                  <tr>
				<td align="center" valign="top"><?php echo"$nop";?> </td>
				<td align="left" valign="top"><?php echo"$dn[pembelajaran]";?></td>
				<td align="left" valign="top"><?php echo"$dn[nama_log]";?></td>
  
				<td align="left" valign="top"><?php echo"$akses $jam";?></td>
				<td align="left" valign="top"><?php echo"$dn[ip]";?></td>
				
  </tr>
                    <?php } ?>                    
                                </table>
								<pagebreak>
								
								<?php }  } ?>    
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