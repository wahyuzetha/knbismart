<?php 

include "../../inc/koneksi.php";
include "../../inc/aman.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$pass     = anti_injection(md5($_POST['password']));
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);


$petugas = anti_injection($_POST['petugas']);
$username = anti_injection($_POST['username']);
$level = anti_injection($_POST['level']);
$idk = anti_injection($_POST['id']);

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


if(!empty($_POST['password'])){
$q=mysql_query("UPDATE users set username='$username',password='$p',foto='$foto' 
	where id='$idk'") or die("gagal".mysql_error());
}
else {
$q=mysql_query("UPDATE users set username='$username',foto='$foto' 
 where id='$idk'") or die("gagal".mysql_error());
	}

 if($q) {

header('Location: data?h=sukses');
}
else {
echo"gagal"; } 
  
