
<?php 

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include"../../inc/meta.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$tgl=date('dmy');
$jenis = $tgl;
$aktif = anti_injection($_GET['ak']);
$id = anti_injection($_GET['d']);

if($ak!=1){
$q=mysql_query("UPDATE semester set aktif='0'") or die("gagal".mysql_error());
    
}

  
$q=mysql_query("UPDATE semester set aktif='$aktif'
	where id='$id'") or die("gagal".mysql_error());


 if($q) {
 header('Location: data');
} 
?>
</body>
</html>