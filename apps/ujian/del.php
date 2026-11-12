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
$id_pembelajaran = anti_injection($_POST['id_pembelajaran']);
$nama_ujian = anti_injection($_POST['nm']);

$m3=mysql_query("SELECT ujian.*,pembelajaran.nuptk from ujian,pembelajaran WHERE pembelajaran.id=ujian.id_pembelajaran and ujian.id='$id'");
$d3=mysql_fetch_array($m3);

$q=mysql_query("DELETE FROM ujian WHERE id='$id'") ; 
$log=mysql_query("insert into log_aktifitas(nama_log,timestmp,ip,id_user,device,tanggal,id_materi,id_ujian,id_bank_soal,id_perangkat,id_pembelajaran)
values('Hapus Ujian $nama_ujian',NOW(),'$ip','$_SESSION[namauser]','$_SERVER[HTTP_USER_AGENT]','$tgl_s','','$id','','','$id_pembelajaran')") or die("gagal".mysql_error());
  
 if($q) {
	 	 rmdir("../../bank_soal/$d3[nuptk]/$id");

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
window.location = "data?d=<?php echo"$id_pembelajaran";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>