
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
    
if(!empty($_SESSION[id_raport_k])){
mkdir("../raport_file/$_SESSION[id_raport_k]");
mkdir("../raport_file/$_SESSION[id_raport_k]/$_SESSION[kelas_k]");

}

$folder="../raport_file/$_SESSION[id_raport_k]/$_SESSION[kelas_k]/";
$countfiles = count($_FILES['file']['name']);
 
 // Looping all files
 for($i=0;$i<$countfiles;$i++){
   $filename = $_FILES['file']['name'][$i];
   
   $without_extension = pathinfo($filename, PATHINFO_FILENAME);

   $m2=mysql_query("select  * from raport_detail where nis='$without_extension' and
   id_raport='$_SESSION[id_raport_k]' and id_kelas='$_SESSION[kelas_k]'");
$d2=mysql_fetch_array($m2);

	if(!empty($d2[id])){
	unlink("$folder/$filename");
	
	}
   // Upload file
   $q=move_uploaded_file($_FILES['file']['tmp_name'][$i],''.$folder.''.$filename);
	
  if(empty($d2[id])){

   $q=mysql_query("INSERT INTO raport_detail(id_raport,nis,timestmp,id_user,file,id_kelas) 
                         VALUES('$_SESSION[id_raport_k]','$without_extension',NOW(),'$_SESSION[namauser]','$filename','$_SESSION[kelas_k]')") or die("gagal".mysql_error());
		}
 }


$lastd=mysql_insert_id();
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