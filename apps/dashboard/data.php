<?php 
session_start();
if($_SESSION['levelu']==3){
	header('Location: data_siswa');
	echo "<script>window.location = 'data_siswa';</script>";
    exit;
}
else {
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/hari.php";

if(isset($_SESSION['namauser'])){
  $queryus = mysql_query("SELECT * from users where username='$_SESSION[namauser]'");
  $duser=mysql_fetch_array($queryus);
  
  if(empty($dcek['token_notif']) and !empty($_SESSION['token_id'])){
      $upd=mysql_query("update users set token_notif='$_SESSION[token_id]' where username='$_SESSION[namauser]'");
  }
  else if(!empty($dcek['token_notif'])){
      if($dcek['token_notif'] != $_SESSION['token_id']){
          $upd=mysql_query("update users set token_notif='$_SESSION[token_id]' where username='$_SESSION[namauser]'");
      }
  }
}
             
$lh=mysql_query("SELECT guru.*,jabatan.jenis_jab from guru LEFT JOIN jabatan on guru.id_jabatan=jabatan.id where guru.nik='$_SESSION[namauser]'");
$gh=mysql_fetch_array($lh);

$kls=mysql_query("SELECT * from kelas where tahun_ajaran='$tahun_aktif' and wali='$_SESSION[namauser]'");
$dkls=mysql_fetch_array($kls);
$_SESSION['jpantaus']="";

// Quick metrics for Administrator
if($_SESSION['levelu']==1){
    $q_siswa = mysql_query("SELECT count(*) as jml from siswa");
    $d_siswa = mysql_fetch_array($q_siswa);

    $q_guru = mysql_query("SELECT count(*) as jml from guru");
    $d_guru = mysql_fetch_array($q_guru);

    $q_soal = mysql_query("SELECT count(*) as jml from bank_soal");
    $d_soal = mysql_fetch_array($q_soal);

    $q_materi = mysql_query("SELECT count(*) as jml from materi");
    $d_materi = mysql_fetch_array($q_materi);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<?php include "../../inc/meta.php"; ?>
<link href='../../css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link href="../../css/modern-admin.css?v=<?php echo time(); ?>" rel="stylesheet" type='text/css'>

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
         
        if (detik<10){ second='0'+detik; }
        if (menit<10){ minute='0'+menit; }
        if (jam<10){ hour='0'+jam; }
        waktu = hour+':'+minute+':'+second;
         
        var el = document.getElementById("clock");
        if(el) { el.innerHTML = waktu; }
        detik++;
    }
    setInterval(clock,1000);
</script>
</head>

<?php include "../../inc/nav.php"; ?>

<section>
    <!-- Left Sidebar -->
    <?php include "../../inc/sidebar.php"; ?>    
    <!-- #END# Left Sidebar -->

    <section class="content">
        <div class="container-fluid" style="padding-top: 10px;">

            <?php
			if($_SESSION['levelu']==1){
				$jab="Administrator Master";
                $nama_tampil = !empty($gh['nama']) ? $gh['nama'] : 'Administrator';
			}
			else {
				$jab = !empty($gh['jenis_jab']) ? $gh['jenis_jab'] : 'Tenaga Pendidik / Guru';
                $nama_tampil = $gh['nama'];
			}
            
            if(!empty($dkls['id'])){
                $_SESSION['wali_kelas']=$dkls['nama_kelas'];
                $_SESSION['wali_tingkat']=$dkls['tingkat'];
            }
			$t_skrng=$tanggal_pelajaran_aktif_s;
			$tgl_k=date('d/m/Y', strtotime($t_skrng));
            ?>

            <!-- 1. MODERN HERO GREETING BANNER -->
            <div class="modern-hero-card">
                <div class="row" style="margin-bottom: 0;">
                    <div class="col-md-8 col-sm-12">
                        <div class="hero-welcome-badge">
                            <span class="dot"></span>
                            <span>Portal Pembelajaran Terpadu</span>
                        </div>
                        <h2 class="hero-user-name">
                            Selamat Datang, <?php echo $nama_tampil; ?>!
                        </h2>
                        <div class="hero-meta">
                            <span class="hero-pill"><i class="material-icons" style="font-size: 15px;">verified_user</i> <?php echo $jab; ?></span>
                            <span class="hero-pill"><i class="material-icons" style="font-size: 15px;">date_range</i> TA: <?php echo $tahun_aktif; ?> (<?php echo $semester_aktif; ?>)</span>
                            <?php if(!empty($dkls['id'])){ ?>
                            <span class="hero-pill"><i class="material-icons" style="font-size: 15px;">meeting_room</i> Wali Kelas <?php echo $dkls['nama_kelas']; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="hero-clock-box pull-right">
                            <div class="hero-clock-date"><?php echo $tgl_k; ?></div>
                            <div class="hero-clock-time" id="clock"><?php echo date('H:i:s'); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. EXECUTIVE METRIC KPI CARDS (ADMIN ONLY) -->
            <?php if($_SESSION['levelu'] == 1){ ?>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="stat-card-modern">
                        <div class="stat-card-info">
                            <div class="stat-value"><?php echo number_format($d_siswa['jml'], 0, ',', '.'); ?></div>
                            <div class="stat-label">Siswa Terdaftar</div>
                        </div>
                        <div class="stat-card-icon stat-icon-emerald">
                            <i class="material-icons">school</i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="stat-card-modern">
                        <div class="stat-card-info">
                            <div class="stat-value"><?php echo number_format($d_guru['jml'], 0, ',', '.'); ?></div>
                            <div class="stat-label">Tenaga Pendidik</div>
                        </div>
                        <div class="stat-card-icon stat-icon-blue">
                            <i class="material-icons">badge</i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="stat-card-modern">
                        <div class="stat-card-info">
                            <div class="stat-value"><?php echo number_format($d_soal['jml'], 0, ',', '.'); ?></div>
                            <div class="stat-label">Bank Soal CBT</div>
                        </div>
                        <div class="stat-card-icon stat-icon-purple">
                            <i class="material-icons">quiz</i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="stat-card-modern">
                        <div class="stat-card-info">
                            <div class="stat-value"><?php echo number_format($d_materi['jml'], 0, ',', '.'); ?></div>
                            <div class="stat-label">Materi Pembelajaran</div>
                        </div>
                        <div class="stat-card-icon stat-icon-amber">
                            <i class="material-icons">menu_book</i>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <!-- 3. MODERN ACTION HUB (CATEGORIZED MENU GRID) -->
            
            <!-- KATEGORI A: AKADEMIK & MASTER DATA -->
            <div class="category-section-title">
                <i class="material-icons">tune</i> Manajemen Akademik & Data Pokok
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/dashboard/jadwal" class="modern-action-card">
                        <div class="card-icon-container grad-emerald">
                            <i class="material-icons">schedule</i>
                        </div>
                        <div class="card-title-text">Jadwal Mengajar</div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/guru/data" class="modern-action-card">
                        <div class="card-icon-container grad-blue">
                            <i class="material-icons">groups</i>
                        </div>
                        <div class="card-title-text">Data PTK / Guru</div>
                    </a>
                </div>

                <?php if($_SESSION['jabatan_guru']!=11){ ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/siswa/data" class="modern-action-card">
                        <div class="card-icon-container grad-cyan">
                            <i class="material-icons">person_search</i>
                        </div>
                        <div class="card-title-text">Data Siswa</div>
                    </a>
                </div>
                <?php } ?>

                <?php if($_SESSION['levelu']==1 or $_SESSION['jabatan_guru']==7 or $_SESSION['jabatan_guru']==1){ ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/kelas/data" class="modern-action-card">
                        <div class="card-icon-container grad-indigo">
                            <i class="material-icons">meeting_room</i>
                        </div>
                        <div class="card-title-text">Data Kelas</div>
                    </a>
                </div>
                <?php } ?>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/pembelajaran/data" class="modern-action-card">
                        <div class="card-icon-container grad-purple">
                            <i class="material-icons">auto_stories</i>
                        </div>
                        <div class="card-title-text">Mata Pelajaran</div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/perangkat/data" class="modern-action-card">
                        <div class="card-icon-container grad-teal">
                            <i class="material-icons">folder_special</i>
                        </div>
                        <div class="card-title-text">Perangkat Ajar</div>
                    </a>
                </div>
            </div>

            <!-- KATEGORI B: PEMBELAJARAN & EVALUASI -->
            <div class="category-section-title">
                <i class="material-icons">cast_for_education</i> Pembelajaran, Tugas & CBT
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/materi/data_m" class="modern-action-card">
                        <div class="card-icon-container grad-amber">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <div class="card-title-text">Materi Belajar</div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/tugas/data_m" class="modern-action-card">
                        <div class="card-icon-container grad-pink">
                            <i class="material-icons">assignment_turned_in</i>
                        </div>
                        <div class="card-title-text">Tugas Siswa</div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/dashboard/jurnal_mengajar_s" class="modern-action-card">
                        <div class="card-icon-container grad-rose">
                            <i class="material-icons">edit_note</i>
                        </div>
                        <div class="card-title-text">Jurnal Mengajar</div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/ujian/data_m" class="modern-action-card">
                        <div class="card-icon-container grad-blue">
                            <i class="material-icons">quiz</i>
                        </div>
                        <div class="card-title-text">Ujian CBT</div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/ujian/data_m?jenis=p" class="modern-action-card">
                        <div class="card-icon-container grad-emerald">
                            <i class="material-icons">psychology</i>
                        </div>
                        <div class="card-title-text">Pengayaan</div>
                    </a>
                </div>

                <?php if($_SESSION['levelu']==1 or $_SESSION['jabatan_guru']==7 or $_SESSION['wali_kelas']!=''){ ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/raport/data" class="modern-action-card">
                        <div class="card-icon-container grad-purple">
                            <i class="material-icons">grade</i>
                        </div>
                        <div class="card-title-text">Nilai Raport</div>
                    </a>
                </div>
                <?php } ?>
            </div>

            <!-- KATEGORI C: MONITORING & INFORMASI -->
            <div class="category-section-title">
                <i class="material-icons">monitoring</i> Monitoring & Pusat Informasi
            </div>
            <div class="row">
                <?php if($_SESSION['levelu']==1 or $_SESSION['jabatan_guru']==7 or $_SESSION['wali_kelas']!='' or $_SESSION['jabatan_guru']==12 or ($_SESSION['levelu']==2 and $_SESSION['penyelenggara_ujians']!="null" and $_SESSION['penyelenggara_ujians']!="")){ ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/ujian/data_pantau_ujian" class="modern-action-card">
                        <div class="card-icon-container grad-rose">
                            <i class="material-icons">sensors</i>
                        </div>
                        <div class="card-title-text">Pantau Event Ujian</div>
                    </a>
                </div>
                <?php } ?>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/laporan/data" class="modern-action-card">
                        <div class="card-icon-container grad-blue">
                            <i class="material-icons">insights</i>
                        </div>
                        <div class="card-title-text">Monitor Ujian</div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/laporan/data_materi" class="modern-action-card">
                        <div class="card-icon-container grad-cyan">
                            <i class="material-icons">visibility</i>
                        </div>
                        <div class="card-title-text">Monitor Siswa</div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/laporan/aktifitas" class="modern-action-card">
                        <div class="card-icon-container grad-teal">
                            <i class="material-icons">history</i>
                        </div>
                        <div class="card-title-text">Monitor Guru</div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/laporan/data_tugas" class="modern-action-card">
                        <div class="card-icon-container grad-amber">
                            <i class="material-icons">fact_check</i>
                        </div>
                        <div class="card-title-text">Monitor Tugas</div>
                    </a>
                </div>

                <?php if(!empty($dkls['id'])){ ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/laporan/data?wali=<?php echo "$_SESSION[wali_kelas]"; ?>" class="modern-action-card">
                        <div class="card-icon-container grad-indigo">
                            <i class="material-icons">supervisor_account</i>
                        </div>
                        <div class="card-title-text">Wali Kelas</div>
                    </a>
                </div>
                <?php } ?>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="../../apps/informasi/data" class="modern-action-card">
                        <div class="card-icon-container grad-slate">
                            <i class="material-icons">campaign</i>
                        </div>
                        <div class="card-title-text">Pusat Informasi</div>
                    </a>
                </div>
            </div>

            <!-- 4. MODERN INFORMATION BOARD TABLE -->
            <div class="modern-table-box">
                <div class="modern-table-header">
                    <i class="material-icons">campaign</i>
                    <span>PAPAN PENGUMUMAN & INFORMASI TERKINI</span>
                </div>
                <div style="padding: 15px 20px;">
                    <table id='empTable' class='display dataTable table table-striped table-hover' style="width:100%">
                        <thead>
                            <tr> 
                                <th>Kategori & Isi Informasi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- 5. JADWAL MENGAJAR GURU (IF GURU) -->
            <?php
            if($_SESSION['levelu']!='1'){
            $tgl_ini=$tanggal_pelajaran_aktif_s;
            $tgl_besok=	date('Y-m-d', strtotime('+1 days', strtotime($tgl_ini))); 

            for($i=1;$i<=1;$i++){
                $tanggal_cari = ($i==1) ? $tgl_ini : $tgl_besok;
                $chari=date('D', strtotime($tanggal_cari));
                $thari=date('d/m/Y', strtotime($tanggal_cari));
                $hari_jadwal=hari_indo($chari);	
                
                $qhr=mysql_query("SELECT * from asc_daysdefs where name='".mysql_real_escape_string($hari_jadwal)."'");	
                $dhr=mysql_fetch_array($qhr);
            ?>
            <br>
            <div class="modern-table-box">
                <div class="modern-table-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff;">
                    <i class="material-icons" style="color: #fff;">event_note</i>
                    <span>Jadwal Mengajar <?php echo "$hari_jadwal, $thari"; ?></span>
                </div>
                <div style="padding: 15px 20px;">
                    <table width="100%" class='table table-bordered table-striped'>
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
                        pembelajaran.tahun_ajaran='$tahun_aktif' AND
                        pembelajaran.semester='$semester_aktif' and
                        pembelajaran.tingkat=kelas.tingkat
                        ");	
                        $djadwal=mysql_fetch_array($qjadwal);
                        
                        $qstatus=mysql_query("SELECT status_belajar.status,status_belajar.warna,status_mengajar.* 
                        from status_mengajar,status_belajar
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
                        
                        $nh = !empty($dstatus['id']) ? "" : "NOT";

                        if(!empty($djadwal['mapel'])){
                            if(empty($dstatus['status_belajar']) || $dstatus['status_belajar']=="0"){
                                $status_mengajar_guru="Belum Open";
                                $status_warna="red";
                                $kode_status=2; 
                                $kode_status_m=1; 
                                $furl="proses_belajar";
                            }
                            else {
                                $status_mengajar_guru=$dstatus['status'];
                                $status_warna=$dstatus['warna'];
                                $kode_status=$dstatus['status_belajar'] + 1; 
                                $kode_status_m=$dstatus['status_belajar'] + 1;
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
                        <td align="center" width="20%"><?php echo "$djam[starttime] <br><span class='badge bg-$status_warna'>$status_mengajar_guru</span>"; ?></td>
                        <td align="center" width="50%"><?php echo "<b>$djadwal[nama_kelas]</b> <br> $djadwal[mapel]"; ?></td>
                        <td>
                            <?php if(!empty($djadwal['nama_kelas'])){ ?>
                            <button type="button" class="btn bg-<?php echo $status_warna; ?> waves-effect" data-toggle="modal" data-target="#smallModal<?php echo "$i$j"; ?>"><i class="material-icons">launch</i> Detail</button>

                            <div class="modal fade" id="smallModal<?php echo "$i$j"; ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content" style="margin-top: 130px; border-radius: 16px; overflow: hidden;">
                                        <div class="modal-header bg-blue">
                                            <button type="button" class="btn bg-orange waves-effect pull-right" data-dismiss="modal"><i class="material-icons">close</i></button>                          
                                            <h4 class="modal-title" id="smallModalLabel"><?php echo "<b>$hari_jadwal $thari Pukul $djam[starttime] $djadwal[nama_kelas]</b> $djadwal[mapel]"; ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $qm=mysql_query("select materi.* from materi,pembelajaran where 
                                            pembelajaran.id=materi.id_pembelajaran and 
                                            materi.id_pembelajaran='$djadwal[id_pembelajaran]' and
                                            pembelajaran.tingkat='$djadwal[tingkat]' AND
                                            pembelajaran.nuptk='$_SESSION[namauser]' and
                                            materi.batas_tanggal<='$tanggal_cari' and 
                                            materi.id $nh IN(SELECT id_materi from status_mengajar WHERE 
                                            id_user='$_SESSION[namauser]' and 
                                            id_pembelajaran='$djadwal[id_pembelajaran]' and id_kelas='$djadwal[nama_kelas]') and 
                                            (materi.akses_kelas='null' or materi.akses_kelas='' or materi.akses_kelas like '%$djadwal[nama_kelas]%')
                                            order by materi.batas_tanggal desc");
                                            $dm=mysql_fetch_array($qm);
                                            echo !empty($dm['tema']) ? "Materi : <br> $dm[tema]" : "Belum Ada Materi";
                                            echo "<hr>";
                                            
                                            $nht = !empty($dstatus['id_tugas']) ? "" : "NOT";
                                            $ktt = ($nht=="NOT") ? " and tanggal<'$tanggal_cari' and id_tugas!='' and status_belajar='3'" : " and id_tugas!='' ";
                                            
                                            $qt=mysql_query("select tugas.* from tugas,pembelajaran where 
                                            pembelajaran.id=tugas.id_pembelajaran and 
                                            pembelajaran.nuptk='$_SESSION[namauser]' and 
                                            tugas.id_pembelajaran='$djadwal[id_pembelajaran]' and 
                                            pembelajaran.tingkat='$djadwal[tingkat]' AND
                                            tugas.tanggal_mulai<='$tanggal_cari' and 
                                            tugas.id $nht IN(SELECT id_tugas from status_mengajar WHERE 
                                            id_user='$_SESSION[namauser]' and 
                                            id_pembelajaran='$djadwal[id_pembelajaran]' and id_kelas='$djadwal[nama_kelas]' $ktt) and 
                                            (tugas.akses_kelas='null' or tugas.akses_kelas='' or tugas.akses_kelas like '%$djadwal[nama_kelas]%')
                                            order by tugas.tanggal_mulai desc");
                                            $dt=mysql_fetch_array($qt);
                                            echo !empty($dt['judul']) ? "Tugas : <br> $dt[judul]" : "Belum Ada Tugas";
                                            echo "<hr>";
                                            
                                            $nhtu = !empty($dstatus['id_ujian']) ? "" : "NOT";
                                            $kttu = " and tanggal<'$tanggal_cari' and id_ujian!='' and status_belajar='3'";
                                            
                                            $qj=mysql_query("select ujian.* from ujian,pembelajaran where 
                                            pembelajaran.id=ujian.id_pembelajaran and 
                                            pembelajaran.nuptk='$_SESSION[namauser]' and 
                                            ujian.id_pembelajaran='$djadwal[id_pembelajaran]' and 
                                            pembelajaran.tingkat='$djadwal[tingkat]' AND
                                            ujian.jenis_ujian!='1' and 
                                            ujian.waktu_mulai<='$tanggal_cari' and 
                                            ujian.id $nhtu IN(SELECT id_ujian from status_mengajar WHERE 
                                            id_user='$_SESSION[namauser]' and 
                                            id_pembelajaran='$djadwal[id_pembelajaran]' and id_kelas='$djadwal[nama_kelas]' $kttu) and 
                                            (ujian.akses_kelas='null' or ujian.akses_kelas='' or ujian.akses_kelas like '%$djadwal[nama_kelas]%')
                                            order by ujian.waktu_mulai desc");
                                            $dj=mysql_fetch_array($qj);
                                            echo !empty($dj['nama_ujian']) ? "Ujian : <br> $dj[nama_ujian]" : "Belum Ada Ujian";
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="<?php echo $furl; ?>" method="get" id="<?php echo "f$i$j"; ?>"> 
                                                <input type="hidden" name="id_pembelajaran" value="<?php echo $dm['id_pembelajaran']; ?>">
                                                <input type="hidden" name="id_materi" value="<?php echo $dm['id']; ?>">
                                                <input type="hidden" name="id_tugas" value="<?php echo $dt['id']; ?>">
                                                <input type="hidden" name="id_ujian" value="<?php echo $dj['id']; ?>">
                                                <input type="hidden" name="id_kelas" value="<?php echo $djadwal['nama_kelas']; ?>">
                                                <input type="hidden" name="status_belajar" value="<?php echo $kode_status; ?>">
                                                <input type="hidden" name="tanggal" value="<?php echo $tanggal_cari; ?>">
                                                <input type="hidden" name="jam" value="<?php echo $djam['starttime']; ?>">
                                                <input type="hidden" name="teacher_id" value="<?php echo $_SESSION['teacher_id_se']; ?>">
                                                <input type="hidden" name="classid" value="<?php echo $djadwal['id_class']; ?>">
                                                <input type="hidden" name="subject_id" value="<?php echo $djadwal['id_mapel']; ?>">
                                                <input type="hidden" name="days" value="<?php echo $dhr['days']; ?>">
                                                <input type="hidden" name="startime" value="<?php echo $djam['starttime']; ?>">
                                                
                                                <?php
                                                if(!empty($dm['id_pembelajaran'])){
                                                    $qwr=mysql_query("SELECT * from status_belajar where id='$kode_status_m'");	
                                                    $dqwr=mysql_fetch_array($qwr);

                                                    if(!empty($dstatus['status_belajar'])){
                                                        echo "<button type='submit' id='s$i$j' class='btn bg-green waves-effect'><i class='material-icons'>launch</i> Detail</button>";
                                                    } 
                                                    else {
                                                        $jam_aktif=$jam_aktif_server;
                                                        if($jam_aktif>=$jam_selesai_pelajaran_tutup){
                                                            echo "Sudah Lebih dari jam 16.00";
                                                        }
                                                        else {
                                                            echo "<button type='submit' id='s$i$j' class='btn bg-green waves-effect'><i class='material-icons'>launch</i> $dqwr[status]</button>";				
                                                        }
                                                    }
                                                }
                                                ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    </table>
                </div>
            </div>
            <br>
            <?php } } ?>  

            <br><br><br>
        </div>
    </section>
</section>

<?php include "../../inc/footerm.php"; ?>

<script type="text/javascript">
$(document).ready(function(){
    $('#empTable').DataTable({
        'processing': true,
        'serverSide': true,
        'ordering': false,
        'lengthChange': false,
        'searching': false,        
        'serverMethod': 'post',
        'ajax': {
            'url':'../../apps/informasi/table_info.php'
        },
        'columns': [
            { data: 'kategori' }
        ]
    });
});
</script>
</body>
</html>
<?php } ?>
