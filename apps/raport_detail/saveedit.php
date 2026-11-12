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
else {
    $jfile=$_POST[file_lama];
}

    $q=mysql_query("update detail_perangkat set nama_perangkat='$nama_perangkat',
                    file='$jfile',id_user='$_SESSION[namauser]' where id='$id'") or die("gagal".mysql_error());

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
window.location = "edit?d=<?php echo"$id&id_pembelajaran=$id_pembelajaran";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>