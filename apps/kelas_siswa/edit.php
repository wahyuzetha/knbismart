<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m2=mysql_query("select  * from kelas_siswa where id='$id'");
$d2=mysql_fetch_array($m2);

$m=mysql_query("SELECT guru.nama,kelas.* from kelas
LEFT JOIN guru on kelas.wali=guru.nuptk where kelas.tahun_ajaran='$tahun_aktif' and kelas.nama_kelas='$_SESSION[kelas_c]'");   
$d=mysql_fetch_array($m);

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>

<script src="../../js/jquery-1.11.2.min.js"></script>
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>



<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Siswa yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".select2 option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
 
</script>
</head>
<script type="text/javascript">
$(document).ready(function() {
  $(".provinsi").change(function() {
    var provinsi =$(this).val();
    var dataString = 'provinsi='+provinsi;
    $.ajax({
      type: "POST",
      url: "../delinasi/getkabupaten.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".kabupaten").html(html);
      } 
    });
  });
});

</script>
<style>
    .dragArea {
			background-color: #efefef;
			border: 3px dashed #cccccc;
			border-radius: 10px;
			text-align: center;
		
		}

		.dragArea.over {
			border-color: #ff0000;
			background-color: #FFE9EA;
		}

		.resultImageWrapper {
			display: none;
			
			text-align: center;
		}

		#resultImage {
			box-shadow: rgba(0,0,0,0.4) 0 40px 50px;
		}
    .select-wrapper {
  background: url(images/camera.png) no-repeat;
  background-size: cover;
  display: block;
  position: relative;
  width: 80px;
  height: 71px;
  margin: auto;
}
#imageFile {
  width: 80px;
  height: 61px;
  margin-right: 100px;
  opacity: 0;
  filter: alpha(opacity=0); /* IE 5-7 */
}

.dragArea2 {
			background-color: #efefef;
			border: 3px dashed #cccccc;
			border-radius: 10px;
			text-align: center;
		
		}

		.dragArea2.over {
			border-color: #ff0000;
			background-color: #FFE9EA;
		}

		.resultImageWrapper2 {
			display: none;
			
			text-align: center;
		}

		#resultImage2 {
			box-shadow: rgba(0,0,0,0.4) 0 40px 50px;
		}
    .select-wrapper2 {
  background: url(images/camera.png) no-repeat;
  background-size: cover;
  display: block;
  position: relative;
  width: 80px;
  height: 71px;
  margin: auto;
}
#imageFile2 {
  width: 80px;
  height: 61px;
  margin-right: 100px;
  opacity: 0;
  filter: alpha(opacity=0); /* IE 5-7 */
}
     .bfoto {
         margin-top: 0px;
     }
     .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
  	text-align: center;
  	 background: url(../../images/camera.png) no-repeat;
  background-size: cover;
  display: block;
  position: relative;
  width: 80px;
  height: 71px;
  margin: auto;
}

.btn {
  
  
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
top: 25px;
opacity: 0;
}
</style>
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

                        </div>
                 <?php
    if($_GET[h]=="sukses"){ ?>    
    <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong> Data Berhasil Di Simpan</div>
    <?php } 
    else  if($_GET[h]=="gagal"){ ?>   
     <div class="alert alert-danger" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Gagal! </strong> <?php echo"$_GET[pesan]";?></div>
    <?php
        }
        else {
        echo"";
        }
    ?>    
          <div class="body">
          <form id="form_validation" method="POST" action="saveedit" enctype="multipart/form-data">


          <div class="header">
                            <h2>Ubah Data Siswa Kelas <?php echo"$d[nama_kelas] $tahun_aktif";?></h2>
                            
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
          <form id="form_validation" method="POST" action="saveedit">
    
                    <input type="hidden" name="d" value="<?php echo"$id";?>">
            <div class="form-group form-float">
            <label class="form-label"> Data Siswa</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick select2" name="siswa" id="siswa" style="width:100%">
            <option value="">-- Pilih Siswa --</option>
            <?php
            $mp=mysql_query("select * from siswa");
            while($dp=mysql_fetch_array($mp)){ 
            if($d2[nis]==$dp[nis]) {
                $pil="selected";
            }   
            else {
                $pil="";
            }
            ?>      
          <option value="<?php echo"$dp[nis]";?>" <?php echo"$pil";?>><?php echo"$dp[nama]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>


         
         
            
            <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
            <a href="data"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
   


 <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="../../plugins/jquery-countto/jquery.countTo.js"></script>

    <script src="../../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../../js/pages/tables/jquery-datatable.js"></script>

  <script src="../../plugins/sweetalert/sweetalert.min.js"></script>
 <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="../../plugins/bootstrap-notify/bootstrap-notify.js"></script>
  
    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/ui/dialogs.js"></script>
   
    
</html>