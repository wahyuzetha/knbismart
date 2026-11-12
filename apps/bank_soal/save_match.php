
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
$opsi_penjodohan = $_POST['opsi_penjodohan'];

$soal_kunci = $_POST['soal_kunci'];
$opsi_penjodohan = str_replace('<ol>', '', $opsi_penjodohan);
$opsi_penjodohan = str_replace('</ol>', '', $opsi_penjodohan);
$opsi_penjodohan =explode("<li>",$opsi_penjodohan);

$point=$_POST['point'];

$opsi_ar=array();
$i=0;
foreach($opsi_penjodohan as $opsi_penjodohans){
$opsi_penjodohans = str_replace('</li>', '', $opsi_penjodohans);
$i++;
$jml=strlen($opsi_penjodohans);
if($i>1){
$opsi_ar[]=$opsi_penjodohans;
//echo"$i. $jml $opsi_penjodohans ";
}
    



    
}

$opsi_ars=implode("||",$opsi_ar);

//echo" $opsi_ars";

$q2=mysql_query("INSERT INTO bank_soal(id_ujian,soal,kunci,no_soal,jenis,ket_opsi_matching,point,wajib_jawab,tampilkan_soal) 
VALUES('$id','Jodohkanlah pernyataan-pernyataan berikut ini!','','','match','$opsi_ars','$_POST[point]','1','1')") or die("gagal".mysql_error());

$id_soal=mysql_insert_id();


$soal_kunci =explode("<li>",$soal_kunci);

$soal_kunci_ar=array();
foreach($soal_kunci as $soal_kuncis){
    $ex=explode("===",$soal_kuncis);
    $soal=$ex[0];
    $kunci_p=(int)$ex[1];

//echo"$soal $kunci_p";

if(!empty($kunci_p)){
  $q2=mysql_query("INSERT INTO bank_opsi(id_ujian,id_soal,deskripsi,kunci) 
VALUES('$id','$id_soal','$soal','$kunci_p')") or die("gagal".mysql_error());
}
    
}






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
window.location = "edit_match?d=<?php echo"$id_soal&id_ujian=$id";?>";
  }
});
</script>

<?php 
} 

?>
</body>
</html>