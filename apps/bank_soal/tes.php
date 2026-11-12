<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m3=mysql_query("select  * from ujian where id='$id'");
$d3=mysql_fetch_array($m3);

$m2=mysql_query("select  * from pembelajaran where id='$d3[id_pembelajaran]'");
$d2=mysql_fetch_array($m2);


?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
<script src="../../plugins/tinymce/plugins/tiny_mce_wiris/integration/WIRISplugins.js?viewer=image"></script>

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
                               Bank Soal Ujian <?php echo"$d3[nama_ujian]";?>, Pembelajaran <?php echo"$d2[pembelajaran]";?>
                            </h2>
							<p><math xmlns="http://www.w3.org/1998/Math/MathML"><mn>1</mn><msqrt><mn>2</mn></msqrt></math>Apa yang kamu ketahui mengenai rem yang paling tepat&hellip;.</p>

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
                           <a href="add?d=<?php echo"$d3[id]";?>">        
						   <button type="button" class="btn bg-light-blue waves-effect"><i class="material-icons">add</i> Tambah</button></a>
						   
						   <a href="import?d=<?php echo"$d3[id]";?>">        
						   <button type="button" class="btn bg-green waves-effect"><i class="material-icons">import_export</i> Import Excel</button></a>
						   
						   <a href="preview?d=<?php echo"$d3[id]";?>" target="_NEW">        
						   <button type="button" class="btn bg-pink waves-effect"><i class="material-icons">zoom_in</i> Preview</button></a>
						   
						   
						   <hr>
                                   <?php 
                          $t=mysql_query("select  sum(point) as jum from bank_soal where id_ujian='$d3[id]'");  
                            $dt=mysql_fetch_array($t);
                          
                          echo"<b>Total Point Nilai = $dt[jum]</b>";?>
                                   
                                    <thead class="bg-blue">
                                        <tr>
									<th>NO</th>

                                            <th>DETAIL</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $nop=0;
          $m=mysql_query("select  * from bank_soal where id_ujian='$d3[id]' order by id asc");   
        
            while($d=mysql_fetch_array($m)){
                $nop++;
                $dm=mysql_query("select  * from guru where nuptk='$d[nuptk]'");   
                $guru=mysql_fetch_array($dm);
            $no++;     
            ?>      
           
                  <tr>
				                  <td width="5%"><?php echo"<b>$nop</b>";?><hr>

                <td width="70%"><?php echo"$d[soal]";?><hr>
                <?php
                $m4=mysql_query("select  * from bank_opsi where id_ujian='$d3[id]' and id_soal='$d[id]'");   
        
            while($d4=mysql_fetch_array($m4)){
				$desk=$d4[deskripsi];
				$desk=str_ireplace('<p>','',$desk);
				$desk=str_ireplace('</p>','',$desk);   
               echo"$d4[opsi] = $desk <hr>"; 
                 }
                 echo"<b>Kunci : $d[kunci] <br> Point Nilai : $d[point]</b>";
                ?>
                
                </td>
                  <td>
                   <form action="edit" method="post"> 
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
                 <input type="hidden" name="id_ujian" value="<?php echo"$d[id_ujian]";?>">
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
                 <input type="hidden" name="id_ujian" value="<?php echo"$d[id_ujian]";?>">
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