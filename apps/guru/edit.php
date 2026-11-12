<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
if($_SESSION[levelu]==1){
$m2=mysql_query("select  * from guru where nik='$id'");
$d2=mysql_fetch_array($m2);
}
else if($_SESSION[levelu]==2){
$m2=mysql_query("select  * from guru where nik='$_SESSION[namauser]'");
$d2=mysql_fetch_array($m2);
}

$m3=mysql_query("select  * from users where id_pengguna='$d2[nik]'");
$d3=mysql_fetch_array($m3);

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>
<script>
	//  for drag and drop file access

	$(function(){
		var dropTimer;
		var fileInput = $('#imageFile');

		handleDrop = function(files){

			var file = files[0]; // Multiple files can be dropped. Lets only deal with the "first" one.

			if (file.type.match('image.*')) {
				resizeImage(file, 200, function(result) {
					$('#resultImage').attr('src', result);
                   document.getElementById("myText").value = result;
                   
					$('.resultImageWrapper').show();
				});
			} else {
				alert("That file wasn't an image.");
			}
		};

	

		fileInput.on('change', function(event) {
			handleDrop(event.target.files);
		});

		resizeImage = function(file, size, callback) {
			var fileTracker = new FileReader;
			fileTracker.onload = function() {
				var image = new Image();
				image.onload = function(){
					var canvas = document.createElement("canvas");
				
					if(image.height > size) {
						image.width *= size / image.height;
						image.height = size;
					}
					
					else if(image.width > size) {
						image.height *= size / image.width;
						image.width = size;
					}
					var ctx = canvas.getContext("2d");
                    
					ctx.clearRect(0, 0, canvas.width, canvas.height);
					canvas.width = image.width;
					canvas.height = image.height;
					ctx.drawImage(image, 0, 0, image.width, image.height);
					callback(canvas.toDataURL("image/png"));
				};
				image.src = this.result;
			}

			fileTracker.readAsDataURL(file);

			fileTracker.onabort = function() {
				alert("The upload was aborted.");
			}

			fileTracker.onerror = function() {
				alert("An error occured while reading the file.");
			}
		};
	});
</script>

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
           <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                      
                        <div class="header">
                            <h2>Edit Data</h2>
                            
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


         
            <div class="form-group form-float">
            <div class="form-line ">
             <input type="text" class="form-control" name="nuptk" required="" aria-required="true" value="<?php echo"$d2[nik]";?>">
              <input type="hidden" class="form-control" name="nuptk_lama" required="" aria-required="true" value="<?php echo"$d2[nik]";?>">
              <input type="hidden" class="form-control" name="foto_lama" required="" aria-required="true" value="<?php echo"$d2[foto]";?>">

             <label class="form-label">NIK</label>
            </div>
            </div>
            
            
            <div class="form-group form-float">
            <div class="form-line ">
             <input type="text" class="form-control" name="nama" required="" aria-required="true" value="<?php echo"$d2[nama]";?>">
             <label class="form-label">Nama</label>
            </div>
            </div>


              <div class="form-group form-float">
            <label class="form-label">Jabatan</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick jabatan" name="jabatan" id="jabatan" <?php if($_SESSION[levelu]!=1){ echo"disabled";}?>>
            <option value="">-- Pilih Jabatan --</option>
            <?php
            $mp=mysql_query("select * from jabatan");
            while($dp=mysql_fetch_array($mp)){ 
                if($dp[id]==$d2[id_jabatan]){
                    $pil="selected";
                }
                else {
                    $pil="";
                }
            ?>      
          <option value="<?php echo"$dp[id]";?>" <?php echo"$pil";?>><?php echo"$dp[jenis_jab]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
            
             
             <div class="form-group form-float">
            <div class="form-line ">
             <input type="text" class="form-control" name="username" required="" aria-required="true" value="<?php echo"$d3[username]";?>">
             <label class="form-label">Username</label>
            </div>
            </div>
            

 <div class="form-group form-float">
      <label class="form-label">Password (Kosongi apabila tidak di ubah)</label>
            <div class="form-line ">
             <input type="password" class="form-control" name="password"  value="">
            
            </div>
            </div>
            <label>Hak Akses Penyelenggara Ujian</label><br>
			
			<?php 
			
			if($_SESSION[levelu]==1){
				
			
						  $someArray = json_decode($d2[penyelenggara_ujian], true);

			$m2p=mysql_query("SELECT * from penyelenggara_ujian");
			while($d2p=mysql_fetch_array($m2p)){
						               $lokasi_ar=array();

			
			foreach($someArray as $jurusanku) { 
			if($d2p[id]==$jurusanku){
			$lokasi_ar[]="checked";

			}
			else {
			$lokasi_ar[]="";
			
			}
			}
			               $pilj=implode("",$lokasi_ar);
			
			
			?>
			<input type="checkbox" id="basic_checkbox_2<?php echo"$d2p[id]";?>" class="filled-in" 
			name="penyelenggara_ujian[]" value='<?php echo"$d2p[id]";?>' <?php echo"$pilj";?>>
            <label for="basic_checkbox_2<?php echo"$d2p[id]";?>"><?php echo"$d2p[penyelenggara] 
			";?></label>
         <br>
			<?php } } else {
				
				 $someArray = json_decode($d2[penyelenggara_ujian], true);
   $t=0;
			$m2p=mysql_query("SELECT * from penyelenggara_ujian");
			while($d2p=mysql_fetch_array($m2p)){
						               $lokasi_ar=array();

			$t++;
			foreach($someArray as $jurusanku) { 
			if($d2p[id]==$jurusanku){
			echo"<b>$t. $d2p[penyelenggara]</b> <br>";

			}
			else {
			echo"";
			
			}
			}
			
			}	}			?>
			<hr>
             <label>Foto  </label><br>
              <?php
	     
        if(!empty($d2[foto])){
        echo"<img src='../../foto/$d2[foto]' alt=''  width='100px' /><br>";    
        }
        else {
            
        }
        ?><br>
         <div>
            <span class="select-wrapper">
  
    <input type="file" id="imageFile" accept="image/*"/> </span>
        <div class="resultImageWrapper">
   
     <img src="" alt="" id="resultImage" width="200" />
  
    <input type="hidden" id="myText" value="" name="img" >
      
      
</div>
  
</div>
<hr>


            
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
 
   
<?php include"../../inc/footerm.php";?></body>

</html>