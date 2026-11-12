<?php 
ini_set('date.timezone', 'Asia/Jakarta');
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
$_SESSION[dujian]=$id;
$m2=mysql_query("SELECT siswa.nis,kelas.tingkat from siswa,kelas
WHERE siswa.kelas=kelas.nama_kelas and kelas.tahun_ajaran='$tahun_aktif' and siswa.nis='$_SESSION[namauser]'");
$d2=mysql_fetch_array($m2);

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
</head>

<?php include"../../inc/nav.php";?>
 <script src="../../js/jquery-1.11.2.min.js"></script>

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
    
                            <h4>
                              RAPORT <?php echo"";?>
                            </h4>
                        
                        <div class="body">
                            <!--
                           <form action="data" method="POST">
                            <input type="text" class="form-control" name="cari" placeholder="Cari Nama Guru">  
                            <input type="submit" class="btn btn-success" value="Cari">  
                           </form>
                          <hr>
                          -->
                                <table class="table table-bordered" id="example">
                                    <thead class="bg-green">
                                        <tr>
                                            <th>DETAIL</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;
			$tgl_c=date('Y-m-d H:i:s');
             $peng=mysql_query("select * from pengaturan where id='1'");   
             $dpeng=mysql_fetch_array($peng);
                $jam=date('H:i:s');
				
				  $m=mysql_query("SELECT * from raport where tanggal_buka<='$tgl_c'"); 

            while($d=mysql_fetch_array($m)){
				
				
            ?>      
           
                  <tr>
                <td width="50%"><?php echo"<h4>$d[nama_raport]</h4> ";
						   echo"<a href='v_raport?d=$d[id]'><button type='button' class='btn bg-green waves-effect'><i class='material-icons'>print</i> Cetak</button></a>";

				
				?> <br><br>
               
                 
               </td>
                                       
                                        </tr>
                    <?php }?>                    
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
   
<script>


window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);
//# sourceURL=pen.js
</script>

<script type="text/javascript">
  $(document).ready(function(){
 $('#example').dataTable( {
  "ordering": false
} );
});
</script>

  <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

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


   <!-- Custom Js -->
   <script src="../../js/pages/ui/dialogs.js"></script>
  
    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
     <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

   
    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>

</html>