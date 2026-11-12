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
$nuptk_lama = anti_injection($_POST['nuptk_lama']);
$email = anti_injection($_POST['email']);
$nuptk = anti_injection($_POST['nuptk']);
$nama = anti_injection($_POST['nama']);
$id_jabatan = anti_injection($_POST['jabatan']);

$nik = anti_injection($_POST['nik']);
$username = anti_injection($_POST['username']);


$query = "SELECT * from guru WHERE nik ='$nik' and nik!='$nuptk_lama'";
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);

$query2 = "SELECT * from users WHERE username ='$username' and id_pengguna!='$nuptk_lama'";
$hasil2 = mysql_query($query2);
$data2  = mysql_fetch_array($hasil2);
if(!empty($data[id])){
    header('Location: add?h=gagal&pesan=Double NIK&d='.$nuptk_lama);
  
}

else {


    
$waktu=date('Ymdhis');



if(!empty($_POST['img'])){

define('UPLOAD_DIR', '../../foto/');
    $img = $_POST['img'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $tgl=date("Ymd");
    $time=time("h:i:sa");
    $name=$nik;
    $name = str_replace(' ', '_', $name);
    $namefoto="$name$tgl$time.png";
    $file = UPLOAD_DIR . $namefoto;
    $success = file_put_contents($file, $data);
    $foto="$namefoto";
}
else {
    $foto=$_POST[foto_lama];
}

if($_SESSION[levelu]==1){
$jab=",id_jabatan='$id_jabatan'";
}
else {
$jab="";
}
$penyelenggara_ujian=json_encode($_POST[penyelenggara_ujian]);;

$q=mysql_query("UPDATE guru set nuptk='$nuptk',nama='$nama',tanggal_lahir='$_POST[tgl_lahir]',foto='$file_name2',foto='$foto',penyelenggara_ujian='$penyelenggara_ujian' $jab
										where nik='$nuptk_lama'") or die("gagal".mysql_error());

 
 



$pass     = anti_injection(md5($_POST['password']));
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);

if(!empty($_POST['password'])){
  
$q=mysql_query("UPDATE users set username='$username',password='$p'
	where id_pengguna='$_POST[nuptk_lama]'") or die("gagal".mysql_error());
}

$q=mysql_query("UPDATE users set username='$username'
	where id_pengguna='$_POST[nuptk_lama]'") or die("gagal".mysql_error());
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
window.location = "<?php echo"edit?d=$nuptk_lama";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>