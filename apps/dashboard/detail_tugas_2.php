<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
ini_set('date.timezone', 'Asia/Jakarta'); 
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
$id_pembelajaran = anti_injection($_GET['id_pembelajaran']);
$tgl=date('Y-m-d');
if(empty($id) or empty($id_pembelajaran)){
header('Location: ../../apps/dashboard/dashs_tugas');
}
$cek=mysql_query("select * from log_akses_materi where id_user='$_SESSION[namauser]' and id_materi='$id'");
$dcek=mysql_fetch_array($cek);
$png=mysql_query("select * from pengaturan");
$dpng=mysql_fetch_array($png);
/*
if(!empty($dcek[id])){
$save=mysql_query("update log_akses_materi set ip='$ip',hit=hit+1,tanggal='$tgl',timestmp=NOW(),device='$_SERVER[HTTP_USER_AGENT]'
                where id_user='$_SESSION[namauser]' and id_materi='$id'") or die("gagal".mysql_error());
    
}
else {
$save=mysql_query("insert into log_akses_materi(ip,id_materi,id_user,hit,tanggal,timestmp,device,id_pembelajaran)
                    values('$ip','$id','$_SESSION[namauser]','1','$tgl',NOW(),'$_SERVER[HTTP_USER_AGENT]','$id_pembelajaran')") or die("gagal".mysql_error());
}
*/

           $jumlah_file=$dpng[maksimal_upload_tugas_file];

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
            callback("../../images/"+filename);
	 };
         reader.readAsDataURL(file);
       });
     }
		        
   }
 
  

});
  
  </script>
<style>

    .map-responsive{
    overflow:hidden;
    height:0;
    border: none;
}
.map-responsive iframe{
    left:0;
    height:100%;
    width:100%;
    position:absolute;
    border: none;
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
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
         <?php
            $no=0;
          $m=mysql_query("select  * from tugas where id='$id'");   
            $d=mysql_fetch_array($m);
                $dm=mysql_query("select  * from guru where nik='$d[nuptk]'");   
                $guru=mysql_fetch_array($dm);
            $no++;     
            
             $hdm=mysql_query("select  * from hasil_jwb_tugas where nis='$_SESSION[namauser]' and id_tugas='$id' and id_pembelajaran='$id_pembelajaran'");   
                $dhsiljwb=mysql_fetch_array($hdm);
                
                $tgl_batas=date('d/m/Y', strtotime($d[batas_tanggal]));
                $tgl_kirim=date('d/m/Y', strtotime($dhsiljwb[tanggal]));

            ?>      
             
                        <div class="header">
                         <?php echo"<h4>$d[judul]</h4>Batas Pengumpulan $tgl_batas $d[batas_jam] ";
                      
                        if(!empty($dhsiljwb[tanggal])){ echo"<h5 style='color:green'>Jawaban terkirim $tgl_kirim $dhsiljwb[jam]</h5>"; }
                         
                        if(!empty($dhsiljwb[nilai])){ echo"<h4 style='color:red'>Nilai $dhsiljwb[nilai]</h4>"; }
                        
                        
                         if(!empty($d[foto])){ echo"
                         <img src='../../images/$d[foto]'>"; }?>
    
                         </div>
                        <div class="body">
                            
                          
           
                 <?php echo"$d[isi]";?>
                
          


              
  
<?php
$ext = pathinfo($d[file], PATHINFO_EXTENSION);
$base_url=$dpng[base_url];
 if(!empty($d[file])){

		   echo"<a href='../../file/$d[file]' download>Download File Tugas</a>";

					}
	?>
	<hr>
	<?php 
	$tgl_ini=date('Y-m-d H:i:s');
//	$jam_ini=date('H:i:s'); 
	$jam_ini="09:00"; 

$waktu="$d[batas_tanggal] $d[batas_jam]";

if($tgl_ini>$waktu){ 
    
  	    echo"<span style='color:red'>Waktu Menjawab Tugas Berakhir, anda tidak dapat menjawab/mengubah jawaban anda</span><hr>
  	    
  	    <p align='left'>$dhsiljwb[jawaban] <br></p>";
     if(!empty($dhsiljwb[jfile])){
		   echo"<a href='../../tugas/$dhsiljwb[jfile]' download>Download File</a>";
		   }
    
}

	else {
	?>
                                    <form id="form_validation" method="POST" action="jawab_tugas_2" enctype="multipart/form-data">

                          <div class="form-group">
                   <label class="form-label">Jawaban Tugas Anda </label>
                       <input type='hidden' class='form-control'  aria-required='true' name='id_pembelajaran' value="<?php echo"$id_pembelajaran";?>">
                       <input type='hidden' class='form-control'  aria-required='true' name='id_tugas' value="<?php echo"$id";?>">
                       <input type='hidden' class='form-control'  aria-required='true' name='file_lama' value="<?php echo"$dhsiljwb[jfile]";?>">

            <div class="form-line ">
         <textarea name="isi"><?php echo"$dhsiljwb[jawaban]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
    
    	<div class='form-group form-float'>
             <label class='form-label'>Upload Tugas (Bisa foto atau file <span style='color:red'><?php echo"Maksimal Upload $jumlah_file";?></span>)</label>
           <br>
           <?php
           
		   if(!empty($dhsiljwb[jfile])){
		    $separated = explode(',', $dhsiljwb[jfile]);
            $i=0;
            foreach ($separated as $value) {

            if(!empty($value)){
            $i++;
		   echo"<a href='../../tugas/$value' download>Download File</a> <a href='hp?jfile=$value&d=$dhsiljwb[id]&full=$dhsiljwb[jfile]&id_pembelajaran=$id_pembelajaran&id_tugas=$id' style='color:red'>Hapus</a> <br>";
		    }
            }
		   }
		   ?>
		   <hr>
		   <?php 
		   $jumlah_file_sekrang=$jumlah_file-$i;
		   if($i>=$jumlah_file){ echo"<span style='color:red'>Sudah mencapai batas maksimal upload</span>";}?>
            <div class='form-line '>
             <input type='file' class='form-control' id="filek"  aria-required='true' name='jfile[]' multiple <?php if($i>=$jumlah_file){ echo"disabled";}?>>
            

            </div>
            </div>
            
              <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
               </form>
               <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           

            <!-- #END# Exportable Table -->
        </div>   
    </section>
   
<script>window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);
//# sourceURL=pen.js
$(document).ready(function() {

$("#filek").on("change", function() {
    if ($("#filek")[0].files.length > <?php echo"$jumlah_file_sekrang";?>) {
        alert("Anda Hanya bisa memilih <?php echo"$jumlah_file File";?>");
        $("#filek").val(null);
    } else {
       
    }
});
});
</script>

<?php include"../../inc/footerm.php";?></body>

</html>