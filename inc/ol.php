<?php

include"koneksi.php";
$m2=mysql_query("select  * from pengaturan where id='1'");
$d2=mysql_fetch_array($m2);
if(isset($_POST["update_token"]))
{
	
	 $query = mysql_query("
  UPDATE users 
  SET token_firebase = '$_POST[token_user]' 
  WHERE id_pengguna = '$_SESSION[namauser]'");
  
   $query = mysql_query("
  UPDATE siswa 
  SET token_firebase = '$_POST[token_user]' 
  WHERE nis = '$_SESSION[namauser]'");

}
/*
 if($d2[buka_nilai]==4){
     echo"Fitur Di nonaktifkan untuk meringkankan beban server pada saat ujian";

 }
 else {

if(isset($_POST["action"]))
{
 if($_POST["action"] == "update_time")
 {
     $tgl=date("Y-m-d H:i:s");
  $query = mysql_query("
  UPDATE users 
  SET last_activity = '$tgl' 
  WHERE id_pengguna = '$_SESSION[namauser]'");
 
 }
 
 if($_POST["action"] == "fetch_data")
 {
      $query = mysql_query("SELECT * from users
  WHERE last_activity > DATE_SUB(NOW(), INTERVAL 5 SECOND)");
  
  $jum=mysql_num_rows($query);
  echo"<b style='color:red'>User Online $jum</b>";
    echo"<table id='empTable' class='display dataTable' style='width:100%'>
                                        <thead class='bg bg-green'>
                                       
                                        ";     
 
  if($jum<1){
      echo"<tr><td colspan='2'>Saat Ini Tidak Ada User Online</td></tr>";
  }
  else {
  
  while($data=mysql_fetch_array($query)){
 if($data[level]==2){
    $login=mysql_query("select * from guru where nik='$data[id_pengguna]'");
    $ketemu=mysql_fetch_array($login);
    $nama=$ketemu[nama];
    $foto=$ketemu[foto];
    $status="Guru";
   
 }
   else if($data[level]==3){
    $login=mysql_query("SELECT * from siswa where nis='$data[id_pengguna]'");
    $ketemu=mysql_fetch_array($login);
    $nama=$ketemu[nama]; 
    $foto=$ketemu[foto];
    $status="Siswa";
    $kelas="<br>Kelas $ketemu[kelas]";


   }
   
     if(!empty($foto)){
                    $ft="<img src='../../foto/$foto' width='70' height='70' />";
                    } 
                    else {
                    $ft="<img src='../../css/nopic.png' height='60' /> ";  
                    }
                   
   
 
 
  echo"<tr><td width='20%'>$ft</td> <td>$nama ($status)  $kelas</td></tr>";
 
  }
  
  echo"</table>";
  
 }
 }
 
}
}
*/
 ?>