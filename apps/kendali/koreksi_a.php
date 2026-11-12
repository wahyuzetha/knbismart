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
ini_set('max_execution_time', 0);
		include"../../inc/fungsi.php";

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

function plainText($text)
{
    $text = strip_tags($text);
    $text = trim(preg_replace(['/<[^>]*>/','/\s+/'],' ', $text));

    return $text;
}


function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}

$id_ujian=anti_injection($_GET[id_ujian]);
$id_pembelajaran=anti_injection($_GET[id_pembelajaran]);
$ujian=mysql_fetch_array(mysql_query("select * from ujian where id='$id_ujian'"));


$empQuery = "SELECT * from hasil_jwb WHERE id_ujian='$id_ujian' ";
$empRecords = mysql_query($empQuery);
$data = array();

echo"Sistem koreksi ulang <hr>";

             	 
while ($row = mysql_fetch_assoc($empRecords)) {

$nilai_pilgan=0;
$nilai_essay_auto=0;
$nilai_multi_n=0;
$nilai_match=0;	
	
    $soal=mysql_fetch_array(mysql_query("select * from hasil_jwb where nis='$row[nis]' and id_ujian='$id_ujian'"));
echo"Nis $row[nis]  : <br>";
 $res = mysql_query("SELECT bank_soal.point as point_nilai,bank_soal.soal,bank_soal.kunci,hasil_opsi.* from hasil_opsi,bank_soal
                    WHERE bank_soal.id=hasil_opsi.id_soal and hasil_opsi.nis='$row[nis]'
                    and hasil_opsi.id_ujian='$id_ujian' and hasil_opsi.jenis!='essay_manual'") or die(mysql_error());
     while($result=mysql_fetch_array($res)){
         
         $kunci=strtoupper($result[kunci]);
	$jawaban_k=mysql_real_escape_string($result[opsi]);

	  if($ujian[bobot_persoal]==1){
        $point_nilai=$result[point_nilai];
            
        }
        else {
        $point_nilai=1;    
        }
		
		

         
		 
		if($result[jenis]=="essay"){
	   $kuncijwb_p=plainText($result[kunci]);
       $jwb_kirim=strtoupper($jawaban_k);
	    $jwb=$jawaban_k;
	   
	   $kuncijwb=strtoupper($kuncijwb_p);
		
		//	echo"Jenis Essay Manual kunci = $kuncijwb | jawaban $jwb_kirim<Br>";
	
		}
	   else if($result[jenis]=="multi"){
	   	$jwb=$result[opsi];
		
			//echo"multi $jwb<Br>";

	   }
	   else {
       $kuncijwb=strtoupper($result[kunci]);
       $jwb_kirim=$result[opsi];
	    $jwb=$result[opsi];

	   }
	   
	   
	   
	   if($result[jenis]=="multi"){
		
		/*
		if($result[opsi]==$result[kunci]){
		$b="B";
		$p=$point_nilai;
		}
		else {
		$b="S";
		$p=0;
		}
		echo"Jenis Multi point $p <br>";
		
		
$nilai_multi=$nilai_multi+$p;
		*/
		
		
		//mencari nilai
		$jawabanku_multi=$result[opsi];
		$total_multi=0;
		$salah_multi=0;
		$jumlah_jawab_multi=0;
		$kunci_multi=explode(",",$result[kunci]);
		$hasil_jawaban=explode(",",$jawabanku_multi);
		foreach($hasil_jawaban as $ljawaban){
		$jumlah_jawab_multi++;
		$nilai_multi=0;
		$n_salah_m=0;
		foreach($kunci_multi as $lkunci){
		
		if($ljawaban==$lkunci){
	    $nilai_multi=$nilai_multi+1;
		$n_salah_m=$n_salah_m+0;
		}
		else {
		$nilai_multi=$nilai_multi+0;
		$n_salah_m=$n_salah_m+1;
		}
		}
		$total_multi=$total_multi+$nilai_multi;
		$salah_multi=$salah_multi+$n_salah_m;
		
		}
		
		//echo"Benar $total_multi salah $salah_multi <br>";
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
		
//		echo"$result[kunci] jum_kunci $jum_kunci jum_jwb $jum_jwb <br>";
		
		
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
		}
		
		$nilai_multi_n=$nilai_multi_n+$p;
		}
	   
	   else if($result[jenis]=="match"){
		//mencari nilai
	
		$hasil_jawaban=explode("||",$result[opsi]);
		
		$benar_match=0;
		$salah_match=0;
		$hasil_jawaban_opsi_match=array();
		foreach($hasil_jawaban as $opsi_match_k){
		$pecah_jwbk=explode("=",$opsi_match_k);
		$id_opsi_match=$pecah_jwbk[0];
		$opsi_match=$pecah_jwbk[1];
		
		
		 $mo=mysql_query("SELECT * from bank_opsi  where 1 and id_ujian='$id_ujian' and 
		 id_soal='$result[id_soal]' and id='$id_opsi_match'");   
         $rowo=mysql_fetch_array($mo);
		
		$jwb_number=alpha_to_number("$opsi_match");		
		if($jwb_number==$rowo[kunci]){
    	$benar_match=$benar_match+$point_nilai;
		$salah_match=$salah_match+0;
		}
		else {
		$benar_match=$benar_match+0;
		$salah_match=$salah_match+0;
		}
		 
		 
		// echo"opsi_match $opsi_match $jwb_number <br>";
		
		
		
		}
		
		$p=$benar_match;
		$s=$salah_match;
		
		$save_opsi_match=implode("||",$hasil_jawaban_opsi_match);
		
		echo"Jenis Match $p <br>";
		
		$nilai_match=$nilai_match + $p;	


	   }
	   else if($result[jenis]=="essay"){
		//if($kuncijwb==$jwb_kirim){
	if(strstr($kuncijwb,$jwb_kirim)){
	
		$p=$point_nilai;


		}
	   else {
			   $p=0;
			  
           }
	echo"Jenis Essay singkat  $p - <br>";
	$nilai_essay_auto=$nilai_essay_auto+$p;

  
	  }
	   else {
		   
	   if($kuncijwb==$jwb_kirim){
        $p=$point_nilai;
		}
	   else{
             $p=0;
        }
		$nilai_pilgan=$nilai_pilgan+$p;
		  
		  echo"Jenis Pilgan  $p <br>";
 
	   } 
	   
	   
	   
	   
	
	   echo"update hasil_opsi set point='$p'    where nis='$row[nis]' and id_ujian='$id_ujian' and id_soal='$result[id_soal]' <hr>";
	   
         
        // echo" - $result[id_soal] = kunci $kunci hasil jwb =$result[opsi] <br>";
        $upd=mysql_query("update hasil_opsi set point='$p'
             where nis='$row[nis]' and id_ujian='$id_ujian' and id_soal='$result[id_soal]'") or die("gagal save 2".mysql_error());    

     }
	 
	 

if($ujian[bobot_persoal]==1){
$nilai_s=$nilai_pilgan;    
}   
else {
$nilai_s=$nilai_pilgan/$soal[jml_soal]*$ujian[skala];
}


echo"pilgan = $nilai_s <br>";




if($ujian[bobot_persoal]==1){

$nilai_sat=$nilai_essay_auto;
}
else {
 $nilai_sat=$nilai_essay_auto/$soal[jml_soal_essay]*$ujian[bobot_essay_auto];
  
}





//if($ujian[bobot_multiple]>0){

if($ujian[bobot_persoal]==1){

$nilai_multiple=$nilai_multi_n;

echo"multiple 1 $nilai_multiple <br>";
}
else {
	$jml_multi_n=$soal[jml_soal_multi];
	$nilai_multiple=$nilai_multi_n/$jml_multi_n;
    $nilai_multiple=$nilai_multiple*$ujian[bobot_multiple];
	echo"multiple 2 $nilai_multi_n/$jml_multi_n*$ujian[bobot_multiple] = $nilai_multiple <br>";

}

//}


//if($ujian[bobot_matching]>0){

//echo"match = $benar_match <br>";

if($ujian[bobot_persoal]==1){

$nilai_match_n=$nilai_match;
}
else {
$nilai_match_n=$nilai_match/$soal[jml_soal_match]*$ujian[bobot_matching];
    
}
//echo"$benar_match/$jml_soalat*$ujian[bobot_matching]";

//}

 
 

$n_akhir=$nilai_s+$nilai_sat+$nilai_multiple+$nilai_match+$row[nilai_essay];

$wkt=date('Y-m-d H:i:s');

echo"$nilai_s + $nilai_sat+$nilai_multiple+$nilai_match+$row[nilai_essay] = $n_akhir<br>

								
";

$upd=mysql_query("update hasil_jwb set
                                nilai='$nilai_s',
								benar='$nilai_pilgan',
                                nilai_essay_auto='$nilai_sat',
								benar_essay_auto='$nilai_essay_auto',
                                nilai_multi='$nilai_multiple',
								benar_multi='$nilai_multi_n',
                                nilai_match='$nilai_match',
								benar_match='$nilai_match_n'
                 where nis='$row[nis]' and id_ujian='$id_ujian'") or die("gagal save 2".mysql_error());    




	
	echo"<hr>";

}

//echo"a";
 

 if($upd) {
//	 echo"uod";
 	?>
	<script type="text/javascript">
swal({
  title: "Data Berhasil Di Koreksi ulang",
  icon: "success",
  showCancelButton: false,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "OK"
},
function(isConfirm) {
  if (isConfirm) {
window.location = "peserta?d=<?php echo"$id_ujian";?>";
  }
});
</script>

<?php 
} 
?>
</body>
</html>