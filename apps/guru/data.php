<?php 
session_start();
if($_SESSION[levelu]==3){
	header('Loction: data_siswa');
	echo"<script>window.location = '../../apps/dashboard/data_siswa';</script>";
}
else {
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
if($_SESSION[levelu]==1){
}
else if($_SESSION[levelu]==2){
if($_SESSION[jabatan_guru]==7){
}
else if($_SESSION[jabatan_guru]==1){     
}
else {
header('Location: edit');    
}
    
}


?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
</head>

<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include"../../inc/sidebar.php";
 $tgls=date('Y-m-d'); 
           $tgl_awal=date('Y-m-d', strtotime('-7 days', strtotime($tgls)));
          
        $tgl_akhir=date('Y-m-d');
?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
 <!-- Datatable CSS -->
<link href='../../css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

<!-- jQuery Library -->
<script src="../../jjquery.min.js"></script>

<!-- Datatable JS -->
<script src="../../js/jquery.dataTables.min.js"></script>
 
    <section class="content">
            <!-- Exportable Table -->
            <div class="row">
               
                    <div class="card">
                        <div class="header">
                       
    
                            <h2>
                              Data PTK 
                            </h2>
                            
                         </div>
                        <div class="body">
                                                          <?php
        error_reporting(0);
    if($_GET[h]=="sukses"){ ?>    
    <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Berhasil!! </strong> <p>Data Berhasil Di Simpan</p> </div>
    <?php } 
     else  if($_GET[h]=="suksesh"){ ?>    
    <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Berhasil! </strong> <p>Data Berhasil Di Hapus</p>  </div>
    <?php } 
  
        else if($_GET[h]=="gagal") {
       ?>    
    <div class="alert alert-danger" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Gagal!! <br> <?php echo"$_GET[pesan]";?> </strong>  </div>
    <?php
        }
    ?>
    
                    <?php if($_SESSION[levelu]==1){?>

                                  <a href="add">        
                                  <button type="button" class="btn bg-light-blue waves-effect"><i class="material-icons">add</i> Tambah</button></a>
								  
								   <a href="import">        <button type="button" class="btn bg-green waves-effect"><i class="material-icons">import_export</i> Import Excel</button></a>
          <!--
           <button type="button" class="btn bg-red waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$d[id]";?>"><i class="material-icons">delete</i> Reset</button>
       
          <div class="modal fade" id="smallModal<?php echo"$d[id]";?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-red">
                            <h4 class="modal-title bg" id="smallModalLabel">Konfirmasi Reset</h4>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin mau MERESET data :<br>
                            1. Data Guru <br>
                            2. Data Users Password<br>

                            </div>
                        <div class="modal-footer">
                            <form action="reset" method="post"> 
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
                   <button type="submit" class="btn btn-danger waves-effect"><i class="material-icons">delete</i> HAPUS</button>

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>-->
                                  <hr><?php } ?>
                         
 <?php
$_SESSION[cari]=$_POST[cari];
$_SESSION[tgl_awal]=$_POST[tgl_awal];
$_SESSION[tgl_akhir]=$_POST[tgl_akhir];

 ?>           
        <div class="table-responsive">
      
<table id='empTable' class='display dataTable' style="width:100%">
                                    <thead class="bg bg-green">
                                        <tr>  
											  <th>FOTO</th>
                                            
											  <th>USERNAME</th>
                                            <th>NAMA</th>
										<!--
										 <th>TGL LAHIR</th>

											  <th>ALAMAT</th>
											  <th>NO TELP</th>
											  -->
											  <th>JABATAN</th>


                                      <?php if($_SESSION[levelu]==1){ ?>      <th>ACTION</th> <?php } ?>
                                           
                                        </tr>
                                    </thead>
                     <tbody>
                  
                 
           
                                       
                                       </tbody>
                                </table>
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
}, 5000);
//# sourceURL=pen.js
</script>
<?php include"../../inc/footerm.php";?></body>
<script type="text/javascript">
  $(document).ready(function(){
   $('#empTable').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':'table.php'
      },
      'columns': [
         { data: 'foto' },
         { data: 'username' },
        { data: 'nama' },
       /* { data: 'tgl_lahir' },
		{ data: 'alamat' },
        { data: 'no_telp' },*/
        { data: 'jabatan' },

        <?php if($_SESSION[levelu]==1){ ?>
         { data: 'aksi' },
         <?php } ?>
      ]
   });
});
</script>
</html>
<?php } ?>