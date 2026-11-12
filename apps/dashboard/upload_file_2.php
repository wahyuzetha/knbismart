<?php
//memasukkan file config.php
//include("config.php");

//mendefinisikan folder upload
define("UPLOAD_DIR", "../../fileforum/");

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
	$name="$tgl$name";
	$parts = pathinfo($name);
	while (file_exists(UPLOAD_DIR . $name)) {
		$i++;
		$name = $parts["filename"] . "-$tgl" . $i . "." . $parts["extension"];
	}

	$success = move_uploaded_file($media["tmp_name"], UPLOAD_DIR . $name);
	if ($success) {
	    
	 // echo"$name";
		
						echo"<textarea name='download' id='downloadf2' style='display:none'>$name</textarea><br>
						<a href='../../../fileforum/$name' target='_NEW'>$name</a><br><br>";
		
	}
	chmod(UPLOAD_DIR . $name, 0644);
}
?>