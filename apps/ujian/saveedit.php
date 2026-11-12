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

$tgl=date('dmy');
$jenis = $tgl;
$id = anti_injection($_POST['id']);
$id_pembelajaran = anti_injection($_POST['id_pembelajaran']);

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

$gidm=mysql_query("SELECT * from pembelajaran where id='$id_pembelajaran'");	
$didm=mysql_fetch_array($gidm);

$batas_tuntas=$_POST[batas_tuntas];
$id_soal_next=$_POST[id_soal_next];

$jumlah_soal_keluar_pilgan=$_POST[jumlah_soal_keluar_pilgan];
$jumlah_soal_keluar_multiple=$_POST[jumlah_soal_keluar_multiple];
$jumlah_soal_keluar_matching=$_POST[jumlah_soal_keluar_matching];
$jumlah_soal_keluar_essay_auto=$_POST[jumlah_soal_keluar_essay_auto];


$q=mysql_query("update ujian set 
                                nama_ujian='$nama_ujian',
                                waktu_mulai='$waktu_mulai',
                                waktu_selesai='$waktu_selesai',
                                acak_soal='$soal_acak',
                                acak_jwb='$opsi_acak',
                                lama_ujian='$lama_ujian',
                                kesempatan='$kesempatan',
								skala='$_POST[skala]',
								jam_mulai='$jam_mulai',
								jam_selesai='$jam_selesai',
								essay='$essay',
								status_essay='$status_essay',
								akses_kelas='$akses_kelas',
								akses_siswa='$akses_siswa',
								jenis_akses='$jenis_akses',
								tampilkan_nilai='$tampilkan_nilai',
								id_user='$didm[nuptk]',
								status_essay_auto='$status_essay_auto',
								bobot_essay_auto='$bobot_essay_auto',
								jenis_ujian='$jenis_ujian',
								fix_uts='$_POST[fix_uts]',
								susulan='$_POST[susulan]',
								bobot_multiple='$bobot_multiple',
								bobot_matching='$bobot_matching',
								batas_tuntas='$batas_tuntas',
								id_soal_next='$id_soal_next',
								jumlah_soal_keluar_pilgan='$jumlah_soal_keluar_pilgan',
								jumlah_soal_keluar_multiple='$jumlah_soal_keluar_multiple',
								jumlah_soal_keluar_matching='$jumlah_soal_keluar_matching',
								jumlah_soal_keluar_essay_auto='$jumlah_soal_keluar_essay_auto',
								nilai_koma='$_POST[nilai_koma]'
                                where id='$id'") or die("gagal".mysql_error());

 if($q) {
     
      $tgl_s=date('Y-m-d');
    $log=mysql_query("insert into log_aktifitas(nama_log,timestmp,ip,id_user,device,tanggal,id_materi,id_ujian,id_bank_soal,id_perangkat,id_pembelajaran)
values('Update Ujian $nama_ujian',NOW(),'$ip','$_SESSION[namauser]','$_SERVER[HTTP_USER_AGENT]','$tgl_s','','$id','','','$id_pembelajaran')") or die("gagal".mysql_error());
  
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
window.location = "edit?d=<?php echo"$id&id_pembelajaran=$id_pembelajaran";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>