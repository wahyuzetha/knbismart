<?php
include "koneksi.php";
function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}

function ambil_ip() {
foreach (array('HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'REMOTE_ADDR', 'HTTP_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED') as $key) {
    if (array_key_exists($key, $_SERVER) === true) {
      foreach (explode(',', $_SERVER[$key]) as $ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
          return $ip;
        }
      }
    }
  }
}
$ip = ambil_ip();
$username = anti_injection($_POST['username']);
$pass     = anti_injection(md5($_POST['password']));

$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
 

$login=mysql_query("SELECT * FROM users WHERE username='$username'");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);
    
$p=md5($pengacak.md5($pass).$pengacak);

// Apabila username dan password ditemukan
if (md5($pengacak.md5($pass).$pengacak) == $r['password'])
{

  session_start();
  

  $_SESSION[levelu]     = $r[level];
  $_SESSION[id_user]     = $r[id];
  $_SESSION[id_pengguna]     = $r[id_pengguna];
    
   if($r[level]==1){    
      $_SESSION[namauser] = $r[username];
     
    
   }
   else if($r[level]==2 ){    
      $_SESSION[namauser] = $r[id_pengguna];
        $lh=mysql_query("SELECT jabatan.jenis_jab,jabatan.kode_jab,guru.* from guru,jabatan
WHERE guru.id_jabatan=jabatan.id and guru.nik='$_SESSION[namauser]'");
    $gh=mysql_fetch_array($lh);
    $_SESSION[jabatan_guru]= $gh[kode_jab];
    $_SESSION[teacher_id_se]= $gh[teacher_id];
	$someArray = json_decode($gh[penyelenggara_ujian], true);
	$lokasi_ar=array();
	foreach($someArray as $jurusanku) { 
	$lokasi_ar[]=$jurusanku;
	}
	$pilj=implode(",",$lokasi_ar);
    $_SESSION[penyelenggara_ujians]= $pilj;
    
   }
   else if($r[level]==3){    
	  $_SESSION[namauser] = $r[id_pengguna];

    
   } 
  
  $tgl_s=date('Y-m-d');
    $log=mysql_query("insert into log_aktifitas(nama_log,timestmp,ip,id_user,device,tanggal,id_materi,id_ujian,id_bank_soal,id_perangkat,id_pembelajaran)
values('Login Aplikasi',NOW(),'$ip','$r[id_pengguna]','$_SERVER[HTTP_USER_AGENT]','$tgl_s','','','','','')") or die("gagal".mysql_error());
  
  $_SESSION[login_ujianonline] = 1;
    	$m2peng=mysql_query("select  * from pengaturan where id='1'");
	$dm2peng=mysql_fetch_array($m2peng);



if($_SESSION[levelu]==1){    

  header('Location: ../apps/dashboard/data');
}
else if($_SESSION[levelu]==3){    
  
  $cak=mysql_query("SELECT * FROM siswa WHERE nis='$r[id_pengguna]'");
$dcak=mysql_fetch_array($cak);
$kelas_all=$dcak[kelas];
	

	$split=$dm2peng[split_import];
	
	$data_kelas_all = explode("$split" , $kelas_all);
	
	$tingkat_kelas_all=$data_kelas_all[0];
	$jurusan_kelas_all=$data_kelas_all[1];
	
	
	
	
//if($dcak[aktif]==2){
 // header('Location: ../login?h=nonaktif');
 
//}

//else {
	if(!empty($dm2peng[tingkat])){
/*	$ct=mysql_query("select  * from pengaturan where tingkat='$tingkat_kelas_all'");
	$dct=mysql_num_rows($ct);
	echo"select  * from pengaturan where tingkat='$tingkat_kelas_all'";
	if($dct<1){
	  header('Location: ../login?h=salah_server&p=SERVER HANYA UNTUK TINGKAT XI');
	}*/
	//else {
		 //echo"sukses";
		 header('Location: ../apps/dashboard/data_siswa');

//	}
	}
//}	
}

    else {
    header('Location: ../apps/dashboard/data');   
    }
}
else{
    
  header('Location: ../login?h=gagal');
}

?>
