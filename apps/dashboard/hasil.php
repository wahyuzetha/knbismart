<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

$ujian=mysql_fetch_array(mysql_query("select * from ujian where id='$_SESSION[id_ujian]'"));


?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
     </head>

<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include"../../inc/sidebar.php";?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    
    <section class="content">
     <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
              
                        <div class="header">
                             <h4><?php echo"Berhasil";?></h4>
       
                            <?php
    if($_GET[h]=="sukses"){ ?>    
    <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong> Data Berhasil Di Simpan</div>
    <?php } 
    else  if($_GET[h]=="suksesh"){ ?>   
     <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong> Data Berhasil Di Hapus</div>
    <?php
        }
        else {
        echo"";
        }
    ?>    
    
                         </div>
                        <div class="body">
        <?php
$soal=mysql_fetch_array(mysql_query("select * from hasil_jwb where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]'"));                           

		
$hasil=mysql_fetch_array(mysql_query("select count(point) as jum from hasil_opsi where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' and point='0' and jenis=''"));
$hasil2=mysql_fetch_array(mysql_query("select sum(point) as jum from hasil_opsi where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' and point='1' and jenis=''"));									 
						   
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
$hasilat=mysql_fetch_array(mysql_query("select count(point) as jum from hasil_opsi where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' and point='0' and jenis='essay' "));
$hasil2at=mysql_fetch_array(mysql_query("select sum(point) as jum from hasil_opsi where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' and point='1' and jenis='essay'"));									 
						   
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

if($ujian[bobot_multiple]>0){
$hasil2at=mysql_fetch_array(mysql_query("select sum(point) as jum from hasil_opsi where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' and point>'0' and jenis='multi'"));									 
						   
$benar_multi=$hasil2at[jum];
$jml_soalat=$soal[jml_soal_multi];

$nilai_multiple=$benar_multi/$jml_soalat*$ujian[bobot_multiple];


}


if($ujian[bobot_matching]>0){
$hasil2at=mysql_fetch_array(mysql_query("select sum(point) as jum from hasil_opsi where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' and point>'0' and jenis='match'"));									 
						   
$benar_match=$hasil2at[jum];
$jml_soalat=$soal[jml_soal_match];

$nilai_match=$benar_match/$jml_soalat*$ujian[bobot_matching];
//echo"$benar_match/$jml_soalat*$ujian[bobot_matching]";

}

 

$upd=mysql_query("update hasil_jwb set benar='$benar_s',salah='$salah_s',kosong='$kosong_s',nilai='$nilai_s',status='3',benar_essay_auto='$benar_sat',salah_essay_auto='$salah_sat',kosong_essay_auto='$kosong_sat',
nilai_essay_auto='$nilai_sat',nilai_multi='$nilai_multiple',nilai_match='$nilai_match',benar_multi='$benar_multi',benar_match='$benar_match'
                 where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]'") or die("gagal save 2".mysql_error());    




echo "<h4> Selamat $name anda Berhasil Menyelesaikan $ujian[nama_ujian]</h4>";
 
 
 
?>


<hr><a href="../../apps/dashboard/data_siswa"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
			</div>
		</div>
        </div>   
    </section>

<script >window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);
//# sourceURL=pen.js
</script>
<?php include"../../inc/footerm.php";?></body>

</html>