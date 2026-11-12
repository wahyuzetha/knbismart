<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/hari.php";

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

if(!empty($_GET[tingkat])){
$_SESSION[tingkat_pem]=$_GET[tingkat];
}
else {
$_SESSION[tingkat_pem]=$_SESSION[tingkat_pem];
}

if(!empty($_GET[tanggal])){
$tanggal=$_GET[tanggal];

}
else {
$tanggal=date('Y-m-d');

}
?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
  <script src="../../js/jquery-1.11.2.min.js"></script>

<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>
<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Guru yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".select2 option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
 </script>
</head>
<link href='../../css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                          
                          <h2>
                               Jadwal Mengajar  <?php echo"$_SESSION[tahun_ajaran_pem] $_SESSION[semester_pem]";?>
                            </h2>
                         </div>
                        <div class="body">
						<form action="jurnal_mengajar_s" method="GET">		
			<input type="hidden" value="<?php echo"1";?>" name="d">
          <div class="row">
		  <div class="col-md-2">
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
			  <div class="col-md-2">
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
			 
			 <?php
            if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1){
            ?>    
           <div class="col-md-3">
			  <div class="form-group form-float">
            <div class="form-line">
            <select class="form-control show-tick select2" name="nuptk"  style="width:100%">
            <option value="">-- Pilih Guru --</option>
            <?php
            $mp=mysql_query("select * from guru order by nama asc");
             
           
            while($dp=mysql_fetch_array($mp)){ 
            ?>      
          <option value="<?php echo"$dp[nuptk]";?>"><?php echo"$dp[nama]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>

			</div>
			<?php } ?>
			
			  <div class="col-md-2">
            <select class="form-control show-tick" name="status_m"  style="width:100%">
            <option value="">-- Semua--</option>

		 <option value="<?php echo"1";?>" <?php if($_GET[status_m]==1){ echo"selected"; }?>><?php echo"Belum Open";?></option>          
          <option value="<?php echo"2";?>" <?php if($_GET[status_m]==2){ echo"selected"; }?>><?php echo"Open";?></option>
          <option value="<?php echo"3";?>" <?php if($_GET[status_m]==3){ echo"selected"; }?>><?php echo"Close";?></option>

              
              </select>

			</div>
			
		   <div class="col-md-3">
		   <input type="date" name="tanggal" value="<?php echo"$tanggal";?>" class="form-control">
		   </div>
			</div>
			<div class="row">
			<div class="col-md-2">
             <select class="form-control show-tick"  name="tingkat">          
			 <option value="all">--Semua Tingkat--</option>
			 <?php
            $s2=mysql_query("select * from tingkat order by tingkat asc");
            while($sm2=mysql_fetch_array($s2)){ 
			if($_SESSION[tingkat_pem]==$sm2[tingkat]){
			$pilsk="selected";
			}
			else {
			$pilsk="";
			}	
				
            ?>      
          <option value="<?php echo"$sm2[tingkat]";?>" <?php echo"$pilsk";?>><?php echo"$sm2[tingkat]";?></option>

              <?php } ?>    
              </select>
            
			</div>
		   <div class="col-md-3">
		   <button class="btn btn-primary waves-effect k" type="submit"><i class="material-icons">search</i> Filter</button>
			</div>
			</div>
			</form>  			
            
  <button type="button" class="btn bg-green waves-effect" data-toggle="modal" data-target="#smallModal"><i class="material-icons">print</i> Cetak</button>

                    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-green">
                            <h4 class="modal-title bg" id="smallModalLabel">Cetak Jurnal</h4>
                        </div>
						<form action="cetak_jurnal_mengajar_s" method="get" target='_NEW'> 

                        <div class="modal-body">
                           Pilih Jenis Cetak
<div class="row">
<input type="hidden" class="form-control" name="nuptk" required="" aria-required="true" value="<?php echo"$_GET[nuptk]";?>">

<input type="hidden" class="form-control" name="status_m" required="" aria-required="true" value="<?php echo"$_GET[status_m]";?>">

<input type="hidden" class="form-control" name="tanggal" required="" aria-required="true" value="<?php echo"$_GET[tanggal]";?>">

			<div class="col-md-12">
           <input name="jenis" type="radio" id="radio_1" checked="" value="normal">
		   <label for="radio_1"> &nbsp;&nbsp; NORMAL</label>
		    <input name="jenis" type="radio" id="radio_2" value="pdf">
		   <label for="radio_2"> &nbsp;&nbsp;PDF </label>
		    <input name="jenis" type="radio" id="radio_3" value="excel">
		   <label for="radio_3">&nbsp;&nbsp; EXCEL</label>
		   </div>
		   </div>							
							
							</div>
                        <div class="modal-footer">
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
                   <button type="submit" class="btn btn-success waves-effect"><i class="material-icons">print</i> Cetak</button> 

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>		
 
<hr>			
                               <table id='empTable' class='display dataTable' style="width:100%">

                                        
                                    <thead class="bg-green">
                                        <tr>
                                           <!-- <th>NO</th>-->
                                            <th>GURU</th>
                                            <th>MAPEL</th>
                                            <th>TEMA</th>
                                            <th>KELAS</th>
                                            <th>TANGGAL</th>
                                            <th>WAKTU</th>
                                            <th>OPEN</th>
                                            <th>CLOSE</th>
                                            <th>DETAIL</th>

                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;
$chari=date('D', strtotime($tanggal));
$thari=date('d/m/Y', strtotime($tanggal));

$hari_jadwal=hari_indo($chari);	

if($_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1 or $_SESSION[levelu]==1){

if(!empty($_GET[nuptk])){
$gr=" and guru.nik='$_GET[nuptk]'";
}
else {
$gr="";
}

}
else {
$gr=" and guru.nik='$_SESSION[namauser]'";

}


if($_GET[status_m]>1){
$status_m="and status_mengajar.status_belajar='$_GET[status_m]' ";
}
else if($_GET[status_m]==1){
$status_m="and status_mengajar.status_belajar>'1' ";
}
else {
$status_m="and status_mengajar.status_belajar>'1' ";

}

if($_GET[tingkat]!="all"){
$tgkt=" and kelas.tingkat='$_GET[tingkat]'";
}
else {
$tgkt="";
}
//mencari hari
$qhr=mysql_query("SELECT * from asc_daysdefs where name='".mysql_real_escape_string($hari_jadwal)."'");	
$dhr=mysql_fetch_array($qhr);
 

          $m=mysql_query("SELECT pembelajaran.id as id_pembelajaran,guru.nik,guru.teacher_id,guru.nama,kelas.id_class,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
	from asc_cards,guru,kelas,asc_subjects,asc_lessons,pembelajaran
	WHERE 
	asc_lessons.id=asc_cards.lessonid AND
	asc_lessons.teacherids=guru.teacher_id AND
	asc_lessons.classids=kelas.id_class AND
	asc_lessons.subjectid=asc_subjects.id AND
	asc_subjects.id=pembelajaran.subjectid AND
	pembelajaran.teacher_id=guru.teacher_id and
	pembelajaran.tingkat=kelas.tingkat
 	$gr and
	asc_cards.days='$dhr[days]' AND
	asc_cards.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' AND
	asc_cards.semester='$_SESSION[semester_pem]' and
    pembelajaran.tahun_ajaran='$tahun_aktif' AND
	pembelajaran.semester='$semester_aktif'  $tgkt group by asc_lessons.classids,asc_lessons.teacherids,asc_lessons.subjectid
	ORDER BY asc_cards.days,guru.nama,asc_cards.period
	") or die("gagagl".mysql_error());   
      
            while($d=mysql_fetch_array($m)){ 
            $no++;     
			
			  $qstatus=mysql_query("SELECT status_belajar.status,status_belajar.warna,status_mengajar.* from status_mengajar,status_belajar
											where 
                                            status_belajar.id=status_mengajar.status_belajar and
											status_mengajar.subject_id='$d[id_mapel]' and
											status_mengajar.tanggal='$tanggal' and
											status_mengajar.id_kelas='$d[nama_kelas]' and
											status_mengajar.semester='$_SESSION[semester_pem]' and
											status_mengajar.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' 
											$status_m
											");	
			$dstatus=mysql_fetch_array($qstatus);
	
			$qm=mysql_query("select * from materi where id='$dstatus[id_materi]'");
			$dm=mysql_fetch_array($qm);
		/*	
   if(!empty($dstatus[id])){
	$nh="";
	}
	else {
	$nh="NOT";
	}
	*/
	
	if(!empty($dstatus[id])){
	$nh="";
	$sdhq=" and tanggal='$tanggal' and id_kelas='$d[nama_kelas]'";
	}
	else {
	$nh="NOT";
	$sdhq=" and tanggal='$tanggal' and id_kelas='$d[nama_kelas]'";
	}
			if($dstatus[status_belajar]==2 or $dstatus[status_belajar]==3){
			$open="<span style='color:green; font-weight:bold'>V</span>";
			$url="<br><a href='../dashboard/detail_open?id_pembelajaran=$dstatus[id_pembelajaran]&tanggal=$tanggal&id_kelas=$d[nama_kelas]&jam=$djam2[starttime]&id_materi=$dstatus[id_materi]&id_tugas=$dstatus[id_tugas]&id_ujian=$dstatus[id_ujian]&subject_id=$d[id_mapel]&teacher_id=$d[teacher_id]&classid=$d[id_class]'>Detail</a>";

			}
			else {
			$open="<span style='color:red; font-weight:bold'>X</span>";
				$url="<a href='../materi/data?d=$d[id_pembelajaran]'  style='color:red'>Detail</a>";
		
			}
			
			if($dstatus[status_belajar]==3){
			$close="<span style='color:green; font-weight:bold'>V</span>";
			}
			else {
			$close="<span style='color:red; font-weight:bold'>X</span>";
			}
			
			
			//if(!empty($dstatus[waktu_mengajar])){
			//	$waktu_status_m=$dstatus[waktu_mengajar];
			//}
			//else {
			 $qjadwal=mysql_query("SELECT asc_periods.starttime,asc_periods.endtime,guru.nik,guru.nama,kelas.id_class,kelas.tingkat,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
	from asc_cards,guru,kelas,asc_subjects,asc_lessons,asc_periods
	WHERE 
	asc_lessons.id=asc_cards.lessonid AND
	asc_lessons.teacherids=guru.teacher_id AND
	asc_lessons.classids=kelas.id_class AND
	asc_lessons.subjectid=asc_subjects.id AND
	asc_cards.period=asc_periods.period and
	asc_lessons.classids='$d[id_class]' and
	asc_cards.days='$dhr[days]' AND
	asc_cards.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' AND
	asc_cards.semester='$_SESSION[semester_pem]' and
	asc_lessons.teacherids='$d[teacher_id]' and 
	asc_lessons.subjectid='$d[id_mapel]' order by asc_periods.starttime asc
	");	
	$jno=0;
	$jam_k=array();
	$jam_k2=array();
	$jum_jadwal=mysql_num_rows($qjadwal);
	while($djadwal=mysql_fetch_array($qjadwal)){
	$jno++;
	if($jno==1){
	$jam_k[]=$djadwal[starttime];
	}
	
   if($jno === $jum_jadwal) {
    $jam_k2[]=$djadwal[endtime];
	}
	
	
	
	
	}
	$jam_mg1=implode("",$jam_k);
	$jam_mg2=implode("",$jam_k2);

	$waktu_status_m="$jam_mg1 sampai $jam_mg2";

	//}
	
	if(!empty($dm[tema])){
	$tema_m=$dm[tema];
	}
	else {
		/*
	 $qsudah=mysql_query("SELECT * from status_mengajar
											where 
											status_mengajar.subject_id='$d[id_mapel]' and
											status_mengajar.tanggal<'$tanggal' and
											status_mengajar.id_kelas='$d[nama_kelas]' and
											status_mengajar.semester='$_SESSION[semester_pem]' and
											status_mengajar.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and
											status_mengajar.teacher_id='$d[teacher_id]'
											and status_mengajar.status_belajar>'1'");	
	$dsudah=mysql_fetch_array($qsudah);
	*/
	
	  //cek materi
	   $qm=mysql_query("SELECT * from materi where id_pembelajaran='$d[id_pembelajaran]' 
	    and id $nh IN(SELECT id_materi from status_mengajar WHERE 
						id_user='$d[nik]' and 
						id_pembelajaran='$d[id_pembelajaran]' $sdhq) 
						and batas_tanggal<='$tanggal' order by batas_tanggal desc");	
	  $dqm=mysql_fetch_array($qm);
	  
	  
	  if(!empty($dqm[id])){
	  $tema_m="$dqm[tema]";
	  }
	  else {
	  $tema_m="Belum Ada Materi";
	  }
	
	}
	
			if(!empty($dm[id])){ $thros=$thari; } 
			
			$hsil="<tr>
                <td width='10%'>$d[nama]  </td>
                <td width='10%'>$d[mapel]</td>
                <td width='10%'>$tema_m</td>
                <td width='10%' align='center'>$d[nama_kelas]</td>
                <td width='10%' align='center'>$thros</td>
                <td width='10%' align='center'>$waktu_status_m</td>
                <td width='10%' align='center'>$open</td>
                <td width='10%' align='center'>$close</td>
				<td>$url</td>
				</tr>";
		
			if($_GET[status_m]==0){
			echo"$hsil";
			} 
			else if($_GET[status_m]==1){
				
				if(empty($dstatus[id])){ 
				echo"$hsil";
				}
				else {
				echo"";
				}
						
			}
			else if($_GET[status_m]>1){
				
				if(!empty($dstatus[id])){ 
				echo"$hsil";
				}
				else {
				echo"";
				}
						
			}
				
				


			} ?>                    
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
   <?php include"../../inc/footernojs.php";?></body>

<script>window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);

$('#empTable').DataTable( {
  "ordering": false
} );
//# sourceURL=pen.js
</script>

</html>