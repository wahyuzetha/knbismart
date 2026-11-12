
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
$soal = mysql_real_escape_string($_POST['soal']);
$opsia = mysql_real_escape_string($_POST['opsia']);
$opsib = mysql_real_escape_string($_POST['opsib']);
$opsic = mysql_real_escape_string($_POST['opsic']);
$opsid = mysql_real_escape_string($_POST['opsid']);
$opsie = mysql_real_escape_string($_POST['opsie']);
$kunci = $_POST['kunci'];
$point=$_POST['point'];
$timer=$_POST['timer'];
$m3=mysql_query("select  * from bank_soal where id_ujian='$id'");
$d3=mysql_num_rows($m3);


$wajib_jawab=$_POST['wajib_jawab'];

$kn_ar=array();
foreach($kunci as $kuncis){
   $kn_ar[]=$kuncis; 
}
$kunci_s=implode(",",$kn_ar);
$no_soal=$d3+1;
$q2=mysql_query("INSERT INTO bank_soal(id_ujian,soal,kunci,point,pila,pilb,pilc,pild,pile,no_soal,timer,jenis,wajib_jawab,tampilkan_soal) 
VALUES('$id','$soal','$kunci_s','$point','$opsia','$opsib','$opsic','$opsid','$opsie','$no_soal','$timer','$_SESSION[jenis_soal_k]','$wajib_jawab','1')") or die("gagal".mysql_error());
$id_soal=mysql_insert_id();



 if($q2) {
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
window.location = "add?d=<?php echo"$id";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>