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

$m2=mysql_query("select  * from pembelajaran where id='$id_pembelajaran'");
$d2=mysql_fetch_array($m2);

$m=mysql_query("select  * from tugas where id='$id'");
$d=mysql_fetch_array($m);

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>
<script src='../../plugins/tinymce/tinymce.min.js'></script>
<?php include"../../inc/tiny.php";?>
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>

<?php include"../../inc/tiny.php";?>
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
 
     $(function(){
       $('.siswa').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Siswa yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".ptk option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
 
 $(document).ready(function() {
     $('.vkelas').hide();
     $('.vsiswa').hide();


var dataString = 'kelas=<?php echo"$d2[kelas]&akses_kelas=$d[akses_kelas]&akses_siswa=$d[akses_siswa]";?>';

   var tam='<?php echo"$d[jenis_akses]";?>';
    if(tam==2){
     $('.vkelas').show();
     $('.vsiswa').hide();
     
    $.ajax({
      type: "POST",
      url: "../materi/getkelas.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".kelas").html(html);
      } 
    });
    }
   else if(tam==3){
      $('.vkelas').hide();
     $('.vsiswa').show();
     
     $.ajax({
      type: "POST",
      url: "../materi/getsiswa.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".siswa").html(html);
      } 
    });
   }
   else {
        $('.vkelas').hide();
     $('.vsiswa').hide();
   }
    
    
    
  $(".tampilan").change(function() {
 var dataStringk = 'kelas=<?php echo"$d2[kelas]";?>';

   var tam=$(".tampilan").val();
    if(tam==2){
     $('.vkelas').show();
     $('.vsiswa').hide();
     
    $.ajax({
      type: "POST",
      url: "../materi/getkelas.php",
      data: dataStringk,
      cache: false,
      success: function(html) {
        $(".kelas").html(html);
      } 
    });
    }
   else if(tam==3){
      $('.vkelas').hide();
     $('.vsiswa').show();
     
     $.ajax({
      type: "POST",
      url: "../materi/getsiswa.php",
      data: dataStringk,
      cache: false,
      success: function(html) {
        $(".siswa").html(html);
      } 
    });
   }
   else {
        $('.vkelas').hide();
     $('.vsiswa').hide();
   }
    
    
    
  });
});
</script>

 
  <script>
	//  for drag and drop file access
	jQuery.event.props.push('dataTransfer');

	$(function(){
		var dropTimer;
		var dropTarget = $('.dragArea');
		var fileInput = $('#imageFile');

		dropTarget.on("dragover", function(event) {
			clearTimeout(dropTimer);
			if (event.currentTarget == dropTarget[0]) {
				dropTarget.addClass('over');
			}

			return false; //  for drop to work
		});

		dropTarget.on('dragleave', function(event) {
			if (event.currentTarget == dropTarget[0]) {
				dropTimer = setTimeout(function() {
					dropTarget.removeClass('over');
				}, 300);
			}
		});

		handleDrop = function(files){
			dropTarget.removeClass('over');

			var file = files[0]; // Multiple files can be dropped. Lets only deal with the "first" one.

			if (file.type.match('image.*')) {
				resizeImage(file, 300, function(result) {
					$('#resultImage').attr('src', result);
                   document.getElementById("myText").value = result;
                   
					$('.resultImageWrapper').show();
				});
			} else {
				alert("That file wasn't an image.");
			}
		};

		dropTarget.on('drop', function(event) {
			event.preventDefault(); // Or else the browser will open the file
			handleDrop(event.dataTransfer.files);
		});

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
<style>
		 

		.dragArea {
			background-color: #efefef;
			border: 3px dashed #cccccc;
			border-radius: 10px;
			text-align: center;
			padding: 50px;
		}
    .dragArea2 {
			background-color: #fff;
			border: 3px dashed #cccccc;
			border-radius: 10px;
			text-align: left;
			}

		.dragArea.over {
			border-color: #ff0000;
			background-color: #FFE9EA;
		}

		.resultImageWrapper {
			display: none;
			margin-top: 50px;
			text-align: center;
		}

		#resultImage {
			box-shadow: rgba(0,0,0,0.4) 0 2px 5px;
		}
    .select-wrapper {
  background: url(../../css/camera.png) no-repeat;
  background-size: cover;
  display: block;
  position: relative;
  width: 80px;
  height: 74px;
      margin-left: 45%;
      margin-right: 50%;

}
#imageFile {
  width: 80px;
  height: 61px;
  margin-right: 100px;
  opacity: 0;
  filter: alpha(opacity=0); /* IE 5-7 */
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
           <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                      
                        <div class="header">
                            <h2>Edit Data Tugas <?php echo"$d2[pembelajaran] $d2[tingkat]";?></h2>
                            
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

      <div class="body">
 
<input type='hidden' name='id' value="<?php echo"$d[id]";?>">
<input type='hidden' name='id_pembelajaran' value="<?php echo"$d[id_pembelajaran]";?>">
<input type='hidden' name='foto_lama' value="<?php echo"$d[foto]";?>">
<input type='hidden' name='file_lama' value="<?php echo"$d[file]";?>">

  <div class="form-group">
                   <label class="form-label">Judul Tugas </label>
          
            <div class="form-line ">
                         <input type="text" name="judul" class="form-control" value="<?php echo"$d[judul]";?>">

      

    </div>

            </div>
         
           <div class="form-group">
                   <label class="form-label">Keterangan Tugas </label>
          
            <div class="form-line ">
         <textarea name="isi"><?php echo"$d[isi]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
	
			<div class='form-group form-float'>
             <label class='form-label'>Upload File Pendukung</label>
           <br>
           <?php
		   if(!empty($d[file])){
		   echo"<a href='../../file/$d[file]' download>Download File</a>";
		   echo"<a href='upd_f?d=$d[id]&j=f&nm=../../file/$d[file]&id_pembelajaran=$_GET[id_pembelajaran]' style='color:red'>Hapus</a>";
		   }
		   ?>
            <div class='form-line '>
             <input type='file' class='form-control'  aria-required='true' name='jfile'>
            

            </div>
            </div>
          
            <br>
            
            <div class="form-group form-float">
            <label class="form-label">Tampilke Ke :</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick tampilan" required name="jenis_akses">

			 <?php
            $mpjt=mysql_query("select * from jennis_tampil order by id asc");
            while($dpjt=mysql_fetch_array($mpjt)){ 
                if($dpjt[id]==$d[jenis_akses]){
                    $pil="selected";
                }
                else {
                    $pil="";
                }
            ?>      
          <option value="<?php echo"$dpjt[id]";?>" <?php echo"$pil";?>><?php echo"$dpjt[jenis_tampil]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
         
		  <div class="form-group form-float vkelas">
            <label class="form-label">Pilih Kelas</label>
            <br>
            <select class="form-control show-tick  select2 kelas" name="akses_kelas[]"  multiple style="width:100%">
         
              </select>
                                
            </div>
            
             <div class="form-group form-float vsiswa">
            <label class="form-label">Pilih Siswa</label>
            <br>
            <select class="form-control show-tick  select3 siswa" name="akses_siswa[]"  multiple style="width:100%">
         
              </select>
                                
            </div>
            
            
            <label class='form-label'>Tambahkan Thumbnail Foto </label><br>
		   <?php
		   if(!empty($d[foto])){
		   echo"<img src='../../images/$d[foto]' height='100px'>";
		   		   echo"<a href='upd_f?d=$d[id]&j=p&nm=../../file/$d[file]&id_pembelajaran=$_GET[id_pembelajaran]' style='color:red'>Hapus</a>";

		   }
		   ?>
		    <div class="dragArea">
         <div>
            <span class="select-wrapper">
  
    <input type="file" id="imageFile" accept="image/*"/> </span>
        <div class="resultImageWrapper">
   
     <img src="" alt="" id="resultImage" width="200" />
  
    <input type="hidden" id="myText" value="" name="img" >
      
      
</div>
  </div>
</div><br>
         
           
            
           <div class="row">
            <div class="col-md-4">           <div class="form-group">
  
            <label class="form-label">Tanggal Bisa Di akses</label>
         
              <div class="form-line ">
            
             <input type='date' name='tanggal_mulai' class='form-control' required value="<?php echo"$d[tanggal_mulai]";?>">

            </div>

</div>
</div>
 <div class="col-md-4">
 <div class="form-group form-float">
                                                <label class="form-label">Jam Bisa Diakses</label>

                                        <div class="form-line">
    <input type="text" name="jam_mulai" id="date-format" value="<?php echo"$d[jam_mulai]";?>" class="waktu wkt form-control floating-label" placeholder="Klik di sini untuk pilih jam mulai" required>
                                        </div>
                                    </div>
									
     </div>     
       </div>   
           <div class="row">
            <div class="col-md-4">           <div class="form-group">
  
            <label class="form-label">Maksimal Tanggal Pengumpulan</label>
         
              <div class="form-line ">
            
             <input type='date' name='batas_tanggal' class='form-control' required value="<?php echo"$d[batas_tanggal]";?>">

            </div>

</div>
</div>
 <div class="col-md-4">
 <div class="form-group form-float">
                                                <label class="form-label">Maksimal Jam Pengumpulan</label>

                                        <div class="form-line">
    <input type="text" name="batas_jam" id="date-format" value="<?php echo"$d[batas_jam]";?>" class="waktu wkt form-control floating-label" placeholder="Klik di sini untuk pilih jam mulai" required>
                                        </div>
                                    </div>
									
     </div>     
       </div>  
            


          
         
            
            <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
            <a href="data?d=<?php echo"$id_pembelajaran";?>"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
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
     <!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>


    <script src="../../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../../js/pages/tables/jquery-datatable.js"></script>

  <script src="../../plugins/sweetalert/sweetalert.min.js"></script>
 <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="../../plugins/bootstrap-notify/bootstrap-notify.js"></script>
  
   <!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
     <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

   
    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>
   
    <script type="text/javascript">
		$(document).ready(function()
		{
			
			$('#date-format').bootstrapMaterialDatePicker
			({
								date: false,
			format: 'HH:mm',
				lang: 'id',
				weekStart: 1, 
				cancelText : 'Batal',
				nowButton : true,
				switchOnClick : true,
				//minDate : new Date() 
			});
			
			$('#date-format2').bootstrapMaterialDatePicker
			({
								date: false,
			format: 'HH:mm',
				lang: 'id',
				weekStart: 1, 
				cancelText : 'Batal',
				nowButton : true,
				switchOnClick : true,
				//minDate : new Date() 
			});
		
		});
		</script>
</html>