
   <html>
<head>
<title>Save</title>
<link rel="stylesheet" type="text/css" href="../../plugins/sweetalert/sweetalert.css">
<script type="text/javascript" src="../../plugins/sweetalert/sweetalert.min.js"></script>
</head>
<body>

<?php 

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include"../../inc/meta.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
ini_set('date.timezone', 'Asia/Jakarta');
$tgl=date("Ymdhis");

$id_tugas = anti_injection($_POST['id_tugas']);
$id_pembelajaran = anti_injection($_POST['id_pembelajaran']);
$isi = mysql_real_escape_string($_POST['isi']);

$file_lama = anti_injection($_POST['file_lama']);

$img=$_POST[img];
$tgl=date("Ymd");
    $time=time("h:i:sa");
    

/*

$namaFile = $_FILES['jfile']['name'];

if(!empty($namaFile)){

$namaSementara = $_FILES['jfile']['tmp_name'];
$dirUpload = "../../tugas/";

// pindahkan file
$namefiles="$tgl$time$namaFile";
$namefiles=str_replace(" ","",$namefiles);
$terupload = move_uploaded_file($namaSementara, $dirUpload.$namefiles);

if ($terupload) {
  $jfile=$namefiles;
}

}
*/

 $countfiles = count($_FILES['jfile']['name']);
 $dirUpload = "../../tugas/";
               $jfile_ar=array();

 // Looping all files
 for($i=0;$i<$countfiles;$i++){
   
   
   $namaSementara = $_FILES['jfile']['tmp_name'][$i];
 $path_parts = pathinfo($_FILES["jfile"]["name"][$i]);
$extension = $path_parts['extension'];

// pindahkan file
$namefiles="$i$tgl$time$_SESSION[namauser]_$i.$extension";
$namefiles=str_replace(" ","",$namefiles);
$terupload = move_uploaded_file($namaSementara, $dirUpload.$namefiles);
if ($terupload) {

$jfile_ar[]=$namefiles; 
} 
     
 }

$hasil_file=implode(",",$jfile_ar);

if(!empty($hasil_file) and !empty($file_lama)){
$jfile="$file_lama,$hasil_file";                
}
else if(!empty($hasil_file) and empty($file_lama)){
$jfile="$hasil_file";                

}
else {
    $jfile="$file_lama";                

}
     $tgl_s=date('Y-m-d');
     $his_jam=date('H:i:s');
 $dm=mysql_query("select  * from hasil_jwb_tugas where nis='$_SESSION[namauser]' and id_tugas='$id_tugas' and id_pembelajaran='$id_pembelajaran'");   
                $dcek=mysql_fetch_array($dm);
 if(!empty($dcek[id])){
 $q=mysql_query("update  hasil_jwb_tugas set jawaban='$isi',jfile='$jfile',tanggal='$tgl_s',jam='$his_jam',timestmp=NOW(),ip='$ip' 
                where nis='$_SESSION[namauser]' and id_tugas='$id_tugas' and id_pembelajaran='$id_pembelajaran'") or die("gagal".mysql_error());
    
 }   
 else {
$q=mysql_query("INSERT INTO hasil_jwb_tugas(id_pembelajaran,id_tugas,jawaban,jfile,tanggal,jam,timestmp,ip,nis) 
                                 
                         VALUES('$id_pembelajaran','$id_tugas','$isi','$jfile','$tgl_s','$his_jam',NOW(),'$ip','$_SESSION[namauser]')") or die("gagal".mysql_error());
}
$lastd=mysql_insert_id();
 if($q) {
  header('Location: detail_tugas_2?d='.$id_tugas.'&id_pembelajaran='.$id_pembelajaran); 
} 
?>
</body>
</html>
