<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
         
?>
<!DOCTYPE html>
<html>
      <script src="../../js/jquery-1.11.2.min.js"></script>


<head>
<?php include"../../inc/meta.php"; ?>
<style>
    .menu_depan_s {
    color: #000;
    padding: 5px;
    border-radius: 10px;
    background: rgba(0, 0, 0, 0.08);
    text-decoration:none;
    width: 101px;
}
a {
      text-decoration:none !important;
   }
</style>
<link href='../../css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

</head>

<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include"../../inc/sidebar.php";?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    
    <section class="content">
<div class="row">


    <div class="col-md-12">
      
                                     
                                          <h4>LIVE ONLINE USERS</h4>
        <div id="user_login_status"></div>
                            </div>
                         
                           
                            </div>
                            </div>
            <!-- #END# Widgets -->
           
  </section>
   
<?php include"../../inc/footerm.php";?></body>

    <script type="text/javascript">

setInterval(function(){
 fetch_user_login_data();
}, 3000);
function fetch_user_login_data()
{
 var action = "fetch_data";
 var id_pengguna = "1002";

 $.ajax({
  url:"../../inc/ol.php",
  method:"POST",
  data:{action:action,id_pengguna:id_pengguna},
  success:function(data)
  {
   $('#user_login_status').html(data);
  }
 });
}
</script>
</body>
</body>

</html>