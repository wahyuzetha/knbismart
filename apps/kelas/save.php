
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

$tingkat = anti_injection($_POST['tingkat']);
$kelas = anti_injection($_POST['kelas']);
$guru = anti_injection($_POST['guru']);
$jurusan = anti_injection($_POST['jurusan']);

//echo"$_SESSION[id_user]$tgl";

if(!empty($kelas)){

$q=mysql_query("INSERT INTO kelas(nama_kelas,tingkat,wali,tahun_ajaran,jurusan) 
                                 
                         VALUES('$kelas','$tingkat','$guru','$tahun_aktif','$jurusan')") or die("gagal".mysql_error());
}
else {
 
  header('Location: add');
}
 if($q) {
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