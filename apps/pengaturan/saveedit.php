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
$kelas = anti_injection($_POST['kelas']);
$id = anti_injection($_POST['id']);
$minimal_keluar_ujian=anti_injection($_POST['minimal_keluar_ujian']);
$tingkat=json_encode($_POST[tingkat]);



  
$q=mysql_query("UPDATE pengaturan set blok='$_POST[blok]',waktu_rilis_token='$_POST[waktu_rilis_token]',
						split_import='$_POST[split_import]',tingkat='$tingkat',minimal_keluar_ujian='$minimal_keluar_ujian',
    					buka_nilai='$_POST[blok_k]',maksimal_upload_tugas_file='$_POST[maksimal_upload_tugas_file]',
						messagingSenderId='$_POST[messagingSenderId]',
						apiKey='$_POST[apiKey]',
						projectId='$_POST[projectId]',
						appId='$_POST[appId]',
						apicloud='$_POST[apicloud]'") or die("gagal".mysql_error());


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
window.location = "edit";
  }
});
</script>

<?php 
} 
?>
</body>
</html>