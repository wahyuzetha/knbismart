<?php 

include "../../inc/koneksi.php";
include "../../inc/aman.php";



function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}


$field=$_POST[field];
$id_data=$_POST[id_data];
$id_komen=$_POST[id_komen];



$judul = addslashes($_POST['judul']);
if(!empty($_POST['img'])){

define('UPLOAD_DIR', '../../imgforum/');
    $img = $_POST['img'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $tgl=date("Ymd");
    $time=time("h:i:sa");
    $name=$_SESSION[namauser];
    $name = str_replace(' ', '_', $name);
    $namefoto="sub_$name$tgl$time.png";
    $file = UPLOAD_DIR . $namefoto;
    $success = file_put_contents($file, $data);
    
    $foto="$namefoto";
    $foto_h=$foto;
}
else {
    $foto=$_POST[foto_lama];
    $foto_h="";
}


$isi_d="$foto_h  <br><br> $_POST[download]<br>";
$isi=mysql_real_escape_string($isi_d);	

if(!empty($_POST[download])){
    $download=$_POST[download];
}
else {
    $download="";
}
$isi_d="$foto_h $download";
$isi=$isi_d;	

	

if(!empty($isi)){

$q=mysql_query("INSERT INTO koment_sub_forum($field,
								id_komen,
								 id_users,
								 timestmp,
								 ip,
								 komentar,
								 gambar,
								 file,
								 kelas,
								 tahun_ajaran) 
                                 
	                       VALUES('$id_data',
									'$id_komen',
								'$_SESSION[namauser]',
								 NOW(),
								 '$ip',
	                       		 '$_POST[isi]',
	                       		 '$foto_h',
	                       		 '$download',
	                       		 '$_SESSION[kelasku]',
	                       		 '$tahun_aktif')") or die("gagal".mysql_error());

}
else {
}
 
if($q) {
echo"sukses";
   if($_SESSION[levelu]==1 or $_SESSION[levelu]==2){
        $dm=mysql_query("select  * from materi where id='$id_data'");   
        $dmtr=mysql_fetch_array($dm);
     $tgl_s=date('Y-m-d');
    $log=mysql_query("insert into log_aktifitas(nama_log,timestmp,ip,id_user,device,tanggal,id_materi_diskusi,id_ujian,id_bank_soal,id_perangkat,id_pembelajaran)
values('Membalas Diskusi Materi $dmtr[judul] : $_POST[isi] di Kelas $_SESSION[kelasku]',NOW(),'$ip','$_SESSION[namauser]','$_SERVER[HTTP_USER_AGENT]','$tgl_s','$id_data','','','','$id')") or die("gagal".mysql_error());
   
} 
}
else {
} 
 
  