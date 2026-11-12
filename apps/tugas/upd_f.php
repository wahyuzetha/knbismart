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
$id = anti_injection($_GET['d']);
$jenis = anti_injection($_GET['j']);

if($jenis=="f"){
$q=mysql_query("update tugas set file='' WHERE id='$id'") ; 
unlink($_GET[nm]);
}
else if($jenis=="p"){
$q=mysql_query("update tugas set foto='' WHERE id='$id'") ; 
unlink($_GET[nm]);

}

 if($q) {
  $tgl_s=date('Y-m-d');
    $log=mysql_query("insert into log_aktifitas(nama_log,timestmp,ip,id_user,device,tanggal,id_materi,id_ujian,id_bank_soal,id_perangkat,id_pembelajaran)
values('Hapus Materi $judul',NOW(),'$ip','$_SESSION[namauser]','$_SERVER[HTTP_USER_AGENT]','$tgl_s','$id','','','','$id_pembelajaran')") or die("gagal".mysql_error());
         
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
window.location = "edit?d=<?php echo"$id&id_pembelajaran=$_GET[id_pembelajaran]";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>