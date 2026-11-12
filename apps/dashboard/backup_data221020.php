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
             

                 $lh=mysql_query("SELECT guru.*,jabatan.jenis_jab from guru
LEFT JOIN jabatan on guru.id_jabatan=jabatan.id where guru.nik='$_SESSION[namauser]'");
    $gh=mysql_fetch_array($lh);
    
     $kls=mysql_query("SELECT * from kelas  where tahun_ajaran='$tahun_aktif' and wali='$_SESSION[namauser]'");
    $dkls=mysql_fetch_array($kls);
$_SESSION[jpantaus]="";
                
?>
<!DOCTYPE html>
<html>
      <script src="../../js/jquery-1.11.2.min.js"></script>
<script>

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
	height:96px;
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
			if($_SESSION[levelu]==1){
				$jab="Administrator";
			}
			else {
				$jab=$gh[jenis_jab];
			}
            echo"<h3>$gh[nama] </h3> <h5> $_SESSION[namauser] <br>Jabatan :  $jab <br> ";
            if(!empty($dkls[id])){
                echo"Wali Kelas $dkls[nama_kelas]";
                $_SESSION[wali_kelas]=$dkls[nama_kelas];
                $_SESSION[wali_tingkat]=$dkls[tingkat];
                
            }
			 $t_skrng=$tanggal_pelajaran_aktif_s;
			$tgl_k=date('d/m/Y', strtotime($t_skrng));
						
						echo"<br><span style='font-size: 15px;'>$tgl_k</span>
						<span style='font-size: 15px;' id='clock'></span>";
            ?>
            <hr>
          </div>
          <div class="row">
          
		   
				 <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/jadwal">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">access_time</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Jadwal</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
				
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/guru/data">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">account_circle</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Data PTK</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                                                                <?php if($_SESSION[jabatan_guru]!=11){?>

                 <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/siswa/data">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">account_circle</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Data Siswa</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                <?php if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7  or $_SESSION[jabatan_guru]==1){?>
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/kelas/data">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">dashboard</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Data Kelas</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
                 <?php } ?>
                
                 <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/pembelajaran/data">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-purple btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">book</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Mapel</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
               
                 <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/perangkat/data">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">description</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Perangkat</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
                
                  <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/materi/data_m">
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
                  <a href="../../apps/tugas/data_m">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment_turned_in</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Tugas</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
                     <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/ujian/data_m">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment_turned_in</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Ujian</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                

               
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/laporan/data_materi">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Monitor Siswa</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
                
                
                
                                  <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/laporan/data">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Monitor Ujian</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                
                
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/laporan/aktifitas">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Monitor Guru</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
				  <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/laporan/data_tugas">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Monitor Tugas</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                <?php
                if(!empty($dkls[id])){?>
                 <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/laporan/data?wali=<?php echo"$_SESSION[wali_kelas]";?>">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Wali Kelas</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
                    <?php } ?>        
                            
               
                
                
             
                
                <?php } ?>
                
              
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/dashboard/jurnal_mengajar_s">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">book</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Jurnal Mengajar</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
				
		 <?php 
			  if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7){?>
 
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/ujian/data_pantau_ujian">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">book</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Pemantaun Event Ujian</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
		 <?php } 
		 
		   if($_SESSION[levelu]==2 and $_SESSION[penyelenggara_ujians]!="null" and $_SESSION[penyelenggara_ujians]!=""){?>
 
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/ujian/data_pantau_ujian">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">book</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Pemantaun Event Ujian</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
		   <?php } ?>
                <div class="col-md-2 col-xs-4" align="center" style="padding-bottom: 19px;">
                  <a href="../../apps/informasi/data">
                  <div  class="menu_depan_s">
                             <button type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">info</i>
                                </button>
                                <div class="content">
                                    <div class="text">
                                        <h5>Informasi</h5></div>
                                </div>
                        </div>
                        </a>
                </div>
               
                
              
           </div>
<hr>
<div class="row">

    <div class="col-md-12">
<table id='empTable' class='display dataTable' style="width:100%">
                                        <thead class="bg bg-green">
                                        <tr> 
                                        <td>INFORMASI</td>
                                        </tr>
                                        </table>
                            </div>
                         
                           
                            </div>
                            </div>
            <!-- #END# Widgets -->
