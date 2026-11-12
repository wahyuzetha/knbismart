<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

			$someArray = json_decode($_POST[kelas], true);
			$someArray_akses = json_decode($_POST[akses_siswa], true);
		    
		    $lokasi_ar=array();
			foreach($someArray as $jurusanku) { 
			$lokasi_ar[]="kelas='$jurusanku'";

			}
		  $kelas=implode(" or ",$lokasi_ar);

			$mpj=mysql_query("select * from siswa where $kelas  order by kelas,nis asc");
            while($dpj=mysql_fetch_array($mpj)){ 
			
			$lokasi_ar=array();
			foreach($someArray_akses as $siswaku) { 
			
			if($dpj[nis]==$siswaku){
			$lokasi_ar[]="selected";

			}
			else {
			$lokasi_ar[]="";
			
			}
			}
			
			               $pilj=implode("",$lokasi_ar);


            ?>      
          <option value="<?php echo"$dpj[nis]";?>" <?php echo"$pilj";?>><?php echo"$dpj[kelas]-$dpj[nis]-$dpj[nama]";?></option>

			<?php } ?>    