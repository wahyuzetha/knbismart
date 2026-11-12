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
$id = anti_injection($_POST['id']);
$pembelajaran = anti_injection($_POST['pembelajaran']);
$nuptk = anti_injection($_POST['nuptk']);
$tingkat = anti_injection($_POST['tingkat']);
$jurusan = anti_injection($_POST['jurusan']);

//echo"$_SESSION[id_user]$tgl";

if(!empty($pembelajaran)){
 

               $jurusan_siswa=json_encode($_POST[kelas]);;

$q=mysql_query("UPDATE pembelajaran set nuptk='$nuptk',
                       pembelajaran='$pembelajaran' ,kelas='$jurusan_siswa',tingkat='$tingkat'
										where id='$id'") or die("gagal".mysql_error());
}
else {
	header('Location: data');
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
window.location = "data";
  }
});
</script>

<?php 
} 
?>
</body>
</html>