
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

$nama_perangkat = anti_injection($_POST['nama_perangkat']);
$keterangan = anti_injection($_POST['keterangan']);
$tgl_batas = anti_injection($_POST['tgl_batas']);

if(!empty($nama_perangkat)){

$q=mysql_query("INSERT INTO perangkat(nama_perangkat,keterangan,tgl_batas) 
                                 
                         VALUES('$nama_perangkat','$keterangan','$tgl_batas')") or die("gagal".mysql_error());
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