<?php
	include"../../inc/koneksi.php";
include"../../inc/aman.php";

$field=$_POST[field];
$id_data=$_POST[id_data];
$id_komen=$_POST[id_komen];



?>
<script>
	$('.loadingsavek').hide();

$(".tombol-simpan").click(function(){
 for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    };
    
	var data = $('.form-user').serialize();
		var cek=$('#editor1<?php echo"$id_komen";?>').val();
    if(cek==""){
     	swal("Peringatan", "Silahkan isi komentar", "warning");
   
    } 	
    else {
	$.ajax({
	type: 'POST',
	url: "savesubkomen.php",
	data: data,
	beforeSend: function(){
	$('.loadingsavek').show();
	},
	complete: function(){
	$('.loadingsavek').hide();
	},
	error: function(){
	swal("Peringatan", "Koneksi Terputus, Silahkan cek jaringan anda", "warning");
    },
	success: function(data) {
	    //alert(data)
	if(data=="gagal"){	
		swal("Peringatan", "Gagal di simpan, silahkan ulangi", "warning");
	}
	else {	
	
	swal({
  title: "Berhasil!",
  text: "Berhasil Komentar",
  type: "success",
  confirmButtonText: "OK"
	},
	function(isConfirm){
  if (isConfirm) {
var dataString = 'field=<?php echo"$field";?>&id_komen=<?php echo"$id_komen";?>&id_data=<?php echo"$id_data";?>';
	 $.ajax({
	type: "POST",
	url: "hasil_sub_komen.php",
	data: dataString,
	cache: false,
	beforeSend: function(){
	$('#loading').show();
	},
	complete: function(){
	$('#loading').hide();
	},
	success: function(html) { 
	$('#loading').hide();

	$(".hasil_komen").html(html);
	$('#myTextk').val("");
$('textarea').val('');

 for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
    }
        CKEDITOR.instances[instance].setData('');
$('.form-user')[0].reset();
$('.resultImageWrapperk').hide();
$('.msg').hide();



	}
	,timeout: 60000 
	});
	
	
	 var dataStringk = 'id_komen=<?php echo"$id_komen";?>';

	 $.ajax({
	type: "POST",
	url: "hitung.php",
	data: dataStringk,
	cache: false,
	beforeSend: function(){
	$('#loading').show();
	},
	complete: function(){
	$('#loading').hide();
	},
	success: function(html) { 
	$('#loading').hide();
	$(".hasil_hitung<?php echo"$id_komen";?>").html(html);
	}
	,timeout: 60000 
	});
		 
  }
	}); 

	}	

	},
	timeout: 60000 
	});
    }
	});
	
var dataString = 'field=<?php echo"$field";?>&id_komen=<?php echo"$id_komen";?>&id_data=<?php echo"$id_data";?>';
	 $.ajax({
	type: "POST",
	url: "hasil_sub_komen.php",
	data: dataString,
	cache: false,
	beforeSend: function(){
	$('#loading').show();
	},
	complete: function(){
	$('#loading').hide();
	},
	success: function(html) { 
	$('#loading').hide();

	$(".hasil_komen").html(html);



	}
	,timeout: 60000 
	});
	

	jQuery.event.props.push('dataTransfer');

	$(function(){



		handleDrop = function(files,hasil_wrapper,hasil_gambar,hasil_text){

			var file = files[0]; // Multiple files can be dropped. Lets only deal with the "first" one.

			if (file.type.match('image.*')) {
				resizeImage(file, 300, function(result) {
					hasil_gambar.attr('src', result);
                    hasil_text.val(result);
					hasil_wrapper.show();
				});
			} else {
				alert("That file wasn't an image.");
			}
		};


		

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
		
		$('#imageFilek').on('change', function(event) {
			var hasil_wrapper=$('.resultImageWrapperk');
			var hasil_gambar=$('#resultImagek');
			var hasil_text=$('#myTextk');
			handleDrop(event.target.files,hasil_wrapper,hasil_gambar,hasil_text);
		});
		
	
		
		
	});


			</script>
	<div class="edr<?php echo"$id_komen";?>">
	    <div class="hasil_komen"></div>

	
 <form method="post" class="form-user" name="form-user">
		<input type='hidden' class='form-control'  name='id_data'  value='<?php echo"$id_data";?>' required>
		<input type='hidden' class='form-control'  name='field'  value='<?php echo"$field";?>' required>
		<input type='hidden' class='form-control'  name='id_komen'  value='<?php echo"$id_komen";?>' required>
<div class="image-upload">
    <label for="imageFilek">
       <i class="material-icons" style="color:green">add_a_photo</i>
    </label>

    <input type="file" id="imageFilek" accept="image/*"/>
   
    <input type="file" id="media" name="media" style="display: none;" required>
    <label for="media">
       <i class="material-icons" style="color:green"><b>attach_file</b></i>
    </label>


    <div class="progress" style="display:none">
					<div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						<span class="sr-only">0%</span>
					</div>
				</div>
</div>
    <div class="resultImageWrapperk">
    <img src="" alt="" id="resultImagek" width="100" style="padding:10px;border-radius:10px;" /> 
    <input type="hidden" id="myTextk" value="" name="img" >    
    </div>
    				<div class="msg" style="display:none"></div>


		 <textarea  id="editor1<?php echo"$id_komen";?>" class="editork form-control"  name="isi" rows="5" data-sample-short></textarea>

                            <button class="btn bg-green btn-sm tombol-simpan" type="button" id="btn-chat">
                                Kirim <span class="loadingsavek" style='display:none'> <img src="../../css/loader.gif"></span> </button>
			
								</form><br><br>
					 	<script>
	$(document).ready(function() {
	$('#media').on('change', function(event){
		event.preventDefault();
   var formData = new FormData();
   formData.append('media', $('#media')[0].files[0]);
		$('.msg').hide();
		$('.progress').show();
		
		$.ajax({
			xhr : function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(e){
					if(e.lengthComputable){
						console.log('Bytes Loaded : ' + e.loaded);
						console.log('Total Size : ' + e.total);
						console.log('Persen : ' + (e.loaded / e.total));
						
						var percent = Math.round((e.loaded / e.total) * 100);
						
						$('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
					}
				});
				return xhr;
			},
			
			type : 'POST',
			url : 'upload_file.php',
			data : formData,
			processData : false,
			contentType : false,
			success : function(response){
				$('form')[0].reset();
				$('.progress').hide();
				$('.msg').show();
				if(response == ""){
					alert('File gagal di upload');
				}else{
					var msg = response;
					$('.msg').html(msg);
				}
			}
		});
	});
});
     CKEDITOR.replace('editor1<?php echo"$id_komen";?>', {
      extraPlugins: 'image2,uploadimage,emoji',

      toolbar: [{
          name: 'clipboard',
          items: ['Undo', 'Redo']
        },
        {
          name: 'basicstyles',
          items: ['Bold', 'Italic']
        },
       
        {
          name: 'links',
          items: ['Link', 'Unlink']
        },
        {
          name: 'insert',
          items: ['Source,Emoji']
        },
        {
          name: 'tools',
          items: ['Maximize']
        },
      //  {
        //  name: 'editing',
          //items: ['Scayt']
        //}
      ],

     
      height: 100,
	  
    });

  </script></div>  
