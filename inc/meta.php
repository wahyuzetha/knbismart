    <?php include"../../inc/skl.php";?>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo"$nama_sekolah";?> </title>
    <!-- Favicon-->
<link rel="icon" href="../../favicon.ico" type="image/x-icon">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo"$logo_sekolah2";?>">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../../plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="../../css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../../css/themes/all-themes.css" rel="stylesheet" />
  <link href="../../plugins/sweetalert/sweetalert.css" rel="stylesheet" /> 
  
  <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

  <style>
  .opsi_hurufk{
	  position: absolute;
    margin-left: -12px;
    margin-top: 20px !important; top: -19px;
  }
  .opsi_deskripsik{
	 margin-left:20px;
  }
  .theme-red .navbar {
      <?php echo"$warna_bg";?>

}
.sidebar .user-info {
         <?php echo"$warna_bg";?>

}
.bg-green {
         <?php echo"$warna_bg";?>

}
.sidebar .user-info {
    padding: 3px 26px 16px 18px;
    white-space: nowrap;
    position: relative;
    border-bottom: 1px solid #e9e9e9;
    background: #50a3a2;
    background-image: linear-gradient(to right, #0072ff, #00c6ff);
    height: 144px;
}

  </style>
  <script>
  /*
      function update_user_activity()
{
 var action = 'update_time';
 $.ajax({
  url:"../../inc/ol.php",
  method:"POST",
  data:{action:action},
  success:function(data)
  {
//alert(data)
  }
 });
}
setInterval(function(){ 
 update_user_activity();
}, 3000);
*/
  </script>