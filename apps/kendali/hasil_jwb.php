<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m=mysql_query("SELECT pembelajaran.pembelajaran,ujian.* from ujian,pembelajaran WHERE ujian.id_pembelajaran=pembelajaran.id and ujian.id='$id'");   
$d=mysql_fetch_array($m);
?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
 <script src="../../js/js/jquery-1.10.2.min.js"></script>
       
		<script src="../../js/js/countdown.js"></script>
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
</head>

<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include"../../inc/sidebar.php";?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    
    <section class="content">
     <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
              
                        <div class="header">
                             <h4>Ujian <?php echo"$d[nama_ujian] $d[pembelajaran]";?></h4>
       
                        

<table>
    <tr>
      <th>No</th>
      <th>Jawaban</th>
      </tr>
      <?php
      $p=0;
       $res = mysql_query("SELECT * from hasil_opsi WHERE nis='$_GET[d2]' and id_ujian='$_GET[d]' order by id asc") or die(mysql_error());
     while($result=mysql_fetch_array($res)){
    $res2 = mysql_query("SELECT * from bank_opsi WHERE id_soal='$result[id_soal]' and opsi='$result[opsi]'") or die(mysql_error());
     $result2=mysql_fetch_array($res2);
     $p++;
   
   ?>
   <tr>
      <td><?php echo"$p";?></td>
      <td><?php echo"$result2[deskripsi]";?></td> 
       </tr>
       <?php } ?>
       </table>
<hr><a href="peserta?d=<?php echo"$id";?>"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
			</div>
		</div>
        </div>   
    </section>

<script >window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);
//# sourceURL=pen.js
</script>
<?php include"../../inc/footerm.php";?></body>

</html>