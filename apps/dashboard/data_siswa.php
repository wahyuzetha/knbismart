<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/hari.php";

if(isset($_SESSION['namauser'])){
		
  $queryus = mysql_query("SELECt * from users where username='$_SESSION[namauser]'");
  $duser=mysql_fetch_array($queryus);
  
  if(empty($dcek[token_notif]) and !empty($_SESSION[token_id])){
   
        $upd=mysql_query("update users set token_notif='$_SESSION[token_id]' where username='$_SESSION[namauser]'");
}


else if(!empty($dcek[token_notif])){
    if($dcek[token_notif]==$_SESSION[token_id]){
        
    }
    else {
        $upd=mysql_query("update users set token_notif='$_SESSION[token_id]' where username='$_SESSION[namauser]'");
    }
}
}
$cak=mysql_query("SELECT siswa.nis,siswa.nama,kelas.nama_kelas,kelas.tahun_ajaran,kelas.id_class from 
siswa,kelas WHERE 
siswa.kelas=kelas.nama_kelas and 
kelas.tahun_ajaran='$tahun_aktif' and 
siswa.nis='$_SESSION[namauser]'");
$dcak=mysql_fetch_array($cak);  
?>
<!DOCTYPE html>
<html>
      <script src="../../js/jquery-1.11.2.min.js"></script>

<script type="text/javascript">
/*
$(document).ready(function() {
    var dataString = 'k=1';
    $.ajax({
      type: "POST",
      url: "rekap_ppdb",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".ppdb").html(html);
      } 
    });
 
});
*/

    var detik = <?php echo date('s'); ?>;
    var menit = <?php echo date('i'); ?>;
    var jam   = <?php echo date('H'); ?>;
     
    function clock()
    {
        if (detik!=0 && detik%60==0) {
            menit++;
            detik=0;
        }
        second = detik;
         
        if (menit!=0 && menit%60==0) {
            jam++;
            menit=0;
        }
        minute = menit;
         
        if (jam!=0 && jam%24==0) {
            jam=0;
        }
        hour = jam;
         
        if (detik<10){
            second='0'+detik;
        }
        if (menit<10){
            minute='0'+menit;
        }
         
        if (jam<10){
            hour='0'+jam;
        }
        waktu = hour+':'+minute+':'+second;
         
        document.getElementById("clock").innerHTML = waktu;
        detik++;
    }
 
    setInterval(clock,1000);
</script>
<head>
<?php include"../../inc/meta.php"; ?>
<?php include"../../inc/notif.php";?>

<style>
    .menu_depan_s {
    color: #000;
    padding: 5px;
    border-radius: 10px;
    background: rgba(0, 0, 0, 0.08);
    text-decoration:none;
    width: 101px;
	height: 102px;
}
a {
      text-decoration:none !important;
   }
</style>
<link href='../../css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

</head>

<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include"../../inc/sidebar.php";?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    <br>
    <section class="content">
<div class="col-md-12" style="margin-top: -33px"> 

            <?php
            echo"<h4>$nama </h4> <h5>$kelas_all<br><br>";
            $t_skrng=$tanggal_pelajaran_aktif_s;
			$tgl_k=date('d/m/Y', strtotime($t_skrng));
						
						echo"<span style='font-size: 15px;'>$tgl_k</span>
						<span style='font-size: 15px;' id='clock'></span>";
				?>		
            <hr>
          </div>
		  <div class="row">
    <div class="col-md-12">

<?php
$tgl_ini=$tanggal_pelajaran_aktif_s;
$tgl_besok=	date('Y-m-d', strtotime('+1 days', strtotime($tgl_ini))); 

for($i=1;$i<=1;$i++){
if($i==1){
$tanggal_cari=$tgl_ini;	
}
else {
$tanggal_cari=$tgl_besok;	
}
$chari=date('D', strtotime($tanggal_cari));
$thari=date('d/m/Y', strtotime($tanggal_cari));

$hari_jadwal=hari_indo($chari);	
//mencari hari
$qhr=mysql_query("SELECT * from asc_daysdefs where name='".mysql_real_escape_string($hari_jadwal)."'");	
$dhr=mysql_fetch_array($qhr)

	?>
<table width="100%"  class='display dataTable'>
  <tr>
    <td colspan="3" align="left" class="bg bg-green"><?php echo"<h5>Jadwal Pelajaran $hari_jadwal, $thari</h5>";?></td>
  </tr>
  <?php
  $warna_o=mysql_query("select  * from status_belajar where id='1'"); 
                $dwarna_o=mysql_fetch_array($warna_o);   
 
  $j=0;
  	$qjam=mysql_query("SELECT * from asc_periods order by starttime asc");	
	while($djam=mysql_fetch_array($qjam)){
    $j++;
   $qjadwal=mysql_query("SELECT pembelajaran.id as id_pembelajaran,guru.teacher_id,guru.nik,guru.nama,kelas.tingkat,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
	from asc_cards,guru,kelas,asc_subjects,asc_lessons,pembelajaran
	WHERE 
	asc_lessons.id=asc_cards.lessonid AND
	asc_lessons.teacherids=guru.teacher_id AND
	asc_lessons.classids=kelas.id_class AND
	asc_lessons.subjectid=asc_subjects.id AND
	asc_subjects.short=pembelajaran.kode_asc AND
	pembelajaran.teacher_id=guru.teacher_id AND
	asc_cards.period='$djam[period]' AND
	asc_cards.days='$dhr[days]' AND
	asc_cards.tahun_ajaran='$tahun_aktif' AND
	asc_cards.semester='$semester_aktif' and
    pembelajaran.tahun_ajaran='$tahun_aktif' AND
	pembelajaran.semester='$semester_aktif' and
	kelas.nama_kelas='$dcak[nama_kelas]' AND
pembelajaran.kelas like '%$dcak[nama_kelas]%'
	");	
	$djadwal=mysql_fetch_array($qjadwal);
	

   $qstatus=mysql_query("SELECT status_belajar.status,status_belajar.status_siswa,status_belajar.warna,status_mengajar.* from status_mengajar,status_belajar
											where 
                                            status_belajar.id=status_mengajar.status_belajar and
											status_mengajar.id_pembelajaran='$djadwal[id_pembelajaran]' and
											status_mengajar.tanggal='$tanggal_cari' and
											status_mengajar.id_kelas='$djadwal[nama_kelas]' and
											status_mengajar.semester='$semester_aktif' and
											status_mengajar.tahun_ajaran='$tahun_aktif'  and status_mengajar.id_user='$djadwal[nik]' and
											status_mengajar.status_belajar>'1'");	
	$dstatus=mysql_fetch_array($qstatus);
	
	
	if(!empty($dstatus[id])){
	$nh="NOT";
	}
	else {
	$nh="NOT";
	}
	
	if(!empty($djadwal[mapel])){
    if(!empty($dstatus[status_belajar])){
	$status_warna=$dstatus[warna];
	$status_mengajar_guru=$dstatus[status_siswa];
	
	}
	else {
	$status_warna=$dwarna_o[warna];
	$status_mengajar_guru=$dwarna_o[ket];
	
	}
	$ket_status="<span class='badge bg-$status_warna'>$status_mengajar_guru</span>";
	}
	else {
	$ket_status="";
	}
	
	$qm=mysql_query("select  materi.* from materi,pembelajaran where 
						pembelajaran.id=materi.id_pembelajaran and 
						pembelajaran.subjectid='$djadwal[id_mapel]' and
						pembelajaran.tingkat='$djadwal[tingkat]' AND
						materi.batas_tanggal<='$tanggal_cari' and 
						materi.id!='$dsudah[id_materi] ' and 
						pembelajaran.nuptk='$dstatus[id_user]' and
						(materi.akses_kelas='null' or materi.akses_kelas='' or materi.akses_kelas like '%$djadwal[nama_kelas]%')
						order by materi.batas_tanggal desc");
						$dm=mysql_fetch_array($qm);
						
						
	$cek_log=mysql_query("select * from log_akses_materi where id_user='$_SESSION[namauser]' and 
	id_materi='$dm[id]'");
	$dcek_log=mysql_fetch_array($cek_log);
    
	if(!empty($djadwal[mapel])){
	if(!empty($dcek_log[id])){
	$ket_hadir="<span class='badge bg-green'>Hadir</span>";
	}
    else {
	$ket_hadir="<span class='badge bg-red'>Tidak Hadir</span>";

	}		
	}
	else {
	$ket_hadir="";	
	}
   ?>
  <tr>
    <td align="center" width="20%"><?php echo"$djam[starttime] <br>$ket_status <br>$ket_hadir";?> </td>
    <td align="center" width="50%"><?php echo"<b>$djadwal[mapel]</b> <br> $djadwal[nama]";?> </td>
    <td width="30%"><?php if(!empty($djadwal[nama_kelas])){ 
		
	if(!empty($dstatus[status_belajar])){ 
	?>
	
	 <button type="button" class="btn bg-<?php echo"$status_warna";?> waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$i$j";?>"><i class="material-icons">launch</i> <?php echo"Buka Materi";?></button>
                    </form>
                    <div class="modal fade" id="smallModal<?php echo"$i$j";?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-blue">
 <button type="button" class="btn bg-orange waves-effect pull-right" data-dismiss="modal"><i class="material-icons">close</i></button>                          
						  <h4 class="modal-title bg" id="smallModalLabel"><?php echo"<b>$hari_jadwal $thari Pukul $djam[starttime] $djadwal[nama_kelas]</b>  $djadwal[mapel]";?> </h4>
                        </div>
                        <div class="modal-body">
                        <?php
						//mencari materi 
						if(!empty($dm[tema])){
						echo"Materi : <br>
						$dm[tema]
						";
						}
						else{
						echo"Belum Ada Materi";
						}
						echo"<hr>";
						
						//mencari Tugas 
					
	if($nh!="not"){
						$kt=" and tanggal<'$tanggal_cari' and id_tugas!=''";
						}
						else {
						$kt="";
						}
						
						
						
						$qt=mysql_query("select  tugas.* from tugas,pembelajaran where 
						pembelajaran.id=tugas.id_pembelajaran and 
						pembelajaran.id='$djadwal[id_pembelajaran]'  and 
						pembelajaran.tingkat='$djadwal[tingkat]' AND
						tugas.tanggal_mulai<='$tanggal_cari' and 
						tugas.id $nh IN(SELECT id_tugas from status_mengajar WHERE 
						id_user='$dstatus[id_user]' and 
						id_pembelajaran='$djadwal[id_pembelajaran]' and id_kelas='$djadwal[nama_kelas]' $kt) and 
						pembelajaran.nuptk='$dstatus[id_user]' and 
						(tugas.akses_kelas='null' or tugas.akses_kelas='' or tugas.akses_kelas like '%$djadwal[nama_kelas]%')
						order by tugas.tanggal_mulai desc");
						$dt=mysql_fetch_array($qt);
						if(!empty($dt[judul])){
						echo"Tugas : <br>
						$dt[judul]
						";
						}
						else{
						echo"Belum Ada Tugas";
						}
						
						echo"<hr>";
						
						//mencari Ujian 
						
						
						$qj=mysql_query("select  ujian.* from ujian,pembelajaran where 
						pembelajaran.id=ujian.id_pembelajaran and 
						ujian.id_pembelajaran='$djadwal[id_pembelajaran]' and
						pembelajaran.subjectid='$djadwal[id_mapel]'  and 
						ujian.jenis_ujian!='1' and 
						pembelajaran.tingkat='$djadwal[tingkat]' AND
						ujian.waktu_mulai<='$tanggal_cari' and 
						pembelajaran.nuptk='$dstatus[id_user]' and 
						(ujian.akses_kelas='null' or ujian.akses_kelas='' or ujian.akses_kelas like '%$djadwal[nama_kelas]%')
						order by ujian.waktu_mulai desc");
						$dj=mysql_fetch_array($qj);
						if(!empty($dj[nama_ujian])){
						echo"Ujian : <br>
						$dj[nama_ujian]
						";
						}
						else{
						echo"Belum Ada Ujian";
						}
						
						
						
						?>	
							
							
							</div>
                 <div class="modal-footer">
                <form action="<?php echo"detail_open";?>" method="get" id="<?php echo"f$i$j";?>"> 
                <input type="hidden" name="id_pembelajaran" value="<?php echo"$dm[id_pembelajaran]";?>">
                <input type="hidden" name="id_materi" value="<?php echo"$dm[id]";?>">
                <input type="hidden" name="id_tugas" value="<?php echo"$dt[id]";?>">
                <input type="hidden" name="id_ujian" value="<?php echo"$dj[id]";?>">
                <input type="hidden" name="id_kelas" value="<?php echo"$djadwal[nama_kelas]";?>">
                <input type="hidden" name="status_belajar" value="<?php echo"$kode_status";?>">
                <input type="hidden" name="tanggal" value="<?php echo"$tanggal_cari";?>">
                <input type="hidden" name="jam" value="<?php echo"$djam[starttime]";?>">
                <input type="hidden" name="teacher_id" value="<?php echo"$djadwal[teacher_id]";?>">
                <input type="hidden" name="classid" value="<?php echo"$djadwal[id_class]";?>">
                <input type="hidden" name="subject_id" value="<?php echo"$djadwal[id_mapel]";?>">
                <input type="hidden" name="days" value="<?php echo"$dhr[days]";?>">
                <input type="hidden" name="startime" value="<?php echo"$djam[starttime]";?>">
			
				 <button type="submit" id="<?php echo"s$i$j";?>" class="btn bg-green waves-effect"><i class="material-icons">launch</i>  Buka Materi</button>

                           
                              </form>
                        </div>
                    </div>
                </div>
            </div>
	
	
	<?php } else { //echo"Belum Buka";
	} } ?></td>
    
  </tr>
		<?php } ?>
</table>
<br><br>
<?php } ?>

	
	
	
                            </div>
                            </div>
							
          <div class="row">
          
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/siswa/profile">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">account_circle</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Profile</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
                
                 <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/dash_2">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">chrome_reader_mode</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Materi</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
                
                 <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/dashs_tugas">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-purple btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">chrome_reader_mode</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Tugas</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/dash_ujian">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment_turned_in</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Ulangan Harian</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
				
				  
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/ujian_pengayaanns">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment_turned_in</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Pengayaan</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
				
				<div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/ujian_event">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment_turned_in</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Ujian Utama Sekolah</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
				
				 <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/ujian_event_susulan">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment_turned_in</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Ujian Susulan Sekolah</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
				
				
				
				<div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/log_absensi">
                  <div class="menu_depan_s">
                             <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">book</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Log Absensi</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
				
					<div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/raport">
                  <div class="menu_depan_s">
                             <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">book</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Raport</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
                
            
               
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../logout">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">power_settings_new</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Logout</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
              
           </div>
<hr>
<table id='empTable' class='display dataTable' style="width:100%">
                                        <thead class="bg bg-green">
                                        <tr> 
                                        <td>INFORMASI</td>
                                        </tr>
                                        </table>
                            </div>
                         
                            <div class="col-md-6 ppdb">
                                
                            </div>
                          


            <!-- #END# Widgets -->
           
  </section>
   
<?php include"../../inc/footerm.php";?></body>

    <script type="text/javascript">
  $(document).ready(function(){
   $('#empTable').DataTable({
      'processing': true,
      'serverSide': true,
      'ordering':false,
        "lengthChange": false,
        'searching':false,        
      'serverMethod': 'post',
      'ajax': {
          'url':'../../apps/informasi/table_info.php'
      },
      'columns': [
        { data: 'kategori' },
      ]
   });
   
   $('#empTable2').DataTable({
      'processing': true,
      'serverSide': true,
      'ordering':false,
        "lengthChange": false,

      'serverMethod': 'post',
      'ajax': {
          'url':'../../apps/informasi/table_log.php'
      },
      'columns': [
        { data: 'kategori' },
      ]
   });
});
</script>
</body>
</body>

</html>