   <html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
$id_ujian = anti_injection($_POST['id_ujian']);

$soal = mysql_real_escape_string($_POST['soal']);
$opsia = mysql_real_escape_string($_POST['opsia']);
$opsib = mysql_real_escape_string($_POST['opsib']);
$opsic = mysql_real_escape_string($_POST['opsic']);
$opsid = mysql_real_escape_string($_POST['opsid']);
$opsie = mysql_real_escape_string($_POST['opsie']);
$kunci = $_POST['kunci'];
$point=$_POST['point'];
$timer=$_POST['timer'];

$q2=mysql_query("update bank_soal set soal='$soal',kunci='$kunci'
				where id='$id' and id_ujian='$id_ujian'") or die("gagal".mysql_error());


 
 if($q2) {
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
window.location = "edit_essay?d=<?php echo"$id";?>&id_ujian=<?php echo"$id_ujian";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>