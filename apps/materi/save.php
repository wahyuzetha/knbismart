
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

$id = anti_injection($_POST['id']);
$judul = mysql_real_escape_string($_POST['judul']);
$isi = mysql_real_escape_string($_POST['isi']);
$batas_tanggal = mysql_real_escape_string($_POST['batas_tanggal']);
$batas_jam = mysql_real_escape_string($_POST['batas_jam']);
$akses_kelas=json_encode($_POST[akses_kelas]);
$akses_siswa=json_encode($_POST[akses_siswa]);
$jenis_akses=anti_injection($_POST['jenis_akses']);
$tanggal_akhir_akses=anti_injection($_POST['tanggal_akhir_akses']);
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

 $gidm=mysql_query("SELECT * from pembelajaran where id='$id'");	
$didm=mysql_fetch_array($gidm);

$q=mysql_query("INSERT INTO materi(id_pembelajaran,judul,isi,file,foto,batas_tanggal,batas_jam,jenis_akses,akses_kelas,akses_siswa,tanggal_akhir_akses,tema,id_user) 
                                 
                         VALUES('$id','$judul','$isi','$jfile','$namefoto','$batas_tanggal','$batas_jam','$jenis_akses','$akses_kelas','$akses_siswa','$tanggal_akhir_akses','$tema','$didm[nuptk]')") or die("gagal".mysql_error());

$lastd=mysql_insert_id();
 if($q) {
     $tgl_s=date('Y-m-d');
    $log=mysql_query("insert into log_aktifitas(nama_log,timestmp,ip,id_user,device,tanggal,id_materi,id_ujian,id_bank_soal,id_perangkat,id_pembelajaran)
values('Membuat Materi $judul',NOW(),'$ip','$_SESSION[namauser]','$_SERVER[HTTP_USER_AGENT]','$tgl_s','$lastd','','','','$id')") or die("gagal".mysql_error());
     
   $_SESSION[id_pemohon]=$newID;
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
window.location = "edit?d=<?php echo"$lastd&id_pembelajaran=$id";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>