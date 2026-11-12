<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
$id_pembelajaran = anti_injection($_GET['id_pembelajaran']);
$tgl=date('Y-m-d');
$cek=mysql_query("select * from log_akses_materi where id_user='$_SESSION[namauser]' and id_materi='$id'");
$dcek=mysql_fetch_array($cek);
$png=mysql_query("select * from pengaturan");
$dpng=mysql_fetch_array($png);
if(!empty($dcek[id])){
$save=mysql_query("update log_akses_materi set ip='$ip',hit=hit+1,tanggal='$tgl',timestmp=NOW(),device='$_SERVER[HTTP_USER_AGENT]'
                where id_user='$_SESSION[namauser]' and id_materi='$id'") or die("gagal".mysql_error());
    
}
else {
$save=mysql_query("insert into log_akses_materi(ip,id_materi,id_user,hit,tanggal,timestmp,device,id_pembelajaran)
                    values('$ip','$id','$_SESSION[namauser]','1','$tgl',NOW(),'$_SERVER[HTTP_USER_AGENT]','$id_pembelajaran')") or die("gagal".mysql_error());
}
?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
<style>

    .map-responsive{
    overflow:hidden;
    height:0;
    border: none;
}
.map-responsive iframe{
    left:0;
    height:100%;
    width:100%;
    position:absolute;
    border: none;
}
</style>
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
         <?php
            $no=0;
          $m=mysql_query("select  * from materi where id='$id'");   
            $d=mysql_fetch_array($m);
                $dm=mysql_query("select  * from guru where nuptk='$d[nuptk]'");   
                $guru=mysql_fetch_array($dm);
            $no++;     
            ?>      
             
                        <div class="header">
                         <?php echo"<h4>$d[judul]</h4>";?>
    
                         </div>
                        <div class="body">
                            
                          
           
                 <?php echo"$d[isi]";?>
                
          


              
  
<?php
$ext = pathinfo($d[file], PATHINFO_EXTENSION);
$base_url=$dpng[base_url];
 if(!empty($d[file]) and $ext!=="pdf"){

	echo"<a href='../../file/$d[file]'> 
					<button class='btn btn-success waves-effect' type='button'
					data-toggle='modal' data-target='#defaultModaledit$i' style='background: linear-gradient(to right, #00bcd4, #673ab7);'>
					<i class='material-icons'>cloud_download</i> Download </button>
					</a>
					<iframe  name='myiframe' class='iframe' height='0px' width='0px' frameborder='0'></iframe>

					";
					?>
				<?php	}
					else  if(!empty($d[file]) and $ext=="pdf"){
						$actual_link = "$base_url/file/$d[file]&zoom=195#page=1";

?>
	<div class="map-responsive">
<iframe src="<?php echo"$base_url";?>/pdf_js/web/lihat.php?file=<?php echo"$actual_link";?>"  style="border: none;"></iframe>

 
</div>
<?php					}
	?>
                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           

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