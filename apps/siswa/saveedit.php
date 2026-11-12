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
$nis_lama = anti_injection($_POST['nis_lama']);
$email = anti_injection($_POST['email']);
$nis = anti_injection($_POST['nis']);
$nama = anti_injection($_POST['nama']);
$kelas = anti_injection($_POST['kelas']);
$foto_lama = $_POST['foto_lama'];

$m2=mysql_query("select  * from siswa where nis='$nis' and nis!='$nis_lama'");
$d2=mysql_fetch_array($m2);
$muser=mysql_query("select  * from users where username='$_POST[username]' and id_pengguna!='$nis_lama'");
$duser=mysql_fetch_array($muser);

if(!empty($d2[nis])){
  header('Location: data?h=gagal&pesan=Duplikat NIS');
}

else if(!empty($duser[username])){
  header('Location: add?h=gagal&pesan=Duplikat Username');
}

else {
    


if(!empty($nama)){
$waktu=date('Ymdhis');
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
    $foto=$foto_lama;
}



$q=mysql_query("UPDATE siswa set nis='$nis',nama='$nama',tanggal_lahir='$_POST[tgl_lahir]',kelas='$kelas',foto='$foto',
aktif='$_POST[aktif]'
										where nis='$nis_lama'") or die("gagal".mysql_error());

$q=mysql_query("update kelas_siswa set kelas='$kelas' where nis='$nis_lama' and tahun_ajaran='$_SESSION[thn_ajarann]'") or die("gagal".mysql_error());


$pass     = anti_injection(md5($_POST[password]));
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);

if(!empty($_POST[password])){
$q=mysql_query("update users set password='$p',username='$_POST[username]' where id_pengguna='$nis_lama'") or die("gagal".mysql_error());
$q=mysql_query("update siswa set pas='$_POST[password]' where nis='$_POST[nis_lama]'") or die("gagal".mysql_error());

}
else {
$q=mysql_query("update users set username='$_POST[username]' where id_pengguna='$nis_lama'") or die("gagal".mysql_error());

}
    
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
}
?>
</body>
</html>