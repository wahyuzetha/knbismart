<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
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
<?php include"../../inc/sidebar.php";?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    
    <section class="content">
     <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
         
                            <h2>
                               Data Admin
                            </h2>
                         </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                           <a href="add">         <button type="button" class="btn bg-light-blue waves-effect"><i class="material-icons">add</i> Tambah</button></a>
                                    <thead class="bg-blue">
                                        <tr>
                                            <th>Username</th>
                                            <th>Data user</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;
            if($_SESSION[levelu]==1){ 
            $m=mysql_query("select * from users where level='1'");
        }
        else {
           $m="";   
        }
            while($d=mysql_fetch_array($m)){ 
            $no++;     
              if(!empty($d[foto])){
      $ft="<img src='../../foto/$d[foto]' width='80px'>";
  }  
  else {
      $ft="<img src='../../css/nopic.png' width='80px'>";
  }
            ?>      
           
                  <tr>
                <td width="20%"><?php echo"$ft";?></td>
                 <td width="40%"><?php echo"$d[username]";?></td>
                  <td>
                     <form action="edit" method="post"> 
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
                <button type="submit" class="btn bg-pink waves-effect">
                    <i class="material-icons">mode_edit</i>Ubah</button>
                
                <button type="button" class="btn bg-red waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$d[id]";?>"><i class="material-icons">delete</i>Hapus</button>
                    </form>
                  
                    <div class="modal fade" id="smallModal<?php echo"$d[id]";?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-red">
                            <h4 class="modal-title bg" id="smallModalLabel">Konfirmasi Hapus</h4>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin mau menghapus data ini?      </div>
                        <div class="modal-footer">
                            <a href="del?d=<?php echo"$d[id]";?>">
                            <button type="button" class="btn btn-danger waves-effect"><i class="material-icons">delete</i> HAPUS</button></a>
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
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
}, 1000);
//# sourceURL=pen.js
</script>
<?php include"../../inc/footerm.php";?></body>

</html>