<?php
if($_SESSION[levelu]!='1'){
$tgl_ini=$tanggal_pelajaran_aktif_s;
$tgl_besok=	date('Y-m-d', strtotime('+1 days', strtotime($tgl_ini))); 
?>
<?php for($i=1;$i<=1;$i++){
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
$dhr=mysql_fetch_array($qhr);

	?>
<table width="100%"  class='display dataTable'>
  <tr>
    <td colspan="3" align="left" class="bg bg-green"><?php echo"<h5>Jadwal Mengajar $hari_jadwal, $thari</h5>";?></td>
  </tr>
 
   <?php
    $j=0;
  	$qjam=mysql_query("SELECT * from asc_periods order by starttime asc");	
	while($djam=mysql_fetch_array($qjam)){
   $j++;
   $qjadwal=mysql_query("SELECT pembelajaran.id as id_pembelajaran,guru.nik,guru.nama,kelas.id_class,kelas.tingkat,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
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
	pembelajaran.nuptk='$_SESSION[namauser]' and
	pembelajaran.tingkat=kelas.tingkat
	");	
	$djadwal=mysql_fetch_array($qjadwal);
	
											
	//mengecek status mengajar apakah sudah open
	$qstatus=mysql_query("SELECT status_belajar.status,status_belajar.warna,status_mengajar.* from status_mengajar,status_belajar
											where 
                                            status_belajar.id=status_mengajar.status_belajar and
											status_mengajar.id_pembelajaran='$djadwal[id_pembelajaran]' and
											status_mengajar.tanggal='$tanggal_cari' and
											status_mengajar.id_kelas='$djadwal[nama_kelas]' and
											status_mengajar.semester='$semester_aktif' and
											status_mengajar.tahun_ajaran='$tahun_aktif' and
											status_mengajar.id_user='$djadwal[nik]'
											");	
	$dstatus=mysql_fetch_array($qstatus);
	
	//mencari status mengajar sebelumya yg sudah di close
	$qsudah=mysql_query("SELECT * from status_mengajar
											where 
											status_mengajar.id_pembelajaran='$djadwal[id_pembelajaran]' and
											status_mengajar.tanggal<'$tanggal_cari' and
											status_mengajar.id_kelas='$djadwal[nama_kelas]' and
											status_mengajar.semester='$semester_aktif' and
											status_mengajar.tahun_ajaran='$tahun_aktif'
											and status_mengajar.status_belajar>'1' and status_mengajar.id_user='$djadwal[nik]'
");	
	$dsudah=mysql_fetch_array($qsudah);
	
	
   
	if(!empty($djadwal[mapel])){
    if($dstatus[status_belajar]=="0" or $dstatus[status_belajar]==""){
	$status_mengajar_guru="Belum Open";
	$status_warna="red";
	$kode_status=2; 
	$kode_status_m=1; 
	$furl="proses_belajar";
	}
	else {
	$status_mengajar_guru=$dstatus[status];
	$status_warna=$dstatus[warna];
	$kode_status=$dstatus[status_belajar] + 1; 
	$kode_status_m=$dstatus[status_belajar] + 1; ; 
    $furl="detail_open";

	}
	
	}
	else {
	$status_mengajar_guru="";
    $kode_status=2; 
	$kode_status_m=1; 
    $furl="proses_belajar";

	}
	
   
   ?>
  <tr>
    <td align="center" width="20%"><?php echo" $djam[starttime] <br><span class='badge bg-$status_warna'>$status_mengajar_guru</span>";?> </td>
    <td align="center" width="50%"><?php echo"<b>$djadwal[nama_kelas]</b> <br>  $djadwal[mapel]";?> </td>
    <td><?php if(!empty($djadwal[nama_kelas])){?>
	
	  <button type="button" class="btn bg-<?php echo"$status_warna";?> waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$i$j";?>"><i class="material-icons">launch</i> <?php echo"Detail";?></button>
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
						
						
						$qm=mysql_query("select  materi.* from materi,pembelajaran where 
						pembelajaran.id=materi.id_pembelajaran and 
						pembelajaran.subjectid='$djadwal[id_mapel]' and
						pembelajaran.tingkat='$djadwal[tingkat]' AND
						pembelajaran.nuptk='$_SESSION[namauser]' and
						materi.batas_tanggal<='$tanggal_cari' and 
						materi.id!='$dsudah[id_materi]' and 
						(materi.akses_kelas='null' or materi.akses_kelas='' or materi.akses_kelas like '%$djadwal[nama_kelas]%')
						order by materi.batas_tanggal desc");
						$dm=mysql_fetch_array($qm);
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
						
						
						$qt=mysql_query("select  tugas.* from tugas,pembelajaran where 
						pembelajaran.id=tugas.id_pembelajaran and 
						pembelajaran.nuptk='$_SESSION[namauser]' and
						pembelajaran.subjectid='$djadwal[id_mapel]'  and 
						pembelajaran.tingkat='$djadwal[tingkat]' AND
						tugas.tanggal_mulai<='$tanggal_cari' and 
						tugas.id!='$dsudah[id_tugas]' and 
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
						pembelajaran.nuptk='$_SESSION[namauser]' and
						pembelajaran.subjectid='$djadwal[id_mapel]'  and 
						pembelajaran.tingkat='$djadwal[tingkat]' AND
						ujian.waktu_mulai<='$tanggal_cari' and 
						ujian.id!='$dsudah[id_ujian]' and 
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
                <form action="<?php echo"$furl";?>" method="get" id="<?php echo"f$i$j";?>"> 
                <input type="hidden" name="id_pembelajaran" value="<?php echo"$dm[id_pembelajaran]";?>">
                <input type="hidden" name="id_materi" value="<?php echo"$dm[id]";?>">
                <input type="hidden" name="id_tugas" value="<?php echo"$dt[id]";?>">
                <input type="hidden" name="id_ujian" value="<?php echo"$dj[id]";?>">
                <input type="hidden" name="id_kelas" value="<?php echo"$djadwal[nama_kelas]";?>">
                <input type="hidden" name="status_belajar" value="<?php echo"$kode_status";?>">
                <input type="hidden" name="tanggal" value="<?php echo"$tanggal_cari";?>">
                <input type="hidden" name="jam" value="<?php echo"$djam[starttime]";?>">
                <input type="hidden" name="teacher_id" value="<?php echo"$_SESSION[teacher_id_se]";?>">
                <input type="hidden" name="classid" value="<?php echo"$djadwal[id_class]";?>">
                <input type="hidden" name="subject_id" value="<?php echo"$djadwal[id_mapel]";?>">
                <input type="hidden" name="days" value="<?php echo"$dhr[days]";?>">
                <input type="hidden" name="startime" value="<?php echo"$djam[starttime]";?>">
				
				<?php
				if(!empty($dm[id_pembelajaran])){
				$qwr=mysql_query("SELECT * from status_belajar where id='$kode_status_m'");	
				$dqwr=mysql_fetch_array($qwr);

				if($kode_status_m>1){
				$button_d="<button type='submit' id='s$i$j' class='btn bg-green waves-effect'>
				<i class='material-icons'>launch</i> Detail</button>";
				} 
				 else {
				$jam_aktif=$jam_aktif_server;
			     //$jam_aktif="11:16:00";
				if($jam_aktif<$djam[starttime]){
				$button_d="Belum Waktunya Open";
				}
				else if($jam_aktif>=$djam[starttime] and $jam_aktif<=$djam[endtime]){

				$button_d="<button type='submit' id='s$i$j' class='btn bg-green waves-effect'>
				<i class='material-icons'>launch</i> $dqwr[status]</button>";				
				
				}
				else {
				$button_d="Lewat Waktu Open";
				}
				
				
				
				
				}
				 
				 
				 
				 					echo"$button_d";

				?>	

				 

				<?php }  ?>
                           
                              </form>
                        </div>
                    </div>
                </div>
            </div>
	
	<?php } ?></td>
    
  </tr>
		<?php } ?>
</table>
<br><br>
<?php } ?>

<?php } ?>  
<br><br><br><br><br><br>
  
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

});
</script>
</body>
</body>
 
</html>