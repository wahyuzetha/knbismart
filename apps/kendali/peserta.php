﻿<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
$m2=mysql_query("SELECT ujian.*,pembelajaran.pembelajaran,pembelajaran.tingkat from ujian,pembelajaran
WHERE ujian.id_pembelajaran=pembelajaran.id and ujian.id='$_GET[d]'");
$d2=mysql_fetch_array($m2);

if(!empty($_GET[j])){
$_SESSION[jpantaus]=$_GET[j];
}
else {
$_SESSION[jpantaus]=$_SESSION[jpantaus];

} 

if(!empty($_SESSION[jpantaus])){
$_SESSION[jpantau]="../../apps/ujian/data_pantau_ujian";
}
else {
$_SESSION[jpantau]="../../apps/ujian/data?d=$d2[id_pembelajaran]";
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
  <script src="../../js/jquery-1.11.2.min.js"></script>

<!-- Datatable JS -->
<script src="../../js/jquery.dataTables.min.js"></script>
 
    <section class="content">
            <div class="row">
               
                    <div class="card" style="margin-top: -30px;">
                        <div class="header">
                       
    
                            <h2>
                              DATA PESERTA UJIAN <?php echo"MAPEL $d2[pembelajaran]  $d2[nama_ujian] $d2[tingkat]";?>
                            </h2>
                            
                         </div>
                        <div class="body">
						<a href="<?php echo"$_SESSION[jpantau]";?>">
						<button type="button" class="btn bg-green waves-effect"><i class="material-icons">arrow_back</i> Kembali</button></a>
  
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
		$_SESSION[id_ujian_kendali]=$_GET[d];
    ?>
  <button type="button" class="btn bg-red waves-effect" data-toggle="modal" data-target="#smallModalreal"><i class="material-icons">delete</i> HAPUS SEMUA HASIL UJIAN</button>
  
                    </form>
                    <div class="modal fade" id="smallModalreal" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-red">
                            <h4 class="modal-title bg" id="smallModalLabel">Konfirmasi Hapus</h4>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin mau menghapus semua data ini?      </div>
                        <div class="modal-footer">
                            <form action="reset_all" method="post"> 
                <input type="hidden" name="id_ujian" value="<?php echo"$d2[id]";?>">
                 <input type="hidden" name="id_pembelajaran" value="<?php echo"$d[id_pembelajaran]";?>">
                   <button type="submit" class="btn btn-danger waves-effect"><i class="material-icons">delete</i> HAPUS SEMUA HASIL UJIAN</button>

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
<button type="button" class="btn bg-blue waves-effect" data-toggle="modal" data-target="#smallModalkor"><i class="material-icons">assignment_turned_in</i> KOREKSI ULANG</button>
                 
                   </form>
                    <div class="modal fade" id="smallModalkor" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-red">
                            <h4 class="modal-title bg" id="smallModalLabel">Koreksi Ulang Ujian</h4>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin mau koreksi ulang Ujian ini?      </div>
                        <div class="modal-footer">
                            <form action="koreksi_a" method="get"> 
                <input type="hidden" name="id_ujian" value="<?php echo"$d2[id]";?>">
                 <input type="hidden" name="id_pembelajaran" value="<?php echo"$d[id_pembelajaran]";?>">
                   <button type="submit" class="btn btn-danger waves-effect"><i class="material-icons">refresh</i> KOREKSI ULANG</button>

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>

<hr>      

		  <form action="peserta" method="GET">
				<input type="hidden" name="d" value="<?php echo $_GET[d];?>">
              <div class="row">
                 <div class="col-md-3">
                 <select class="form-control show-tick" name="status">
            
			<option value="all">Semua Status</option>
			<option value="1">Belum Selesai</option>
			<option value="2">Selesai Ujian</option>
              </select> 
               </div>
			   </div>
			    <div class="row">
             <div class="col-md-3"><label>Tanggal Mulai</label>
            <input type="date" name="tgl_awal" value="<?php echo $d2[waktu_mulai];?>" class="form-control">
             </div>
             <div class="col-md-3">
			 <label>Sampai Tanggal</label>
            <input type="date" name="tgl_akhir" value="<?php echo $d2[waktu_selesai];?>" class="form-control">
              </div>
			  
			    <div class="col-md-3"><label>Jam Mulai</label>
            <input type="text" name="jam_mulai" id="txtTime"  class="form-control jam">
             </div>
             <div class="col-md-3">
			 <label>Sampai Jam</label>
            <input type="text" name="jam_selesai"  class="form-control jam">
              </div>
                                    

            
                  </div> 
 <button type="submit" class="btn bg-green waves-effect"><i class="material-icons">filter_list</i> Filter</button>				  
                  </form>  
<hr>
 <?php
if(!empty($_GET[status])){ 
$_SESSION[status_ujian_s]=$_GET[status];
}
else {
$_SESSION[status_ujian_s]=$_SESSION[status_ujian_s];
}

if(!empty($_GET[tgl_awal])){
$_SESSION[tgl_awal_ujian_s]=$_GET[tgl_awal];
$_SESSION[tgl_akhir_ujian_s]=$_GET[tgl_akhir];
}
else {
$_SESSION[tgl_awal_ujian_s]=$_SESSION[tgl_awal_ujian_s];
$_SESSION[tgl_akhir_ujian_s]=$_SESSION[tgl_akhir_ujian_s];

}

if(!empty($_GET[jam_mulai])){
$_SESSION[jam_mulai_s]=$_GET[jam_mulai];
$_SESSION[jam_selesai_s]=$_GET[jam_selesai];
}
else {
$_SESSION[jam_mulai_s]=$_SESSION[jam_mulai_s];
$_SESSION[jam_selesai_s]=$_SESSION[jam_selesai_s];

}
 ?>      

        <div class="table-responsive">
      
<table id='empTable' class='display dataTable' style="width:100%">
                                    <thead style="background: #2196f3; color:#fff; ">
                                        <tr>  
                                            
                                            <th>DATA</th>
                                    <!--        <th>NAMA</th>-->
 										  


                                     
                                           
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

<script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="../../plugins/jquery-countto/jquery.countTo.js"></script>
     <!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>


    <script src="../../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../../js/pages/tables/jquery-datatable.js"></script>

  <script src="../../plugins/sweetalert/sweetalert.min.js"></script>
 <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="../../plugins/bootstrap-notify/bootstrap-notify.js"></script>
  
   <!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
     <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

   
    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>
   
    <script type="text/javascript">
		$(document).ready(function()
		{
			
			$('#date-format').bootstrapMaterialDatePicker
			({
								date: false,
			format: 'HH:mm',
				lang: 'id',
				weekStart: 1, 
				cancelText : 'Batal',
				nowButton : true,
				switchOnClick : true,
				//minDate : new Date() 
			});
			
			$('.jam').bootstrapMaterialDatePicker
			({
								date: false,
			format: 'HH:mm',
				lang: 'id',
				weekStart: 1, 
				cancelText : 'Batal',
				nowButton : true,
				switchOnClick : true,
				//minDate : new Date() 
			});
		
		});
		</script>
</html>
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
         <!--       { data: 'kelas' },-->

		
       
      ]
   });
});

 function update_data(id, column_name, value)
  {
   $.ajax({
    url:"update.php",
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     
swal({
  title: "Berhasil!",
  text: "Ujian Berhasil di buka",
  type: "success",
  confirmButtonText: "OK"
},
function(isConfirm){
  if (isConfirm) {
location.reload();

	 
  }
}); 

    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }

  $(document).on('change', '.update', function(){
   var id = $(this).data("id");

   var column_name = $(this).data("column");
   var value = $(this).val();

   
   update_data(id, column_name, value);
  });
  
  
  
  
  
  
  function update_komentar(id, column_name, value)
  {
   $.ajax({
    url:"update_komentar.php",
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     
swal({
  title: "Berhasil!",
  text: "Komentar berhasil dikirim",
  type: "success",
  confirmButtonText: "OK"
},
function(isConfirm){
  if (isConfirm) {
location.reload();

	 
  }
}); 

    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }

  $(document).on('change', '.update_komentar', function(){
   var id = $(this).data("id");

   var column_name = $(this).data("column");
   var value = $(this).val();

   
   update_komentar(id, column_name, value);
  
  });
  
  
  
  
  
  
  

</script>

</html>