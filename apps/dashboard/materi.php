<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$id = anti_injection($_GET['d']);

$mk=mysql_query("select  * from pembelajaran where id='$id'");   
$dk=mysql_fetch_array($mk);
   

                
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
<?php include"../../inc/sidebar.php";?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    
    <section class="content">
        <h4>Materi <?php echo"$dk[pembelajaran]";?></h4>
        <hr>
        
      <div class="row clearfix">
         
    
            <!-- #END# Widgets -->
            <div class="container">
    <div class="row">
         <?php
         	$tgl_ini=date('Y-m-d H:i:s');
//	$jam_ini=date('H:i:s'); 
	$jam_ini="09:00"; 


          $m=mysql_query("SELECT materi.* from materi,status_mengajar
WHERE materi.id=status_mengajar.id_materi and 
status_mengajar.status_belajar>'1' and status_mengajar.id_kelas='$kelas_all' and 
materi.id_pembelajaran='$id' order by materi.id desc");   
        
            while($d=mysql_fetch_array($m)){
            $waktu="$d[batas_tanggal] $d[batas_jam]";
            if(!empty($d[foto])){
             $ft="<div class='col-xs-3 col-md-3 text-center'>
             <img src='../../images/$d[foto]' alt='$d[judul]' class='img-rounded img-responsive' />
             </div>";
             } 
             else {
             $ft="";
             }
			 
$hasil="<div class='col-md-6'>
            <div class='well well-sm'>
                <div class='row'>
                    $ft
                    <div class='col-xs-8 col-md-8 section-box'>
                             <a href='detail_materi?d=$d[id]&id_pembelajaran=$id'>
					<h4> $d[judul]
                            </a>
                        </h4>
                       
                        <hr />
                        
                </div>
            </div>
        </div>
        
        
        </div>";
    if($tgl_ini>$waktu){ 
     
    if($d[akses_siswa]=="null" and $d[akses_kelas]=="null"){
     echo"$hasil";
 
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
			    echo"$hasil";
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
			    echo"$hasil";
			}
    
    }
    else {
        echo"$hasil";
    }
    
   
    
     } }?>
           </div>
  </section>
   
<?php include"../../inc/footerm.php";?>

</body>

</html>