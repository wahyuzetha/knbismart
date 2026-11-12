<?php 
include "../../inc/koneksi.php";
include "../../inc/aman.php";

$kategori = $_POST['kategori'];
$judul = mysql_real_escape_string($_POST['judul']);
$isi=$_POST[isi];
$img=$_POST[img];
$tgl=date("Ymd");
    $time=time("h:i:sa");
    
if(!empty($img)){
define('UPLOAD_DIR', '../../images/');
 $img = $_POST['img'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $name="ft";
    $name = str_replace(' ', '_', $name);
    $namefoto="$name$tgl$time.png";
    $file = UPLOAD_DIR . $namefoto;
    $success = file_put_contents($file, $data);
}


$namaFile = $_FILES['jfile']['name'];

if(!empty($namaFile)){

$namaSementara = $_FILES['jfile']['tmp_name'];
$dirUpload = "../../file/";

// pindahkan file
$namefiles="$tgl$time$namaFile";
$terupload = move_uploaded_file($namaSementara, $dirUpload.$namefiles);

if ($terupload) {
  $jfile=$namefiles;
}

}
$q=mysql_query("INSERT INTO berita(judul,
									isi,
									foto,
									kategori,
									jfile,
									id_user) 
                                 
	                       VALUES('$judul',
	                       		 '$isi',
								 '$namefoto',
								 '$kategori',
								 '$jfile',
								 '$_SESSION[id_pengguna]')") or die("gagal".mysql_error());


 
if($q) {

header('Location: add?h=sukses');	

}
else {
    $errorg=mysql_error();
header('Location: add?h=gagal&&pesan='.$errorg); 
} 
 
  