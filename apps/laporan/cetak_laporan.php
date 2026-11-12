<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
include "../../inc/fungsi.php";

ini_set('max_execution_time', '0'); // for infinite time of execution 
ini_set("memory_limit","-1");
 $query1 = "select * from pembelajaran where id = '$_GET[pembelajaran]'";
	$results1 	= mysql_query( $query1);
	$row1=mysql_fetch_assoc($results1);
	
	$query = "select pembelajaran.tingkat,pembelajaran.pembelajaran,ujian.* from pembelajaran,ujian 
    where ujian.id_pembelajaran=pembelajaran.id and ujian.id = '$_GET[ujian]'";
	$results 	= mysql_query( $query);
	$row=mysql_fetch_assoc($results);
	function plainText($text)
{
    $text = strip_tags($text);
    $text = trim(preg_replace(['/<[^>]*>/','/\s+/'],' ', $text));

    return $text;
}
$analis=$_GET[analisis];
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
header('Content-Disposition: attachment; filename=Analisis Butir Soal Kelas '.$_GET[kelas].' Mapel '.$row[pembelajaran].' '.$row[nama_ujian].' .xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
}
else if($_GET[jenis]=="pdf"){
   ob_start();
   $nama_dokumen='Analisis Butir Soal Kelas '.$_GET[kelas].' Mapel '.$row[pembelajaran].' '.$row[nama_ujian].''; //Beri nama file PDF hasil.
define('_MPDF_PATH','../../MPDF57/');
include(_MPDF_PATH . "mpdf.php");
 
$mpdf=new mPDF('c', 'A4');  // Create new mPDF Document

$tgl=date('d/m/Y H:i:s');
$mpdf->SetFooter('Laporan Nilai |'.$tgl.'|{PAGENO}');

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
<p align="center"><strong>ANALISIS BUTIR SOAL  <?php echo"KELAS $row_kelas[nama_kelas]"; echo"<br>";
echo"MATA PELAJARAN ";  echo strtoupper($row[pembelajaran]); echo"<br>";
echo strtoupper($row[nama_ujian]);
?> </strong></p>

<table border="1" style="border-collapse: collapse; color: #000;" width="100%">
  <tr>
    <td width="30" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>NO</strong></td>
    <td width="100" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>NIS </strong></td>
    <td width="270" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>NAMA</strong></td>
 <?php
 
 if($analis=="c"){
	$nr=0;
	$banksoalr=mysql_query("select  * from bank_soal where id_ujian='$_GET[ujian]' order by id asc")or die("ss".mysql_error());   
	while($dbanksoalr=mysql_fetch_array($banksoalr)){
	$nr++;	
	}
	?>	   
   <td height="35" colspan="<?php echo"$nr";?>" align="center" bgcolor="#FFFF00" ><strong>JAWABAN</strong></td>
 <?php } ?>
	    <td colspan="4" align="center" bgcolor="#FFFF00" ><strong>PILIHAN GANDA</strong></td>
	<?php if($row[status_essay_auto]==1){?>
    <td colspan="2" align="center" bgcolor="#FFFF00" ><strong>ESSAY SINGKAT </strong></td>
	<?php } if($row[status_essay]==1){?>
    <td width="30" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>ESSAY MANUAL </strong></td>
	<?php } 

if($row[bobot_multiple]>1){?>
    <td width="30" colspan="2" align="center" bgcolor="#FFFF00" ><strong>MULTIPLE RESPON </strong></td>
	<?php }
	if($row[bobot_matching]>1){?>
    <td width="30" colspan="2" align="center" bgcolor="#FFFF00" ><strong>MATCHING </strong></td>
	<?php }
	
	?>
   <td width="30" rowspan="2" align="center" bgcolor="#FFFF00" ><strong>NILAI AKHIR </strong></td>
  </tr>
  <tr>
 <?php
  if($analis=="c"){

	$n=0;
	$banksoal=mysql_query("select  * from bank_soal where id_ujian='$_GET[ujian]' order by id asc")or die("ss".mysql_error());   
	while($dbanksoal=mysql_fetch_array($banksoal)){
	$n++;	
	if($dbanksoal[jenis]=="match"){
		
	 $match_ar=array();
	 $mo=mysql_query("SELECT * from bank_opsi  where 1 and id_ujian='$_GET[ujian]' and id_soal='$dbanksoal[id]' order by id asc");   
     while($rowo=mysql_fetch_array($mo)){ 
	 $kunci_mt=number_to_str($rowo[kunci]);
	$match_ar[]="$kunci_mt";
	}
			
	$kuncis=implode(",",$match_ar);	
	}
	else {
	$kuncis=$dbanksoal[kunci];
	}
	?>				
	<td height="35" align="center" bgcolor="#FFFF00" ><strong><?php echo"$n <br> $kuncis";?></strong></td>
  <?php } } 
  ?>
  <td align="center" bgcolor="#FFFF00" ><strong>BENAR</strong></td>
    <td align="center" bgcolor="#FFFF00" ><strong>SALAH</strong></td>
    <td align="center" bgcolor="#FFFF00" ><strong>KOSONG</strong></td>
    <td align="center" bgcolor="#FFFF00" ><strong>NILAI</strong></td>
	<?php 
   if($row[status_essay_auto]==1){?>

    <td width="30" align="center" bgcolor="#FFFF00" ><strong>BENAR</strong></td>
   <!-- <td width="30" align="center" bgcolor="#FFFF00" ><strong>SALAH</strong></td>
    <td width="30" align="center" bgcolor="#FFFF00" ><strong>KOSONG</strong></td>-->
    <td width="30" align="center" bgcolor="#FFFF00" ><strong>NILAI</strong></td>
		<?php } 
   if($row[status_essay]==1){ ?>
       <td width="30" align="center" bgcolor="#FFFF00" ><strong>NILAI</strong></td>

   <?php }  if($row[bobot_multiple]>1){ ?>
       <td width="30" align="center" bgcolor="#FFFF00" ><strong>BENAR</strong></td>
       <td width="30" align="center" bgcolor="#FFFF00" ><strong>NILAI</strong></td>

   <?php } 
if($row[bobot_matching]>1){ ?>
       <td width="30" align="center" bgcolor="#FFFF00" ><strong>BENAR</strong></td>
       <td width="30" align="center" bgcolor="#FFFF00" ><strong>NILAI</strong></td>

   <?php }   ?>
    
  </tr>
      <?php
	  $no=0;
             
	// $m=mysql_query("select  * from siswa where kelas='$row_kelas[nama_kelas]' and kelas!='' order by nama asc");	
		 $m=mysql_query("select  siswa.* from siswa,kelas_siswa where
					siswa.nis=kelas_siswa.nis and kelas_siswa.kelas='$row_kelas[nama_kelas]' and kelas_siswa.tahun_ajaran='$tahun_aktif' 
					order by nama asc");	

				$ujiand=mysql_query("select  * from ujian where id='$_GET[ujian]'")or die("ss".mysql_error());   
                $dujiand=mysql_fetch_array($ujiand); 					
				while($d=mysql_fetch_array($m)){
                $nn=mysql_query("select  * from hasil_jwb where nis='$d[nis]' and id_ujian='$_GET[ujian]' order by nilai desc");   
                $dn=mysql_fetch_array($nn);
            $no++;     
            $nialais=$dn[benar]/$djsoal[jum]*$dujiand[skala];
            
			if($dujiand[nilai_koma]==1){
			
			//pilgan
			$nilai_pilgan=$dn[benar]/$dn[jml_soal]*$dujiand[skala];
			
			//auto
			$nilai_sat=$dn[benar_essay_auto]/$dn[jml_soal_essay]*$dujiand[bobot_essay_auto];
			
			//multi
			$jml_soalat=$soal[jml_soal_multi];

			$nilai_multiple=$dn[benar_multi]/$dn[jml_soal_multi]*$dujiand[bobot_multiple];
			
			//match
			$jml_soalat=$soal[jml_soal_match];

			$nilai_match=$dn[benar_match]/$dn[jml_soal_match]*$dujiand[bobot_matching];

			$na_essay=$nilai_pilgan+$nilai_sat+$dn[nilai_essay]+$nilai_multiple+$nilai_match;
            $na_essay=number_format($na_essay,2);
			
			$na_pilgan_c=number_format($nilai_pilgan,2);
			$nilai_sat_c=number_format($nilai_sat,2);
			$nilai_multiple_c=number_format($nilai_multiple,2);
			$nilai_match_c=number_format($nilai_match,2);
			} 
			else {
			$na_essay=$dn[nilai]+$dn[nilai_essay_auto]+$dn[nilai_essay]+$dn[nilai_multi]+$dn[nilai_match];	
            $na_pilgan_c=$dn[nilai];
			$nilai_sat_c=$dn[nilai_essay_auto];
			$nilai_multiple_c=$dn[nilai_multi];
			$nilai_match_c=$dn[nilai_match];
			
			$na_essay=number_format($na_essay,0);
			
			}
			
            ?>      
           
                  <tr>
				<td align="center"><?php echo"$no";?> </td>

				<td align="center"><?php echo"$d[nis]";?> </td>
				<td><?php echo"$d[nama] ";?> </td>
<?php
 if($analis=="c"){

	$banksoala=mysql_query("SELECT hasil_opsi.*,bank_soal.jenis,bank_soal.soal,bank_soal.kunci from bank_soal
LEFT JOIN hasil_opsi on hasil_opsi.id_soal=bank_soal.id and hasil_opsi.nis='$d[nis]'
WHERE bank_soal.id_ujian='$_GET[ujian]' order by bank_soal.id asc")or die("ss".mysql_error());   
	while($dbanksoala=mysql_fetch_array($banksoala)){
	if($dbanksoala[point]>0){
		$bg="";  
	}
	else {
		$bg="red";
	}
	
		if($dbanksoala[jenis]=="match"){
		$hasil_match=explode("||",$dbanksoala[opsi]);
		sort($hasil_match);

			$val_match=array();
			foreach($hasil_match as $hasil_match_cek){
			$jawaban_match=explode("=",$hasil_match_cek);
			$id_opsi=$jawaban_match[0];
			$jawaban_opsi=$jawaban_match[1];
			
			$val_match[]=$jawaban_opsi;	
			}
			
			
			
			$hasil_opss=implode(" , ",$val_match);
				
		}
	else {
	$hasil_opss="$dbanksoala[opsi]";
	}

	?>				
	<td align="center" bgcolor="<?php echo"$bg";?>" ><strong><?php echo"$hasil_opss";?></strong></td>
 <?php } } ?>
				
				
				
				<td align="center"><?php echo"$dn[benar]";?> </td>
				  <td align="center"><?php echo"$dn[salah]";?> </td>
				    <td align="center"><?php echo"$dn[kosong]";?> </td>
                  <td align="center"><?php echo"$na_pilgan_c";?> </td>
				  	<?php if($row[status_essay_auto]==1){?>

                  <td align="center"><?php echo"$dn[benar_essay_auto]";?> </td>
                 
<!--				 <td align="center"><?php echo"$dn[salah_essay_auto]";?> </td>
                  <td align="center"><?php echo"$dn[kosong_essay_auto]";?> </td>-->
                  <td align="center"><?php echo "$nilai_sat_c";?> </td>
					<?php }  if($row[status_essay]==1){?>

                  <td align="center"><?php echo number_format($dn[nilai_essay],0);?></td>
					<?php } if($row[bobot_multiple]>1){?>

                  <td align="center"><?php echo"$dn[benar_multi]";?></td>
                  <td align="center"><?php echo "$nilai_multiple_c";?></td>

					<?php }

if($row[bobot_matching]>1){?>

                  <td align="center"><?php echo"$dn[benar_match]";?></td>
                  <td align="center"><?php echo"$nilai_match_c";?></td>

					<?php }					?>
                  <td align="center"><?php echo"$na_essay";?> </td>
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
