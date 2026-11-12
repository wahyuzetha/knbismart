<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";

$m2=mysql_query("select  * from pengaturan where id='1'");
$d2=mysql_fetch_array($m2);

if($d2[buka_nilai]==1 and $_SESSION[levelu]!='1'){
    header('Location: data_absen');
}

$_SESSION[wali_kelas_k]=$_GET[wali]
?>
<!DOCTYPE html>
<html>

<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>



<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Kelas yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".select2 option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
 </script>
</head>
<script type="text/javascript">
$(document).ready(function() {
    <?php
    
    if(!empty($_SESSION[wali_kelas_k])){?>
 var dataString = 'tingkat=<?php echo"$_SESSION[wali_kelas_k]";?>';
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
  
 <?php } ?>
  
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
                               Laporan Analisis Hasil Ujian  <?php echo"$_SESSION[tahun_ajaran_pem] $_SESSION[semester_pem]";?>
                            </h2>
                         </div>
                        <div class="body">
                           <form action="cetak_laporan_analisis" method="GET" target="myiframe">
                            <div class="form-group form-float">
           <br>
            <div class="form-line">
            <select class="form-control show-tick tingkat select2" name="kelas" style="width:100%">
            <?php
             if($_SESSION[levelu]==3){  
             
             }
             else{
            ?><option value="">-- Pilih Kelas --</option>
             
            <?php }
             ?>
                <?php
              if($_SESSION[levelu]==3){    
            $mp=mysql_query("select * from siswa where nis='$_SESSION[id_pengguna]'");
              }
              else if($_SESSION[levelu]==2 and !empty($_SESSION[wali_kelas_k])){    
            $mp=mysql_query("select * from kelas where nama_kelas='$_SESSION[wali_kelas_k]' and tahun_ajaran='$_SESSION[tahun_ajaran_pem]'");
              }
              else {
            $mp=mysql_query("select * from kelas where tahun_ajaran='$_SESSION[tahun_ajaran_pem]' order by nama_kelas asc");
              }
            while($dp=mysql_fetch_array($mp)){ 
            
            if($_SESSION[levelu]==3){   
            ?>      
          <option value="<?php echo"$dp[nis]";?>"><?php echo"$dp[nama]";?></option>
          <?php } else { 
		  			if($_GET[kelas]==$dp[nama_kelas]){
							$pilk="selected";
					}
					else {
						$pilk="";
					}

		  ?>
          <option value="<?php echo"$dp[nama_kelas]";?>" <?php echo"$pilk";?>><?php echo"$dp[nama_kelas]";?></option>
          <?php

              } } ?>    
              </select>
                                
            </div>
            </div>
            
            <div id="tingkat"></div>
            
            <div class="ujian"></div>
			
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
<?php include"../../inc/footernojs.php";?></body>

</html>