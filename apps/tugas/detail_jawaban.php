  ﻿<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

 $nn=mysql_query("select  * from hasil_jwb_tugas where id='$id' order by nilai desc");   
                $dn=mysql_fetch_array($nn);
                
  echo html_entity_decode($dn[jawaban]); echo"<br>";
  
    
				 		   
				 		   
				 		   
				 		   if(!empty($dn[jfile])){
		  // echo"<a href='../../tugas/$dn[jfile]' download>Download Jawaban</a>";
		   }

if(!empty($dn[jfile])){
		    $separated = explode(',', $dn[jfile]);
            $i=0;
            foreach ($separated as $value) {

            if(!empty($value)){
            $i++;
            
            $ext = pathinfo($value, PATHINFO_EXTENSION);

		   echo"$i. <a href='../../tugas/$value' download>Download File</a>  ";
		   if($ext=="jpg" or $ext=="jpeg" or $ext=="png" or $ext=="gif"){
		   echo" atau <a href='img?v=../../tugas/$value'>Preview File</a>";
		   }
		   echo"<br>";
		    }
            }
		   }
		   
				 ?>