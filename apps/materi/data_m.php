<?php 
session_start();
if($_SESSION[levelu]==3){
	header('Loction: data_siswa');
	echo"<script>window.location = '../../apps/dashboard/data_siswa';</script>";
}
else {
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";

if(!empty($_GET[tahun_ajaran])){
$_SESSION[tahun_ajaran_pem]=$_GET[tahun_ajaran];
}
else {
$_SESSION[tahun_ajaran_pem]=$tahun_aktif;
}

if(!empty($_GET[semester])){
$_SESSION[semester_pem]=$_GET[semester];
}
else {
$_SESSION[semester_pem]=$semester_aktif;
}
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
                              DATA MATERI <?php echo"$_SESSION[tahun_ajaran_pem] $_SESSION[semester_pem]";?>
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
         <form action="data_m" method="GET">		
			<input type="hidden" value="<?php echo"$id";?>" name="d">
          <div class="row">
		  <div class="col-md-3">
             <select class="form-control show-tick"  name="tahun_ajaran">          
			 <?php
            $mpjt=mysql_query("select * from tahun_ajaran order by namathn asc");
            while($t=mysql_fetch_array($mpjt)){ 
			if($_SESSION[tahun_ajaran_pem]==$t[namathn]){
			$pil="selected";
			}
			else {
			$pil="";
			}	
				
            ?>      
          <option value="<?php echo"$t[namathn]";?>" <?php echo"$pil";?>><?php echo"$t[namathn]";?></option>

              <?php } ?>    
              </select>
            
			</div>
			  <div class="col-md-3">
             <select class="form-control show-tick"  name="semester">          
			 <?php
            $s=mysql_query("select * from semester order by semester asc");
            while($sm=mysql_fetch_array($s)){ 
			if($_SESSION[semester_pem]==$sm[semester]){
			$pils="selected";
			}
			else {
			$pils="";
			}	
				
            ?>      
          <option value="<?php echo"$sm[semester]";?>" <?php echo"$pils";?>><?php echo"$sm[semester]";?></option>

              <?php } ?>    
              </select>
            
			</div>
		   <div class="col-md-3">
		   <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">search</i> Filter</button>
			</div>
            </div>
			</form>                             
        <div class="table-responsive">
      
<table id='empTable' class='display dataTable' style="width:100%">
                                    <thead class="bg bg-green">
                                        <tr>  
                                            
                                            <th>NAMA GURU</th>
                                            <th>PEMBELAJARAN</th>
												 <th>TINGKAT</th>
 <th>KELAS</th>

									
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
          'url':'table.php'
      },
      'columns': [
         { data: '1' },
        { data: '2' },
        { data: '3' },
		        { data: '4' },

		
        <?php if($_SESSION[levelu]!=3){ ?>
         { data: 'aksi' },
         <?php } ?>
      ]
   });
});
</script>
</html>
<?php } ?>