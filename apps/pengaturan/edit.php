﻿<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_POST['d']);
$m2=mysql_query("select  * from pengaturan where id='1'");
$d2=mysql_fetch_array($m2);

?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>

<script src="../../js/jquery-1.11.2.min.js"></script>
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>



<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Jurusan yang ingin anda cari',
         
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
                            <h2>Pengaturan</h2>
                            
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
          <form id="form_validation" method="POST" action="saveedit" enctype="multipart/form-data">
              
  <input type="hidden" class="form-control" name="id" required="" aria-required="true" value="<?php echo"$d2[id]";?>">
            <!--
            <div class="form-group form-float">
			             <label class="form-label">Auto Rilis Token (dalam second)</label>

            <div class="form-line ">
             <input type="number" class="form-control" name="waktu_rilis_token" required="" aria-required="true" value="<?php echo"$d2[waktu_rilis_token]";?>">
            </div>
            </div>
			-->
			
			<div class="form-group form-float">
			             <label class="form-label">Jumlah Blok Ujian apabila siswa keluar</label>

            <div class="form-line ">
             <input type="number" class="form-control" name="blok" required="" aria-required="true" value="<?php echo"$d2[blok]";?>">
            </div>
            </div>
            <!--
            <div class="form-group form-float">
			             <label class="form-label">Waktu Minimal Sebelum Keluar Ujian (dalam second)</label>

            <div class="form-line ">
             <input type="number" class="form-control" name="minimal_keluar_ujian" required="" aria-required="true" value="<?php echo"$d2[minimal_keluar_ujian]";?>">
            </div>
            </div>
            -->
             <div class="form-group form-float">
			             <label class="form-label">Jumlah Maksimal Upload Tugas File Siswa</label>

            <div class="form-line ">
             <input type="number" class="form-control" name="maksimal_upload_tugas_file" required="" aria-required="true" value="<?php echo"$d2[maksimal_upload_tugas_file]";?>">
            </div>
            </div>
			
			 <div class="form-group form-float">
			<label class="form-label">messagingSenderId</label>

            <div class="form-line ">
             <input type="text" class="form-control" name="messagingSenderId"  value="<?php echo"$d2[messagingSenderId]";?>">
            </div>
            </div>
			
			
			 <div class="form-group form-float">
			<label class="form-label">apiKey</label>

            <div class="form-line ">
             <input type="text" class="form-control" name="apiKey"  value="<?php echo"$d2[apiKey]";?>">
            </div>
            </div>
			
			
			 <div class="form-group form-float">
			<label class="form-label">projectId</label>

            <div class="form-line ">
             <input type="text" class="form-control" name="projectId"  value="<?php echo"$d2[projectId]";?>">
            </div>
            </div>
			
			
			 <div class="form-group form-float">
			<label class="form-label">appId</label>

            <div class="form-line ">
             <input type="text" class="form-control" name="appId"  value="<?php echo"$d2[appId]";?>">
            </div>
            </div>
			
			
			
			 <div class="form-group form-float">
			<label class="form-label">API NOTIF CLOUD MESSAGING</label>

            <div class="form-line ">
             <input type="text" class="form-control" name="apicloud"  value="<?php echo"$d2[apicloud]";?>">
            </div>
            </div>
			
			<div class="form-group form-float">
			<label class="form-label">Tampilkan Opsi E</label>
            <div class="form-line ">
             <input type="text" class="form-control" name="split_import" required="" aria-required="true" value="<?php echo"$d2[split_import]";?>">
             
            </div>
            </div>
            
           <!--
			 <div class="form-group form-float">
            <label class="form-label">Server ini hanya untuk Tingkat?</label>
            <br>
            <select class="form-control show-tick provinsi select2" name="tingkat[]" id="provinsi" multiple>
             
			 <?php
			 			  $someArray = json_decode($d2[tingkat], true);

            $mpj=mysql_query("select * from tingkat");
            while($dpj=mysql_fetch_array($mpj)){ 
			               $lokasi_ar=array();
			foreach($someArray as $tingkat) { 
			if($dpj[tingkat]==$tingkat){
			$lokasi_ar[]="selected";

			}
			else {
			$lokasi_ar[]="";
			
			}
			}
			               $pilj=implode("",$lokasi_ar);

            ?>      
          <option value="<?php echo"$dpj[tingkat]";?>" <?php echo"$pilj";?>><?php echo"$dpj[tingkat]";?></option>

			<?php } ?>    
              </select>
                               
            </div>--> 
            <br>
<input type="checkbox" id="basic_checkbox_2" class="filled-in" name="blok_k" value='4' <?php if($d2[buka_nilai]==4){ echo"checked"; } else { } ?>>
         <label for="basic_checkbox_2">Blok Akses Live User Online, Hal ini untuk mengurangi beban server pada saat ujian</label>
         <br><br>
            
            <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
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