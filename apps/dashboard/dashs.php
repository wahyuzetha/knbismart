<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";


             


                
?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
date_default_timezone_set("Asia/Jakarta");

          $waktu_ini=date('Y-m-d');
          $jam=date('H:i:s');
		  
		  
          $m=mysql_query("SELECT pembelajaran.jurusan,pembelajaran.tingkat,pembelajaran.id,pembelajaran.pembelajaran,ujian.nama_ujian,ujian.waktu_mulai,ujian.waktu_selesai,ujian.jam_mulai,ujian.jam_selesai from ujian,pembelajaran
WHERE ujian.id_pembelajaran=pembelajaran.id and 
 ((ujian.waktu_mulai >= '$waktu_ini' AND ujian.waktu_selesai <= '$waktu_ini') 
 OR (ujian.waktu_mulai <= '$waktu_ini' AND ujian.waktu_selesai >= '$waktu_ini'))
 and waktu_mulai!='0000-00-00' and waktu_selesai!='0000-00-00' 
 and pembelajaran.tingkat='$tingkat_kelas_all' and (pembelajaran.kelas='null' or pembelajaran.kelas='' or pembelajaran.kelas like '%$jurusan_kelas_all%') and 
 ((ujian.jam_mulai >= '$jam' AND ujian.jam_selesai <= '$jam') 
 OR (ujian.jam_mulai <= '$jam' AND ujian.jam_selesai >= '$jam')) ");   
            while($d=mysql_fetch_array($m)){
                $dm=mysql_query("select  * from guru where nuptk='$d[nuptk]'");   
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
				else {
				$jurusan="Semua Jurusan";
				}
       
          ?>
                <a href="ujian?d=<?php echo"$d[id]";?>">
                <div class="col-xs-12 col-md-6">
                    <div class="info-box bg-green hover-expand-effect">
                       
                        <div class="content">
                            <div class="text"><?php echo"$d[pembelajaran]	
	
";?></div>
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