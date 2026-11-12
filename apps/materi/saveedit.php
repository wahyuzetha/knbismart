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
$id_pembelajaran = anti_injection($_POST['id_pembelajaran']);
$batas_tanggal = mysql_real_escape_string($_POST['batas_tanggal']);
$batas_jam = mysql_real_escape_string($_POST['batas_jam']);
$tanggal_akhir_akses=anti_injection($_POST['tanggal_akhir_akses']);

$judul = mysql_real_escape_string($_POST['judul']);
$isi = mysql_real_escape_string($_POST['isi']);

$akses_kelas=json_encode($_POST[akses_kelas]);
$akses_siswa=json_encode($_POST[akses_siswa]);
$jenis_akses=anti_injection($_POST['jenis_akses']);
$tema=mysql_real_escape_string($_POST['tema']);


$img=$_POST[img];
$tgl=date("Ymd");
    $time=time("h:i:sa");
    
if(!empty($img)){
define('UPLOAD_DIR', '../../images/');
 $img = $_POST['img'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $name=$judul;
    $name = str_replace(' ', '_', $name);
    $namefoto="$name$tgl$time.png";
    $file = UPLOAD_DIR . $namefoto;
    $success = file_put_contents($file, $data);
}
else {
    $namefoto=$_POST[foto_lama];
}

$namaFile = $_FILES['jfile']['name'];

if(!empty($namaFile)){

$namaSementara = $_FILES['jfile']['tmp_name'];
$dirUpload = "../../file/";

// pindahkan file
$namefiles="$tgl$time$namaFile";
$namefiles=str_replace(" ","",$namefiles);
$terupload = move_uploaded_file($namaSementara, $dirUpload.$namefiles);

if ($terupload) {
  $jfile=$namefiles;
}

}
else {
    $jfile=$_POST[file_lama];
}
$gidm=mysql_query("SELECT * from pembelajaran where id='$id_pembelajaran'");	
$didm=mysql_fetch_array($gidm);

    $q=mysql_query("update materi set judul='$judul',isi='$isi',file='$jfile',foto='$namefoto',batas_tanggal='$batas_tanggal',batas_jam='$batas_jam',akses_kelas='$akses_kelas',akses_siswa='$akses_siswa',jenis_akses='$jenis_akses',tanggal_akhir_akses='$tanggal_akhir_akses',
	tema='$tema',id_user='$didm[nuptk]' where id='$id'") or die("gagal".mysql_error());

 if($q) {
    $tgl_s=date('Y-m-d');
    $log=mysql_query("insert into log_aktifitas(nama_log,timestmp,ip,id_user,device,tanggal,id_materi,id_ujian,id_bank_soal,id_perangkat,id_pembelajaran)
values('Update Materi $judul',NOW(),'$ip','$_SESSION[namauser]','$_SERVER[HTTP_USER_AGENT]','$tgl_s','$id','','','','$id_pembelajaran')") or die("gagal".mysql_error());
   
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
window.location = "edit?d=<?php echo"$id&id_pembelajaran=$id_pembelajaran";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>