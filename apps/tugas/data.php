<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m2=mysql_query("select  * from pembelajaran where id='$id'");
$d2=mysql_fetch_array($m2);

$_SESSION[id_pembelajaran_mtns]=$id;
$_SESSION[jenis_baca]="non";

?>
<!DOCTYPE html>
<html>

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
    
    <section class="content">
     <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                    <div class="card">
                        <div class="header">
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
    
                            <h2>
                               Tugas <?php echo"$d2[pembelajaran] $d2[tingkat]";?>
                            </h2>
                         </div>
                        <div class="body">
                          
                                   <a href="add?d=<?php echo"$d2[id]";?>">        <button type="button" class="btn bg-orange waves-effect"><i class="material-icons">add</i> Tambah</button></a><hr>
                          
<table id='empTable' class='display dataTable' style="width:100%">
                                    <thead class="bg bg-green">
                                        <tr>  
                                            
                                            <th width="60%">DETAIL</th>
                                         
                                      <?php if($_SESSION[levelu]!=3){ ?>      <th>ACTION</th> <?php } ?>
                                           
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
          'url':'table_materi.php'
      },
      'columns': [
         { data: '1' },

        <?php if($_SESSION[levelu]!=3){ ?>
         { data: 'aksi' },
         <?php } ?>
      ]
   });
});
</script>
</html>