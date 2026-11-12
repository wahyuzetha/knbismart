<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";

$m2=mysql_query("select  * from pengaturan where id='1'");
$d2=mysql_fetch_array($m2);

if($d2[buka_nilai]==1 and $_SESSION[levelu]!='1'){
    header('Location: data_absen');
}
?>
<!DOCTYPE html>
<html>

<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>

</head>
<script type="text/javascript">
$(document).ready(function() {
	/*
 var pembelajaran =$(this).val();
    var dataString = 'pembelajaran=<?php echo"$_GET[pembelajaran]";?>';
    $.ajax({
      type: "POST",
      url: "get_data.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".ujian").html(html);
      } 
    });
  */
  
 
  $(".ct").hide();

  $(".tingkat").change(function() {
    var tingkat =$(this).val();
    var dataString = 'tingkat='+tingkat;
    $.ajax({
      type: "POST",
      url: "get_data_kelas.php",
      data: dataString,
      cache: false,
      success: function(html) {
          $(".ct").show();

        $("#tingkat").html(html);
 $(".tingkat").change(function() {
    var tingkat =$(this).val();
    var dataString = 'tingkat='+tingkat;
    $.ajax({
      type: "POST",
      url: "get_data_2.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $("#pemb").html(html);
        
      } 
    });
  });
      } 
    });
  });
  
});

</script>
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
        include"menu.php";
    ?>    
    

	<hr>
                            <h2>
                               Rekap Absensi Per-Hari <?php echo"$_SESSION[tahun_ajaran_pem] $_SESSION[semester_pem]";?>
                            </h2>
                         </div>
                        <div class="body">
                           <form action="cetak_laporan_absen_harian" method="GET" target="myiframe">
                            <div class="form-group form-float">
           <br>
            <div class="form-line">
            <select class="form-control show-tick tingkat" name="tingkat">
            <option value="">-- Pilih Tingkat --</option>
             
           
                <?php
             
             if(!empty($_SESSION[wali_kelas_k])){ 
            $mp=mysql_query("select * from tingkat where tingkat='$_SESSION[wali_tingkat]' order by tingkat asc");
            }
            else {
            $mp=mysql_query("select * from tingkat order by tingkat asc");    
            }
             
            while($dp=mysql_fetch_array($mp)){ 
            
		  ?>
          <option value="<?php echo"$dp[tingkat]";?>"><?php echo"$dp[tingkat]";?></option>
          <?php

              }  ?>    
              </select>
                                
            </div>
            </div>
            
            <div id="tingkat">
                
                
            </div>
	<div class="row ct">
			<div class="col-md-12">
		   <label >Tanggal</label>
<br>
           <input name="tanggal" type="date" class="form-control" value="<?php echo date('Y-m-d');?>">
			    <br>
         
		   <label>Pilih Status Kehadiran</label>
		    <div class="form-line">
            <select class="form-control show-tick" name="kehadiran">
            <option value="semua">Semua </option>
            <option value="hadir">Hadir </option>
            <option value="tidak">Tidak Hadir </option>
             
           
              
              </select>
                   </div>  
<br>
  <input name="jenis" type="radio" id="radio_1" checked="" value="normal">
		   <label for="radio_1"> &nbsp;&nbsp; NORMAL</label>
		    <input name="jenis" type="radio" id="radio_2" value="pdf">
		   <label for="radio_2"> &nbsp;&nbsp;PDF </label>
		    <input name="jenis" type="radio" id="radio_3" value="excel">
		   <label for="radio_3">&nbsp;&nbsp; EXCEL</label>
		   
		   
		  <br><br>				   
            </div>
		   </div>
		   
		  

             <input type="submit" class="btn btn-success" value="REKAP">  
                  <hr>			
                       </form>
					
	<iframe name="myiframe" src="cetak_laporan" width="100%" height="1000px" frameborder="0"></iframe>
                      
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