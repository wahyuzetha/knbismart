<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);


$m2=mysql_query("SELECT guru.nama,pembelajaran.* from pembelajaran,guru
WHERE guru.nik=pembelajaran.nuptk and pembelajaran.id='$id'");
$d2=mysql_fetch_array($m2);

$m3=mysql_query("SELECT * from perangkat where id='$_SESSION[id_perangkat_s]'");
$d3=mysql_fetch_array($m3);


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
                               Perangkat <?php echo"$d3[nama_perangkat] - $d2[pembelajaran] - $d2[nama]";?>
                            </h2>
                         </div>
                        <div class="body">
                            <!--
                           <form action="data" method="POST">
                            <input type="text" class="form-control" name="cari" placeholder="Cari Nama Guru">  
                            <input type="submit" class="btn btn-success" value="Cari">  
                           </form>
                          <hr>
                          -->
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                           <a href="add?d=<?php echo"$d2[id]";?>">     
                           <button type="button" class="btn bg-orange waves-effect"><i class="material-icons">add</i> Upload</button></a><hr>
                                    <thead class="bg-green">
                                        <tr>
                                            <th>DETAIL</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            
            $m=mysql_query("select  * from detail_perangkat where id_pembelajaran='$d2[id]' and id_perangkat='$d3[id]'");   
            while($d=mysql_fetch_array($m)){
              
            $no++;     
            ?>      
           
                  <tr>
                <td width="50%"><?php echo"$d[nama_perangkat] <br>";?>
                 <?php
		   if(!empty($d[file])){
		   echo"<a href='../../file/$d[file]' download>Download File</a>";
		   }
		   ?>
                </td>
                  <td>
                   <form action="edit" method="get"> 
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
                 <input type="hidden" name="id_pembelajaran" value="<?php echo"$d[id_pembelajaran]";?>">
                <button type="submit" class="btn bg-pink waves-effect"><i class="material-icons">mode_edit</i></button>
                
                <button type="button" class="btn bg-red waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$d[id]";?>"><i class="material-icons">delete</i></button>
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
                            <form action="del" method="post"> 
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
                 <input type="hidden" name="id_pembelajaran" value="<?php echo"$d[id_pembelajaran]";?>">
                   <button type="submit" class="btn btn-danger waves-effect"><i class="material-icons">delete</i> HAPUS</button>

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
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