<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/hari.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
			
			$qstatus=mysql_query("SELECT * from status_mengajar where id='$id'");	
	        $dstatus=mysql_fetch_array($qstatus);
	
	
	
			$m=mysql_query("select pembelajaran.pembelajaran,materi.* from pembelajaran,materi
			WHERE materi.id_pembelajaran=pembelajaran.id and materi.id='$dstatus[id_materi]'");   
            $d=mysql_fetch_array($m);
			
			$mt=mysql_query("select  * from tugas where id='$dstatus[id_tugas]'");   
            $dt=mysql_fetch_array($mt);
			
			
			$mj=mysql_query("select  * from ujian where id='$dstatus[id_ujian]'");   
            $dj=mysql_fetch_array($mj);
			
			$dm=mysql_query("select  * from guru where nuptk='$dstatus[id_user]'");   
            $guru=mysql_fetch_array($dm);
			
			$kep=mysql_query("select  * from guru where id_jabatan='1'");   
            $dkep=mysql_fetch_array($kep);
			  

$PNG_TEMP_DIR = '../qr/temp/';
    
    //html PNG location prefix
    $PNG_WEB_DIR = '../qr/temp/';

    include "../qr/qrlib.php";  
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 3;

$tgl=date('d/m/Y', strtotime($dstatus[tanggal]));

 $chari=date('D', strtotime($dstatus[tanggal]));
				$hari_jadwal=hari_indo($chari);	

$qhr=mysql_query("SELECT * from asc_daysdefs where name='".mysql_real_escape_string($hari_jadwal)."'");	
$dhr=mysql_fetch_array($qhr);
 
/*			  

 $qjadwal=mysql_query("SELECT asc_periods.starttime,asc_periods.endtime,guru.nama,kelas.id_class,kelas.tingkat,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
	from asc_cards,guru,kelas,asc_subjects,asc_lessons,asc_periods
	WHERE 
	asc_lessons.id=asc_cards.lessonid AND
	asc_lessons.teacherids=guru.teacher_id AND
	asc_lessons.classids=kelas.id_class AND
	asc_lessons.subjectid=asc_subjects.id AND
	asc_cards.period=asc_periods.period and
	asc_lessons.classids='$dstatus[classid]' and
	asc_cards.days='$dhr[days]' AND
	asc_cards.tahun_ajaran='$dstatus[tahun_ajaran]' AND
	asc_cards.semester='$dstatus[semester]' and
	asc_lessons.teacherids='$dstatus[teacher_id]' and 
	asc_lessons.subjectid='$dstatus[subject_id]' order by asc_periods.starttime asc
	");	
	$jno=0;
	$jam_k=array();
	$jam_k2=array();
	$jum_jadwal=mysql_num_rows($qjadwal);
	while($djadwal=mysql_fetch_array($qjadwal)){
	$jno++;
	if($jno==1){
	$jam_k[]=$djadwal[starttime];
	}
	
   if($jno == $jum_jadwal) {
    $jam_k2[]=$djadwal[endtime];
	}
	
	
	
	
	}
	$jam_mg1=implode("",$jam_k);
	$jam_mg2=implode("",$jam_k2);
*/
	$waktu_status_m=$_GET[jam_mengajar];

 
        $nma="$guru[nama] - 
			  Mata Pelajaran : $d[pembelajaran] -
			  Tema : $d[tema] -
			  Kelas : $dstatus[id_kelas] -
			  Waktu : $tgl - $waktu_status_m";
        $filename = $PNG_TEMP_DIR.'test'.md5($nma.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($nma, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Jurnal Mengajar <?php echo"$guru[nama] $dstatus[id_kelas] $tgl";?></title>
<script>window.print()</script>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td width="17%" rowspan="2" align="center"><img src="../../logo.png" height="100px" /></td>
    <td valign="bottom"><span style='font-size:25px; font-weight:bold; color:red;'>SMK KARYA NUGRAHA BOYOLALI</span></td>
  </tr>
  <tr>
    <td width="83%" valign="top">Jl Sandanglawe Karanggeneng Boyolali Boyolali  Kab. Boyolali-Jawa Tengah <br>Telp. 0276-321749 Kd Pos: 57312 email: smkknbi@yahoo.co.id</td>
  </tr>
</table>
<hr />
<table width="100%" border="0" align="center">
  <tr>
    <td colspan="2" align="center"><span class="style1">JURNAL MENGAJAR GURU <br>
      <br>
    </span></td>
  </tr>
  <tr>
    <td width="29%" align="center"><?php
	         echo"<img style='margin-left:-9px' src='".$PNG_WEB_DIR.basename($filename)."' />";

	?></td>
    <td width="71%"><table width="100%" border="0">
      <tr>
        <td width="22%">Nama Guru </td>
        <td width="2%">:</td>
        <td width="76%"><?php echo"$guru[nama]";?></td>
      </tr>
      <tr>
        <td>Mata Pelajaran </td>
        <td>:</td>
        <td><?php echo"$d[pembelajaran]";?></td>
      </tr>
      <tr>
        <td>Tema</td>
        <td>:</td>
        <td><?php echo"$d[tema]";?></td>
      </tr>
      <tr>
        <td>Kelas</td>
        <td>:</td>
        <td><?php echo"$dstatus[id_kelas]";?></td>
      </tr>
      <tr>
        <td>Waktu</td>
        <td>:</td>
        <td><?php echo"$tgl - $waktu_status_m";?></td>
      </tr>
      <tr>
        <td>Metode</td>
        <td>:</td>
        <td><?php echo"Pembelajaran Daring";?></td>
      </tr>
      <tr>
        <td>Media</td>
        <td>:</td>
        <td><?php echo"Komputer, Laptop dan Smartphone";?></td>
      </tr>
    </table></td> 
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p class="style2"><u>Materi Pembelajaran</u> :<br>
</p>
<?php
echo"$d[isi]";

 if(!empty($dt[judul])){
				 echo"<br><p class='style2'><u>Tugas</u> :<br> </p><br> $dt[judul]<br><br> $dt[isi]
				 ";
				 }
				 
				if(!empty($dj[nama_ujian])){
				echo"<br><p class='style2'><u>Ujian</u> :<br></p> <br> $dj[nama_ujian]<br>";

				 			
				 }

//menampilkan siswa dalam kelas tersebut
$siswa_hadir_ar=array();
$siswa_tidak_hadir_ar=array();
$jum_siswa=0;
$jum_hadir=0;
$jum_tidak_hadir=0;
$kls=mysql_query("SELECT siswa.nis,siswa.nama,kelas_siswa.kelas from siswa,kelas_siswa,kelas
WHERE siswa.nis=kelas_siswa.nis and kelas_siswa.kelas=kelas.nama_kelas and kelas.nama_kelas='$dstatus[id_kelas]'
and kelas.tahun_ajaran='$dstatus[tahun_ajaran]'");   
while($dkls=mysql_fetch_array($kls)){
//cek kehadiran
$jum_siswa++;
$cek_hdr=mysql_query("select  * from log_akses_materi where id_mengajar='$dstatus[id]' and
 id_user='$dkls[nis]'");   
$dcek_hdr=mysql_fetch_array($cek_hdr);
if(!empty($dcek_hdr[id_user])){
$siswa_hadir_ar[]=$dkls[nama];
$jum_hadir++;
}	
else {
$siswa_tidak_hadir_ar[]=$dkls[nama];
$jum_tidak_hadir++;

}
}	

$siswa_hadir=implode(",",$siswa_hadir_ar);
$siswa_tidak_hadir=implode(", ",$siswa_tidak_hadir_ar);

echo"<p class='style2'><u>Siswa Hadir</u> :<br></p> <br>$siswa_hadir <br>";

echo"<br><p class='style2'><u>Siswa Tidak Hadir</u> :<br> </p><br>$siswa_tidak_hadira <br>";
				 
?>
<p>&nbsp; </p>

<p class='style2'><u>Rekapitulasi</u> :<br></p> <br>

<table width="100%" border="0">
  <tr>
    <td width="37%"><table width="100%" border="0">
      <tr>
        <td width="57%">Jumlah Siswa </td>
        <td width="8%">:</td>
        <td width="35%"><?php echo"$jum_siswa";?></td>
      </tr>
      <tr>
        <td>Siswa Hadir </td>
        <td>:</td>
        <td width="35%"><?php echo"$jum_hadir";?></td>
      </tr>
      <tr>
        <td>Siswa Tidak Hadir </td>
        <td>:</td>
        <td width="35%"><?php echo"$jum_tidak_hadir";?></td>
      </tr>
    </table></td>
    <td width="63%" valign="top">Catatan: <br>
    <?php echo"$dstatus[catatan]";?></td>
  </tr>
</table>
<br>
<br>
<table width="100%" border="0">
  <tr>
    <td width="42%">&nbsp;</td>
    <td width="17%">&nbsp;</td>
    <td width="41%" align="center"><strong>Boyolali, <?php echo"$tgl";?></strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Kepala Sekolah </strong></td>
    <td>&nbsp;</td>
    <td align="center"><strong>Guru</strong></td>
  </tr>
  <tr>
    <td height="45" align="center"><br>
    <br></td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong><?php echo"$dkep[nama]";?></strong> </td>
    <td>&nbsp;</td>
    <td align="center"><strong><?php echo"$guru[nama]";?></strong> </td>
  </tr>
</table>
<p><span class="style2"><u>Percakapan Pembelajaran</u> :</span></p>

<?php
$k=mysql_query("select * from koment_forum where id_materi='$dstatus[id_materi]' and kelas='$dstatus[id_kelas]' and tahun_ajaran='$dstatus[tahun_ajaran]' order by id desc") 
or die("gagal buka".mysql_error());
while($dk=mysql_fetch_array($k)){
  
$cpeg=mysql_query("SELECT * from users where id_pengguna='$dk[id_users]'");
$cdpeg=mysql_fetch_array($cpeg);
$tanggal_tr=date('H:i:s', strtotime($dk[timestmp])); 

$id_komen=$dk[id];

		
if($cdpeg[level]==2){
    $nm=mysql_query("SELECT * from guru where nik='$dk[id_users]'");
    $dnm=mysql_fetch_array($nm);
    $nama=$dnm[nama];
}
else if($cdpeg[level]==3){
    $nm=mysql_query("SELECT * from siswa where nis='$dk[id_users]'");
    $dnm=mysql_fetch_array($nm);
    $nama=$dnm[nama];
}
else {
  $nama="(Admin)"; 

}
		
echo"$nama ($tanggal_tr)$dk[komentar]";	
 if(!empty($dk[gambar])){
   echo"<img src='../../imgforum/$dk[gambar]' width='150px'>";     
 }
 //sub koment_forum
 $ks=mysql_query("select * from koment_sub_forum where id_materi='$dstatus[id_materi]' and id_komen='$id_komen' order by id asc") 
	or die("gagal buka".mysql_error());
    while($dks=mysql_fetch_array($ks)){

$cpegs=mysql_query("SELECT * from users where id_pengguna='$dks[id_users]'");
$cdpegs=mysql_fetch_array($cpegs);
 
$tanggal_trs=date('H:i:s', strtotime($dk[timestmp])); 


if($cdpegs[level]==2){
    $nms=mysql_query("SELECT * from guru where nik='$dks[id_users]'");
    $dnms=mysql_fetch_array($nms);
    $namas=$dnms[nama];
}
else if($cdpegs[level]==3){
    $nms=mysql_query("SELECT * from siswa where nis='$dks[id_users]'");
    $dnms=mysql_fetch_array($nms);
    $namas=$dnms[nama];
}
else {
  $namas="(Admin)";

}
echo"<br>$namas ($tanggal_trs) $dks[komentar]";	
 if(!empty($dks[gambar])){
   echo"<img src='../../imgforum/$dks[gambar]' width='150px'>";     
 }
	}
 
}
	
?>	
</body>
</html>
