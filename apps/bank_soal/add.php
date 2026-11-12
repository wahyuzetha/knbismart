<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m2=mysql_query("select  * from ujian where id='$id'");
$d2=mysql_fetch_array($m2);

$peng=mysql_query("select  * from pengaturan");
$dpeng=mysql_fetch_array($peng);

if(!empty($_GET[j])){
    $_SESSION[jenis_soal_o]=$_GET[j];
}
else {
   $_SESSION[jenis_soal_o]=$_SESSION[jenis_soal_o]; 
}

if($_SESSION[jenis_soal_o]=="pilgan"){
    $jns="Pilihan Ganda";
    $_SESSION[jenis_soal_k]="";
}
else if($_SESSION[jenis_soal_o]=="multi"){

    $jns="Multiple Respon ";
    $_SESSION[jenis_soal_k]="multi";
}

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>
  <!--<script src='https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.2/tinymce.min.js'></script>-->
    <script src='../../plugins/tinymce/tinymce.min.js'></script>
	<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>

<?php include"../../inc/tiny.php";?>
<script type="text/javascript">
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
                            <h2>Tambah Soal 
							<?php echo" $jns $d2[pembelajaran] $d2[tingkat]";?>
                            
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
    
    <input type='hidden' name='id' value="<?php echo"$d2[id]";?>">
	<?php
	if($d2[lama_ujian]=="auto"){?>
	<label>Timer Soal Dalam Detik)
    <input type='number' class="form-control" name='timer' value='60' style="width:200px">
	
	<br>
	<?php } ?>
  <div class="form-group">
                   <label class="form-label">Soal / Pertanyaan </label>
          
            <div class="form-line ">
         <textarea name="soal"></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
         
 <div class="form-group">
                   <label class="form-label">OPSI A </label>
          
            <div class="form-line ">
         <textarea name="opsia"></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
    
<div class="form-group">
                   <label class="form-label">OPSI B </label>
          
            <div class="form-line ">
         <textarea name="opsib"></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>    

<div class="form-group">
                   <label class="form-label">OPSI C </label>
          
            <div class="form-line ">
         <textarea name="opsic"></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>            
           
 <div class="form-group">
                   <label class="form-label">OPSI D </label>
          
            <div class="form-line ">
         <textarea name="opsid"></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div> 
<?php if($dpeng[split_import]=="ya"){?>	
 <div class="form-group">
                   <label class="form-label">OPSI E </label>
          
            <div class="form-line ">
         <textarea name="opsie"></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>     
<?php } ?>
       <div class="form-group form-float">
            <label class="form-label">Kunci Jawaban</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick select2" required name="kunci[]" multiple style="width:100%">
            <option value="">-- Pilih --</option>
            <?php
            $mp1=mysql_query("select * from kunci");
            while($dp1=mysql_fetch_array($mp1)){ 
             if($dp1[kunci]==$d[kunci]) {
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
            <a href="data?d=<?php echo"$id";?>"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
   
<?php include"../../inc/footernojs.php";?></body>

</html>