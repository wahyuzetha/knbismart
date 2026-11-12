<?php
if($_SESSION[levelu]==3){
	header('Loction: data_siswa');
	echo"<script>window.location = '../../apps/dashboard/data_siswa';</script>";
}
else {
include"../../inc/koneksi.php";
$server=$_SERVER['REQUEST_URI'];
$server=explode("/",$server);
$url_send=$server[5];

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
<style>
    .mjn{
            padding: 7px;
    width: 139px;
    margin-bottom: 6px;
    text-align: inherit;
    }
</style>
<div class="row">
<div class="col-md-2">
   <button type="button" class="btn bg-green waves-effect" data-toggle="modal" data-target="#lap"><i class="material-icons">book</i>Laporan Lainya</button>
                    <div class="modal fade" id="lap" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-green">
                            <h4 class="modal-title bg" id="smallModalLabel">MENU LAPORAN LAINNYA</h4>
                        </div>
                        <div class="modal-body">
                            	<a href="data?wali=<?php echo"$_SESSION[wali_kelas_k]";?>"><button class="btn btn-success waves-effect mjn" type="button"><i class="material-icons">assignment</i>Ujian Per-Kelas</button></a>
<?php if(empty($_SESSION[wali_kelas_k])) {?>
	<a href="data_tingkat"><button class="btn btn-success waves-effect mjn" type="button"><i class="material-icons">assignment</i>Ujian Per-Tingkat</button></a>
	<?php } ?>
	<a href="data_absen"><button class="btn btn-success waves-effect mjn" type="button"><i class="material-icons">assignment</i>Absensi Ujian</button></a>
	<a href="data_materi"><button class="btn btn-success waves-effect mjn" type="button"><i class="material-icons">assignment</i>Monitor Siswa</button></a>
	<a href="data_tugas"><button class="btn btn-success waves-effect mjn" type="button"><i class="material-icons">assignment</i>Monitor Tugas</button></a>


	<?php if(empty($_SESSION[wali_kelas_k])) {?>

	<a href="aktifitas"><button class="btn btn-success waves-effect mjn" type="button"><i class="material-icons">assignment</i>Monitor Guru</button></a>
<?php } ?>

	<a href="rekap_absen"><button class="btn btn-success waves-effect mjn" type="button"><i class="material-icons">assignment</i>Absen Per-Mapel</button></a>
	<a href="rekab_absen_perhari"><button class="btn btn-success waves-effect mjn" type="button"><i class="material-icons">assignment</i>Absen Per-Hari</button></a>
<a href="analisis"><button class="btn btn-success waves-effect mjn" type="button"><i class="material-icons">assignment</i>Analisis Ujian</button></a>

                            </div>
                        <div class="modal-footer">
                         
             
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
	</div>
	
<div class="col-md-8">	
			
<form action="<?php echo"$url_send";?>" method="GET">		
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
		   <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">filter</i> SET</button>
			</div>
            </div>
			</form>  					                            
</div></div>
<?php } ?>
