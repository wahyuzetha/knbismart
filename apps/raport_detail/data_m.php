<?php 
session_start();
if($_SESSION[levelu]==3){
	header('Loction: ../../apps/dashboard/data_siswa');
	echo"<script>window.location = 'data_siswa';</script>";
}
else {
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$id = anti_injection($_GET['d']);

$m2=mysql_query("select  * from raport where id='$id'");
$d2=mysql_fetch_array($m2);

if(!empty($id)){
    $_SESSION[id_perangkat_s]=$id;
}
else {
    $_SESSION[id_perangkat_s]=$_SESSION[id_perangkat_s];
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
                              DETAIL <?php echo"$d2[nama_raport]";?>
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
	
                          
        <div class="table-responsive">
                  
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        
                                    <thead class="bg-green">
                                        <tr>
                                            <th>KELAS</th>
                                         <!--   <th>JURUSAN</th>-->
                                            <th>NAMA WALI</th>
                                         <?php if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1 or $_SESSION[wali_kelas]!=""){?>

                                            <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;
           if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1){
		   $kls="";
		   }  
		else if($_SESSION[wali_kelas]!=""){
		$kls=" and kelas.wali='$_SESSION[namauser]'";
		}
		  
          $m=mysql_query("SELECT guru.nama,kelas.* from kelas
LEFT JOIN guru on kelas.wali=guru.nik where kelas.tahun_ajaran='$d2[tahun_ajaran]' $kls");   
      
            while($d=mysql_fetch_array($m)){  
            $no++;     
		?>      
              
                  <tr>
                <td width="30%"><?php echo"$d[nama_kelas] ";?></td>
                <td width="30%"><?php echo"$d[nama]";?></td>

                  <td width="30%">
                   <form action="edit" method="post"> 
                  <a href="../../apps/raport_detail/data?d=<?php echo"$d[nama_kelas]&id_raport=$d2[id]";?>">                
                  <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">supervisor_account</i> Upload Raport</button>
</a> 
              
                     
               </td>
                                        </tr>
                    <?php } ?>                    
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

</html>
<?php } ?>