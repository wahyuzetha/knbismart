<?php 
session_start();
include "../../inc/koneksi_sim.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_POST['d']);
$m2=mysql_query("select  * from kelas where id='$id'");
$d2=mysql_fetch_array($m2);


		$result = mysql_query("SELECT * FROM `sekolah`") or trigger_error(mysql_error()); 
		$row = mysql_fetch_array($result); 

?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>
<script src="../../js/jquery-1.8.3.min.js"></script>

<link href="../../css/jquery.fancybox-1.3.4.css" rel="stylesheet" media="screen">
<script src="../../js/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="../../tiny/tinymce.min.js"></script>
    <script type="text/javascript">
tinymce.init({
    mode: "textareas",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image  charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "music |print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    
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
                            <h2>Pengaturan PPDB</h2>
                            
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
              
  <inpu <input name='id' type='hidden' size="100" value="<?php echo"$row[0]";?>"/>
                    <label>Nama Sekolah</label>
                    <input name='nama_sekolah' class="form-control" type='text' size="100" value="<?php echo"$row[1]";?>"/>

                 
                 <br>
                    <label>Alamat</label>
                   
                      <input class="form-control" name='alamat_sekolah' type='text' size="100" value="<?php echo"$row[4]";?>"/>
                   
                 <br>

                    <label>Telepon</label>
                      <input class="form-control" name='telp' type='text' size="30" value="<?php echo"$row[6]";?>"/><br>
                      
                      <label>Whastapp</label>
                      <input class="form-control" name='wa' type='text' size="30" value="<?php echo"$row[wa]";?>"/><br>
                      
                      <label>Email</label>
                      <input class="form-control" name='email' type='text' size="30" value="<?php echo"$row[email]";?>"/><br>
       
                    <label>Background Slider Home  </label>
                      <a href="../../tiny/plugins/filemanager/dialog.php?type=2&field_id=fieldID3&relative_url=1" class="btn iframe-btn btn-info" type="button">Ganti Foto</a>
	
                    
      <input id="fieldID3" type="text" name="bg" class="form-control" value="<?php echo"$row[bg]";?>" size="50"><br />
<br>
 
                   <label>Text Header Home</label>
                      <input class="form-control" name='headerhome' type='text' size="40" value="<?php echo"$row[headerhome]";?>"/>
                 <br>
                       
                    <label>Konten Home </label>
                   <textarea name="koneten_home"><?php echo"$row[koneten_home]";?></textarea>
        
                    <br>
                    <label>Konten Tentang </label>
                    <textarea name="konten_tentang"><?php echo"$row[konten_tentang]";?></textarea>
                    <br>
                    <label>Konten Promosi </label>
                        <textarea name="konten_promosi"><?php echo"$row[konten_promosi]";?></textarea>
                         
      				<br>
      				<label>Alur Pendaftaran </label>
                    		  <textarea name="alur"><?php echo"$row[alur]";?></textarea>
                   
                   
                    <br>
                    <img src="<?php echo"$row[galeri1]";?>" width="100" height="100" />
                     <br>  
                    <label>Gallery 1  </label><br>
                      <a href="../../tiny/plugins/filemanager/dialog.php?type=2&field_id=fieldID4&relative_url=1" class="btn iframe-btn btn-info" type="button">Ganti Foto</a>
	
                    <br>
                    <input id="fieldID4" type="text" name="galeri1" class="form-control" value="<?php echo"$row[galeri1]";?>" size="50"><br />
	                 
                     
                   <br>    
                  <img src="<?php echo"$row[galeri2]";?>" width="100" height="100" />
                  <br>
                    <label>Gallery 2  </label><br>
                      <a href="../../tiny/plugins/filemanager/dialog.php?type=2&field_id=fieldID5&relative_url=1" class="btn iframe-btn btn-info" type="button">Ganti Foto</a>
	               <br> 
                    <input id="fieldID5" type="text" name="galeri2" class="form-control" value="<?php echo"$row[galeri2]";?>" size="50"><br />
	              
	              <br>
	              <img src="<?php echo"$row[galeri3]";?>" width="100" height="100" />
                  <br>
                    <label>Gallery 3  </label><br>
                      <a href="../../tiny/plugins/filemanager/dialog.php?type=2&field_id=fieldID6&relative_url=1" class="btn iframe-btn btn-info" type="button">Ganti Foto</a>
	               <br> 
                    <input id="fieldID6" type="text" name="galeri3" class="form-control" value="<?php echo"$row[galeri3]";?>" size="50"><br />
	                  
                   <br>
                   <img src="<?php echo"$row[galeri4]";?>" width="100" height="100" />
                  <br>
                    <label>Gallery 4  </label><br>
                      <a href="../../tiny/plugins/filemanager/dialog.php?type=2&field_id=fieldID7&relative_url=1" class="btn iframe-btn btn-info" type="button">Ganti Foto</a>
	                <br>
                    <input id="fieldID7" type="text" name="galeri4" class="form-control" value="<?php echo"$row[galeri4]";?>" size="50"><br />
	                                 
                    
                            
               <br>
               <label>Pendaftaran di buka atau tutup</label>
                     <select name="daftar_buka"  class="form-control">
                  <option value="">- Pilih -</option>
                    <?php $querydb=mysql_query("select*from setting");
					while($ddb=mysql_fetch_array($querydb)){
					if($ddb[0]==$row[daftar_buka]){?>
					<option value="<?php echo"$ddb[0]";?>" selected><?php echo"$ddb[1]";?></option>
					<?php } else {?> <option value="<?php echo"$ddb[0]";?>"><?php echo"$ddb[1]";?><?php }} ?></option>
                     </select>
                     
                     <br>
                    <label>Pengumuman di buka atau tutup</label>
                   
                     <select name="pengumuman_buka"  class="form-control">
                  <option value="">- Pilih -</option>
                    <?php $querydb=mysql_query("select*from setting");
					while($ddb=mysql_fetch_array($querydb)){
					if($ddb[0]==$row[pengumuman_buka]){?>
					<option value="<?php echo"$ddb[0]";?>" selected><?php echo"$ddb[1]";?></option>
					<?php } else {?> <option value="<?php echo"$ddb[0]";?>"><?php echo"$ddb[1]";?><?php }} ?></option>
                     </select>
                             
                  
                             <br>
                    <label>Setting Kata-Kata Pengumuman apabila di terima</label>

                         <textarea name="pengumuman_lulus"><?php echo"$row[pengumuman_lulus]";?></textarea>
                    
                   <br>
                   
                             <label>Setting Kata-Kata Pengumuman apabila tidak di terima</label>

                         <textarea name="pengumuman_tidak"><?php echo"$row[pengumuman_tidak]";?></textarea>
                    
                  
				<div class="box-footer">
                    <button type="Submit" class="btn btn-primary">Simpan</button>
                  </div>
				</div><!-- /.box-body -->
                </form>
              </div><!-
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
   
<script>
jQuery(document).ready(function ($) {
      $('.iframe-btn').fancybox({
			  'width'	: 880,
			  'height'	: 570,
			  'type'	: 'iframe',
			  'autoScale'   : false
      });
      
 
			//
			// Handles message from ResponsiveFilemanager
			//
			function OnMessage(e){
			  var event = e.originalEvent;
			   // Make sure the sender of the event is trusted
			   if(event.data.sender === 'responsivefilemanager'){
			      if(event.data.field_id){
			      	var fieldID=event.data.field_id;
			      	var url=event.data.url;
							$('#'+fieldID).val(url).trigger('change');
							$.fancybox.close();

							// Delete handler of the message from ResponsiveFilemanager
							$(window).off('message', OnMessage);
			      }
			   }
			}

		  // Handler for a message from ResponsiveFilemanager
			$('.iframe-btn').on('click',function(){
			  $(window).on('message', OnMessage);
			});


      
      $('#download-button').on('click', function() {
	    ga('send', 'event', 'button', 'click', 'download-buttons');      
      });
      $('.toggle').click(function(){
	    var _this=$(this);
	    $('#'+_this.data('ref')).toggle(200);
	    var i=_this.find('i');
	    if (i.hasClass('icon-plus')) {
		  i.removeClass('icon-plus');
		  i.addClass('icon-minus');
	    }else{
		  i.removeClass('icon-minus');
		  i.addClass('icon-plus');
	    }
      });
});



function open_popup(url)
{
        var w = 880;
        var h = 570;
        var l = Math.floor((screen.width-w)/2);
        var t = Math.floor((screen.height-h)/2);
        var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
}

</script>

<script type="text/javascript">
	jQuery('#my-tab a').click(function (e) {
  e.preventDefault();
  jQuery(this).tab('show');
})
</script>
  <!-- Bootstrap Core Js -->
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
   
    
    <!-- Demo Js -->

</html>