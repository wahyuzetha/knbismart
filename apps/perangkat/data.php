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
                               PERANGKAT PEMBELAJARAN
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
                                         <?php if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7){?>

                           <a href="add">       
                           <button type="button" class="btn bg-light-blue waves-effect">
                           <i class="material-icons">add</i> Tambah</button></a>
                           
                          
                           <hr><?php } ?>
                                    <thead class="bg-green">
                                        <tr>
                                            <th>DETAIL</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;
           
          $m=mysql_query("select  * from perangkat");   
      
            while($d=mysql_fetch_array($m)){ 
            $no++;     
            $tgl=date('d/m/Y', strtotime($d[tgl_batas])); 
		?>      
           
                  <tr>
                <td width="50%"><?php echo"<h4>$d[nama_perangkat]</h4> <hr> $d[keterangan] <br> Batas Pengumpulan $tgl";?></td>
                  <td>
                   <form action="edit" method="post"> 
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
               
                <a href="../../apps/perangkat_detail/data_m?d=<?php echo"$d[id]";?>">               
                <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">book</i> Detail Isi</button>
                </a>
               
                 <?php if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7){?>
                <button type="submit" class="btn bg-blue waves-effect"><i class="material-icons">mode_edit</i></button>
                
                <button type="button" class="btn bg-red waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$d[id]";?>"><i class="material-icons">delete</i></button>
                     <?php } ?>
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