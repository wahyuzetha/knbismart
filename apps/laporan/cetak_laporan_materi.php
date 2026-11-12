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
<p align="center"><strong>LAPORAN KEAKTIFAN MENGIKUTI MATERI KELAS <?php echo strtoupper($dk[nama_kelas]); echo"<br>";
echo"MATA PELAJARAN ";  echo strtoupper($row1[pembelajaran]); echo"<br>";

if($_GET[ujian]!="semua") {echo strtoupper($row[judul]); } else { echo"SEMUA MATERI"; } 
?> </strong></p>

<table border="1" style="border-collapse: collapse; color: #000;" width="100%">
  <tr>
    <td width="30px" height="35" align="center" bgcolor="#FFFF00"><strong>NO</strong></td>
    <td width="100px" align="center" bgcolor="#FFFF00" ><strong>NIS </strong></td>
    <td width="270px" align="center" bgcolor="#FFFF00" ><strong>NAMA</strong></td>
<?php
           if($_GET[ujian]!="semua") {?>
<td width="30px" align="center" bgcolor="#FFFF00" ><strong>MEMBUKA</strong></td>
<?php }?>
    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>PROSENTASE</strong></td>
  <?php            if($_GET[ujian]!="semua") {?>

    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>TERAKHIR MEMBUKA</strong></td>
    <td width="30px" align="center" bgcolor="#FFFF00" ><strong>IP</strong></td>

<?php } ?>
  </tr>
      <?php
	  $no=0;
	  
	    //menghitung jumlah materi
            $cjem=mysql_query("select  count(*) as jum from materi where  id_pembelajaran='$_GET[pembelajaran]' order by id desc");   
            $djum=mysql_fetch_array($cjem);
            
           $m=mysql_query("select  siswa.* from siswa,kelas_siswa where
					siswa.nis=kelas_siswa.nis and kelas_siswa.kelas='$dk[nama_kelas]' and kelas_siswa.tahun_ajaran='$tahun_aktif' 
					order by nama asc");   
		
				while($d=mysql_fetch_array($m)){
				    
				$no++;         
                $nn=mysql_query("select  * from log_akses_materi where id_user='$d[nis]' and id_materi='$_GET[ujian]' order by id desc");   
                $dn=mysql_fetch_array($nn);
            
           if($_GET[ujian]!="semua") {
              if($dn[hit]>0){
                  $prosen="100%";
              } 
              else {
                  $prosen="0%";
              }
              $membuka="$dn[hit]";
               
           } else { 
                $j=0;
                $cn=mysql_query("select  log_akses_materi.* from materi,log_akses_materi
                where materi.id=log_akses_materi.id_materi and log_akses_materi.id_user='$d[nis]' and log_akses_materi.id_pembelajaran='$_GET[pembelajaran]' 
                group by log_akses_materi.id_materi order by log_akses_materi.id desc");   
                while($dcn=mysql_fetch_array($cn)){
                $j++;    
                }
               $prosen=$j/$djum[jum]*100;
            $prosen="$prosen %";
            $membuka=$prosen;

           } 

            
				    
				
           
           if(!empty($dn[tanggal])) {
            $tgl=date('d/m/Y', strtotime($dn[timestmp]));
           }
           
           else {
               $tgl="";
           }
           
            ?>      
           
                  <tr>
				<td align="center"><?php echo"$no";?> </td>

				<td align="center"><?php echo"$d[nis]";?> </td>
				<td><?php echo"$d[nama]";?> </td>
			 <?php          if($_GET[ujian]!="semua") {?>

				  <td align="center"><?php echo"$membuka";?> </td>
				  <?php  } ?>
				    <td align="center"><?php echo"$prosen";?> </td>
				<?php            if($_GET[ujian]!="semua") {?>
    
				    				    <td align="center"><?php echo"$tgl $dn[jam]";?> </td>
				    <td align="center"><?php echo"$dn[ip]";?> </td>
				    <?php } ?>

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