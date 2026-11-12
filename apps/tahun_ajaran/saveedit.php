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
$tahun_ajaran = anti_injection($_POST['tahun_ajaran']);
$id = anti_injection($_POST['id']);
$tahun_ajaran = anti_injection($_POST['tahun_ajaran']);
$no_ppdb = anti_injection($_POST['no_ppdb']);
$nama_panitia = anti_injection($_POST['nama_panitia']);




  
$q=mysql_query("UPDATE tahun_ajaran set namathn='$tahun_ajaran',no_ppdb='$no_ppdb',nama_panitia='$nama_panitia'
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