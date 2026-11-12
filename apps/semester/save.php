
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

$semester = anti_injection($_POST['semester']);
$no_ppdb = anti_injection($_POST['no_ppdb']);
$nama_panitia = anti_injection($_POST['nama_panitia']);

//echo"$_SESSION[id_user]$tgl";

if(!empty($tahun_ajaran)){

$q=mysql_query("INSERT INTO semester(semester,aktif) 
                                 
                         VALUES('$semester','0')") or die("gagal".mysql_error());
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
window.location = "data";
  }
});
</script>

<?php 
} 
?>
</body>
</html>