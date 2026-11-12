<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_POST['d']);
if($_SESSION[levelu]==1){
$m2=mysql_query("select  * from siswa where nis='$id'");
$d2=mysql_fetch_array($m2);
$dis="";
}
else {
$m2=mysql_query("select  * from siswa where nis='$_SESSION[id_pengguna]'");
$d2=mysql_fetch_array($m2);
   $dis="disabled"; 
}

$muser=mysql_query("select  * from users where id_pengguna='$d2[nis]'");
$duser=mysql_fetch_array($muser);
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
                            <h2>Edit Data Siswa</h2>
                            
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


         
            <div class="form-group form-float">
            <div class="form-line ">
             <input type="text"  <?php echo"$dis";?> class="form-control" name="nis" required="" aria-required="true" value="<?php echo"$d2[nis]";?>">
              <input type="hidden" class="form-control" name="nis_lama" required="" aria-required="true" value="<?php echo"$d2[nis]";?>">
              <input type="hidden" class="form-control" name="foto_lama" required="" aria-required="true" value="<?php echo"$d2[foto]";?>">

             <label class="form-label">NIS</label>
            </div>
            </div>
            
            <div class="form-group form-float">
            <div class="form-line ">
             <input type="text" <?php echo"$dis";?> class="form-control" name="nama" required="" aria-required="true" value="<?php echo"$d2[nama]";?>">
             <label class="form-label">Nama</label>
            </div>
            </div>
            
           
              <input type="hidden" class="form-control" name="foto_lama" required="" aria-required="true" value="<?php echo"$d2[foto]";?>">
  
            <div class="form-group form-float">
                      <label class="form-label">Kelas</label>

            <div class="form-line ">
        <select class="form-control" <?php echo"$dis";?> name="kelas" id="kelas">
             <option value="">--Pilih Kelas----</option>
             <?php
                        $sql_kategori = mysql_query("SELECT * FROM kelas where tahun_ajaran='$_SESSION[thn_ajarann]' order by nama_kelas asc");
                while($k = mysql_fetch_assoc($sql_kategori))
                {
                    if($k[nama_kelas]==$d2[kelas]){
                        $s="selected";
                    }
                    else {
                        $s="";
                    }
                
                    echo"<option value='$k[nama_kelas]' $s>$k[nama_kelas]</option>";
                  
                }
                echo"</select>";
      ?>  
            </div>
            </div>



         
           <label>Foto  </label>
           <br>
            <?php
	     
        if(!empty($d2[foto])){
        echo"<img src='../../foto/$d2[foto]' width='100px' /><br>";    
        }
        else {
        echo"<img src='../../css/nopic.png'  width='100px' /><br>";    
    
        }
        ?>
	     <br>
         <div>
            <span class="select-wrapper">
  
    <input type="file" id="imageFile" accept="image/*"/> </span>
        <div class="resultImageWrapper">
   
     <img src="" alt="" id="resultImage" width="200" />
  
    <input type="hidden" id="myText" value="" name="img" >
      
      
</div>
  
</div>
<hr>
			 <div class="form-group form-float">
                      <label class="form-label">Keaktifan</label>

            <div class="form-line ">
        <select class="form-control" <?php echo"$dis";?> name="aktif" id="kelas">
             <option value="">--Pilih aktif----</option>
             <?php
                        $sql_kategoria = mysql_query("SELECT * FROM aktif");
                while($ka = mysql_fetch_assoc($sql_kategoria))
                {
                    if($ka[id]==$d2[aktif]){
                        $s2="selected";
                    }
                    else {
                        $s2="";
                    }
                
                    echo"<option value='$ka[id]' $s2>$ka[aktif]</option>";
                  
                }
                echo"</select>";
      ?>  
            </div>
            </div>
			
			
          <div class="form-group form-float">
                         <label class="form-label">Username</label>
     
            <div class="form-line ">
             <input type="text" class="form-control" name="username" value="<?php echo"$duser[username]";?>" required="" aria-required="true">
            </div>
            </div>

        
        
			<div class="row">
			<div class="col-md-4">
               <div class="form-group form-float">
			                <label class="form-label">Password (Kosongi jika tidak ingin diganti)</label>

            <div class="form-line ">
             <input type="password"  class="form-control" name="password"  value="">
            </div>
            </div>
			</div>
            </div>
          
	     
            
            <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
            <?php if($_SESSION[levelu]==3){?>
                        <a href="../../apps/dashboard/data_siswa"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>

            <?php } else {?>
            <a href="data"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
            <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
   
<?php include"../../inc/footerm.php";?></body>

</html>