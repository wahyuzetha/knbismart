
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

$id = anti_injection($_POST['id']);
$nama_ujian = $_POST['nama_ujian'];
$waktu_mulai = $_POST['waktu_mulai'];
$waktu_selesai = $_POST['waktu_selesai'];
$soal_acak = $_POST['soal_acak'];
$opsi_acak = $_POST['opsi_acak'];
$lama_ujian = $_POST['lama_ujian'];
$kesempatan = $_POST['kesempatan'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];
$essay = anti_injection($_POST['essay']);
$status_essay = $_POST['status_essay'];
$akses_kelas=json_encode($_POST[akses_kelas]);
$akses_siswa=json_encode($_POST[akses_siswa]);
$jenis_akses=anti_injection($_POST['jenis_akses']);
$tampilkan_nilai=$_POST[tampilkan_nilai];
$status_essay_auto=$_POST[status_essay_auto];
$bobot_essay_auto=$_POST[bobot_essay_auto];
$jenis_ujian=$_POST[jenis_ujian];
$bobot_multiple=$_POST[bobot_multiple];
$bobot_matching=$_POST[bobot_matching];

$batas_tuntas=$_POST[batas_tuntas];
$id_soal_next=$_POST[id_soal_next];

$jumlah_soal_keluar_pilgan=$_POST[jumlah_soal_keluar_pilgan];
$jumlah_soal_keluar_multiple=$_POST[jumlah_soal_keluar_multiple];
$jumlah_soal_keluar_matching=$_POST[jumlah_soal_keluar_matching];
$jumlah_soal_keluar_essay_auto=$_POST[jumlah_soal_keluar_essay_auto];

$gidm=mysql_query("SELECT * from pembelajaran where id='$id'");	
$didm=mysql_fetch_array($gidm);

$q=mysql_query("INSERT INTO ujian(id_pembelajaran,nama_ujian,waktu_mulai,waktu_selesai,acak_soal,acak_jwb,
lama_ujian,kesempatan,skala,jam_mulai,jam_selesai,status_essay,essay,jenis_akses,akses_kelas,
akses_siswa,tampilkan_nilai,id_user,status_essay_auto,bobot_essay_auto,jenis_ujian,bobot_multiple,bobot_matching,
jumlah_soal_keluar_pilgan,batas_tuntas,id_soal_next,
jumlah_soal_keluar_multiple,jumlah_soal_keluar_matching,jumlah_soal_keluar_essay_auto) 
                                 
                         VALUES('$id','$nama_ujian','$waktu_mulai','$waktu_selesai','$soal_acak','$opsi_acak','$lama_ujian','$kesempatan',
						 '$_POST[skala]','$jam_mulai','$jam_selesai','$status_essay','$essay','$jenis_akses','$akses_kelas',
						 '$akses_siswa','$tampilkan_nilai','$didm[nuptk]',
						 '$status_essay_auto','$bobot_essay_auto','$jenis_ujian','$bobot_matching','$bobot_matching',
						 '$jumlah_soal_keluar_pilgan','$batas_tuntas','$id_soal_next',
						 '$jumlah_soal_keluar_multiple','$jumlah_soal_keluar_matching','$jumlah_soal_keluar_essay_auto')") or die("gagal".mysql_error());

 if($q) { 
     $last_d=mysql_insert_id();
 $tgl_s=date('Y-m-d');
    $log=mysql_query("insert into log_aktifitas(nama_log,timestmp,ip,id_user,device,tanggal,id_materi,id_ujian,id_bank_soal,id_perangkat,id_pembelajaran)
values('Membuat Ujian $nama_ujian',NOW(),'$ip','$_SESSION[namauser]','$_SERVER[HTTP_USER_AGENT]','$tgl_s','','$last_d','','','$id')") or die("gagal".mysql_error());
        
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
window.location = "data?d=<?php echo"$id";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>