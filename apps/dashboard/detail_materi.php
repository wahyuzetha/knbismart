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
$kelas = anti_injection($_GET['kelas']);

if($_SESSION[levelu]==1 or $_SESSION[levelu]==2){
    $_SESSION[kelasku]=$_GET[kelas];
}
else {
    $_SESSION[kelasku]=$_SESSION[kelassiswa];
}

$tgl=date('Y-m-d');
$jam_k=date('h:i:s');
$cek=mysql_query("select * from log_akses_materi where id_user='$_SESSION[namauser]' and id_materi='$id'");
$dcek=mysql_fetch_array($cek);
$png=mysql_query("select * from pengaturan");
$dpng=mysql_fetch_array($png);

$pem=mysql_query("select * from pembelajaran where id='$id_pembelajaran'");
$dpem=mysql_fetch_array($pem);

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
  <script src="../../js/jquery-1.11.2.min.js"></script>
  <script src="https://cdn.ckeditor.com/4.14.0/standard-all/ckeditor.js"></script>
<style>
.chat
{
    list-style: none;
    margin: 0;
    padding: 0;
	width:100%;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;

}

.chat li img { max-width: 100%; }

.chat li.left .chat-body
{
}

.chat li.right .chat-body
{
    margin-right: 60px;
}


.chat li .chat-body p
{
    margin: 0;
    color: #000;
}

.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
    overflow-y: scroll;
    height: 500px;
}


.image-upload > input
{
    display: none;
}

