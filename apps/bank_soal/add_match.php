<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$id = anti_injection($_GET['d']);
$id_ujian = anti_injection($_GET['d']);

$m2=mysql_query("select  * from ujian where id='$id_ujian'");
$d2=mysql_fetch_array($m2);

$m=mysql_query("select  * from bank_essay where id='$id'");
$d=mysql_fetch_array($m);


$peng=mysql_query("select  * from pengaturan");
$dpeng=mysql_fetch_array($peng);



?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>
   <!--<script src='https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.2/tinymce.min.js'></script>-->
    <script src='../../plugins/tinymce/tinymce.min.js'></script>

<?php include"../../inc/tiny.php";?>


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
                            Tambah  Soal Menjodohkan
							<?php echo"$d2[pembelajaran] $d2[tingkat]";?>
                            
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
               <a href="preview?d=<?php echo"$id_ujian";?>">        
						   <button type="button" class="btn bg-pink waves-effect"><i class="material-icons">zoom_in</i> Preview</button></a>
						  
						  
          <form id="form_validation" method="POST" action="save_match" enctype="multipart/form-data">

      <div class="body">
 
<input type='hidden' name='id' value="<?php echo"$d2[id]";?>">
 <?php
	if($d2[lama_ujian]=="auto"){?>
	<label>Timer Soal Dalam Detik)
    <input type='number' class="form-control" name='timer' value='<?php echo"$d[timer]";?>' style="width:200px">
	
	<br>
	<?php } ?>
	<br>
	<span><i style='color:red;font-size:14px'>Silahkan isi sesuai contoh dibawah ini</i></label>
	
 <div class="form-group">
                   <label class="form-label">Opsi Penjodohan </label>
          
            <div class="form-line ">
         <textarea name="opsi_penjodohan"><ol>
<li>ayam</li>
<li>burung</li>
<li>Apel</li>
<li>kuda</li>
</ol></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
         
 <div class="form-group">
                   <label class="form-label">Soal dan Kunci </label>
          
            <div class="form-line ">
         <textarea name="soal_kunci">
             
             <ol>
<li>buah bulat warna hijau === 3</li>
<li>hewan berkokok === 1</li>
<li>hewan bisa terbang === 2</li>
<li>hewan makan rumput === 4</li>
</ol></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
	 <button class="btn bg-blue waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
            <a href="data?d=<?php echo"$id_ujian";?>"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
             <a href="preview?d=<?php echo"$id_ujian";?>">        
						   <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">zoom_in</i> Preview</button></a>
						  
                            </form>
    
          
    
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
   
<?php include"../../inc/footerm.php";?></body>

</html>
</html>