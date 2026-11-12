<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$id = anti_injection($_GET['d']);

   $m=mysql_query("select  * from pembelajaran where id='$id'");   
      $d=mysql_fetch_array($m);
       
             
         
                
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
        <h3></h3>
        <hr>
        
      <div class="row clearfix">
         
                <a href="materi?d=<?php echo"$d[id]";?>">
                <div class="col-xs-12 col-md-3">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">content_paste</i>
                        </div>
                        <div class="content">
                            <div class="text">Materi <?php echo"$d[pembelajaran]";?></div>
                            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                </a>
               
                <a href="ujian?d=<?php echo"$d[id]";?>">
                <div class="col-xs-12 col-md-6">
                    <div class="info-box bg-blue hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <div class="content">
                            <div class="text">Ujian <?php echo"$d[pembelajaran]";?></div>
                            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                </a>
             

            <!-- #END# Widgets -->
            
           
  </section>
   
<?php include"../../inc/footerm.php";?>

</body>

</html>