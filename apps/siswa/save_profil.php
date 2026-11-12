   <html>
<head>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title>Save</title>
<link rel="stylesheet" type="text/css" href="../../plugins/sweetalert/sweetalert.css">
<script type="text/javascript" src="../../plugins/sweetalert/sweetalert.min.js"></script>
</head>
<body>
<?php 

include "../../inc/koneksi.php";
include "../../inc/aman.php";


$pass     = md5($_POST[password]);
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);

if(!empty($_POST['img'])){

define('UPLOAD_DIR', '../../foto/');
    $img = $_POST['img'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $tgl=date("Ymd");
    $time=time("h:i:sa");
    $name=$nis;
    $name = str_replace(' ', '_', $name);
    $namefoto="$name$tgl$time.png";
    $file = UPLOAD_DIR . $namefoto;
    $success = file_put_contents($file, $data);
    $foto="$namefoto";
}
else {
    $foto=$_POST[foto_lama];
}
$q=mysql_query("update siswa set foto='$foto' where nis='$_POST[nis_lama]'") or die("gagal".mysql_error());


if(!empty($_POST[password])){
$q=mysql_query("update users set password='$p' where id_pengguna='$_POST[nis_lama]'") or die("gagal".mysql_error());
$q=mysql_query("update siswa set pas='$_POST[password]' where nis='$_POST[nis_lama]'") or die("gagal".mysql_error());

    
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