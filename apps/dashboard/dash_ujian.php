<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";


             
$_SESSION[jenis_n]=$_GET[jenis];

if($_SESSION[jenis_n]=="p"){
$_SESSION[namajenisn]="PENGAYAAN";
}
else {
$_SESSION[namajenisn]="UJIAN";
}              


                
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
        <h3>Daftar <?php echo"$_SESSION[namajenisn]";?></h3>
        <form action="dash_ujian" method="get">
            <input type="search" name="cari" class="form-control" placeholder="Ketik nama mapel di sini..">
            <input type="hidden" name="jenis" class="form-control" value="<?php echo"$_GET[jenis]";?>">

        </form>
        <hr>
        
      <div class="row clearfix">
          <?php
          if(!empty($_GET[cari])){
              $cr="and pembelajaran like '%$_GET[cari]%'";
          }
          else {
              $cr="";
          }
          $m=mysql_query("select  * from pembelajaran where 1 and pembelajaran.tahun_ajaran='$tahun_aktif' and pembelajaran.semester='$semester_aktif'    
 and pembelajaran.tingkat='$tingkat_kelas_all' and (pembelajaran.kelas='null' or pembelajaran.kelas=''
 or pembelajaran.kelas like '%$jurusan_kelas_all%') and pembelajaran.manual is null $cr");   
        
            while($d=mysql_fetch_array($m)){
                $dm=mysql_query("select  * from guru where nik='$d[nuptk]'");   
                $guru=mysql_fetch_array($dm);
       
          ?>
                <a href="ujian?d=<?php echo"$d[id]";?>">
                <div class="col-xs-12 col-md-6">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">content_paste</i>
                        </div>
                        <div class="content">
                            <div class="text"><?php echo"$d[pembelajaran] <br> $guru[nama]";?></div>
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