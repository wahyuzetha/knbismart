<?php
session_start();
error_reporting(0);
include"inc/skl.php";
if($_GET[token]!="null" and !empty($_GET[token])){
    $_SESSION[token_id]=$_GET[token];
}
else {
     $_SESSION[token_id]=$_SESSION[token_id];
}

if(!empty($_GET['email_notif'])){
		    
$_SESSION['logged_in']=1;
$_SESSION['namauser']=$_GET[email_notif];
}
		
if($_GET[h]!="nonaktif" and $_GET[h]!="salah_server"){
	$lg="sukses";
if(!empty($_SESSION[id_pengguna]) and !empty($_SESSION[id_ujian])){
    header('Location: apps/dashboard/ujian?d='.$_SESSION[id_ujian_pembelajaran]);
}
else if(!empty($_SESSION[id_pengguna]) and empty($_SESSION[id_ujian])){
  if($_SESSION[levelu]==3){
   header('Location: apps/dashboard/data_siswa');
}
else {
       header('Location: apps/dashboard/data');

}
    
}
}
else if($_GET[h]=="nonaktif" and $_GET[h]=="salah_server"){
	$lg="salah";
	session_destroy();
}
$_SESSION[id_server_log]=$_GET[dserver]; 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">

    <title><?php echo"$nama_sekolah";?></title>
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo"$logo_sekolah";?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/login.css" rel="stylesheet" id="bootstrap-css">
	 <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
<script src="plugins/jquery/jquery.min.js"></script>
  
  <script src="plugins/bootstrap/js/bootstrap.js"></script>

   <style>
   .container-login100 {
background: linear-gradient(to right, #0072ff, #00c6ff);background-repeat: no-repeat;
background-position: center center;
background-attachment: fixed;
background-size: cover;

   }.login100-form-btn {
    font-family: Montserrat-Bold;
    font-size: 15px;
    line-height: 1.5;
    color: #fff;
    text-transform: uppercase;
    width: 100%;
    height: 50px;
    border-radius: 25px;
    background: #FFC107;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 25px;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
    transition: all 0.4s;
}
.input100 {
    font-family: Poppins-Medium;
    font-size: 15px;
    line-height: 1.5;
    color: #666666;
    display: block;
    width: 100%;
    background: #ffffff;
    height: 50px;
    border-radius: 25px;
    padding: 0 30px 0 68px;
}

   </style>
</head>
<body>
    <div class="limiter">
		<div class="container-login100">
	
<form class="form-signin" method="post" action="inc/proses">
    	<?php
if($_GET[h]=="gagal"){
    echo'<div class="alert alert-danger">
                                <strong>Login Gagal</strong> <br>Periksa username dan password anda.
                            </div>';
}
else if($_GET[h]=="nonaktif"){
    echo'<div class="alert alert-danger">
                                <strong>Login Gagal</strong> <br>Status Data  Anda NON AKTIF.
                            </div>';
}
else if($_GET[h]=="salah_server"){
    echo'<div class="alert alert-danger">
                                <strong>LOGIN GAGAL</strong> '.$_GET[p].'
                            </div>';
}
?>
					<span class="login100-form-title" style="color:#fff">
										<img src="<?php echo"$logo_sekolah";?>" width="150px"><br><br>

					PEMBELAJARAN ONLINE <br> <?php echo"$nama_sekolah <br> $nama_sekolah_3";?>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username" placeholder="Username" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
					<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" style="margin-left: 259px;
    margin-top: 15px;
    position: absolute;"></span>

						<input class="input100" type="password" id="password-field" name="password" placeholder="Password" required>

						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					
					
				</form>
			</div>
		</div>
	</div>
	
</body>
</html>

      <script>
	$(".toggle-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);

</script>
