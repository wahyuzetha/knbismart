   <html>
<head>
<title>Save</title>
<link rel="stylesheet" type="text/css" href="../../plugins/sweetalert/sweetalert.css">
<script type="text/javascript" src="../../plugins/sweetalert/sweetalert.min.js"></script>
</head>
<body>
<?php 

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include"../../inc/meta.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$pass     = anti_injection(md5("123456"));
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);

$del=mysql_query("DELETE FROM users WHERE level='2'") ; 

     $m=mysql_query("select  * from guru");   
     while($d=mysql_fetch_array($m)){ 
     


	
$q=mysql_query("INSERT INTO users(username,password,level,id_pengguna) 
                                 
	                       VALUES('$d[email]','$p','2','$d[nuptk]')") or die("gagal".mysql_error());

}

 if($q) {
 	?>
	<script type="text/javascript">
swal({
  title: "Data Berhasil Disimpan",
  icon: "success",
  showCancelButton: false,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "OK"
},
function(isConfirm) {
  if (isConfirm) {
window.location = "data";
  }
});
</script>

<?php 
} 
?>
</body>
</html>