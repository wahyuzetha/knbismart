
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
$nama_perangkat = mysql_real_escape_string($_POST['nama_perangkat']);
$isi = mysql_real_escape_string($_POST['isi']);

$img=$_POST[img];
$tgl=date("Ymd");
    $time=time("h:i:sa");
    



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

$q=mysql_query("INSERT INTO detail_perangkat(id_perangkat,nama_perangkat,id_pembelajaran,file,id_user) 
                                 
                         VALUES('$_SESSION[id_perangkat_s]','$nama_perangkat','$id','$jfile','$_SESSION[namauser]')") or die("gagal".mysql_error());

$lastd=mysql_insert_id();
 if($q) {
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