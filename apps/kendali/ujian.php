<?php 
ini_set('date.timezone', 'Asia/Jakarta');
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
$_SESSION[dujian]=$id;
$m2=mysql_query("select  * from pembelajaran where id='$id'");
$d2=mysql_fetch_array($m2);

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
</head>

<?php include"../../inc/nav.php";?>
 <script src="../../js/jquery-1.11.2.min.js"></script>

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
                              DATA UJIAN 
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
                                    <thead class="bg-green">
                                        <tr>
                                            <th>DETAIL</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;
             $peng=mysql_query("select * from pengaturan where id='1'");   
                $dpeng=mysql_fetch_array($peng);
                
          $m=mysql_query("SELECT pembelajaran.pembelajaran,ujian.* from ujian,pembelajaran
						WHERE ujian.id_pembelajaran=pembelajaran.id");   
            while($d=mysql_fetch_array($m)){
				
				if($d[aktif]==1){
				$aktif="<span style='color:green; font-size:20px;'><b>AKTIF</b></span>";
			}
			else {
							$aktif="<span style='color:red; font-size:20px;'><b>NON AKTIF</b></span>";

			}
			
                $dm=mysql_query("select  * from guru where nik='$d[nuptk]'");   
                $guru=mysql_fetch_array($dm);
                
                $wk=mysql_query("select  * from waktu where detik='$d[lama_ujian]'");   
                $dwk=mysql_fetch_array($wk);
                
                $cekj=mysql_query("select  * from hasil_jwb where id_ujian='$d[id]' order by nilai desc");   
                $dcek=mysql_num_rows($cekj);
                
                $kes=mysql_query("select  count(id) as jum from hasil_jwb where nis='$_SESSION[id_pengguna]' and id_ujian='$d[id]' order by nilai desc");   
                $dkes=mysql_fetch_array($kes);
                
                
                $c_blok=mysql_query("select * from log_masuk_ujian where nis='$_SESSION[id_pengguna]' and id_ujian='$d[id]'");   
                $dc_blok=mysql_fetch_array($c_blok);
                
            $no++;     
            $kesempatan=$d[kesempatan]-$dkes[jum];
           $tgl_mulai=date('d/m/Y', strtotime($d[waktu_mulai]));
           $tgl_selesai=date('d/m/Y', strtotime($d[waktu_selesai]));

            ?>      
           
                  <tr>
                <td width="50%"><?php echo"<h4>$d[nama_ujian] $d[pembelajaran]</h4> <br>  $tgl_mulai s/d $tgl_selesai <br>
				Jumlah Peserta Ujian = $dcek <br> $aktif";?> <br><br>
                
                                <a href="peserta?d=<?php echo"$d[id]";?>">
             <button type="button" class="btn bg-blue waves-effect">
                     <i class="material-icons">launch</i>Daftar Peserta Ujian</button>
                    </a>


                 
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
   
<script>


window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);
//# sourceURL=pen.js
</script>
<script>
        $('#image2').hide();
		 		        $('#ptoken').hide();

$("#token").keyup(function(){
var datastrings = $("#frm").serialize();
	
  $.ajax({
    type:'POST',
    data:datastrings,
    url:'ctoken',
	 cache: false,
    beforeSend: function(){
        $('#image2').show();
    },
    complete: function(){
        $('#image2').hide();
    },
    success:function(data) {
		        $('#image2').hide();

	if(data=="sukses"){	
		 		        $('#ptoken').hide();

	
	swal({
  title: "Berhasil!",
  text: "Token Sesuai, silahkan klik OK untuk menuju halaman ujian",
  type: "success",
  confirmButtonText: "OK"
},
function(isConfirm){
  if (isConfirm) {
     $('form').submit();

	 
  }
}); 

	}
	else {
	 		        $('#ptoken').show();

	}
    } 
	});
});
</script>

  <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

<script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="../../plugins/jquery-countto/jquery.countTo.js"></script>

    <script src="../../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../../js/pages/tables/jquery-datatable.js"></script>

  <script src="../../plugins/sweetalert/sweetalert.min.js"></script>
 <!-- Slimscroll Plugin Js -->


   <!-- Custom Js -->
   <script src="../../js/pages/ui/dialogs.js"></script>
     <script src="../../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
     <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

   
    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>
    <script src="../../plugins/bootstrap-notify/bootstrap-notify.js"></script>

</html>