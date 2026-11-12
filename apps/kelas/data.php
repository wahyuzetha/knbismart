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
                               Data Kelas Tahun Ajaran <?php echo"$tahun_aktif";?>
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
                                         <?php if($_SESSION[levelu]==1 ){?>

                           <a href="add">       
                           <button type="button" class="btn bg-orange waves-effect">
                           <i class="material-icons">add</i> Tambah</button></a>
                           
                          
                           <hr>
                           <?php } ?>
                                    <thead class="bg-green">
                                        <tr>
                                            <th>KELAS</th>
                                         <!--   <th>JURUSAN</th>-->
                                            <th>NAMA WALI</th>
                                         <?php if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1 ){?>

                                            <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;
           
          $m=mysql_query("SELECT guru.nama,kelas.* from kelas
LEFT JOIN guru on kelas.wali=guru.nik where kelas.tahun_ajaran='$tahun_aktif'");   
      
            while($d=mysql_fetch_array($m)){ 
            $no++;     
		?>      
           
                  <tr>
                <td width="30%"><?php echo"$d[nama_kelas]";?></td>
                <td width="30%"><?php echo"$d[nama]";?></td>
                                         <?php if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1){?>

                  <td width="30%">
                   <form action="edit" method="post"> 
                  <a href="../../apps/kelas_siswa/data?d=<?php echo"$d[nama_kelas]";?>">                
                  <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">supervisor_account</i> Anggota Rombel</button>
</a> 
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
                <button type="submit" class="btn bg-green waves-effect"><i class="material-icons">mode_edit</i></button>
                
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
                   <button type="submit" class="btn btn-danger waves-effect"><i class="material-icons">delete</i> HAPUS</button>

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
               </td>
                              <?php } ?>         
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