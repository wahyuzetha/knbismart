<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";


             


                
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
        <h3>Ujian Aktif</h3>
        <hr>
        
      <div class="row clearfix">
          <?php
          
          $waktu_ini=date('Y-m-d');
          
          
          $m=mysql_query("SELECT pembelajaran.tingkat,pembelajaran.jurusan,pembelajaran.id,pembelajaran.pembelajaran,ujian.nama_ujian,ujian.waktu_mulai,ujian.waktu_selesai from ujian,pembelajaran
WHERE ujian.id_pembelajaran=pembelajaran.id");   
        
            while($d=mysql_fetch_array($m)){
                $dm=mysql_query("select  * from guru where nik='$d[nuptk]'");   
                $guru=mysql_fetch_array($dm);
				
       $someArray = json_decode($d[jurusan], true);

  $lokasi_ar=array();
			foreach($someArray as $jurusanku) { 
			
			$lokasi_ar[]=$jurusanku;
			
			
			}
			     $pilj=implode(",",$lokasi_ar);
				if(!empty($pilj)){
					$jurusan=$pilj;
				}
				else if(empty($d[jurusan]) or $d[jurusan]=="null") {
				$jurusan="Semua Jurusan";
				}
          ?>
                <a href="ujian?d=<?php echo"$d[id]";?>">
                <div class="col-xs-12 col-md-6">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">content_paste</i>
                        </div>
                        <div class="content">
                            <div class="text"><?php echo"$d[pembelajaran] <br> Tingkat $d[tingkat]	<br> $jurusan";?></div>
                            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                </a>
              <?php } ?>
                        </div>
            
            <!-- #END# Widgets -->
            
           
  </section>
   
<?php include"../../inc/footerm.php";?>

</body>

</html>