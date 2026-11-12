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
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}


$q=mysql_query("DELETE FROM hasil_jwb WHERE id_ujian='$_POST[id_ujian]'") ; 
$q=mysql_query("DELETE FROM hasil_opsi WHERE id_ujian='$_POST[id_ujian]'") ; 
$q=mysql_query("DELETE FROM log_masuk_ujian WHERE  id_ujian='$_POST[id_ujian]'") ; 

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