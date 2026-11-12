   <html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Save</title>
<link rel="stylesheet" type="text/css" href="../../plugins/sweetalert/sweetalert.css">
<script type="text/javascript" src="../../plugins/sweetalert/sweetalert.min.js"></script>
</head>
<body>

<?php 

include "../../inc/koneksi_sim.php";
include "../../inc/aman.php";
include"../../inc/meta.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$tgl=date('dmy');
$jenis = $tgl;
$kelas = anti_injection($_POST['kelas']);
$id = anti_injection($_POST['id']);

error_reporting(1);


  
$string=mysql_escape_string($_POST[konten_promosi]);
$string = str_replace('<p>', '', $string);
$string = str_replace('</p>', '' , $string);        
        
$id=$_POST['id'];

foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "UPDATE `sekolah` SET  aktif_daftar='{$_POST['aktif_daftar']}', 
`nama_sekolah` =  '{$_POST['nama_sekolah']}' ,  `npsn` =  '{$_POST['npsn']}' ,
`nss` =  '{$_POST['nss']}' ,  `alamat_sekolah` =  '{$_POST['alamat_sekolah']}' , 
`kode_pos` =  '{$_POST['kode_pos']}' ,  `telp` =  '{$_POST['telp']}' , 
`kelurahan` =  '{$_POST['kelurahan']}' ,  `kecamatan` =  '{$_POST['kecamatan']}' ,
`kabupaten` =  '{$_POST['kabupaten']}' ,  `provinsi` =  '{$_POST['provinsi']}' ,
`website` =  '{$_POST['website']}' ,  `email` =  '{$_POST['email']}' ,
`foto` =  '{$_POST['foto']}' ,  `bg` =  '{$_POST['bg']}' , 
`headerhome` =  '{$_POST['headerhome']}' , 
`koneten_home` =  '{$_POST['koneten_home']}' , 
`konten_tentang` =  '{$_POST['konten_tentang']}' ,  `konten_promosi` =  '$string' , 
`alur` =  '{$_POST['alur']}' ,  `galeri1` =  '{$_POST['galeri1']}' ,
`galeri2` =  '{$_POST['galeri2']}' ,  `galeri3` =  '{$_POST['galeri3']}' ,  
`galeri4` =  '{$_POST['galeri4']}' ,  `galeri5` =  '{$_POST['galeri5']}' , 
`galeri6` =  '{$_POST['galeri6']}' ,  `daftar_buka` =  '{$_POST['daftar_buka']}' , 
`pengumuman_buka` =  '{$_POST['pengumuman_buka']}' ,  `pengumuman_lulus` =  '{$_POST['pengumuman_lulus']}' , 
`pengumuman_tidak` =  '{$_POST['pengumuman_tidak']}',  `tahun_ajaran` =  '{$_POST['tahun_ajaran']}',  `wa` =  '{$_POST['wa']}' "; 
mysql_query($sql) or die("gagal".mysql_error()); 


 if($sql) {
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
window.location = "profil";
  }
});
</script>

<?php 
} 
?>
</body>
</html>