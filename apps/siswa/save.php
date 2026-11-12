
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
ini_set('date.timezone', 'Asia/Jakarta');
$tgl=date("Ymdhis");
$jenis = "A.$tgl";


$nama = anti_injection($_POST['nama']);
$email = anti_injection($_POST['email']);
$nis = anti_injection($_POST['nis']);
$kelas = anti_injection($_POST['kelas']);
//echo"$_SESSION[id_user]$tgl";


$m2=mysql_query("select  * from siswa where nis='$nis'");
$d2=mysql_fetch_array($m2);

$muser=mysql_query("select  * from users where username='$_POST[username]'");
$duser=mysql_fetch_array($muser);

if(!empty($d2[nis])){
  header('Location: add?h=gagal&pesan=Duplikat NIS');
}
else if(!empty($duser[username])){
  header('Location: add?h=gagal&pesan=Duplikat Username');
}

else {
if(!empty($nama)){
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
    $foto='';
}

$mk=mysql_query("select  * from kelas where nama_kelas='$kelas' and tahun_ajaran='$tahun_aktif'");
$dk=mysql_fetch_array($mk);

$q=mysql_query("INSERT INTO siswa(nis,nama,tanggal_lahir,kelas,pas,foto) 
                                 
                         VALUES('$nis','$nama','$_POST[tgl_lahir]','$kelas','$_POST[password]','$foto')") or die("gagal".mysql_error());

$q=mysql_query("INSERT INTO kelas_siswa(nis,kelas,tahun_ajaran) 
                                 
                         VALUES('$nis','$kelas','$tahun_aktif')") or die("gagal".mysql_error());


$pass     = anti_injection(md5($_POST[password]));
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);

	
$q=mysql_query("INSERT INTO users(username,password,level,id_pengguna,pas) 
                                 
	                       VALUES('$_POST[username]','$p','3','$nis','$_POST[password]')") or die("gagal".mysql_error());
    
    
}
else {
 
  header('Location: add');
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
window.location = "add";
  }
});
</script>

<?php 
} 
}
?>
</body>
</html>