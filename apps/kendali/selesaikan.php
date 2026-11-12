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
$id = anti_injection($_POST['d']);

$ujian=mysql_fetch_array(mysql_query("select * from ujian where id='$_POST[id_ujian]'"));
$soal=mysql_fetch_array(mysql_query("select * from hasil_jwb where nis='$_POST[nis]' and id_ujian='$_POST[id_ujian]'"));                           

		
$hasil=mysql_fetch_array(mysql_query("select count(point) as jum from hasil_opsi where nis='$_POST[nis]' and id_ujian='$_POST[id_ujian]' and point='0' and jenis=''"));
$hasil2=mysql_fetch_array(mysql_query("select sum(point) as jum from hasil_opsi where nis='$_POST[nis]' and id_ujian='$_POST[id_ujian]' and point='1' and jenis=''"));									 
						   
$salah=$hasil[jum];
$benar=$hasil2[jum];
$jml_soal=$soal[jml_soal];
$total_jwb=$salah + $benar;

if($total_jwb==$jml_soal){
$nilai_s=$benar/$jml_soal*$ujian[skala]; 
$benar_s=$benar;
$salah_s=$salah;
$kosong_s=0;


}
else if($total_jwb!=$jml_soal){
$benar_s=$benar;
$salah_s=$salah;
$kosong_s=$jml_soal-$salah-$benar;
$nilai_s=$benar/$jml_soal*$ujian[skala];
}



if($ujian[status_essay_auto]==1){
$hasilat=mysql_fetch_array(mysql_query("select count(point) as jum from hasil_opsi where nis='$_POST[nis]' and id_ujian='$_POST[id_ujian]' and point='0' and jenis='essay' "));
$hasil2at=mysql_fetch_array(mysql_query("select sum(point) as jum from hasil_opsi where nis='$_POST[nis]' and id_ujian='$_POST[id_ujian]' and point='1' and jenis='essay'"));									 
						   
$salahat=$hasilat[jum];
$benarat=$hasil2at[jum];
$jml_soalat=$soal[jml_soal_essay];
$total_jwbat=$salahat + $benarat;

if($total_jwbat==$jml_soalat){
$nilai_sat=$benarat/$jml_soalat*$ujian[bobot_essay_auto];
$benar_sat=$benarat;
$salah_sat=$salahat;
$kosong_sat=0;


}
else if($total_jwbat!=$jml_soalat){
$benar_sat=$benarat;
$salah_sat=$salahat;
$kosong_sat=$jml_soalat-$salahat-$benarat;
$nilai_sat=$benarat/$jml_soalat*$ujian[bobot_essay_auto];
}

}



$upd=mysql_query("update hasil_jwb set benar='$benar_s',salah='$salah_s',kosong='$kosong_s',nilai='$nilai_s',status='3',benar_essay_auto='$benar_sat',salah_essay_auto='$salah_sat',kosong_essay_auto='$kosong_sat',nilai_essay_auto='$nilai_sat'
                 where nis='$_POST[nis]' and id_ujian='$_POST[id_ujian]'") or die("gagal save 2".mysql_error());    




//$q=mysql_query("update hasil_jwb set status='3',timestmp=NOW() WHERE nis='$_POST[nis]' and id_ujian='$_POST[id_ujian]'") ; 

 if($upd) {
 	?>
	<script type="text/javascript">
swal({
  title: "Data Berhasil Di Selesaiakn",
  icon: "success",
  showCancelButton: false,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "OK"
},
function(isConfirm) {
  if (isConfirm) {
window.location = "peserta?d=<?php echo"$_POST[id_ujian]";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>