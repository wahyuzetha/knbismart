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
$tingkat = anti_injection($_POST['tingkat']);
$kelas = anti_injection($_POST['kelas']);
$guru = anti_injection($_POST['guru']);
$id = anti_injection($_POST['id']);
$jurusan = anti_injection($_POST['jurusan']);




  
$q=mysql_query("UPDATE kelas set nama_kelas='$kelas',tingkat='$tingkat',wali='$guru',jurusan='$jurusan'
	where id='$id'") or die("gagal".mysql_error());


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