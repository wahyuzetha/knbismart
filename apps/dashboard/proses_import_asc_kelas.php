<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "excel_reader2.php";
include "akses.php";

ini_set('max_execution_time', 0);
ini_set('memory_limit', '128M');

$tahun_ajaran=$tahun_aktif;
$semester=$semester_aktif;

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
 
      $output = '';  
      if($_FILES['xml_file']['name'] != '')  
      {  
           $file_name = $_FILES['xml_file']['name'];  
           $array = explode(".", $file_name);  
           $name = $array[0];  
           $ext = $array[1];  
           if($ext == 'xml')  
           {  
	   
                $path = "xml_asc/";  
                $location = $path . $file_name;  
                if(move_uploaded_file($_FILES['xml_file']['tmp_name'], $location))  
                {  
                   //   echo"masuk $file_name";


//open manifest xml
$nama_xml="$path/$file_name";
$filexml = simplexml_load_file($nama_xml);

//save 
//$qls=mysql_query("delete from kelas tahun_ajaran='$tahun_ajaran'");	

foreach ($filexml->classes->class as $p9) {
$tingkat_kelas=explode(" ",$p9[name]);
$tingkat_kelas=$tingkat_kelas[0];

$kls=mysql_query("SELECT * from kelas where nama_kelas='$p9[name]' and tahun_ajaran='$tahun_ajaran'");	
$dkls=mysql_fetch_array($kls);

if(empty($dkls[nama_kelas])){
$q=mysql_query("insert into kelas(nama_kelas,
									tingkat,
									tahun_ajaran,
									id_class)
							values('$p9[name]',
								   '$tingkat_kelas',
								   '$tahun_ajaran',
								   '$p9[id]')");
}
else {
	$q=mysql_query("update kelas set id_class='$p9[id]' where nama_kelas='$p9[name]' and tahun_ajaran='$tahun_ajaran'");

}
}
//akhir classes atau kelas//


		
	if($q){
	echo"<script>
	alert('Proses Import Data Selesai Silahkan cek pada menu guru,kelas,dan pembelajaran');
	</script>
";
	}		
					
					
					
                }  
           }  
		   else {
echo"Bukan File XML";
}	
      } 

 

?>

