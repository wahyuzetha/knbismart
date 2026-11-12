<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "excel_reader2.php";
include "akses.php";

ini_set('max_execution_time', 0);
ini_set('memory_limit', '128M');


function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
 
      $output = '';  
      if($_FILES['zip_file']['name'] != '')  
      {  
           $file_name = $_FILES['zip_file']['name'];  
           $array = explode(".", $file_name);  
           $name = $array[0];  
           $ext = $array[1];  
           if($ext == 'zip')  
           {  
                $path = $_SESSION[folder];  
                $location = $path . $file_name;  
                if(move_uploaded_file($_FILES['zip_file']['tmp_name'], $location))  
                {  
                     $zip = new ZipArchive;  
                     if($zip->open($location))  
                     {  
                          $zip->extractTo($path);  
                          $zip->close();  
                     }  
                     $files = scandir($path . $name);  
                     //$name is extract folder from zip file  
                     
                     unlink($location);  
                     rmdir($path . $name); 

//open manifest xml
$nama_xml="$path/imsmanifest.xml";

//cari file xml .dat					
$crixml = simplexml_load_file($nama_xml,'SimpleXMLElement', LIBXML_NOCDATA);
$nama_file=$crixml->resources->resource[file];
$nama_folder=$crixml->resources->resource[baseurl];

$nama_file_xml="$path/$nama_file";
$filexml = simplexml_load_file($nama_file_xml,'SimpleXMLElement', LIBXML_NOCDATA);

echo"$nama_file_xml ";
//print_r($filexml);





//mencari soal multiple choice
$no_soal=0;
foreach ($filexml->QUESTION_MULTIPLECHOICE as $soal_k) {
$no_soal++;
echo"$no_soal. ";  
$id_soalk=$soal_k;
$id_soal=$id_soalk[id];

echo"id_soal $id_soal";
$soal=$soal_k->BODY->TEXT; 
$kunci=$soal_k->GRADABLE->CORRECTANSWER; 
$kunci_soal=$kunci[answer_id];
echo"Kunci = "; 
echo $kunci_soal;
echo"<br><br>";
$jawab=$soal_k->ANSWER; 
    
$data['description']=$soal;
 
$doc = new DOMDocument();
$doc->loadHTML($data['description']);
$tags = $doc->getElementsByTagName('img');
 
 

foreach ($tags as $tag) {
 $old_src = $tag->getAttribute('src');
 $new_src_url = "$_SESSION[folder]/$nama_folder/$old_src";
 $tag->setAttribute('src', $new_src_url);
 $tag->setAttribute('data-src', $old_src);
}
 
$data['description'] = $doc->saveHTML();

echo $data['description'];

//echo"$soal <br> jawaban:  $jawab<br>";

$soal_deskripsi=mysql_real_escape_string($data[description]);
//menyimpan bank_soal
$qcek=mysql_query("select * from bank_soal where id_ujian='$_SESSION[id_ujian_bank]' and id_blackboard='$id_soal'");
$dcek=mysql_fetch_array($qcek);

if(!empty($dcek[id])){
$save_soal=mysql_query("update bank_soal set soal='$soal_deskripsi',no_soal='$no_soal' where id='$dcek[id]'");
	echo"update";
}
else {
$save_soal=mysql_query("insert into bank_soal(id_ujian,soal,id_blackboard,no_soal)
						values('$_SESSION[id_ujian_bank]','$soal_deskripsi','$id_soal','$no_soal')") or die("gagal save".mysql_error());
echo"isi";
}
echo"<br>";
//mencari opsi jawaban
$nj='A';
foreach ($jawab as $jwb) {
$jwb_opsi=$jwb->TEXT; 

 
//mencocokkan kunci
//echo"$jwb[id]==$kunci[answer_id] <br>";
if($jwb[id]=="$kunci_soal"){
$kunci_jwb="$nj";
$save_opsi=mysql_query("update bank_soal set kunci='$kunci_jwb' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}
else {
$kunci_jwb="";
}



echo"$nj . $kunci_jwb. "; 


echo $jwb['id']; echo"-"; 


$dataj['description']=$jwb_opsi;
 
$docj = new DOMDocument();
$docj->loadHTML($dataj['description']);
$tagsj = $docj->getElementsByTagName('img');


foreach ($tagsj as $tagj) {
 $old_srcj = $tagj->getAttribute('src');
 $new_src_urlj = "$_SESSION[folder]/$nama_folder/$old_srcj";
 $tagj->setAttribute('src', $new_src_urlj);
 $tagj->setAttribute('data-src', $old_srcj);
}
 
$dataj['description'] = $docj->saveHTML();

$opsi_deskripsi=mysql_real_escape_string($dataj[description]);
echo $dataj['description']; echo"<br>";

if($nj=="A"){
$save_opsi=mysql_query("update bank_soal set pila='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}
else if($nj=="B"){
$save_opsi=mysql_query("update bank_soal set pilb='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}
else if($nj=="C"){
$save_opsi=mysql_query("update bank_soal set pilc='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}
else if($nj=="D"){
$save_opsi=mysql_query("update bank_soal set pild='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}
else if($nj=="E"){
$save_opsi=mysql_query("update bank_soal set pile='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}

$nj = chr(ord($nj) + 1);
}
echo"<br>";
}


//mencari soal multi answer
$no_soal=0;
foreach ($filexml->QUESTION_MULTIPLEANSWER as $soal_k) {
$no_soal++;
echo"$no_soal. ";  
$id_soalk=$soal_k;
$id_soal=$id_soalk[id];

echo"id_soal $id_soal";
$soal=$soal_k->BODY->TEXT; 
$kunci=$soal_k->GRADABLE->CORRECTANSWER; 
$kunci_soal=$kunci[answer_id];
//echo"Kunci = "; 
echo $kunci_soal;
echo"<br><br>";
$jawab=$soal_k->ANSWER; 
    
$data['description']=$soal;
 
$doc = new DOMDocument();
$doc->loadHTML($data['description']);
$tags = $doc->getElementsByTagName('img');
 
 

foreach ($tags as $tag) {
 $old_src = $tag->getAttribute('src');
 $new_src_url = "$_SESSION[folder]/$nama_folder/$old_src";
 $tag->setAttribute('src', $new_src_url);
 $tag->setAttribute('data-src', $old_src);
}
 
$data['description'] = $doc->saveHTML();

echo $data['description'];

//echo"$soal <br> jawaban:  $jawab<br>";

$soal_deskripsi=mysql_real_escape_string($data[description]);
//menyimpan bank_soal
$qcek=mysql_query("select * from bank_soal where id_ujian='$_SESSION[id_ujian_bank]' and id_blackboard='$id_soal'");
$dcek=mysql_fetch_array($qcek);

if(!empty($dcek[id])){
$save_soal=mysql_query("update bank_soal set soal='$soal_deskripsi',no_soal='$no_soal' where id='$dcek[id]'");
	echo"update";
}
else {
$save_soal=mysql_query("insert into bank_soal(id_ujian,soal,id_blackboard,no_soal,jenis)
					values('$_SESSION[id_ujian_bank]','$soal_deskripsi','$id_soal','$no_soal','multi')") or die("gagal save".mysql_error());
echo"isi";
}
echo"<br>";



//mencari opsi jawaban
$nj='A';
$kunci_multi_akhir=array();
foreach ($jawab as $jwb) {
$jwb_opsi=$jwb->TEXT; 

 

//mencocokkan kunci

$kunci_multi_ar=array();
foreach ($kunci as $kunci_j) {
$kunci_jawaban_multi=$kunci_j[answer_id]; 

if($jwb[id]=="$kunci_jawaban_multi"){
$kunci_jwb="$nj";




}
else {
$kunci_jwb="";
}
$kunci_multi_ar[]=$kunci_jwb;


}

$kunci_multi_ok=implode("",$kunci_multi_ar);
$kunci_multi_akhir[]=$kunci_multi_ok;

echo"Kunci Multi $kunci_multi_ok <br>";



//echo"$nj . $kunci_jwb. "; 


echo $jwb['id']; echo"-"; 


$dataj['description']=$jwb_opsi;
 
$docj = new DOMDocument();
$docj->loadHTML($dataj['description']);
$tagsj = $docj->getElementsByTagName('img');


foreach ($tagsj as $tagj) {
 $old_srcj = $tagj->getAttribute('src');
 $new_src_urlj = "$_SESSION[folder]/$nama_folder/$old_srcj";
 $tagj->setAttribute('src', $new_src_urlj);
 $tagj->setAttribute('data-src', $old_srcj);
}
 
$dataj['description'] = $docj->saveHTML();

$opsi_deskripsi=mysql_real_escape_string($dataj[description]);
echo $dataj['description']; echo"<br>";

if($nj=="A"){
$save_opsi=mysql_query("update bank_soal set pila='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}
else if($nj=="B"){
$save_opsi=mysql_query("update bank_soal set pilb='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}
else if($nj=="C"){
$save_opsi=mysql_query("update bank_soal set pilc='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}
else if($nj=="D"){
$save_opsi=mysql_query("update bank_soal set pild='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}
else if($nj=="E"){
$save_opsi=mysql_query("update bank_soal set pile='$opsi_deskripsi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}

$nj = chr(ord($nj) + 1);
}

$kunci_jawaban_multi=implode(",",$kunci_multi_akhir);
echo"$kunci_jawaban_multi <br>";

$save_opsi=mysql_query("update bank_soal set kunci='$kunci_jawaban_multi' where id_blackboard='$id_soal'
 and id_ujian='$_SESSION[id_ujian_bank]'");

}


//mencari soal urian
foreach ($filexml->QUESTION_FILLINBLANK as $soal_k) {
$no_soal++;
echo"$no_soal. ";  
$soal=$soal_k->BODY->TEXT; 
$kunci=$soal_k->GRADABLE->CORRECTANSWER; 
$kunci_soal=$kunci[answer_id];
$id_soal_essay="e_$soal_k[id]";

echo $kunci_soal;
echo"<br><br>";
$jawab=$soal_k->ANSWER; 
    
$data['description']=$soal;
 
$doc = new DOMDocument();
$doc->loadHTML($data['description']);
$tags = $doc->getElementsByTagName('img');
 
foreach ($tags as $tag) {
 $old_src = $tag->getAttribute('src');
 $new_src_url = "$_SESSION[folder]/$nama_folder/$old_src";
 $tag->setAttribute('src', $new_src_url);
 $tag->setAttribute('data-src', $old_src);
}
 
$data['description'] = $doc->saveHTML();

echo $data['description'];

//echo"$soal <br> jawaban:  $jawab<br>";

//mencari opsi jawaban
$jwb_opsi=$jawab->TEXT; 




$dataj['description']=$jwb_opsi;
 
$docj = new DOMDocument();
$docj->loadHTML($dataj['description']);
$tagsj = $docj->getElementsByTagName('img');
 
foreach ($tagsj as $tagj) {
 $old_srcj = $tagj->getAttribute('src');
 $new_src_urlj = "$_SESSION[folder]/$nama_folder/$old_srcj";
 $tagj->setAttribute('src', $new_src_urlj);
 $tagj->setAttribute('data-src', $old_srcj);
}
 
$dataj['description'] = $docj->saveHTML();

echo $dataj['description']; echo"<br>";

$qcek=mysql_query("select * from bank_soal where id_ujian='$_SESSION[id_ujian_bank]' and id_blackboard='$id_soal_essay' and jenis='essay'");
$dcek=mysql_fetch_array($qcek);

if(!empty($dcek[id])){
$save_soal=mysql_query("update bank_soal set soal='".mysql_real_escape_string($data[description])."',no_soal='$no_soal',kunci='".mysql_real_escape_string($dataj[description])."' where id='$dcek[id]'");
	echo"update";
}
else {
$save_soal=mysql_query("insert into bank_soal(id_ujian,soal,id_blackboard,no_soal,kunci,jenis)
						values('$_SESSION[id_ujian_bank]','".mysql_real_escape_string($data[description])."','$id_soal_essay','$no_soal','".mysql_real_escape_string($dataj[description])."','essay')") or die("gagal save".mysql_error());
echo"isi";
}



echo"<br>";
}




echo "<pre>";
print_r ($filexml);
echo "</pre>";
  

//mencari soal urian
foreach ($filexml->QUESTION_MATCH as $soal_k) {
$no_soal++;
echo"$no_soal. ";  
$soal=$soal_k->BODY->TEXT; 
$pilihan=$soal_k->CHOICE; 
$kunci=$soal_k->GRADABLE->CORRECTANSWER; 
$kunci_soal=$kunci[answer_id];
$id_soal_match="matc_$soal_k[id]";

echo $kunci_soal;
echo"<br><br>";
$jawab=$soal_k->ANSWER; 
    
$data['description']=$soal;
 
$doc = new DOMDocument();
$doc->loadHTML($data['description']);
$tags = $doc->getElementsByTagName('img');
 
foreach ($tags as $tag) {
 $old_src = $tag->getAttribute('src');
 $new_src_url = "$_SESSION[folder]/$nama_folder/$old_src";
 $tag->setAttribute('src', $new_src_url);
 $tag->setAttribute('data-src', $old_src);
}
 
$data['description'] = $doc->saveHTML();

echo $data['description'];



//echo"$soal <br> jawaban:  $jawab<br>";




$dataj['description']=$jwb_opsi;
 
$docj = new DOMDocument();
$docj->loadHTML($dataj['description']);
$tagsj = $docj->getElementsByTagName('img');
 
foreach ($tagsj as $tagj) {
 $old_srcj = $tagj->getAttribute('src');
 $new_src_urlj = "$_SESSION[folder]/$nama_folder/$old_srcj";
 $tagj->setAttribute('src', $new_src_urlj);
 $tagj->setAttribute('data-src', $old_srcj);
}
 
$dataj['description'] = $docj->saveHTML();

echo $dataj['description']; echo"<br>";

$ket_posisi_ar=array();
foreach ($pilihan as $pilihank) {
	
	
$ket_posisi_ar[]=$pilihank->TEXT; 


$pilk=$pilihank->TEXT;
echo"keterangan posisi  $pilk <br>";
}

$ket_opsi_matching=implode("||",$ket_posisi_ar);



$dataj2['description']=$ket_opsi_matching;
 
$docj = new DOMDocument();
$docj->loadHTML($dataj2['description']);
$tagsj = $docj->getElementsByTagName('img');
 
foreach ($tagsj as $tagj) {
 $old_srcj = $tagj->getAttribute('src');
 $new_src_urlj = "$_SESSION[folder]/$nama_folder/$old_srcj";
 $tagj->setAttribute('src', $new_src_urlj);
 $tagj->setAttribute('data-src', $old_srcj);
}
 
$dataj2['description'] = $docj->saveHTML();

$ket_opsi_matching=mysql_real_escape_string($dataj2['description']);


$qcek=mysql_query("select * from bank_soal where id_ujian='$_SESSION[id_ujian_bank]' and id_blackboard='$id_soal_match' and jenis='match'");
$dcek=mysql_fetch_array($qcek);

if(!empty($dcek[id])){
$save_soal=mysql_query("update bank_soal set ket_opsi_matching='$ket_opsi_matching',soal='".mysql_real_escape_string($data[description])."',no_soal='$no_soal',kunci='".mysql_real_escape_string($dataj[description])."' where id='$dcek[id]'");
	echo"update";

$id_match=$dcek[id];	
}
else {
$save_soal=mysql_query("insert into bank_soal(ket_opsi_matching,id_ujian,soal,id_blackboard,no_soal,kunci,jenis)
						values('$ket_opsi_matching','$_SESSION[id_ujian_bank]','".mysql_real_escape_string($data[description])."','$id_soal_match','$no_soal','".mysql_real_escape_string($dataj[description])."','match')") or die("gagal save".mysql_error());
echo"isi";
$id_match=mysql_insert_id();	

}



foreach ($jawab as $jwb) {
$id_opsi_blackboard=$jwb[id]; 
$jwb_opsi=$jwb->TEXT; 
$posisi=$jwb[position]; 

echo"$id_opsi_blackboard - $posisi . $jwb_opsi <br>";


$dataj2['description']=$jwb_opsi;
 
$docj = new DOMDocument();
$docj->loadHTML($dataj2['description']);
$tagsj = $docj->getElementsByTagName('img');
 
foreach ($tagsj as $tagj) {
 $old_srcj = $tagj->getAttribute('src');
 $new_src_urlj = "$_SESSION[folder]/$nama_folder/$old_srcj";
 $tagj->setAttribute('src', $new_src_urlj);
 $tagj->setAttribute('data-src', $old_srcj);
}
 
$dataj2['description'] = $docj->saveHTML();

$ket_opsi_matching=mysql_real_escape_string($dataj2['description']);

$qcek=mysql_query("select * from bank_opsi where id_ujian='$_SESSION[id_ujian_bank]' and 
id_blackboard='$id_opsi_blackboard' and id_soal='$id_match'");
$dcek=mysql_fetch_array($qcek);



if(!empty($dcek[id])){
$save_soal=mysql_query("update bank_opsi set deskripsi='$ket_opsi_matching' where id='$dcek[id]'");
	echo"update";

}
else {
$save_soal=mysql_query("insert into bank_opsi(id_ujian,id_soal,deskripsi,id_blackboard)
						values('$_SESSION[id_ujian_bank]','$id_match','$ket_opsi_matching','$id_opsi_blackboard')") or die("gagal save".mysql_error());
echo"isi";

}


$lkunci=array();
foreach ($kunci as $kuncim) {
$answer_id=$kuncim[answer_id]; 
$choice_id=$kuncim[choice_id]; 
if($answer_id=="$id_opsi_blackboard"){
$lkunci[]=$choice_id;
}
else {
$lkunci[]="";

}

}
$choisk=implode("",$lkunci);

$lposisi=array();

foreach ($pilihan as $pilihanm) {
$choice_id=$pilihanm[id]; 
$posisi=$pilihanm[position]; 

if($choice_id=="$choisk"){
$lposisi[]=$posisi;
}
else {
$lposisi[]="";

}

}
$pilihaku=implode("",$lposisi);



$save_soal=mysql_query("update bank_opsi set kunci='$pilihaku' where id_ujian='$_SESSION[id_ujian_bank]' and 
id_blackboard='$id_opsi_blackboard' and id_soal='$id_match'");
	echo"update";

echo"choice $choisk posisi $pilihaku <br>";



}

echo"<br> Posisi <br>";




echo"<br>";
}


		
					
                }  
           } 
else {
echo"File Harus Berbentuk ZIP";
}	
      }  
	  else {
	  
	  }
 

?>

