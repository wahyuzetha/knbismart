<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
ini_set('max_execution_time', 0);

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set("Asia/Bangkok");
$id_ujian = anti_injection($_GET['id_ujian']);
$nis = anti_injection($_GET['nis']);
$wmulai = anti_injection($_GET['wmulai']);
$ulangi = anti_injection($_GET['ulangi']);

$_SESSION[id_ujian] = $id_ujian;
$_SESSION[nis] = $nis;
$_SESSION[nama_pembelajaran] = $_GET[nmpembelajaran];
$_SESSION[nama_ujian] = $_GET[nmujian];
$_SESSION[id_ujian_pembelajaran]=$_GET[idpembelajaran];
$log_ujian=$_GET[logujian];

if($_GET[acak_soal]==1){
    $acak_soal="order by rand()";
}
else {
    $acak_soal="order by id asc";
}

if($ulangi=="ss"){
$qrc=mysql_query("delete from hasil_jwb where nis='$_SESSION[id_pengguna]' and id_ujian='$id_ujian'");
$qrc2=mysql_query("delete from hasil_opsi where nis='$_SESSION[id_pengguna]' and id_ujian='$id_ujian'");


}

$cek_ujian=mysql_query("select  * from ujian where id='$id_ujian'");   
$dcek_ujian=mysql_fetch_array($cek_ujian);

if($dcek_ujian[jumlah_soal_keluar_pilgan]>0){
$limit_pilgan="limit $dcek_ujian[jumlah_soal_keluar_pilgan]";
}
else {
$limit_pilgan="";

}

if($dcek_ujian[jumlah_soal_keluar_multiple]>0){
$limit_multiple="limit $dcek_ujian[jumlah_soal_keluar_multiple]";
}
else {
$limit_multiple="";

}


if($dcek_ujian[jumlah_soal_keluar_matching]>0){
$limit_matching="limit $dcek_ujian[jumlah_soal_keluar_matching]";
}
else {
$limit_matching="";

}


if($dcek_ujian[jumlah_soal_keluar_essay_auto]>0){
$limit_essay_auto="limit $dcek_ujian[jumlah_soal_keluar_essay_auto]";
}
else {
$limit_essay_auto="";

}


$c_hsil=mysql_query("select  * from hasil_jwb where id_ujian='$id_ujian' and nis='$nis'");   
$dc_hsil=mysql_fetch_array($c_hsil);

