
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
$jenis = "A.$tgl";

$query = "SELECT max(nomor) as maxID FROM pemohon WHERE nomor LIKE '$jenis%'";
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$idMax = $data['maxID'];
$noUrut = (int) substr($idMax, 3, 12);
$noUrut++;
//$newID = $jenis . sprintf("%04s", $noUrut);
 $newID ="$_SESSION[id_user]$tgl"; 
$pembelajaran = anti_injection($_POST['pembelajaran']);
$tingkat = anti_injection($_POST['tingkat']);
$kelas = anti_injection($_POST['kelas']);

$nuptk = anti_injection($_POST['nuptk']);

//echo"$_SESSION[id_user]$tgl";

if(!empty($pembelajaran)){
               $kalas_siswa=json_encode($_POST[kelas]);;

$q=mysql_query("INSERT INTO pembelajaran(nuptk,pembelajaran,tingkat,jurusan,kelas,tahun_ajaran,semester,manual) 
                                 
                         VALUES('$nuptk','$pembelajaran','$tingkat','$jurusan_siswa','$kalas_siswa','$_SESSION[tahun_ajaran_pem]','$_SESSION[semester_pem]','1')") or die("gagal".mysql_error());
}
else {
 
  header('Location: add');
}
 if($q) {
   $_SESSION[id_pemohon]=$newID;
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
window.location = "add";
  }
});
</script>

<?php 
} 
?>
</body>
</html>