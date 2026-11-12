<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
include "../../inc/hari.php";

ini_set('max_execution_time', '0'); // for infinite time of execution 
ini_set("memory_limit","-1");

	$row=mysql_fetch_assoc($results);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Laporan Jurnal</title>
<?php

if(!empty($_GET[tahun_ajaran])){
$_SESSION[tahun_ajaran_pem]=$_GET[tahun_ajaran];
}
else {
$_SESSION[tahun_ajaran_pem]=$tahun_aktif;
}

if(!empty($_GET[semester])){
$_SESSION[semester_pem]=$_GET[semester];
}
else {
$_SESSION[semester_pem]=$semester_aktif;
}

if(!empty($_GET[tanggal])){
$tanggal=$_GET[tanggal];

}
else {
$tanggal=date('Y-m-d');

}

if($_GET[jenis]=="excel"){
header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=Laporan Jurnal Guru.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
}
else if($_GET[jenis]=="pdf"){
   ob_start();
   $nama_dokumen='Laporan Jurnal Guru'; //Beri nama file PDF hasil.
define('_MPDF_PATH','../../MPDF57/');
include(_MPDF_PATH . "mpdf.php");
 
$mpdf=new mPDF('c', 'A4');  // Create new mPDF Document

$tgl=date('d/m/Y H:i:s');
$mpdf->SetFooter('Laporan Jurnal Guru |'.$tgl.'|{PAGENO}');

 } 
else if($_GET[jenis]=="normal"){
}
$chari=date('D', strtotime($tanggal));
$thari=date('d/m/Y', strtotime($tanggal));

$hari_jadwal=hari_indo($chari);	


 ?></head>

<body>
<?php
 
