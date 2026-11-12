<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/hari.php";

ini_set('max_execution_time', 0);
ini_set('memory_limit', '128M');


if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1){
$id_guru=$_GET[nuptk];
}
else {
	
$id_guru=$_SESSION[teacher_id_se];

}


$tanggal=$_GET[tanggal];

$chari=date('D', strtotime($tanggal));
$thari=date('d/m/Y', strtotime($tanggal));

$hari_jadwal=hari_indo($chari);	

$qhr=mysql_query("SELECT * from asc_daysdefs where name='".mysql_real_escape_string($hari_jadwal)."'");	
$dhr=mysql_fetch_array($qhr);


if(!empty($tanggal)){
$hr=" and asc_cards.days='$dhr[days]'";
$tgl_hari=$thari;
}
else {
$hr="";
$tgl_hari="";
}

if($_GET[tingkat]!="all"){
$tkt=" and kelas.tingkat='$_GET[tingkat]'";

}
else {
$tkt="";

}


if(!empty($id_guru)){
$kls=mysql_query("SELECT kelas.id_class,kelas.nama_kelas,asc_lessons.* from asc_lessons,kelas,asc_cards
WHERE 
asc_lessons.id=asc_cards.lessonid AND
asc_lessons.classids=kelas.id_class AND
asc_lessons.teacherids='$id_guru' AND
asc_lessons.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' AND
asc_lessons.semester='$_SESSION[semester_pem]' $hr $tkt
GROUP by asc_lessons.classids order by kelas.nama_kelas asc");
$guru=" AND asc_lessons.teacherids='$id_guru'";	
} 
else {
$kls=mysql_query("SELECT * from kelas where tahun_ajaran='$_SESSION[tahun_ajaran_pem]' $tkt order by nama_kelas,tingkat asc");
$guru="";
}
?>
<!DOCTYPE html>
<html>

<title>Jadwal Pelajaran</title>
<script type="text/javascript" src="../../js/jquery-1.5.1.min.js"></script>

<script type="text/javascript" src="../../js/jquery.freezeheader.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$("table").freezeHeader({ top: true, left: true });
});

</script>

<style>
h1 {
    line-height: 30px;
}

.data-table, .data-table td, .data-table th {
    border-color: black;
    border-style: solid;
}

.data-table {
    border-width: 0 0 0px 0px;  
    border-spacing: 0;
    border-collapse: collapse; 
    margin: 0;
}

.data-table td, .data-table th {
    margin: 0px;
    padding: 6px;
    border-width: 1px;
    vertical-align: top;
	    min-width: 100px;

}

.data-table th {
    background-color: gold; 
}
</style>

</head>


 <?php
 
 
if($_GET[d]==1){
/*
echo"<a href='ijadwal?nuptk=$_GET[nuptk]' target='_NEW'>Perbesar Tampilan</a><hr>
<h2>Jadwal Mengajar $_SESSION[tahun_ajaran_pem] $_SESSION[semester_pem] $tgl_hari</h2>
";
*/
}
else {
	
echo"<h2>Jadwal Mengajar $_SESSION[tahun_ajaran_pem] $_SESSION[semester_pem] $tgl_hari</h2>";
}

