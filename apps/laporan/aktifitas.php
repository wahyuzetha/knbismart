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
  
 
  
  $(".tingkat").change(function() {
    var tingkat =$(this).val();
    var dataString = 'tingkat='+tingkat;
    $.ajax({
      type: "POST",
      url: "get_data_2.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $("#tingkat").html(html);
		$(".pembelajaran").change(function() {
    var pembelajaran =$(this).val();
    var dataString = 'pembelajaran='+pembelajaran;
    $.ajax({
      type: "POST",
      url: "get_data.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".ujian").html(html);
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
                               Laporan Aktifitas Guru
                            </h2>
                         </div>
                        <div class="body">
                           <form action="cetak_laporan_aktifitas" method="GET" target="myiframe">
            <label class="form-label">Guru</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick provinsi" name="nuptk" id="provinsi">
            <?php
            if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1){
            ?>    
            <option value="">-- Pilih Semua Guru --</option>
            <?php
            $mp=mysql_query("select * from guru");
             }
            else if($_SESSION[levelu]==2){
             $mp=mysql_query("select * from guru where nik='$_SESSION[id_pengguna]'");
            }
            while($dp=mysql_fetch_array($mp)){ 
            ?>      
          <option value="<?php echo"$dp[nik]";?>"><?php echo"$dp[nama]";?></option>

              <?php } ?>    
              </select>
                      <br>
        	<div class="row">
			<div class="col-md-4 col-xs-6">
			<label>Tanggal Awal</label>   

			<input type="date" class="form-control" name="tgl_awal" value="<?php echo date('Y-m-d');?>">
			</div> 
			<div class="col-md-4 col-xs-6">
			         	<label>Tanggal Akhir</label>   
			<input type="date" class="form-control" name="tgl_akhir" value="<?php echo date('Y-m-d');?>">
			</div> 
			  </div>     
			
			<div class="row">
			<div class="col-md-12">
           <input name="tampilan" type="radio" id="radio_1r" checked="" value="group">
		   <label for="radio_1r"> &nbsp;&nbsp; Tampilan Group</label>
		    <input name="tampilan" type="radio" id="radio_2r" value="per">
		   <label for="radio_2r"> &nbsp;&nbsp; Tampilan Per Guru </label>
		   
		   </div>
		   </div>
		   
			<div class="row">
			<div class="col-md-12">
           <input name="jenis" type="radio" id="radio_1" value="normal">
		   <label for="radio_1"> &nbsp;&nbsp; NORMAL</label>
		    <input name="jenis" type="radio" id="radio_2" checked=""  value="pdf">
		   <label for="radio_2"> &nbsp;&nbsp;PDF </label>
		    <input name="jenis" type="radio" id="radio_3" value="excel">
		   <label for="radio_3">&nbsp;&nbsp; EXCEL</label>
		   </div>
		   </div>
             <input type="submit" class="btn btn-success" value="REKAP">  
              
			
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