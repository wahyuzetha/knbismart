<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

			  $someArray = json_decode($_POST[kelas], true);
			
			
			

			 
            $mpj=mysql_query("select * from kelas where tingkat='$_POST[tingkat]' and tahun_ajaran='$tahun_aktif' order by nama_kelas asc");
            while($dpj=mysql_fetch_array($mpj)){ 
			               $lokasi_ar=array();
			foreach($someArray as $jurusanku) { 
			if($dpj[nama_kelas]==$jurusanku){
			$lokasi_ar[]="selected";

			}
			else {
			$lokasi_ar[]="";
			
			}
			}
			               $pilj=implode("",$lokasi_ar);

            ?>      
          <option value="<?php echo"$dpj[nama_kelas]";?>" <?php echo"$pilj";?>><?php echo"$dpj[nama_kelas]";?></option>

			<?php } ?>    