<?php
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set("Asia/Bangkok");

$m=mysql_query("SELECT * from hasil_jwb where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]'");   
$d=mysql_fetch_array($m);

//mendefinisikan folder upload
define("UPLOAD_DIR", "../../file/");

if (!empty($_FILES["media"])) {
	$media	= $_FILES["media"];
	$ext	= pathinfo($_FILES["media"]["name"], PATHINFO_EXTENSION);
	$size	= $_FILES["media"]["size"];
	$tgl	= date("Ymdhis");

	if ($media["error"] !== UPLOAD_ERR_OK) {
		echo '<div class="alert alert-warning">Gagal upload file.</div>';
		exit;
	}

	// filename yang aman
	$name = preg_replace("/[^A-Z0-9._-]/i", "_", $media["name"]);

	// mencegah overwrite filename
	$i = 0;
	$name="$tgl$_SESSION[nis]$_SESSION[id_ujian]$name";
	$parts = pathinfo($name);
	while (file_exists(UPLOAD_DIR . $name)) {
		$i++;
		$name = $parts["filename"] . "-$tgl" . $i . "." . $parts["extension"];
	}

	$success = move_uploaded_file($media["tmp_name"], UPLOAD_DIR . $name);
	unlink("../../file/$d[file]");
	if ($success) {
	    
	 // echo"$name";
			$hs="<a href='../../file/$name' download> 
					<button class='btn btn-warning waves-effect btn-xs' type='button'>
					<i class='material-icons'>cloud_download</i> Hasil Lampiran Jawaban Anda </button>
					</a>

					";
						echo"<textarea name='download' id='downlodf' style='display:none'>$name</textarea><br>
						$hs<br><br>";
		
	}
	chmod(UPLOAD_DIR . $name, 0644);
}
?>