.image-upload img
{
    width: 70px;
    cursor: pointer;
}
iframe, object, embed {
    max-width: 100%;
}
</style>
<script>
 $(document).ready(function(){


	$('.loadingsave').hide();



$(".buka_komen_awal").click(function(){
    	$('.koment_awal').show();
    	$('.tutup_komen_awal').show();

}); 

$(".tutup_komen_awal").click(function(){
    	$('.koment_awal').hide();
    	    	$('.tutup_komen_awal').hide();


}); 



$(".baca").click(function(){
     	var data = 1;

  $.ajax({
	type: 'POST',
	url: "getpdf.php",
    data: { id: <?php echo"$id";?>},
	beforeSend: function(){
	$('.loadingpdf').show();
	},
	complete: function(){
	$('.loadingpdf').hide();
	},
	error: function(){
	swal("Peringatan", "Koneksi Terputus, Silahkan cek jaringan anda", "warning");
    },
	success: function(html) { 
	$(".hasil_pdf").html(html);

    
	},
	timeout: 60000 
	});
	
	});
	

$(".tombol-simpan").click(function(){
     for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    };
 	var data = $('.form-user').serialize();
 	
 	var cek=$('#editor1').val();
    if(cek==""){
     	swal("Peringatan", "Silahkan isi komentar", "warning");
   
    } 	
    else {
	$.ajax({
	type: 'POST',
	url: "save_komen.php",
	  cache: false,
	data: data,
	beforeSend: function(){
	$('.loadingsave').show();
	},
	complete: function(){
	$('.loadingsave').hide();
	},
	error: function(){
	swal("Peringatan", "Koneksi Terputus, Silahkan cek jaringan anda", "warning");
    },
	success: function(data) {
	if(data==""){	
		swal("Peringatan", "Gagal di simpan, silahkan ulangi", "warning");
	}
	else {	
	

//  	console.log(data)
$('.form-user')[0].reset();
$('#myText').val("");
$('#downlodf').val("");

      
	load_komen("<?php echo"$id,id_materi";?>");
	 for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
    }
        CKEDITOR.instances[instance].setData('');
$('.resultImageWrapper').hide();
$('.msg').hide();

  }
	

		

	},
	timeout: 60000 
	});
    }
	});
	
	function load_komen(id_data, field){
 var dataString = 'id_data='+id_data+'&field='+field;
	 $.ajax({
	type: "POST",
	url: "load_komen.php",
	data: dataString,
	cache: false,
	beforeSend: function(){
	$('#loading_komen').show();
	},
	complete: function(){
	$('#loading_komen').hide();
	},
	success: function(html) { 
	$('#loading_komen').hide();
	$(".hasil").html(html);



	}
	,timeout: 60000 
	});
	}
	
	load_komen("<?php echo"$id,id_materi";?>");
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
		
		$('#imageFile').on('change', function(event) {
			var hasil_wrapper=$('.resultImageWrapper');
			var hasil_gambar=$('#resultImage');
			var hasil_text=$('#myText');
			handleDrop(event.target.files,hasil_wrapper,hasil_gambar,hasil_text);
		});
		
		$('#imageFile_ktp').on('change', function(event) {
			var hasil_wrapper=$('.resultImageWrapper_ktp');
			var hasil_gambar=$('#resultImage_ktp');
			var hasil_text=$('#myText_ktp');
			handleDrop(event.target.files,hasil_wrapper,hasil_gambar,hasil_text);
		});
		
		
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
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
         <?php
		 
		 $qstatus=mysql_query("SELECT * from status_mengajar
											where 
                                            status_mengajar.id_materi='$id' and
											status_mengajar.tanggal='$tgl' and
											status_mengajar.id_kelas='$kelas_all' and
											status_mengajar.semester='$semester_aktif' and
											status_mengajar.tahun_ajaran='$tahun_aktif' ");	
	        $dstatus=mysql_fetch_array($qstatus);
	
if(!empty($dcek[id])){
   
}
else {
$save=mysql_query("insert into log_akses_materi(ip,id_materi,id_user,hit,tanggal,timestmp,device,id_pembelajaran,jam,id_mengajar)
                    values('$ip','$id','$_SESSION[namauser]','1','$tgl',NOW(),'$_SERVER[HTTP_USER_AGENT]','$id_pembelajaran','$jam_k','$dstatus[id]')") or die("gagal".mysql_error());
}

        $no=0;
          $m=mysql_query("select  * from materi where id='$id'");   
            $d=mysql_fetch_array($m);
                $dm=mysql_query("select  * from guru where nuptk='$d[nuptk]'");   
                $guru=mysql_fetch_array($dm);
            $no++;     
            ?>      
             
                        <div class="header">
                         <?php echo"<h4>$d[judul] "; if(empty($_SESSION[kelasku])){ echo" <span style='color:red'>Silahkan pilih kelas!</span>"; } else { echo" Kelas $_SESSION[kelasku]";} echo"</h4>";?>
    
                         </div>
                         
                        <div class="body">
                            
                          <?php
	
				if($_SESSION[levelu]==1 or $_SESSION[levelu]==2){
					
?>
  <button type="button" class="btn bg-pink waves-effect baca" data-toggle="modal" data-target="#kelas"><i class="material-icons">book</i> Pilih Kelas</button>
                 
                    <div class="modal fade" id="kelas" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                     <div class="modal-header bg-pink">
                            <h4 class="modal-title" id="smallModalLabel">Daftar Kelas</h4>
                        </div>                          
<div class="modal-body">
                  <?php 
                  if(empty($dpem[kelas])){
                       $mpj=mysql_query("select * from kelas where tingkat='$dpem[tingkat]' order by nama_kelas asc");
                        while($dpj=mysql_fetch_array($mpj)){ 
                        echo"<a href='detail_materi?d=$id&id_pembelajaran=$id_pembelajaran&kelas=$dpj[nama_kelas]'>$dpj[nama_kelas] </a><br><br>";
                            
                        }
                  }
                  else {
                      	  $someArray = json_decode($dpem[kelas], true);
			
		            	foreach($someArray as $kelass) { 
		             echo"<a href='detail_materi?d=$id&id_pembelajaran=$id_pembelajaran&kelas=$kelass'>$kelass </a><br><br>";

		            	}
                  }
                  
                  ?>
                        </div>
                       
                        <div class="modal-footer">
                        
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              
                        </div>
                    </div>
                </div>
            </div>  <hr>
             <?php } ?>
          
                 <?php echo"$d[isi]";?>
                
          


              
  
<?php
$ext = pathinfo($d[file], PATHINFO_EXTENSION);
$base_url=$dpng[base_url];
 if(!empty($d[file])){

	echo"<a href='../../file/$d[file]' download> 
				<button type='button' class='btn bg-orange waves-effect'><i class='material-icons'>book</i> Download File</button>	
					</a>

					";
					?>
				<?php	}
				
				if(!empty($d[file]) and $ext=="pdf"){
					
?>
  <button type="button" class="btn bg-blue waves-effect baca" data-toggle="modal" data-target="#vpdf"><i class="material-icons">book</i> Baca Online</button>
                 
                    <div class="modal fade" id="vpdf" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                                                <span class="loadingpdf" style="display:none"> <img src="../../css/loader.gif"></span> 

                            <div class="hasil_pdf"></div>
                        <div class="modal-footer">
                        
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              
                        </div>
                    </div>
                </div>
            </div>
             <?php } ?> 

<hr>
          	<?php 
          	if(!empty($_SESSION[kelasku])){?>
          	<span class="buka_komen_awal"><button type="button" class='btn bg-green waves-effect'><i class="material-icons">comment</i> Komentar </button></span>
<?php } ?>
 
	<br><span class="tutup_komen_awal pull-right" style='color:red; cursor:pointer; display:none;'>  close</span>

	<hr>
	<div class="koment_awal" style="display:none">
	 <form method="post" class="form-user" name="form-user">
		<input type='hidden' class='form-control'  name='id_data'  value='<?php echo"$id";?>' required>
  		<input type='hidden' class='form-control'  name='field'  value='<?php echo"id_materi";?>' required>
  		<input type='hidden' class='form-control'  name='judul_materi'  value='<?php echo"$d[judul]";?>' required>
  
    <div class="image-upload">
    <label for="imageFile">
       <i class="material-icons" style="color:green">add_a_photo</i>
    </label>

    <input type="file" id="imageFile" accept="image/*"/>
   
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
    <div class="resultImageWrapper">
    <img src="" alt="" id="resultImage" width="100" style="padding:10px;border-radius:10px;" /> 
    </div>
    <input type="hidden" id="myText" value="" name="img" >    
    				<div class="msg" style="display:none"></div>

    		 <textarea  id="editor1" name="isi" rows="5" class="form-control" data-sample-short></textarea>
<br>
                            <button class="btn btn-info btn-sm tombol-simpan" type="button" id="btn-chat">
                                <i class="material-icons">comment</i> 
								
								 Kirim <span class="loadingsave"> <img src="../../css/loader.gif"></span> </button>
								</form>
								<br><br>
								<hr>
								</div>
								
<div id="loading_komen">Memuat Komentar <img src="../../css/loader.gif"></div>   
   <div class="row hasil">
          
                    
                </div>
                      
            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           

            <!-- #END# Exportable Table -->
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
    CKEDITOR.replace('editor1', {
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

     
      // Reduce the list of block elements listed in the Format drop-down to the most commonly used.
      format_tags: 'p;h1;h2;h3;pre',
      // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
      removeDialogTabs: 'image:advanced;link:advanced',

      height: 100,
	  
    });

  </script>
          
</html>