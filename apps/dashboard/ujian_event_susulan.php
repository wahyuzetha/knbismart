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
$m2=mysql_query("SELECT siswa.aktif,siswa.nis,kelas.tingkat from siswa,kelas
WHERE siswa.kelas=kelas.nama_kelas and kelas.tahun_ajaran='$tahun_aktif' and siswa.nis='$_SESSION[namauser]'");
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
    
                            <h4>
                              UJIAN <?php echo"SUSUALAN";?>
                            </h4>
                        
                        <div class="body">
						
						<?php 
					
					if($d2[aktif]==2){
						echo"<H3>UJIAN NON AKTIF SILAHKAN HUBUNGI WALI KELAS</H3>";
					}
					else {?>
					
                            <!--
                           <form action="data" method="POST">
                            <input type="text" class="form-control" name="cari" placeholder="Cari Nama Guru">  
                            <input type="submit" class="btn btn-success" value="Cari">  
                           </form>
                          <hr>
                          -->
                                <table class="table table-bordered" id="example">
                                    <thead class="bg-green">
                                        <tr>
                                            <th>DETAIL</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;
			$tgl_c=date('Y-m-d');
             $peng=mysql_query("select * from pengaturan where id='1'");   
             $dpeng=mysql_fetch_array($peng);
                
				
				  $m=mysql_query("SELECT ujian.*,pembelajaran.pembelajaran from ujian,pembelajaran
WHERE ujian.id_pembelajaran=pembelajaran.id  and ((ujian.waktu_mulai >= '$tgl_c' AND ujian.waktu_selesai <= '$tgl_c')  OR (ujian.waktu_mulai <= '$tgl_c' AND ujian.waktu_selesai >= '$tgl_c')) and ujian.fix_uts='1'  and pembelajaran.tingkat='$d2[tingkat]' order by ujian.waktu_mulai desc"); 
/*
          $m=mysql_query("SELECT ujian.*,pembelajaran.pembelajaran from ujian,pembelajaran,status_mengajar
WHERE ujian.id_pembelajaran=pembelajaran.id and status_mengajar.id_ujian=ujian.id  and 
status_mengajar.status_belajar>'1' and status_mengajar.id_kelas='$kelas_all' and ujian.id_pembelajaran='$d2[id]' order by ujian.waktu_mulai desc");   
*/
            while($d=mysql_fetch_array($m)){
     
	   $cekj=mysql_query("select  * from hasil_jwb where nis='$_SESSION[id_pengguna]' and id_ujian='$d[id]' order by nilai desc");   
                $dcek=mysql_fetch_array($cekj);
				
if($d[susulan]==0){
$tampil=0;
}
else if($dcek[status]==3){
			$tampil=0;
			} 	
     else if($d[akses_siswa]=="null" and $d[akses_kelas]=="null"){
     $tampil=1;
 
    }
    
    else if($d[akses_siswa]=="null" and $d[akses_kelas]!="null"){
        	$someArray = json_decode($d[akses_kelas], true);
		    $ok_kelas=0;
			foreach($someArray as $kelasku) { 
			 if($_SESSION[kelasku]==$kelasku){
			     $ok_kelas=$ok_kelas+1;
			 }   
			 else {
			     $ok_kelas=$ok_kelas+0;
			 }

			}
			if($ok_kelas>0){
     $tampil=1;
			}
			else {
		     $tampil=0;
	    
			}
    
    }
    else if($d[akses_siswa]!="null" and $d[akses_kelas]=="null"){
        	$someArray_siswa = json_decode($d[akses_siswa], true);
		    $ok_siswa=0;
			foreach($someArray_siswa as $siswaku) { 
			 if($_SESSION[id_pengguna]==$siswaku){
			     $ok_siswa=$ok_siswa+1;
			 }   
			 else {
			     $ok_siswa=$ok_siswa+0;
			 }

			}
			if($ok_siswa>0){
     $tampil=1;
			}
				else {
		     $tampil=0;
	    
			}
    
    }
    
             
			 
         
		
		  else {
			$tampil=1;
			}
  
	
             if($tampil==1){   
                
                
              
				$c_blok=mysql_query("select * from log_masuk_ujian where nis='$_SESSION[id_pengguna]' and id_ujian='$d[id]'");   
                $dc_blok=mysql_fetch_array($c_blok);
                $jblok=number_format($dc_blok[jumlah],0);
            $no++;     
           $tgl_mulai=date('d/m/Y', strtotime($d[waktu_mulai]));
           $tgl_selesai=date('d/m/Y', strtotime($d[waktu_selesai]));
            
            if($d[status_essay]==1){
                $st="<span style='color:red'> Soal Pilihan Ganda dan Essay</span>";
            }
            else {
                $st="<span style='color:red'> Soal Pilihan Ganda </span>";
            }
            ?>      
           
                  <tr>
                <td width="50%"><?php echo"<h4>$d[nama_ujian]</h4> <br> Tanggal : $tgl_mulai s/d $tgl_selesai <br>
                Jam : $d[jam_mulai] - $d[jam_selesai] <br> $st <br> Terdeteksi Masuk Ujian Kali $jblok ";?> <br><br>
                <?php
                $tgl_skrng=date('Y-m-d');
				$jam_sekarang=date('H:i:s');
				
				if($jam_sekarang<$d[jam_mulai]){
                ?>
                <button type="button" class="btn bg-red waves-effect"><i class="material-icons">book</i>BELUM WAKTUNYA</button></a>
                <?php }  
                else if($jam_sekarang>$d[jam_selesai]){
                ?>
                <button type="button" class="btn bg-red waves-effect"><i class="material-icons">book</i>UJIAN BERAKHIR</button></a>
                <?php } 
               else if($tgl_skrng<$d[waktu_mulai]){
                ?>
                <button type="button" class="btn bg-red waves-effect"><i class="material-icons">book</i>BELUM WAKTUNYA</button></a>
                <?php }  
                else if($tgl_skrng>$d[waktu_selesai]){
                ?>
                <button type="button" class="btn bg-red waves-effect"><i class="material-icons">book</i>UJIAN BERAKHIR</button></a>
                <?php } 
                 else if($dcek[status]==3){
                ?>
               <!--<a href="hasil_jwb?d=<?php echo"$d[id]&d2=$_SESSION[id_pengguna]";?>"> <button type="button" class="btn bg-red waves-effect"><i class=<"material-icons">book</i>ANDA SUDAH UJIAN</button>
                </a>
				-->
				<?php if($d[tampilkan_nilai]==1){ $nhj=number_format($dcek[nilai],0); echo"<h4>Nilai $nhj</h4>";} ?>
               <button type="button" class="btn bg-red waves-effect"><i class="material-icons">book</i>ANDA SUDAH UJIAN</button>
              
			  <?php } 
                else if($dc_blok[jumlah]>$dpeng[blok] and !empty($dcek[id])){
                ?>
                <button type="button" class="btn bg-red waves-effect"><i class="material-icons">lock</i>UJIAN TERKUNCI, HUBUNGI PENGAWAS</button></a>
                <?php } 
                else {
					
					
                    if(!empty($dc_blok[id]) and !empty($dcek[id])){
                        $nm="Lanjutkan Ujian";
                        $cl="orange";
                        $startTime = date("Y-m-d H:i:s");
                        $tgl_ini=date('Y-m-d');
                        
                      
                        $waktu_ujian_start=date('H:i:s');
                        $waktu_selesai_ujian=date('H:i:s',strtotime('+'.$d[lama_ujian].' seconds',strtotime($startTime)));
                        $selesai_ujian=$dcek[waktu_selesai];

                        $awal  = strtotime("$tgl_ini $waktu_ujian_start"); //waktu awal
                        $akhir = strtotime("$tgl_ini $selesai_ujian"); //waktu akhir
                        $diff  = $akhir - $awal;
                        $jam   = floor($diff / (60 * 60));
                        
                        $menit = $diff - $jam * (60 * 60);
                        
                        $menits=floor( $menit / 60 );
                        $sisa_jam="$jam Jam $menits Menit";                        
                        
                    }
                    else {
                    $nm="Mulai Ujian";
                    $cl="blue";
                    $sisa_jam=$dwk[waktu];

                    }
                ?>
                
                 <button type="button" class="btn bg-<?php echo"$cl";?> waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$d[id]";?>">
                     <i class="material-icons">launch</i><?php echo"$nm";?></button>
                    <div class="modal fade" id="smallModal<?php echo"$d[id]";?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title bg" id="smallModalLabel">Konfirmasi Ujian</h4>
                        </div>
                        <div class="modal-body">
                            <h5>Mata Ujian <?php echo"$d2[pembelajaran] $d[nama_ujian] ";?><br>
                           
                           <!-- Waktu <?php echo"$sisa_jam";?>--></h5>
                            
							  <form action="temp" method="get" id="frm"> 
                <input type="hidden" name="id_ujian" value="<?php echo"$d[id]";?>">
               <input type="hidden" name="wmulai" value="<?php echo date('YmdHis');?>">
                <input type="hidden" name="nis" value="<?php echo"$_SESSION[id_pengguna]";?>">
                <input type="hidden" name="nmpembelajaran" value="<?php echo"$d[pembelajaran]";?>">
                <input type="hidden" name="nmujian" value="<?php echo"$d[nama_ujian]";?>">
                <input type="hidden" name="logujian" value="<?php echo"$dc_blok[jumlah]";?>">
                <input type="hidden" name="logwsave" value="<?php echo"$dc_blok[waktu_save]";?>">
                <input type="hidden" name="acak_soal" value="<?php echo"$d[acak_soal]";?>">
                <input type="hidden" name="acak_jwb" value="<?php echo"$d[acak_jwb]";?>">
                <input type="hidden" name="lama_ujian" value="<?php echo"$d[lama_ujian]";?>">
				 <input type="hidden" name="idpembelajaran" value="<?php echo"$d[id_pembelajaran]";?>">


					<?php
				if(empty($dcek[id])){ ?>
				<!--
				Masukkan Token
                <input type="text" id="token" name="token" class="form-control" style="text-transform:uppercase" >
							<div id="image2"><img src="image.gif">Cheking..</div>			
				<span style="color:red" id="ptoken">Token salah</span>-->
				<?php } ?>
<br>

                                  </div>
                        <div class="modal-footer">
                          <?php
                    if(!empty($dc_blok[id]) and !empty($dcek[id])){?>
                   <button type="submit" class="btn btn-info waves-effect"><i class="material-icons">send</i> MULAI</button>
				<?php } else if(empty($dcek[id])){  ?>
				                   <button type="submit" class="btn btn-info waves-effect"><i class="material-icons">launch</i> MULAI</button>

				<?php } ?>
             
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
                <?php } ?>


                 
               </td>
                                       
                                        </tr>
                    <?php } else {} }?>                    
                                       </tbody>
                                </table>
                            </div>
					<?php } ?>
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
<script type="text/javascript">
  $(document).ready(function(){
 $('#example').dataTable( {
  "ordering": false
} );
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
  
    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
     <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

   
    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>

</html>