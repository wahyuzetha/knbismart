<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
 
 if($_SESSION[jenis]=="p"){
				
			
			$someArray_akses = json_decode($_POST[akses_kelas], true);
            
			$m2=mysql_query("select  * from kelas where tingkat='$_POST[tingkat]' and tahun_ajaran='$_POST[tahun_ajaran]'");
			while($d2=mysql_fetch_array($m2))
	
			{ 
			
						$lokasi_ar=array();

			foreach($someArray_akses as $kelasku) { 
			
			if($kelasku==$d2[nama_kelas]){
			$lokasi_ar[]="selected";

			}
			else {
			$lokasi_ar[]="";
			
			}
			}
			
		    $pilj=implode("",$lokasi_ar);

            ?>      
          <option value="<?php echo"$d2[nama_kelas]";?>" <?php echo"$pilj";?>><?php echo"$d2[nama_kelas]";?></option>

			<?php }
			} 
else if($_SESSION[jenis_baca]=="non"){
 $someArray = json_decode($_POST[kelas], true);
			
			$someArray_akses = json_decode($_POST[akses_kelas], true);
            
			foreach($someArray as $jurusanku) { 
						$lokasi_ar=array();

			foreach($someArray_akses as $kelasku) { 
			
			if($kelasku==$jurusanku){
			$lokasi_ar[]="selected";

			}
			else {
			$lokasi_ar[]="";
			
			}
			}
			
		    $pilj=implode("",$lokasi_ar);

            ?>      
          <option value="<?php echo"$jurusanku";?>" <?php echo"$pilj";?>><?php echo"$jurusanku";?></option>

 <?php } }
 
 
 else {
			if($_SESSION[levelu]==1 or strstr($_SESSION[penyelenggara_ujians], '1')){
				
			
			$someArray_akses = json_decode($_POST[akses_kelas], true);
            
			$m2=mysql_query("select  * from kelas where tingkat='$_POST[tingkat]' and tahun_ajaran='$_POST[tahun_ajaran]'");
			while($d2=mysql_fetch_array($m2))
	
			{ 
			
						$lokasi_ar=array();

			foreach($someArray_akses as $kelasku) { 
			
			if($kelasku==$d2[nama_kelas]){
			$lokasi_ar[]="selected";

			}
			else {
			$lokasi_ar[]="";
			
			}
			}
			
		    $pilj=implode("",$lokasi_ar);

            ?>      
          <option value="<?php echo"$d2[nama_kelas]";?>" <?php echo"$pilj";?>><?php echo"$d2[nama_kelas]";?></option>

			<?php }
			}
			else {	
			$someArray = json_decode($_POST[kelas], true);
			
			$someArray_akses = json_decode($_POST[akses_kelas], true);
            
			foreach($someArray as $jurusanku) { 
						$lokasi_ar=array();

			foreach($someArray_akses as $kelasku) { 
			
			if($kelasku==$jurusanku){
			$lokasi_ar[]="selected";

			}
			else {
			$lokasi_ar[]="";
			
			}
			}
			
		    $pilj=implode("",$lokasi_ar);

            ?>      
          <option value="<?php echo"$jurusanku";?>" <?php echo"$pilj";?>><?php echo"$jurusanku";?></option>

 <?php } } } ?>