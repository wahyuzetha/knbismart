<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
if($_SESSION[levelu]==3){
header('Location: profil');
}

if(!empty($_GET[tahun_ajaran])){
$_SESSION[thn_ajarann]=$_GET[tahun_ajaran];
}
else {
 $_SESSION[thn_ajarann]=$_SESSION[thn_ajarann];
   
}

if(empty($_SESSION[thn_ajarann])){
     $_SESSION[thn_ajarann]=$tahun_aktif;
}

$_SESSION[nama_kelas_k]=$_GET[nama_kelas_k];
?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                              Data Siswa <?php echo"$_SESSION[thn_ajarann]";?>
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
    
    <?php if($_SESSION[levelu]==1){?>
                                  <a href="add">        
                                  <button type="button" class="btn bg-light-blue waves-effect"><i class="material-icons">add</i> Tambah</button></a>
								 
 <a href="export">        
                                  <button type="button" class="btn bg-light-blue waves-effect"><i class="material-icons">launch</i> Export</button></a>
								 
								 
								   <a href="import">        
								   <button type="button" class="btn bg-green waves-effect"><i class="material-icons">import_export</i> Import Excel</button></a>
        
          <button type="button" class="btn bg-red waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$d[id]";?>"><i class="material-icons">delete</i> Reset</button>
                                  <hr>
                         
 <?php }
$_SESSION[cari]=$_POST[cari];
$_SESSION[tgl_awal]=$_POST[tgl_awal];
$_SESSION[tgl_akhir]=$_POST[tgl_akhir];

 ?>           
 
  <form action="data" method="GET">
                          
                            <div class="row">
                        
                   
              <div class="col-md-4">     
                  <label>Tahun Ajaran</label>
                      <div class="form-line">
            <select class="form-control"  name="tahun_ajaran" >
            <option value="">-- Pilih Tahun Ajaran --</option>
            <?php
            $mplj=mysql_query("select * from tahun_ajaran order by namathn desc");
            while($dplj=mysql_fetch_array($mplj)){
            if($dplj[namathn]==$_SESSION[thn_ajarann]){
                $pilt="selected";
            }
            else {
                $pilt="";
            }
       
            ?>
          <option value="<?php echo"$dplj[namathn]";?>" <?php echo"$pilt";?>><?php echo"$dplj[namathn]";?></option>

              <?php } ?>
              </select>

            </div></div>
			
			  <div class="col-md-4">     
                  <label>Kelas</label>
                      <div class="form-line">
            <select class="form-control"  name="nama_kelas_k" >
            <option value="">-- Pilih Kelas --</option>
            <?php
            $mpljk=mysql_query("select * from kelas where tahun_ajaran='$_SESSION[thn_ajarann]'");
            while($dpljk=mysql_fetch_array($mpljk)){
            if($dpljk[nama_kelas]==$_SESSION[nama_kelas_k]){
                $piltk="selected";
            }
            else {
                $piltk="";
            }
       
            ?>
          <option value="<?php echo"$dpljk[nama_kelas]";?>" <?php echo"$piltk";?>><?php echo"$dpljk[nama_kelas]";?></option>

              <?php } ?>
              </select>

            </div></div>

              <br>
                   <button type="submit" class="btn bg-green waves-effect"><i class="material-icons">filter_list</i> Filter</button>
                 </div>
                 
                  </form>  
                   <div class="modal fade" id="smallModal<?php echo"$d[id]";?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-red">
                            <h4 class="modal-title bg" id="smallModalLabel">Konfirmasi Reset</h4>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin mau MERESET data :<br>
                            1. Data Siswa Tahun Ajaran <?php echo"$_SESSION[thn_ajarann]";?><br>
                            2. Data Kelas Tahun Ajaran <?php echo"$_SESSION[thn_ajarann]";?><br>
                            3. Data Anggota Rombel Tahun Ajaran <?php echo"$_SESSION[thn_ajarann]";?><br>
                            4. Data Users Password Tahun Ajaran <?php echo"$_SESSION[thn_ajarann]";?><br>

                            </div>
                        <div class="modal-footer">
                            <form action="reset" method="post"> 
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
                   <button type="submit" class="btn btn-danger waves-effect"><i class="material-icons">delete</i> HAPUS</button>

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>


        <div class="table-responsive">
      
<table id='empTable' class='display dataTable' style="width:100%">
                                    <thead class="bg bg-green">
                                        <tr>  
                                            
                                            <th>NIS</th>
                                            <th>USERNAME</th>

                                            <th>NAMA</th>
 <th>KELAS</th>
 <?php if($_SESSION[levelu]==1){ ?>   
											  <th>PASSWORD</th>


                                        <th>ACTION</th> <?php } ?>
                                           
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
          'url':'table.php'
      },
      'columns': [
         { data: 'nis' },
         { data: 'username' },

        { data: 'nama' },
		        { data: 'kelas' },
 <?php if($_SESSION[levelu]==1){ ?>
        { data: 'no_telp' },
       
         { data: 'aksi' },
         <?php } ?>
      ]
   });
});

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