<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
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
                            <h2>Tambah Administrator</h2>
                            
                        </div>
                
          <div class="body">
          <form id="form_validation" method="POST" action="save">
           
          

              

            <div class="form-group form-float">
            <div class="form-line ">
             <input type="text" class="form-control" name="username" required="" aria-required="true">
             <label class="form-label">Username</label>
            </div>
            </div>
               
            
              <div class="form-group form-float">
            <div class="form-line ">
             <input type="password" class="form-control" name="password" required="" aria-required="true">
             <label class="form-label">Password</label>
            </div>
            </div>   
              
               <label>Foto  </label>
         <div>
            <span class="select-wrapper">
  
    <input type="file" id="imageFile" accept="image/*"/> </span>
        <div class="resultImageWrapper">
   
     <img src="" alt="" id="resultImage" width="100" />
  
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
 <script >window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);
//# sourceURL=pen.js
</script>
   
<?php include"../../inc/footerm.php";?></body>

</html>