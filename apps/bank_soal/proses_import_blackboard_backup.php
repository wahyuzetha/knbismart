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


//mencari soal
$no_soal=0;
foreach ($filexml->QUESTION_MULTIPLECHOICE as $soal_k) {
$no_soal++;
echo"$no_soal. ";  
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

//mencari opsi jawaban
$nj='A';
foreach ($jawab as $jwb) {
$jwb_opsi=$jwb->TEXT; 


//mencocokkan kunci
//echo"$jwb[id]==$kunci[answer_id] <br>";
if($jwb[id]=="$kunci_soal"){
$kunci_jwb="$nj";
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

echo $dataj['description']; echo"<br>";


 $nj = chr(ord($nj) + 1);
}
echo"<br>";
}



echo "<pre>";
//print_r ($filexml);
echo "</pre>";

		
					
                }  
           }  
      }  
 

?>

