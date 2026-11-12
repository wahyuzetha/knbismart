<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_POST['d']);
$m2=mysql_query("select  * from jurusan where id='$id'");
$d2=mysql_fetch_array($m2);

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>

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
                            <h2>Edit Data Jurusan</h2>
                            
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
            
            <div class="form-group form-float">
            <div class="form-line ">
             <input type="text" class="form-control" name="jurusan" required="" aria-required="true" value="<?php echo"$d2[jurusan]";?>">
             <label class="form-label">Nama Jurusan</label>
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
 
   
<?php include"../../inc/footerm.php";?></body>

</html>