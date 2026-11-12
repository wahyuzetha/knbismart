<?php
include "../../inc/aman.php";


// Getting file name
$filename = $_FILES['file']['name'];
$tgl=date("Ymd");
    $time=time("h:i:sa");

// file type
$filetype = $_POST['filetype'];

// Valid extension
if($filetype == 'image'){
  $valid_ext = array('png','jpeg','jpg');
}else if($filetype == 'media'){
  $valid_ext = array('mp4','mp3');
}

// Location
$location = "../../images/".$filename;
$dirUpload = "../../images/";

// file extension
$file_extension = pathinfo($location, PATHINFO_EXTENSION);
$file_extension = strtolower($file_extension);

$return_filename = "";

// Check extension
if(in_array($file_extension,$valid_ext)){
 
  // Upload file
  
  $namaSementara = $_FILES['file']['tmp_name']; 

// pindahkan file
$namefiles="$_SESSION[id_pengguna]$tgl$time$filename";
$namefiles=str_replace(" ","",$namefiles);
$namefiles=str_replace("/","",$namefiles);
$namefiles=str_replace("-","",$namefiles);

$terupload = move_uploaded_file($namaSementara, $dirUpload.$namefiles);


  if($terupload){
 
    $return_filename = $namefiles;

  }

}

echo $return_filename;
