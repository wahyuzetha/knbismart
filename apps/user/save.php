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

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$pass     = anti_injection(md5($_POST['password']));
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);


$petugas = anti_injection($_POST['petugas']);
$username = anti_injection($_POST['username']);
$level = anti_injection($_POST['level']);
if(!empty($username)){

if(!empty($_POST['img'])){

define('UPLOAD_DIR', '../../foto/');
    $img = $_POST['img'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $tgl=date("Ymd");
    $time=time("h:i:sa");
    $name=$nis;
    $name = str_replace(' ', '_', $name);
    $namefoto="$name$tgl$time.png";
    $file = UPLOAD_DIR . $namefoto;
    $success = file_put_contents($file, $data);
    $foto="$namefoto";
}
else {
    $foto='';
}


	
$q=mysql_query("INSERT INTO users(username,password,level,foto) 
                                 
	                       VALUES('$username','$p','1','$foto')") or die("gagal".mysql_error());

}
else {
	header('Location: add');
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