if($dc_hsil[status]==3){
	header('Location: hasil_jwb?d='.$id_ujian.'&d2='.$nis);
}
if(empty($log_ujian)){
    $qr=mysql_query("insert into log_masuk_ujian (id_ujian,nis,timestmp,ip,waktu_save,jumlah,jumlah_asli) 
    values('$id_ujian','$nis',NOW(),'$ip','$wmulai','1','1')") or die("gagal save".mysql_error());
}
else {
    
    if($_GET[logwsave]==$wmulai){
        
    }
    else {
     $qr=mysql_query("update log_masuk_ujian set jumlah=jumlah+1,jumlah_asli=jumlah_asli+1,ip='$ip',waktu_save='$wmulai',
	 timestmp=NOW() where nis='$nis' and id_ujian='$id_ujian'");
    }
    
}
     
//cek hasil jwb
$startTime = date("Y-m-d H:i:s");
$tgl_ini=date('Y-m-d');

$waktu_ujian_start=date('H:i:s');
$waktu_selesai_ujian=date('H:i:s',strtotime('+'.$_GET[lama_ujian].' seconds',strtotime($startTime)));





if(empty($dc_hsil[id])){
	$sql = array(); 
	$response=mysql_query("select  * from bank_soal where id_ujian='$id_ujian' and 
	(jenis='' or jenis is null) $acak_soal $limit_pilgan");   
	$jum_soal=mysql_num_rows($response);   

     while($result=mysql_fetch_array($response)){
      
    $sql[] = $result[id];


   }
   
   $c=implode(',', $sql);
   
   
   $sql3 = array(); 
	$response3=mysql_query("select  * from bank_soal where id_ujian='$id_ujian' and jenis='multi' $acak_soal $limit_multiple");   
	$jum_soal3=mysql_num_rows($response3);   

     while($result3=mysql_fetch_array($response3)){
      
    $sql3[] = $result3[id];


   }
   
   if($jum_soal3>0){
   $c3=implode(',', $sql3);
   if(empty($c)){
   $cmulti="$c3";
   }
   else {
   $cmulti=",$c3";
   }
   }
   
   
   
   $sql2 = array(); 
	$response2=mysql_query("select  * from bank_soal where id_ujian='$id_ujian' and jenis='essay' $acak_soal $limit_essay_auto");   
	$jum_soal2=mysql_num_rows($response2);   

     while($result2=mysql_fetch_array($response2)){
      
    $sql2[] = $result2[id];


   }
   
   if($jum_soal2>0){
   $c2=implode(',', $sql2);
   if(empty($c)){
   $cessay="$c2";
   }
   else {
   $cessay=",$c2";
   }
   }
   


  $sql4 = array(); 
  $jml_soal_match=0;
  $opsi_matching_ark=array();
	$response4=mysql_query("select  * from bank_soal where id_ujian='$id_ujian' and jenis='match' $acak_soal limit 1");   
	$jum_soal4=mysql_num_rows($response4);   
	
	echo"tes";
     while($result4=mysql_fetch_array($response4)){
    
	
    $sql4[] = $result4[id];
	
	$soal_match_qr=array();
	$response4s=mysql_query("select * from bank_opsi where id_ujian='$id_ujian' and
	id_soal='$result4[id]' $limit_matching ");   
	$jum_soal4sn=mysql_num_rows($response4s);
	while($jum_soal4s=mysql_fetch_array($response4s)){
	$soal_match_qr[]=$jum_soal4s[id];
    
	 }
	 $soal_match_qrs=implode(",",$soal_match_qr);
	// echo"$soal_match_qrs";
	  $opsi_matching_ark[]=$soal_match_qrs;
	$jml_soal_match=$jml_soal_match+$jum_soal4sn;
   
   }
   
   	 $opsi_matching_ar=implode("",$opsi_matching_ark);
	//echo"$opsi_matching_ar $jml_soal_match";
   
   if($jum_soal4>0){
   $c4=implode(',', $sql4);
   if(empty($c)){
   $cmatch="$c4";
   }
   else {
   $cmatch=",$c4";
   }
   }

   $qr=mysql_query("insert into hasil_jwb (id_ujian,nis,waktu_mulai,waktu_selesai,tanggal,ip,pengacak,jml_soal,jml_soal_essay,jml_soal_multi,jml_soal_match,matching_opsi_ar) 
    values('$id_ujian','$nis','$waktu_ujian_start','$waktu_selesai_ujian','$tgl_ini','$ip','$c $cmulti $cessay $cmatch','$jum_soal','$jum_soal2','$jum_soal3','$jml_soal_match','$opsi_matching_ar')") or die("gagal save".mysql_error());
}

else if(!empty($dc_hsil[id]) and $dc_hsil[komentar]==1){   
    $qr=mysql_query("update hasil_jwb set 
							waktu_mulai='$waktu_ujian_start',
							waktu_selesai='$waktu_selesai_ujian',
							komentar=''
							where id_ujian='$id_ujian' and 
							nis='$nis'") or die("gagal save".mysql_error());
	}
	
else {
   
    }
    
if(!empty($dc_hsil[waktu_selesai])){
    $selesai_ujian=$dc_hsil[waktu_selesai];
}
else {
    $selesai_ujian=$waktu_selesai_ujian;

}



if($qr){
header('Location: soal?sisa_jam='.$sisa_jam.'&acak_soal='.$_GET[acak_soal].'&acak_jwb='.$_GET[acak_jwb].'&wmulai='.$_GET[wmulai]);
}
?>


