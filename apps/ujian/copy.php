
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
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
ini_set('date.timezone', 'Asia/Jakarta');
$tgl=date("Ymdhis");

$id_guru_copy = anti_injection($_POST['copy']);
$id_ujian = anti_injection($_POST['id_ujian']);

$dm=mysql_query("select  * from ujian where id='$id_ujian'") or die("gagal".mysql_error()); 
$dp1=mysql_fetch_array($dm);

$nama_ujian = $dp1['nama_ujian'];
$waktu_mulai = $dp1['waktu_mulai'];
$waktu_selesai = $dp1['waktu_selesai'];
$soal_acak = $dp1['soal_acak'];
$opsi_acak = $dp1['opsi_acak'];
$lama_ujian = $dp1['lama_ujian'];
$kesempatan = $dp1['kesempatan'];
$jam_mulai = $dp1['jam_mulai'];
$jam_selesai = $dp1['jam_selesai'];
$essay = anti_injection($dp1['essay']);
$status_essay = $dp1['status_essay'];
$akses_kelas=$dp1[akses_kelas];
$akses_siswa=$dp1[akses_siswa];
$jenis_akses=$dp1['jenis_akses'];
$tampilkan_nilai=$dp1[tampilkan_nilai];
$status_essay_auto=$dp1[status_essay_auto];
$bobot_essay_auto=$dp1[bobot_essay_auto];
$jenis_ujian=$dp1[jenis_ujian];
$bobot_multiple=$dp1[bobot_multiple];
$bobot_matching=$dp1[bobot_matching];

$batas_tuntas=$dp1[batas_tuntas];
$id_soal_next=$dp1[id_soal_next];

$jumlah_soal_keluar_pilgan=$dp1[jumlah_soal_keluar_pilgan];
$jumlah_soal_keluar_multiple=$dp1[jumlah_soal_keluar_multiple];
$jumlah_soal_keluar_matching=$dp1[jumlah_soal_keluar_matching];
$jumlah_soal_keluar_essay_auto=$dp1[jumlah_soal_keluar_essay_auto];



$q=mysql_query("INSERT INTO ujian(id_pembelajaran,nama_ujian,waktu_mulai,waktu_selesai,acak_soal,acak_jwb,
lama_ujian,kesempatan,skala,jam_mulai,jam_selesai,status_essay,essay,jenis_akses,akses_kelas,akses_siswa,
tampilkan_nilai,status_essay_auto,bobot_essay_auto,jenis_ujian,bobot_multiple,bobot_matching,
jumlah_soal_keluar_pilgan,batas_tuntas,id_soal_next,
jumlah_soal_keluar_multiple,jumlah_soal_keluar_matching,jumlah_soal_keluar_essay_auto) 
                                 
                         VALUES('$id_guru_copy','Copy $nama_ujian','$waktu_mulai','$waktu_selesai','$soal_acak','$opsi_acak','$lama_ujian','$kesempatan',
						 '$dp1[skala]','$jam_mulai','$jam_selesai',
						 '$status_essay','$essay','$jenis_akses','$akses_kelas',
						 '$akses_siswa','$tampilkan_nilai',
						 '$status_essay_auto','$bobot_essay_auto','$jenis_ujian','$bobot_matching','$bobot_matching',
						 '$jumlah_soal_keluar_pilgan','$batas_tuntas','$id_soal_next',
						 '$jumlah_soal_keluar_multiple','$jumlah_soal_keluar_matching','$jumlah_soal_keluar_essay_auto')") or die("gagal".mysql_error());


$lastd=mysql_insert_id();
$bk=mysql_query("select  * from bank_soal where id_ujian='$id_ujian' order by id asc") or die("gagal".mysql_error()); 
while($dbk=mysql_fetch_array($bk)){
$soal = mysql_real_escape_string($dbk['soal']);
$opsia = mysql_real_escape_string($dbk['pila']);
$opsib = mysql_real_escape_string($dbk['pilb']);
$opsic = mysql_real_escape_string($dbk['pilc']);
$opsid = mysql_real_escape_string($dbk['pild']);
$opsie = mysql_real_escape_string($dbk['pile']);
$kunci = $dbk['kunci'];
$point=$dbk['point'];


$no_soal=$dbk[no_soal];
$q2=mysql_query("INSERT INTO bank_soal(id_ujian,soal,kunci,point,pila,pilb,pilc,pild,pile,no_soal) 
VALUES('$lastd','$soal','$kunci','$point','$opsia','$opsib','$opsic','$opsid','$opsie','$no_soal')") or die("gagal".mysql_error());
$id_soal=mysql_insert_id();

    
}

 if($q) {
   
  ?>
  <script type="text/javascript">
swal({
  title: "Data Berhasil Di Copykan",
  icon: "success",
  showCancelButton: false,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "OK"
},
function(isConfirm) {
  if (isConfirm) {
window.location = "data?d=<?php echo"$_SESSION[id_mapel_ujians]";?>";
  }
});
</script>

<?php 
} 

?>