?>
<table id="maintable" class="data-table">
    <colgroup>
        <col style="background-color: #ddd">
        <col>
        <col>
        <col>
    </colgroup>

	<thead>  <tr>
    <th style="background-color: #F5E9A3;">Kelas </td>
	<?php
	 $h=0;
	 $qjam=mysql_query("SELECT * from asc_periods order by starttime asc ");
	 $cols=mysql_num_rows($qjam);
	 $qhr=mysql_query("SELECT asc_daysdefs.name,asc_cards.* from asc_cards,asc_daysdefs
						WHERE asc_daysdefs.days=asc_cards.days   and asc_cards.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and 
						asc_cards.semester='$_SESSION[semester_pem]' $hr
						GROUP by asc_cards.days
						ORDER by asc_cards.days desc");
     while($dhr=mysql_fetch_array($qhr)){
	 $h++;
	  echo"
    <th style='background-color: #F5E9A3' colspan='$cols' align='center'>$dhr[name]</td>";
 	 } ?>
  </tr>
  <tr>
      <th style="background-color: #F5E9A3"></td>

 <?php
	for($j=0;$j<$h;$j++){
		 $qjam=mysql_query("SELECT * from asc_periods order by starttime asc");	
		while($djam=mysql_fetch_array($qjam)){
	echo"
    <th width='10px' style='background-color: #F5E9A3' align='center'> $djam[starttime]</td>";
	 }
	}
	?>
  </tr>
  </thead>
	<tbody>
  <?php
  $no=0;
   
     while($dkls=mysql_fetch_array($kls)){
  $no++;		 
	echo"
   <tr>
    <td align='center'>$dkls[nama_kelas]</td>";
	
 $qhr2=mysql_query("SELECT asc_daysdefs.name,asc_cards.* from asc_cards,asc_daysdefs
						WHERE asc_daysdefs.days=asc_cards.days  and 
						asc_cards.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and 
						asc_cards.semester='$_SESSION[semester_pem]' $hr
						GROUP by asc_cards.days
						ORDER by asc_cards.days desc");
     while($dhr2=mysql_fetch_array($qhr2)){
	$qjam2=mysql_query("SELECT * from asc_periods order by starttime asc");	
	while($djam2=mysql_fetch_array($qjam2)){
	
	//mencari jadwal guru

	$qjadwal=mysql_query("SELECT pembelajaran.id as id_pembelajaran,guru.nik,guru.teacher_id,guru.nama,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.short as kode_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
	from asc_cards,guru,kelas,asc_subjects,asc_lessons,pembelajaran
	WHERE 
	asc_lessons.id=asc_cards.lessonid AND
	asc_lessons.teacherids=guru.teacher_id AND
	asc_lessons.classids=kelas.id_class AND
	asc_lessons.subjectid=asc_subjects.id  AND
	asc_subjects.id=pembelajaran.subjectid AND
	pembelajaran.teacher_id=guru.teacher_id and
    pembelajaran.kelas like '%$dkls[nama_kelas]%' $guru and 
	asc_lessons.classids='$dkls[id_class]' AND
	asc_cards.period='$djam2[period]' AND
	asc_cards.days='$dhr2[days]' AND
	asc_cards.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' AND
	asc_cards.semester='$_SESSION[semester_pem]' and 
    pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' AND
	pembelajaran.semester='$_SESSION[semester_pem]' 	

	");	
	$djadwal=mysql_fetch_array($qjadwal);
	if(!empty($tanggal)){

	
	  $qstatus=mysql_query("SELECT * from status_mengajar
											where 
											status_mengajar.id_pembelajaran='$djadwal[id_pembelajaran]' and
											status_mengajar.tanggal='$tanggal' and
											status_mengajar.id_kelas='$dkls[nama_kelas]' and
											status_mengajar.semester='$_SESSION[semester_pem]' and
											status_mengajar.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and
											status_mengajar.id_user='$djadwal[nik]'
											");	
	  $dstatus=mysql_fetch_array($qstatus);
	  
	if(!empty($dstatus[id])){
	$nh="";
	$sdhq=" and tanggal='$tanggal' and id_kelas='$dkls[nama_kelas]'";
	}
	else {
	$nh="NOT";
	$sdhq=" and tanggal='$tanggal' and id_kelas='$dkls[nama_kelas]'";
	}
	/*
	  $qsudah=mysql_query("SELECT * from status_mengajar
											where 
											status_mengajar.id_pembelajaran='$djadwal[id_pembelajaran]' and
											status_mengajar.tanggal<'$tanggal' and
											status_mengajar.id_kelas='$dkls[nama_kelas]' and
											status_mengajar.semester='$_SESSION[semester_pem]' and
											status_mengajar.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and
											status_mengajar.id_user='$djadwal[nik]'
											and status_mengajar.status_belajar>'1'");	
	$dsudah=mysql_fetch_array($qsudah);
	 */
	

	  //cek materi
	  $qm=mysql_query("SELECT * from materi where id_pembelajaran='$djadwal[id_pembelajaran]' 
	    and id $nh IN(SELECT id_materi from status_mengajar WHERE 
						id_user='$djadwal[nik]' and 
						id_pembelajaran='$djadwal[id_pembelajaran]' $sdhq) 
						and batas_tanggal<='$tanggal'  order by batas_tanggal desc");	
	  $dqm=mysql_fetch_array($qm);
	  
	  
	
	
	
		if(empty($dstatus[status_belajar]) and !empty($djadwal[nama]) and !empty($dqm[id])){
			
			//cek apakah materi tsb sdh close belum
			 $cek_m=mysql_query("SELECT * from status_mengajar where id_materi='$dqm[id]'
			                     and tanggal<='$tanggal' and id_kelas='$dkls[nama_kelas]' and id_pembelajaran='$djadwal[id_pembelajaran]' and tahun_ajaran='$_SESSION[tahun_ajaran_pem]' AND semester='$_SESSION[semester_pem]' ");	
			 $dcek_m=mysql_fetch_array($cek_m);
	  
			if(!empty($dcek_m[id])){
			$open="<span style='color:white; font-weight:bold'>Belum Ada Materi </span>";
			$url="<a href='../materi/data?d=$djadwal[id_pembelajaran]'  style='color:white'>Detail</a>";
			$bg="bgcolor='red' style='color:white;'";
			
			}
			else {
			$open="<span style='color:red; font-weight:bold'>Belum Open </span>";
			$url="<a href='../materi/data?d=$djadwal[id_pembelajaran]'>Detail</a>";
			$bg="bgcolor='#fff'";
			}
			
			}
		else if(empty($dstatus[status_belajar]) and !empty($djadwal[nama]) and empty($dqm[id])){
			$open="<span style='color:white; font-weight:bold'>Belum Ada Materi</span>";
			$url="<a href='../materi/data?d=$djadwal[id_pembelajaran]'  style='color:white'>Detail</a>";
			$bg="bgcolor='red' style='color:white;'";
			}
			
		else if($dstatus[status_belajar]==2 and !empty($djadwal[nama]) and !empty($dqm[id])) {
			$open="<span style='color:#000; font-weight:bold'>Process</span>";
			$url="<br><a href='../dashboard/detail_open?id_pembelajaran=$djadwal[id_pembelajaran]&tanggal=$tanggal&id_kelas=$dkls[nama_kelas]&jam=$djam2[starttime]&id_materi=$dstatus[id_materi]&id_tugas=$dstatus[id_tugas]&id_ujian=$dstatus[id_ujian]&subject_id=$djadwal[id_mapel]&teacher_id=$djadwal[teacher_id]&classid=$dkls[id_class]'>Detail</a>";
			$bg="bgcolor='#FFFF00'";

			}	
	   else if($dstatus[status_belajar]==3 and !empty($djadwal[nama]) and !empty($dqm[id])) {
			$open="<span style='color:#000; font-weight:bold'>Close</span>";
$url="<br><a href='../dashboard/detail_open?id_pembelajaran=$djadwal[id_pembelajaran]&tanggal=$tanggal&id_kelas=$dkls[nama_kelas]&jam=$djam2[starttime]&id_materi=$dstatus[id_materi]&id_tugas=$dstatus[id_tugas]&id_ujian=$dstatus[id_ujian]&subject_id=$djadwal[id_mapel]&teacher_id=$djadwal[teacher_id]&classid=$dkls[id_class]'>Detail</a>";
			$bg="bgcolor='#00FF00'";

			}	
			else {
			$open="";
			$url="";
			$bg="";
			}
	} 
			
	//if(!empty($djadwal[nama])){ 
	
	if($_SESSION[levelu]==1){
	$pem="- . $djadwal[id_pembelajaran]";
	}
	else {
	$pem=" ";	
	}
	
	echo"  
    <td width='10px' align='center' $bg> 


	$djadwal[nama] <hr> $djadwal[mapel] ($djadwal[kode_mapel] $pem) <br>  $open <br>$url 
						
						
						
						</td>";
	// } 
	}
	}
	?>
  </tr>
	 <?php } ?>
	 </tbody>
</table>
   
