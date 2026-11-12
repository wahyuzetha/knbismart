
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



 $newID ="$_SESSION[id_user]$tgl"; 
$nama = anti_injection($_POST['nama']);
$email = anti_injection($_POST['email']);
$nuptk = anti_injection($_POST['nuptk']);
$id_jabatan = anti_injection($_POST['jabatan']);
$nik = anti_injection($_POST['nik']);
$username = anti_injection($_POST['username']);

//echo"$_SESSION[id_user]$tgl";
	
if(!empty($nama)){
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
    $foto='';
}


$query = "SELECT * from guru WHERE nik ='$nik'";
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);

$query2 = "SELECT * from users WHERE username ='$username'";
$hasil2 = mysql_query($query2);
$data2  = mysql_fetch_array($hasil2);

if(!empty($data[id])){
    header('Location: add?h=gagal&pesan=Double NIK');
  
}
else if(!empty($data2[username])){
    header('Location: add?h=gagal&pesan=Double Username');
  
}
else {
$q=mysql_query("INSERT INTO guru(nuptk,nama,tanggal_lahir,id_jabatan,nik,foto) 
                                 
                         VALUES('$nuptk','$nama','$_POST[tgl_lahir]','$id_jabatan','$nik','$foto')") or die("gagal".mysql_error());
$lastid=mysql_insert_id();
    $pass     = anti_injection(md5($_POST['password']));
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);
$q=mysql_query("insert into users (username,password,level,id_pengguna) 
values('$username','$p','2','$nik')") or die("gagal".mysql_error());

}
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
?>
</body>
</html>