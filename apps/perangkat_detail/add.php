<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m2=mysql_query("SELECT guru.nama,pembelajaran.* from pembelajaran,guru
WHERE guru.nuptk=pembelajaran.nuptk and pembelajaran.id='$id'");
$d2=mysql_fetch_array($m2);

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>
<script src='../../plugins/tinymce/tinymce.min.js'></script>


 <script>
  tinymce.init({
  selector: 'textarea',
  themes: 'modern',
  height: 200,
  plugins: "image media",
  image_class_list: [
    {title: 'Responsive', value: 'img-responsive'}
],
  toolbar: 'underline bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link media image | insertfile undo redo | forecolor backcolor emoticons | code',
    fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
  file_picker_callback: function(callback, value, meta) {
    // File type
    if (meta.filetype =="media" || meta.filetype =="image") {

      // Trigger click on file element
      jQuery("#fileupload").trigger("click");
      $("#fileupload").unbind('change');
      // File selection
      jQuery("#fileupload").on("change", function() {
         var file = this.files[0];
         var reader = new FileReader();
		                
         // FormData
         var fd = new FormData();
         var files = file;
         fd.append("file",files);
         fd.append('filetype',meta.filetype);
         var filename = "";
		                
         // AJAX
	 jQuery.ajax({
            url: "uploadimage.php",
	    type: "post",
	    data: fd,
	    contentType: false,
	    processData: false,
	    async: false,
	    success: function(response){
	       filename = response;
            }
         });
		             
	 reader.onload = function(e) {
            callback("../../../images/"+filename);
	 };
         reader.readAsDataURL(file);
       });
     }
		        
   }
 
  

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
				resizeImage(file, 500, function(result) {
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
					/*
					if(image.height > size) {
						image.width *= size / image.height;
						image.height = size;
					}
					*/
					if(image.width > size) {
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
  background: url(../../../css/camera.png) no-repeat;
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
                    <div class="card">
                      
                        <div class="header">
                            <h2>Tambah Perangkat Materi Pembelajaran <?php echo"$d2[pembelajaran] - $d2[nama]";?></h2>
                            
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
          <form id="form_validation" method="POST" action="save" enctype="multipart/form-data">
<input type='hidden' name='id' value="<?php echo"$id";?>">
  <div class="form-group">
                   <label class="form-label">Nama Perangkat </label>
          
            <div class="form-line ">
         <input type="text" name="nama_perangkat" class="form-control">
    

    </div>

            </div>
            
            
			<div class='form-group form-float'>
             <label class='form-label'>Upload File</label>
           
            <div class='form-line '>
             <input type='file' class='form-control'  aria-required='true' name='jfile'>
            

            </div>
            </div>
          
           

         
           
            
           
          
         
            
            <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
            <a href="data?d=<?php echo"$id";?>"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
   

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

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

    
    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/ui/dialogs.js"></script>
     <script src="../../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->
     <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

   
    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>
   
   
</html>