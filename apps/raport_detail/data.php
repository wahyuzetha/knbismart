<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id_raport = anti_injection($_GET['id_raport']);
$kelas = anti_injection($_GET['d']);

if(!empty($id_raport)){
$_SESSION[id_raport_k]=$id_raport;
}
else {
$_SESSION[id_raport_k]=$_SESSION[id_raport_k];
}

if(!empty($kelas)){
$_SESSION[kelas_k]=$kelas;
}
else {
$_SESSION[kelas_k]=$_SESSION[kelas_k];
}


$m2=mysql_query("select  * from raport where id='$_SESSION[id_raport_k]'");
$d2=mysql_fetch_array($m2);




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
                                <?php echo"UPLOAD $d2[nama_raport] - $_SESSION[kelas_k]";?>
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
                                            <th>NIS</th>
                                            <th>STATUS</th>
                                            <th>RAPORT</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $i=0;
            $m=mysql_query("
			select  raport_detail.* from raport_detail,kelas
 where
raport_detail.id_kelas=kelas.nama_kelas and kelas.tahun_ajaran='$d2[tahun_ajaran]' AND 
raport_detail.id_raport='$d2[id]' and raport_detail.id_kelas='$_SESSION[kelas_k]'");   
            while($d=mysql_fetch_array($m)){
              $i++;
            $no++;     
            ?>      

                 <?php
		  
		   $folder="../raport_file/$_SESSION[id_raport_k]/$_SESSION[kelas_k]/";

		     $ms=mysql_query("select  * from siswa where nis='$d[nis]'");   
             $ds=mysql_fetch_array($ms);
		   
			 if(!empty($ds[nis])){
				 $sts="<span class='badge bg-green'>Valid :  $ds[nama]</span>";
			 }
			 else {
			 	$sts="<span class='badge bg-red'>Tidak Valid (Data File Tidak Match)</span>";
			 }
			 

			  if($d[aktif]==2){
$status="<span style='color:red'>Non Aktif</span>";

  }
else {
$status="<span style='color:green'>Aktif</span>";

}	
			 
		   ?>
           
                  <tr>
                <td width="10%"><?php echo"$d[nis] ";?></td>
                <td width="30%"><?php echo"$sts <br> $status";?></td>
                <td width="40%"><?php  
				
	 
  if($d[aktif]==2){
  $cheked_peserta="checked";
  }
  else {
  $cheked_peserta="";		
  }
  
  
  
if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==1 or $_SESSION[jabatan_guru]==7  or$_SESSION[wali_kelas]!=""){
  $blok="<input type='checkbox' id='basic_checkbox_pstl$i' class='blok_siswa filled-in' value='2' name='aktif' data-id='$d[nis]' data-column='aktif' $cheked_peserta>
		<label for='basic_checkbox_pstl$i'>Blok Akses Raport</label>";
  }
  else {
  $blok="";
  }

echo"$blok <br>";

				if(!empty($d[file])){
		   echo"<a href='$folder/$d[file]' download><button type='button' class='btn bg-green waves-effect'><i class='material-icons'>print</i> Download</button></a>";
		   echo"<a href='view?d=$d[id]' target='_NEW'><button type='button' class='btn bg-green waves-effect'><i class='material-icons'>print</i> Preview</button></a>";
		   
		 

		   }?></td>

                  <td>
                
                <button type="button" class="btn bg-red waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$d[id]";?>"><i class="material-icons">delete</i></button>
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
                 <input type="hidden" name="file" value="<?php echo"$d[file]";?>">
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
<script>
function update_data(id, column_name, value)
  {
   $.ajax({
    url:"update_aktif.php",
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     
$.notify({
  // options
  message: 'Data Berhasil di simpan, untuk mengecek silahkan refresh' 
},{
  // settings
  type: 'success'
});
           //alert("sukses");
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#user_data').DataTable().destroy();
    // fetch_data();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }
  
   $(document).on('change', '.blok_siswa', function(){
   var id = $(this).data("id");
      
var ischecked= $(this).is(':checked');
                    if(!ischecked){
   var value = 1;
					}
					else {
	var value=2;				
					}
                
   var column_name = $(this).data("column");
//alert(value)
//alert(value);
   
   update_data(id, column_name, value);
  });
  </script>
</html>