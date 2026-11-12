<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo"Cetak Raport";?> </title>

<?php
$id = anti_injection($_GET['d']);
$png=mysql_query("select * from pengaturan");
$dpng=mysql_fetch_array($png);
 $m=mysql_query("select  * from raport_detail where id='$id'");   
 $d=mysql_fetch_array($m);
    $base_url=$dpng[base_url];
	
	
    $actual_link = "$base_url/apps/raport_file/$d[id_raport]/$d[id_kelas]/$d[file]&zoom=195#page=1";

?>
<iframe src="<?php echo"$base_url";?>/pdf_js/web/lihat.php?file=<?php echo"$actual_link";?>"  style="border: none; width:100%; height:100%;" ></iframe>

 
