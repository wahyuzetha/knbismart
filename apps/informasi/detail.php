<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
$m=mysql_query("select  * from berita where id='$id'");
$d=mysql_fetch_array($m);

$minfo=mysql_query("select  * from users where id_pengguna='$d[id_user]'");
$dinfo=mysql_fetch_array($minfo);

if($dinfo[level]==1){
    $publikasi="Administrator";
}
else {
   $mg=mysql_query("select  * from guru where nik='$dinfo[id_pengguna]'");
   $dg=mysql_fetch_array($mg);
       $publikasi=$dg[nama];

 
}
?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>

</head>
<script src='../../plugins/tinymce/tinymce.min.js'></script>


 

<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include"../../inc/sidebar.php";?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    
    <section class="content">
     <div class="container-fluid">
           <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                      
                        <div class="header">
                            <h2>            <?php echo"$d[judul]";?>
 </h2>
                           <?php  
                           
                           $tgl=date('d/m/Y H:i:s', strtotime($d[timestmp]));

                           if(!empty($publikasi)){echo"<hr> Di Publikasikan oleh $publikasi "; } echo"$tgl";?>
                        </div>
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
    
          <div class="body">
         
            <?php
		   if(!empty($d[foto])){
		   echo"<img src='../../images/$d[foto]' height='100px'>";
		   }
		   
		   echo"<br><br>$d[isi] <br>";
		  
		   if(!empty($d[jfile])){
		   echo"<a href='../../file/$d[jfile]' download>Download File</a>";
		   }
		   ?>
           
		  
		    


        </div>   

<br><br><br><br><br>
    </section>

<script>
 
 
  
 window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
//# sourceURL=pen.js
</script>
 
   <?php include"../../inc/footerm.php";?></body>


</body>