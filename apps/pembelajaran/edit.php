<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_POST['d']);

$m2=mysql_query("select  * from pembelajaran where id='$id'");
$d2=mysql_fetch_array($m2);

?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>


<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Kelas yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".select2 option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
 
     $(function(){
       $('.ptk').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Guru yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".ptk option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
 
</script>
</head>
<script type="text/javascript">
$(document).ready(function() {
    
     var tingkat ="<?php echo"$d2[tingkat]";?>";
     var kelas ='<?php echo"$d2[kelas]";?>';

    var dataString = 'tingkat='+tingkat+'&kelas='+kelas;
    $.ajax({
      type: "POST",
      url: "getkelas.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".kelas").html(html);
      } 
    });
    
  $(".tingkat").change(function() {
    var tingkat =$(this).val();
    var dataString = 'tingkat='+tingkat;
    $.ajax({
      type: "POST",
      url: "getkelas.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".kelas").html(html);
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
                            <h2>Edit Data Pembelajaran</h2>
                            
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
          <form id="form_validation" method="POST" action="saveedit">


            <div class="form-group form-float">
            <label class="form-label">Guru</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick provinsi" name="nuptk" id="provinsi">
            <?php
            if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1){
            ?>    
            <option value="">-- Pilih Guru --</option>
            <?php
            $mp=mysql_query("select * from guru order by nama asc");
             }
            else if($_SESSION[levelu]==2){
             $mp=mysql_query("select * from guru where nik='$_SESSION[id_pengguna]' order by nama asc");
            }
            while($dp=mysql_fetch_array($mp)){
                if($dp[nik]==$d2[nuptk]){
            ?>      
          <option value="<?php echo"$dp[nik]";?>" selected><?php echo"$dp[nama]";?></option>

              <?php } 
              else { 
              ?>    
              <option value="<?php echo"$dp[nik]";?>"><?php echo"$dp[nama]";?></option>
              <?php } }?>
              </select>
                                
            </div>
            </div>


 
         
		  <div class="form-group form-float">
            <label class="form-label">Tingkat</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick provinsi" required name="tingkat" id="provinsi">
          <option value=""><?php echo"Pilih Tingkat";?></option>
             
			 <?php
            $mpjt=mysql_query("select * from tingkat order by tingkat asc");
            while($dpjt=mysql_fetch_array($mpjt)){ 
			if($dpjt[tingkat]==$d2[tingkat]){
			$pilt="selected";
			}
			else {
			$pilt="";
			}
            ?>      
          <option value="<?php echo"$dpjt[tingkat]";?>" <?php echo"$pilt";?>><?php echo"$dpjt[tingkat]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
            
            <div class="form-group form-float">
            <label class="form-label">Kelas 
			</label>
            <br>
            <select class="form-control show-tick provinsi select2 kelas" name="kelas[]" id="kelas" multiple style="width:100%">
        
              </select>
                                
            </div>
            
         
                    <input type="hidden" class="form-control" name="id" required="" aria-required="true" value="<?php echo"$d2[id]";?>">
            
            <div class="form-group form-float">
			             <label class="form-label">Nama Mapel</label>

            <div class="form-line ">
             <input type="text" class="form-control" name="pembelajaran" required="" aria-required="true" value="<?php echo"$d2[pembelajaran]";?>">
            </div>
            </div>



          
         
            
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
   
    

</html>
</html>