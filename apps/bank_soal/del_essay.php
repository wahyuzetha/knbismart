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
$id_ujian = anti_injection($_POST['id_ujian']);


$q2=mysql_query("DELETE FROM bank_essay WHERE id='$id' and id_ujian='$id_ujian'") ;

 if($q2) {
 	?>
	<script type="text/javascript">
swal({
  title: "Data Berhasil Di Hapus",
  icon: "success",
  showCancelButton: false,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "OK"
},
function(isConfirm) {
  if (isConfirm) {
window.location = "data?d=<?php echo"$id_ujian";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>