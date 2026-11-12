<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m=mysql_query("select  * from ujian where id='$_SESSION[id_ujian]'");   
$d=mysql_fetch_array($m);

    $right_answer=0;
    $wrong_answer=0;
    $unanswered=0; 
   $keys=array_keys($_POST);
   $order=join(",",$keys);
     $nilai_akhir=0;

   $sql = array(); 
   
   
if($_POST[jenis]=="essay"){
$response=mysql_query("select * from bank_soal where id='$_POST[id]' and id_ujian='$d[id]' ")   or die(mysql_error());

}
else if($_POST[jenis]=="multi"){
$response=mysql_query("select * from bank_soal where id='$_POST[id]' and id_ujian='$d[id]' ")   or die(mysql_error());

}
else if($_POST[jenis]=="match"){
$response=mysql_query("select * from bank_soal where id='$_POST[id]' and id_ujian='$d[id]' ")   or die(mysql_error());

}
else {
$response=mysql_query("select id,kunci,point from bank_soal where id IN($order) and id_ujian='$d[id]' ORDER BY FIELD(id,$order)")   or die(mysql_error());
}
$jawaban_k=mysql_real_escape_string($_POST[jawab]);
$jawaban_kirim=$_POST[jawaban_kirim];
$jwb_ar=array();
foreach($jawaban_kirim as $jawabanku){
$jwb_ar[]=$jawabanku;
}


$jawabanku_multi=implode(",",$jwb_ar);

function plainText($text)
{
    $text = strip_tags($text);
    $text = trim(preg_replace(['/<[^>]*>/','/\s+/'],' ', $text));

    return $text;
}



   while($result=mysql_fetch_array($response)){
       //echo $_POST[$result['id']];
	   
	   
       if($_POST[jenis]=="essay"){
	   $kuncijwb_p=plainText($result[kunci]);
       $jwb_kirim=strtoupper($jawaban_k);
	    $jwb=$jawaban_k;
	   
	   $kuncijwb=strtoupper($kuncijwb_p);
	
	   }
	   else if($_POST[jenis]=="multi"){
	   	$jwb=$jawabanku_multi;

	   }
	   else {
       $kuncijwb=strtoupper($result[kunci]);
       $jwb_kirim=$_POST[$result['id']];
	    $jwb=$_POST[$result['id']];

	   }
	   
	   if($_POST[jenis]=="multi"){
		
		//mencari nilai
		$total_multi=0;
		$jumlah_jawab_multi=0;
		$kunci_multi=explode(",",$result[kunci]);
		$hasil_jawaban=explode(",",$jawabanku_multi);
		
		$jum_kunci=count($kunci_multi);
		$jum_jwb=count($hasil_jawaban);
		foreach($hasil_jawaban as $ljawaban){
		$jumlah_jawab_multi++;
		$nilai_multi=0;
		foreach($kunci_multi as $lkunci){
		
		if($ljawaban==$lkunci){
	    $nilai_multi=$nilai_multi+1;
		
		}
		else {
		$nilai_multi=$nilai_multi+0;
		}
		}
		$total_multi=$total_multi+$nilai_multi;
		
		
		}
		
		$jum_kunci=0;
		foreach($kunci_multi as $knc){
		if(!empty($knc)){
		$jum_kunci++;
		}
		
		}
		
		$jum_jwb=0;
		foreach($hasil_jawaban as $jnc){
		if(!empty($jnc)){
		$jum_jwb++;
		} 
		
		}		
		
		if($jumlah_jawab_multi>0){
		if($jum_jwb>$jum_kunci){
		$b="S";
		$p=0;
		}
		else if($total_multi>=1){
		$b="B";
		if($total_multi>=2){
		$p=2;
		}
		else if($total_multi<2){
		$p=1;
		}
		else {
		$p=0;
		}
		
		}
        else {
		$b="S";
		$p=0;
		}			
		}
		else {
		$b="K";
		$p=1;
		}
	   }
	   
	   else if($_POST[jenis]=="match"){
		include"../../inc/fungsi.php";
		//mencari nilai
	
		$hasil_jawaban=explode(",",$jawabanku_multi);
		
		$benar_match=0;
		$salah_match=0;
		$hasil_jawaban_opsi_match=array();
		foreach($_POST[id_opsi_match] as $id_opsi_match){
		$opsi_match=$_POST['jawaban_match'.$id_opsi_match];
		$hasil_jawaban_opsi_match[]="$id_opsi_match=$opsi_match";
		
		 $mo=mysql_query("SELECT * from bank_opsi  where 1 and id_ujian='$_SESSION[id_ujian]' and 
		 id_soal='$result[id]' and id='$id_opsi_match'");   
         $rowo=mysql_fetch_array($mo);
		
		$jwb_number=alpha_to_number("$opsi_match");		
		if($jwb_number==$rowo[kunci]){
		$benar_match=$benar_match+1;
		$salah_match=$salah_match+0;
		}
		else {
		$benar_match=$benar_match+0;
		$salah_match=$salah_match+0;
		}
		 
		 
		 echo"opsi_match $opsi_match $jwb_number <br>";
		
		
		
		}
		
		$p=$benar_match;
		$s=$salah_match;
		
		$save_opsi_match=implode("||",$hasil_jawaban_opsi_match);
	   }
	   else {
	   if($kuncijwb==$jwb_kirim){
               $right_answer++;
               $b="B";
			   $p=1;
			   $s=0;
       }
	   else if($jwb_kirim==""){
               $unanswered++;
               $b="K";
			   $p=0;
			   $s=1;
           }
           else{
               $wrong_answer++;
               $b="S";
			   $p=0;
			   $s=1;
           }
		   
	   } 
	   
	   
	   
	   
	    if($_POST[jenis]=="essay"){
	 
	    $jawabann_save=$jwb;
	   
	
	   }
	   else if($_POST[jenis]=="multi"){
	   	$jwb=$jwb;

	   }
	   else if($_POST[jenis]=="match"){
	   	$jwb=$save_opsi_match;

	   }
	   else {
	    $jwb=$jwb;

	   }
	   
	   
	   
           $nilai=$right_answer*$result[point];
        
$cek=mysql_fetch_array(mysql_query("select * from hasil_opsi where nis='$_SESSION[nis]' and 
id_ujian='$_SESSION[id_ujian]' and id_soal='$result[id]'"));
if(empty($cek[id])){
$save_ins=mysql_query("insert into hasil_opsi (id_ujian,nis,opsi,id_soal,hasil_benar,ip,timestmp,point,jenis) 
values('$_SESSION[id_ujian]','$_SESSION[nis]','$jwb','$result[id]','$b','$ip',NOW(),'$p','$_POST[jenis]')") or die("gagal save 1".mysql_error()); 
} 
else if(!empty($cek[id])) {          
$upd=mysql_query("update hasil_opsi set opsi='$jwb',id_soal='$result[id]',hasil_benar='$b',ip='$ip',timestmp=NOW(),point='$p'
                 where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' and id_soal='$result[id]'") or die("gagal save 2".mysql_error());    
}
else {
}
echo"$_POST[no_soal]";







    

   }
?>