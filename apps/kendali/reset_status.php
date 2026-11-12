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
$id = anti_injection($_POST['d']);


$q=mysql_query("update hasil_jwb set status='0' WHERE nis='$_POST[nis]' and id_ujian='$_POST[id_ujian]'") ; 

 if($q) {
 	?>
	<script type="text/javascript">
swal({
  title: "Data Berhasil Di Reset",
  icon: "success",
  showCancelButton: false,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "OK"
},
function(isConfirm) {
  if (isConfirm) {
window.location = "peserta?d=<?php echo"$_POST[id_ujian]";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>