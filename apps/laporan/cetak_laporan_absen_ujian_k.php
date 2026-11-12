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
	
	$query = "select pembelajaran.tingkat,pembelajaran.pembelajaran,ujian.* from pembelajaran,ujian 
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
header('Content-Disposition: attachment; filename=Laporan Daftar Hadir Kelas '.$_GET[kelas].' Mapel '.$row[pembelajaran].' '.$row[nama_ujian].' .xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
}
else if($_GET[jenis]=="pdf"){
   ob_start();
   $nama_dokumen='Laporan Daftar Hadir Kelas '.$_GET[kelas].' Mapel '.$row[pembelajaran].' '.$row[nama_ujian].''; //Beri nama file PDF hasil.
define('_MPDF_PATH','../../MPDF57/');
include(_MPDF_PATH . "mpdf.php");
 
$mpdf=new mPDF('c', 'A4');  // Create new mPDF Document

$tgl=date('d/m/Y H:i:s');
$mpdf->SetFooter('Laporan Daftar Hadir |'.$tgl.'|{PAGENO}');

 } 
else if($_GET[jenis]=="normal"){
}

 ?></head>

<body>
<?php
if(!empty($_GET[jenis])){

if($_GET[kelas]=="all"){	

if($row[akses_kelas]=="null"){
$qkl=" and kelas.tingkat='$row[tingkat]' ";
}
else {
$someArray = json_decode($row[akses_kelas], true);
            						$lokasi_ar=array();

			foreach($someArray as $kelaskug) { 

		
			$lokasi_ar[]="nama_kelas='$kelaskug'";
			
			
			}
			
$pilj=implode(" or ",$lokasi_ar);
$qkl=" and ($pilj)";

}

$mlg=mysql_query("select  * from kelas where 1 and tahun_ajaran='$tahun_aktif' $qkl");	
}
else {
$mlg=mysql_query("select  * from kelas where nama_kelas='$_GET[kelas]' and tahun_ajaran='$tahun_aktif'");	
}

while($row_kelas=mysql_fetch_array($mlg)){
?>
<p align="center"><strong>LAPORAN ABSEN UJIAN <?php echo"KELAS $row_kelas[nama_kelas]"; echo"<br>";
echo"MATA PELAJARAN ";  echo strtoupper($row[pembelajaran]); echo"<br>";
echo strtoupper($row[nama_ujian]);
?> </strong></p>

<table border="1" style="border-collapse: collapse; color: #000;" width="100%">
  
  <tr>
    <td width="30" height="35" align="center" bgcolor="#FFFF00" ><strong>NO</strong></td>
    <td width="100" align="center" bgcolor="#FFFF00" ><strong>NIS </strong></td>
    <td width="270" align="center" bgcolor="#FFFF00" ><strong>NAMA</strong></td>

    <td width="30" align="center" bgcolor="#FFFF00" ><strong>HADIR</strong></td>
    <td width="30" align="center" bgcolor="#FFFF00" ><strong>STATUS</strong></td>
    <td width="30" align="center" bgcolor="#FFFF00" ><strong>TANGGAL</strong></td>
  </tr>
      <?php
	  $no=0;
             
	 $m=mysql_query("select  siswa.* from siswa,kelas_siswa where
					siswa.nis=kelas_siswa.nis and kelas_siswa.kelas='$row_kelas[nama_kelas]' and kelas_siswa.tahun_ajaran='$tahun_aktif' 
					order by nama asc");	
	
				while($d=mysql_fetch_array($m)){
                $nn=mysql_query("select  * from hasil_jwb where nis='$d[nis]' and id_ujian='$_GET[ujian]' order by nilai desc");   
                $dn=mysql_fetch_array($nn);
            $no++;     
				if($dn[status]==2 and !empty($dn[timestmp])){
				$status_ujian="Sedang Ujian";
				$hadir_s="Hadir";
				$bgcolor="yellow";
				}
				else if($dn[status]==3 and !empty($dn[timestmp])){
				$status_ujian="Selesai Ujian";
				$hadir_s="Hadir";
				$bgcolor="green";
				$stts="selesai";

				}
				else if($dn[status]==0 and !empty($dn[timestmp])){
				$status_ujian="Sedang Ujian";
				$hadir_s="Hadir";
				$bgcolor="yellow";
				$stts="sedang";


				}
				else {
				$status_ujian="Belum Ujian";	
				$hadir_s="Tidak Hadir";
				$bgcolor="red";
				$stts="belum";


				}
			
				$hasil="<tr><td align='center'>$no</td>
				<td align='center'>$d[nis]</td>
				<td>$d[nama]</td>
				<td align='center'>$hadir_s</td>
				<td align='center' bgcolor='$bgcolor'><b>$status_ujian</b> </td>
				<td align='center'>$dn[timestmp] </td>
                </tr>";
				
				
				if($_GET[status_ujian]=="all"){
				echo"$hasil";	
				}
				else {
				if($_GET[status_ujian]=="belum" and $stts=="belum"){
				echo"$hasil";	
				}
				else if($_GET[status_ujian]=="sedang" and $stts=="sedang"){
				echo"$hasil";	
				}
				else if($_GET[status_ujian]=="selesai" and $stts=="selesai"){
				echo"$hasil";	
				}
				}
				
			
            ?>      
           
                
                    <?php } ?>                    
                                </table>
								<pagebreak>
<?php } ?>

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
</body>
</html>