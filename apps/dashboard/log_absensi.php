<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";

?>
<!DOCTYPE html>
<html>
      <script src="../../js/jquery-1.11.2.min.js"></script>


<head>
<?php include"../../inc/meta.php"; ?>

<link href='../../css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

</head>

<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include"../../inc/sidebar.php";?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    <br>
    <section class="content">
<div class="col-md-12" style="margin-top: -33px"> 

            <?php
            echo"<h4>Log Absensi </h4> <h5>Di ambil dari data membaca materi";
            ?>
            <hr>
          </div>
          <div class="row">
          



    <div class="col-md-12">
<table id='empTable' class='display dataTable' style="width:100%">
                                        <thead class="bg bg-green">
                                        <tr> 
                                        <td>DATA</td>
                                        </tr>
                                        </table>
                            </div>
                         
                            <div class="col-md-6 ppdb">
                                
                            </div>
                          
                            </div>
                            </div>
            <!-- #END# Widgets -->
           
  </section>
   
<?php include"../../inc/footerm.php";?></body>

    <script type="text/javascript">
  $(document).ready(function(){
   
   $('#empTable').DataTable({
      'processing': true,
      'serverSide': true,
      'ordering':false,
        "lengthChange": false,

      'serverMethod': 'post',
      'ajax': {
          'url':'table_log_absen.php'
      },
      'columns': [
        { data: 'kategori' },
      ]
   });
});
</script>
</body>
</body>

</html>