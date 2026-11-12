<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$id = anti_injection($_POST['d']);
$id_ujian = anti_injection($_POST['id_ujian']);

$m2=mysql_query("select  * from ujian where id='$id_ujian'");
$d2=mysql_fetch_array($m2);

$m=mysql_query("select  * from bank_soal where id='$id'");
$d=mysql_fetch_array($m);





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
          <form id="form_validation" method="POST" action="saveedit" enctype="multipart/form-data">

      <div class="body">
 
<input type='hidden' name='id' value="<?php echo"$d[id]";?>">
<input type='hidden' name='id_ujian' value="<?php echo"$d[id_ujian]";?>">
 
 <div class="form-group">
                   <label class="form-label">Soal / Pertanyaan </label>
          
            <div class="form-line ">
         <textarea rows="10" style="width:100%" name="soal"><?php echo"$d[soal]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
         
 <div class="form-group">
                   <label class="form-label">OPSI A </label>
          
            <div class="form-line ">
         <textarea rows="10" style="width:100%" name="opsia"><?php echo"$d[pila]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
    
<div class="form-group">
                   <label class="form-label">OPSI B </label>
          
            <div class="form-line ">
         <textarea rows="10" style="width:100%" name="opsib"><?php echo"$d[pilb]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>    

<div class="form-group">
                   <label class="form-label">OPSI C </label>
          
            <div class="form-line ">
         <textarea rows="10" style="width:100%" name="opsic"><?php echo"$d[pilc]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>            
           
 <div class="form-group">
                   <label class="form-label">OPSI D </label>
          
            <div class="form-line ">
         <textarea rows="10" style="width:100%" name="opsid"><?php echo"$d[pild]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>         
 
<div class="form-group">
                   <label class="form-label">OPSI E </label>
          
            <div class="form-line ">
         <textarea rows="10" style="width:100%" name="opsie"><?php echo"$d[pile]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>     
    
       <div class="form-group form-float">
            <label class="form-label">Kunci Jawaban</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick" required name="kunci">
            <option value="">-- Pilih --</option>
            <?php
			$kunci=strtoupper($d[kunci]);
            $mp1=mysql_query("select * from kunci");
            while($dp1=mysql_fetch_array($mp1)){ 
             if($dp1[kunci]==$kunci) {
                 ?>          
           
          <option value="<?php echo"$dp1[kunci]";?>" selected><?php echo"$dp1[kunci] ";?></option>

              <?php } 
              else { ?>
                <option value="<?php echo"$dp1[kunci]";?>"><?php echo"$dp1[kunci]";?></option>

              <?php } }?>    
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
   
<?php include"../../inc/footerm.php";?></body>

</html>