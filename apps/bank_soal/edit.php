<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$id = anti_injection($_GET['d']);
$id_ujian = anti_injection($_GET['id_ujian']);

$m2=mysql_query("select  * from ujian where id='$id_ujian'");
$d2=mysql_fetch_array($m2);

$m=mysql_query("select  * from bank_soal where id='$id'");
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
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>

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

    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Kunci yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".select2 option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
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
                            <h2>Edit Soal  <?php echo"$d2[nama_ujian]";?></h2>
                            
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
						  
          <form id="form_validation" method="POST" action="saveedit" enctype="multipart/form-data">

      <div class="body">
 
<input type='hidden' name='id' value="<?php echo"$d[id]";?>">
<input type='hidden' name='id_ujian' value="<?php echo"$d[id_ujian]";?>">
 <?php
	if($d2[lama_ujian]=="auto"){?>
	<label>Timer Soal Dalam Detik)
    <input type='number' class="form-control" name='timer' value='<?php echo"$d[timer]";?>' style="width:200px">
	
	<br>
	<?php } ?>
 <div class="form-group">
                   <label class="form-label">Soal / Pertanyaan </label>
          
            <div class="form-line ">
         <textarea name="soal"><?php echo"$d[soal]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
         
 <div class="form-group">
                   <label class="form-label">OPSI A </label>
          
            <div class="form-line ">
         <textarea name="opsia"><?php echo"$d[pila]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
    
<div class="form-group">
                   <label class="form-label">OPSI B </label>
          
            <div class="form-line ">
         <textarea name="opsib"><?php echo"$d[pilb]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>    

<div class="form-group">
                   <label class="form-label">OPSI C </label>
          
            <div class="form-line ">
         <textarea name="opsic"><?php echo"$d[pilc]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>            
           
 <div class="form-group">
                   <label class="form-label">OPSI D </label>
          
            <div class="form-line ">
         <textarea name="opsid"><?php echo"$d[pild]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>         
 <?php if($dpeng[split_import]=="ya"){?>	

<div class="form-group">
                   <label class="form-label">OPSI E </label>
          
            <div class="form-line ">
         <textarea name="opsie"><?php echo"$d[pile]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>     
   
 <?php } ?>
        <div class="form-group form-float">
            <label class="form-label">Kunci Jawaban</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick select2" required name="kunci[]" multiple>
            <option value="">-- Pilih --</option>
            <?php
            
			$kunci=strtoupper($d[kunci]);
			$kunci=explode(",",$kunci);
            $mp1=mysql_query("select * from kunci");
            while($dp1=mysql_fetch_array($mp1)){ 
                
          
			
			$lokasi_ar=array();
			foreach($kunci as $kuncis) { 
			
			if($dp1[kunci]==$kuncis){
			$lokasi_ar[]="selected";

			}
			else {
			$lokasi_ar[]="";
			
			}
			}
			
			               $pilj=implode("",$lokasi_ar);

                 ?>          
           

             
                <option value="<?php echo"$dp1[kunci]";?>" <?php echo"$pilj";?>><?php echo"$dp1[kunci]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
            <!--
            <div class="form-group">
                          <label class="form-label">Point Nilai </label>
         
            <div class="form-line ">
          
         <input type='text' name='point' class='form-control' value="<?php echo"$d[point]";?>">

    </div>
    </div>
    -->
            <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
            <a href="data?d=<?php echo"$id_ujian";?>"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
             <a href="preview?d=<?php echo"$id_ujian";?>">        
						   <button type="button" class="btn bg-pink waves-effect"><i class="material-icons">zoom_in</i> Preview</button></a>
						  
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
   
<?php include"../../inc/footernojs.php";?>


</body>

</html>