if(!empty($_GET[jenis])){
$tgl_awal_c=date('d/m/Y', strtotime($tanggal)); 
?>
<p style="font-size:16px; font-weight:bold" align="center">
LAPORAN JURNAL MENGAJAR  <br>
SMK KARYA NUGRAHA BOYOLALI<br>
<?php echo"TANGGAL "; echo strtoupper($hari_jadwal); echo" $tgl_awal_c";?></p>
 <table id='empTable' class='display dataTable' style="width:100%; border-collapse:collapse" border='1'>

                                        
                                    <thead class="bg-green">
                                        <tr>
                                           <!-- <th>NO</th>-->
                                            <th bgcolor="#FFFF00">GURU</th>
                                            <th bgcolor="#FFFF00">MAPEL</th>
                                            <th bgcolor="#FFFF00">TEMA</th>
                                            <th bgcolor="#FFFF00">KELAS</th>
                                            <th bgcolor="#FFFF00">TANGGAL</th>
                                            <th bgcolor="#FFFF00">WAKTU</th>
                                            <th bgcolor="#FFFF00">OPEN</th>
                                            <th bgcolor="#FFFF00">CLOSE</th>

                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;

if($_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1 or $_SESSION[levelu]==1){

if(!empty($_GET[guru])){
$gr=" and guru.nik='$_GET[guru]'";
}
else {
$gr="";
}

}
else {
$gr=" and guru.nik='$_SESSION[namauser]'";

}

if($_GET[status_m]>1){
$status_m="and status_mengajar.status_belajar='$_GET[status_m]' ";
}
else if($_GET[status_m]==1){
$status_m="and status_mengajar.status_belajar>'1' ";
}
else {
$status_m="and status_mengajar.status_belajar>'1' ";

}

if($_SESSION[tingkat_pem]!="all"){
$tgkt=" and kelas.tingkat='$_SESSION[tingkat_pem]'";
}
else {
$tgkt="";
}

//mencari hari
$qhr=mysql_query("SELECT * from asc_daysdefs where name='".mysql_real_escape_string($hari_jadwal)."'");	
$dhr=mysql_fetch_array($qhr);
 
 
 
 
          $m=mysql_query("SELECT pembelajaran.id as id_pembelajaran,guru.nik,guru.teacher_id,guru.nama,kelas.id_class,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
	from asc_cards,guru,kelas,asc_subjects,asc_lessons,pembelajaran
	WHERE 
	asc_lessons.id=asc_cards.lessonid AND
	asc_lessons.teacherids=guru.teacher_id AND
	asc_lessons.classids=kelas.id_class AND
	asc_lessons.subjectid=asc_subjects.id AND
	asc_subjects.id=pembelajaran.subjectid AND
	pembelajaran.teacher_id=guru.teacher_id
 	$gr and
	asc_cards.days='$dhr[days]' AND
	asc_cards.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' AND
	asc_cards.semester='$_SESSION[semester_pem]' and
    pembelajaran.tahun_ajaran='$tahun_aktif' AND
	pembelajaran.semester='$semester_aktif' $tgkt group by asc_lessons.classids,asc_lessons.teacherids,asc_lessons.subjectid
	ORDER BY asc_cards.days,guru.nama,asc_cards.period
	") or die("gagagl".mysql_error());   
      
            while($d=mysql_fetch_array($m)){ 
            $no++;     
			
			  $qstatus=mysql_query("SELECT status_belajar.status,status_belajar.warna,status_mengajar.* from status_mengajar,status_belajar
											where 
                                            status_belajar.id=status_mengajar.status_belajar and
											status_mengajar.subject_id='$d[id_mapel]' and
											status_mengajar.tanggal='$tanggal' and
											status_mengajar.id_kelas='$d[nama_kelas]' and
											status_mengajar.semester='$_SESSION[semester_pem]' and
											status_mengajar.tahun_ajaran='$_SESSION[tahun_ajaran_pem]'
											$status_m");	
			$dstatus=mysql_fetch_array($qstatus);
	/*
	  if(!empty($dstatus[id])){
	$nh="";
	}
	else {
	$nh="NOT";
	}
	*/
	if(!empty($dstatus[id])){
	$nh="";
	$sdhq=" and tanggal='$tanggal' and id_kelas='$d[nama_kelas]'";
	}
	else {
	$nh="NOT";
	$sdhq=" and tanggal='$tanggal' and id_kelas='$d[nama_kelas]'";
	}
			$qm=mysql_query("select * from materi where id='$dstatus[id_materi]'");
			$dm=mysql_fetch_array($qm);
			
			if($dstatus[status_belajar]==2 or $dstatus[status_belajar]==3){
			$open="<span style='color:green; font-weight:bold'>V</span>";
			$url="<br><a href='../dashboard/detail_open?id_pembelajaran=$d[id_pembelajaran]&tanggal=$tanggal&id_kelas=$d[nama_kelas]&jam=$djam2[starttime]&id_materi=$dstatus[id_materi]&id_tugas=$dstatus[id_tugas]&id_ujian=$dstatus[id_ujian]&subject_id=$d[id_mapel]&teacher_id=$d[teacher_id]&classid=$d[id_class]'>Detail</a>";

			}
			else {
			$open="<span style='color:red; font-weight:bold'>X</span>";
				$url="<a href='../materi/data?d=$d[id_pembelajaran]'  style='color:red'>Detail</a>";
		
			}
			
			if($dstatus[status_belajar]==3){
			$close="<span style='color:green; font-weight:bold'>V</span>";
			}
			else {
			$close="<span style='color:red; font-weight:bold'>X</span>";
			}
			
			
		//if(!empty($dstatus[waktu_mengajar])){
				$waktu_status_m=$dstatus[waktu_mengajar];
		//	}
		//	else {
			 $qjadwal=mysql_query("SELECT asc_periods.starttime,asc_periods.endtime,guru.nama,kelas.id_class,kelas.tingkat,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
	from asc_cards,guru,kelas,asc_subjects,asc_lessons,asc_periods
	WHERE 
	asc_lessons.id=asc_cards.lessonid AND
	asc_lessons.teacherids=guru.teacher_id AND
	asc_lessons.classids=kelas.id_class AND
	asc_lessons.subjectid=asc_subjects.id AND
	asc_cards.period=asc_periods.period and
	asc_lessons.classids='$d[id_class]' and
	asc_cards.days='$dhr[days]' AND
	asc_cards.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' AND
	asc_cards.semester='$_SESSION[semester_pem]' and
	asc_lessons.teacherids='$d[teacher_id]' and 
	asc_lessons.subjectid='$d[id_mapel]' order by asc_periods.starttime asc
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
	
   if($jno === $jum_jadwal) {
    $jam_k2[]=$djadwal[endtime];
	}
	
	
	
	
	}
	$jam_mg1=implode("",$jam_k);
	$jam_mg2=implode("",$jam_k2);

	$waktu_status_m="$jam_mg1 sampai $jam_mg2";

	//}
	
	if(!empty($dm[tema])){
	$tema_m=$dm[tema];
	}
	else {
		/*
	 $qsudah=mysql_query("SELECT * from status_mengajar
											where 
											status_mengajar.subject_id='$d[id_mapel]' and
											status_mengajar.tanggal<'$tanggal' and
											status_mengajar.id_kelas='$d[nama_kelas]' and
											status_mengajar.semester='$_SESSION[semester_pem]' and
											status_mengajar.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and
											status_mengajar.teacher_id='$d[teacher_id]'
											and status_mengajar.status_belajar>'1'");	
	$dsudah=mysql_fetch_array($qsudah);
	
	
	  //cek materi
	   $qm=mysql_query("SELECT * from materi where id_pembelajaran='$d[id_pembelajaran]' 
and id $nh IN(SELECT id_materi from status_mengajar WHERE 
						id_user='$d[nik]' and 
						id_pembelajaran='$d[id_pembelajaran]')
						and batas_tanggal<='$tanggal'");	
	  $dqm=mysql_fetch_array($qm);
	 */
	  $qm=mysql_query("SELECT * from materi where id_pembelajaran='$d[id_pembelajaran]' 
	    and id $nh IN(SELECT id_materi from status_mengajar WHERE 
						id_user='$d[nik]' and 
						id_pembelajaran='$d[id_pembelajaran]' $sdhq) 
						and batas_tanggal<='$tanggal' order by batas_tanggal desc");	
	  $dqm=mysql_fetch_array($qm);
	  
	  if(!empty($dqm[id])){
	  $tema_m=$dqm[tema];
	  }
	  else {
	  $tema_m="Belum Ada Materi";
	  }
	
	}
	
			if(!empty($dm[id])){ $thros=$thari; } 
			
			$hsil="<tr>
               <td width='10%'>$d[nama]</td>
                <td width='10%'>$d[mapel]</td>
                <td width='10%'>$tema_m</td>
                <td width='10%' align='center'>$d[nama_kelas]</td>
                <td width='10%' align='center'>$thros</td>
                <td width='10%' align='center'>$waktu_status_m</td>
                <td width='10%' align='center'>$open</td>
                <td width='10%' align='center'>$close</td>
				</tr>";
			if($_GET[status_m]==0){
			echo"$hsil";
			} 
			else if($_GET[status_m]==1){
				
				if(empty($dstatus[id])){ 
				echo"$hsil";
				}
				else {
				echo"";
				}
						
			}
			else if($_GET[status_m]>1){
				
				if(!empty($dstatus[id])){ 
				echo"$hsil";
				}
				else {
				echo"";
				}
						
			}     
           
                    } ?>                    
   </tbody>
</table>

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

?>