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
			$hs="<a href='../../fileforum/$name' download> 
					<button class='btn btn-warning waves-effect btn-xs' type='button'>
					<i class='material-icons'>cloud_download</i> Lampiran </button>
					</a>

					";
						echo"<textarea name='download' id='downlodf' style='display:none'>$name</textarea><br>
						$hs<br><br>";
		
	}
	chmod(UPLOAD_DIR . $name, 0644);
}
?>