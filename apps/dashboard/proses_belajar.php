
   <html>
<head>
<title>Save</title>
<link rel="stylesheet" type="text/css" href="../../plugins/sweetalert/sweetalert.css">
<script type="text/javascript" src="../../plugins/sweetalert/sweetalert.min.js"></script>
</head>
<body>

<?php 

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include"../../inc/meta.php";
include"../../inc/hari.php";
include"../../inc/fire.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
ini_set('date.timezone', 'Asia/Jakarta');

$id_pembelajaran = anti_injection($_GET['id_pembelajaran']);
$id_materi = anti_injection($_GET['id_materi']);
$id_tugas = anti_injection($_GET['id_tugas']);
$id_ujian = anti_injection($_GET['id_ujian']);
$id_kelas = anti_injection($_GET['id_kelas']);
$status_belajar = anti_injection($_GET['status_belajar']);
$tanggal = anti_injection($_GET['tanggal']);
$jam = anti_injection($_GET['jam']);
$teacher_id = anti_injection($_GET['teacher_id']);
$classid = anti_injection($_GET['classid']);
$subject_id = anti_injection($_GET['subject_id']);
$days = anti_injection($_GET['days']);
$startime = anti_injection($_GET['startime']);
$catatan = mysql_real_escape_string($_GET['catatan']);


//fungsi mencari jam mengajar
$chari=date('D', strtotime($tanggal));
$hari_jadwal=hari_indo($chari);	

$cpem=mysql_query("select * from pembelajaran where id='$id_pembelajaran'");
$dcpem=mysql_fetch_array($cpem);

$qhr=mysql_query("SELECT * from asc_daysdefs where name='".mysql_real_escape_string($hari_jadwal)."'");	
$dhr=mysql_fetch_array($qhr);
 

 $qjadwal=mysql_query("SELECT asc_periods.starttime,asc_periods.endtime,guru.nama,kelas.id_class,kelas.tingkat,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
	from asc_cards,guru,kelas,asc_subjects,asc_lessons,asc_periods
	WHERE 
	asc_lessons.id=asc_cards.lessonid AND
	asc_lessons.teacherids=guru.teacher_id AND
	asc_lessons.classids=kelas.id_class AND
	asc_lessons.subjectid=asc_subjects.id AND
	asc_cards.period=asc_periods.period and
	asc_lessons.classids='$_GET[classid]' and
	asc_cards.days='$dhr[days]' AND
	asc_cards.tahun_ajaran='$tahun_aktif' AND
	asc_cards.semester='$semester_aktif' and
	asc_lessons.teacherids='$teacher_id' and 
	asc_lessons.subjectid='$subject_id'
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

	$jam_mengajar_guru_m="$jam_mg1 sampai $jam_mg2";


if(!empty($id_pembelajaran)){
	

											
if($status_belajar==2){
$status_ak_belajar="Open Pelajaran $dcpem[pembelajaran]";

$cek=mysql_query("select * from status_mengajar where 
											id_pembelajaran='$id_pembelajaran' and
											tanggal='$tanggal' and
											id_kelas='$id_kelas' and
											jam='$jam' and
											semester='$semester_aktif' and
											tahun_ajaran='$tahun_aktif'");
$dcek=mysql_fetch_array($cek);

if(!empty($dcek)){
	header('Location: data');
}
else {

$q=mysql_query("INSERT INTO status_mengajar(id_pembelajaran,
											id_materi,
											id_tugas,
											id_ujian,
											id_kelas,
											status_belajar,
											tanggal,
											jam,
											id_user,
											ip,
											agent,
											teacher_id,
											classid,
											subject_id,
											days,
											startime,
											semester,
											tahun_ajaran,
											waktu_mengajar) 
                                 
									 VALUES('$id_pembelajaran',
											'$id_materi',
											'$id_tugas',
											'$id_ujian',
											'$id_kelas',
											'$status_belajar',
											'$tanggal',
											'$jam',
											'$_SESSION[namauser]',
											'$ip',
											'$_SERVER[HTTP_USER_AGENT]',
											'$teacher_id',
											'$classid',
											'$subject_id',
											'$days',
											'$startime',
											'$semester_aktif',
											'$tahun_aktif',
											'$jam_mengajar_guru_m')") or die("gagal".mysql_error());


//kirim_notif_kelas("Status $status_ak_belajar","Silahkan Buka","3",$alamat,$id_kelas,$fcmUrl);

}
}
else if($status_belajar==3){
 $status_ak_belajar="Close Pelajaran $dcpem[pembelajaran]";

 $cek=mysql_query("select * from status_mengajar where 
											id_pembelajaran='$id_pembelajaran' and
											tanggal='$tanggal' and
											id_kelas='$id_kelas' and
											semester='$semester_aktif' and
											tahun_ajaran='$tahun_aktif' and 
											status_belajar='3'");
$dcek=mysql_fetch_array($cek);

//kirim_notif_kelas("Status $status_ak_belajar","Jam","3",$alamat,$id_kelas,$fcmUrl);

if(!empty($dcek)){
	header('Location: data');
}
else {


$q=mysql_query("update status_mengajar set status_belajar='3',
											waktu_mengajar='$jam_mengajar_guru_m',
											ip='$ip',
											agent='$_SERVER[HTTP_USER_AGENT]',
											catatan='$catatan'
											where
											id_pembelajaran='$id_pembelajaran' and
											tanggal='$tanggal' and
											id_kelas='$id_kelas' and
											semester='$semester_aktif' and
											tahun_ajaran='$tahun_aktif'");
}
}
}
else {
 
  header('Location: data');
}
 if($q) {
	 
	    $tgl_s=date('Y-m-d');
    $log=mysql_query("insert into log_aktifitas(nama_log,timestmp,ip,id_user,device,tanggal,id_materi,id_ujian,id_bank_soal,id_perangkat,id_pembelajaran,id_tugas)
values('$status_ak_belajar $id_kelas $catatan',NOW(),'$ip','$_SESSION[namauser]','$_SERVER[HTTP_USER_AGENT]','$tgl_s','$id_materi','$id_ujian','','','$id','$id_tugas')") or die("gagal".mysql_error());
  

  
  ?>
  <script type="text/javascript">
swal({
  title: "Data Berhasil Disimpan",
  icon: "success",
  showCancelButton: false,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "OK"
},
function(isConfirm) {
  if (isConfirm) {
window.location = "<?php echo"detail_open?id_pembelajaran=$id_pembelajaran&tanggal=$tanggal&id_kelas=$id_kelas&jam=$jam&id_materi=$id_materi&id_tugas=$id_tugas&id_ujian=$id_ujian&subject_id=$subject_id&teacher_id=$teacher_id&classid=$classid";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>