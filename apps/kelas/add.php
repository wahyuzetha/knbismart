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
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>
<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Guru yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".select2 option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
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
                            <h2>Tambah Data Kelas</h2>
                            
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
          <form id="form_validation" method="POST" action="save">
        

         <div class="form-group form-float">
            <label class="form-label">Tingkat</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick tingkat" name="tingkat" id="tingkat">
            <option value="">-- Pilih Tingkat --</option>
            <?php
            $mpt=mysql_query("select * from tingkat order by tingkat asc");
            while($dpt=mysql_fetch_array($mpt)){ 
            ?>      
          <option value="<?php echo"$dpt[tingkat]";?>"><?php echo"$dpt[tingkat]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
            
			<!--
             <div class="form-group form-float">
            <label class="form-label">Jurusan</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick jurusan" name="jurusan" id="jurusan">
            <option value="">-- Pilih Jurusan --</option>
            <?php
            $mptj=mysql_query("select * from jurusan order by jurusan asc");
            while($dptj=mysql_fetch_array($mptj)){ 
            ?>      
          <option value="<?php echo"$dptj[jurusan]";?>"><?php echo"$dptj[jurusan]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
			-->
            
            <div class="form-group form-float">
            <div class="form-line ">
             <input type="text" class="form-control" name="kelas" required="" aria-required="true">
             <label class="form-label">Nama Kelas</label>
            </div>
            </div>
            
             <div class="form-group form-float">
            <label class="form-label">Nama Guru</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick select2" name="guru" id="guru" style="width:100%">
            <option value="">-- Pilih Guru --</option>
            <?php
            $mp=mysql_query("select * from guru");
            while($dp=mysql_fetch_array($mp)){ 
            ?>      
          <option value="<?php echo"$dp[nik]";?>"><?php echo"$dp[nama]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
           

          
         
            
            <button class="btn btn-warning waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
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