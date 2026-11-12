<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/hari.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['id_materi']);
$id_pembelajaran = anti_injection($_GET['id_pembelajaran']);
$pem=mysql_query("select * from pembelajaran where id='$id_pembelajaran'");
$dpem=mysql_fetch_array($pem);


$id_tugas = anti_injection($_GET['id_tugas']);
$id_ujian = anti_injection($_GET['id_ujian']);

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
  <script src="../../js/jquery-1.11.2.min.js"></script>
<script>
	$(document).ready(function() {

$('a').click(function() {
  $(this).attr('target', '_blank');
});
});
</script>

</head>

     <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
         <?php
            $no=0;
            $m=mysql_query("select  * from materi where id='$id'");   
            $d=mysql_fetch_array($m);
			
			$mt=mysql_query("select  * from tugas where id='$id_tugas'");   
            $dt=mysql_fetch_array($mt);
			
			
			$mj=mysql_query("select  * from ujian where id='$id_ujian'");   
            $dj=mysql_fetch_array($mj);
			
			$wm=mysql_query("select  * from asc_periods where starttime='$_GET[jam]'");   
            $dwm=mysql_fetch_array($wm);
			
             $dm=mysql_query("select  * from guru where nuptk='$d[nuptk]'");   
              $guru=mysql_fetch_array($dm);
			  
			  $chari=date('D', strtotime($tanggal));
				$hari_jadwal=hari_indo($chari);	

$qhr=mysql_query("SELECT * from asc_daysdefs where name='".mysql_real_escape_string($hari_jadwal)."'");	
$dhr=mysql_fetch_array($qhr);
 
		
	
			$cek=mysql_query("select * from log_akses_materi where id_user='$_SESSION[namauser]' and id_materi='$id' and tanggal='$tgl_skrgs'");
			
			
$dcek=mysql_fetch_array($cek);
?>
                         
                        <div class="body">
      
 
                 <?php 
				 
				 echo"<h5>Materi : </h5> <br> $d[isi]";
				 
				 
				


				
	
				 
				 ?>
                
          


              
  

           

            <!-- #END# Exportable Table -->
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