<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
if(!empty($id)){
    $_SESSION[kelas_c]=$id;
}
else {
        $_SESSION[kelas_c]=$_SESSION[kelas_c];

}
$m=mysql_query("SELECT guru.nama,kelas.* from kelas
LEFT JOIN guru on kelas.wali=guru.nuptk where kelas.tahun_ajaran='$tahun_aktif' and kelas.nama_kelas='$_SESSION[kelas_c]'");   
$d=mysql_fetch_array($m);


?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                             Anggota Rombel Kelas <?php echo"$d[nama_kelas] $tahun_aktif ";?>
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
                                  <a href="add">        
                                  <button type="button" class="btn bg-light-blue waves-effect"><i class="material-icons">add</i> Tambah</button></a>
								  
								   <a href="import">        <button type="button" class="btn bg-green waves-effect"><i class="material-icons">import_export</i> Import Excel</button></a>
        
                                  <hr>
                         
         
        <div class="table-responsive">
      
<table id='empTable' class='display dataTable' style="width:100%">
                                    <thead class="bg bg-green">
                                        <tr>  
                                            
                                            <th>NIS</th>
                                            <th>NAMA</th>

											  <th>PASSWORD</th>


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
         { data: 'nis' },
        { data: 'nama' },

        { data: 'no_telp' },
        <?php if($_SESSION[levelu]==1){ ?>
         { data: 'aksi' },
         <?php } ?>
      ]
   });
});
</script>
</html>