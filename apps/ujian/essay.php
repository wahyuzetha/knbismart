<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id_ujian = anti_injection($_GET['id_ujian']);

if(!empty($id)){
    $_SESSION[id_mapel_ujians]=$id;
}
else {
    $_SESSION[id_mapel_ujians]=$_SESSION[id_mapel_ujians];

}

$m2=mysql_query("select  * from pembelajaran where id='$_SESSION[id_mapel_ujians]'");
$d2=mysql_fetch_array($m2);

$mj=mysql_query("select  * from ujian where id='$id_ujian'");
$dj=mysql_fetch_array($mj);


?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>
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
     <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <?php
    if($_GET[h]=="sukses"){ ?>    
    <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong> Data Berhasil Di Simpan</div>
    <?php } 
    else  if($_GET[h]=="suksesh"){ ?>   
     <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong> Data Berhasil Di Hapus</div>
    <?php
        }
        else {
        echo"";
        }
         $someArray = json_decode($d2[kelas], true);

            $lokasi_ar=array();
            $kls_or=array();
			foreach($someArray as $jurusanku) { 
			
			$lokasi_ar[]=$jurusanku;
			$kls_or[]="'$jurusanku'";
			
			}
			               $pilj=implode(",",$lokasi_ar);
			          //     $slr=implode(" or kelas='",$lokasi_ar);
$slr = "'" . implode ( "' or nama_kelas='", $lokasi_ar ) . "'";


    if(empty($pilj)){
		$jur="Semua Kelas";
	}
	else {
	$jur=$pilj;
	}
    ?>    
    
                            <h2>
                              Input Nilai Essay <?php echo"$dj[judul]";?> Pembelajaran <?php echo"$d2[pembelajaran] $jur";?>
                            </h2>
                         </div>
                        <div class="body">
                            <?php
                            
                            if(empty($pilj)){
                                $wh=" and tingkat='$d2[tingkat]'";
                            }
                            else {
                                $wh=" and (nama_kelas=$slr)";
                            }
                          $tk=mysql_query("select  * from kelas where tahun_ajaran='$tahun_aktif' $wh ");   
 while($dk=mysql_fetch_array($tk)){
             	
             	
?>
<p align="center"><strong>KELAS <?php echo strtoupper($dk[nama_kelas]); echo"<br>";?>


<table border="1" style="border-collapse: collapse; color: #000;" width="100%">
  <tr>
    <td width="5%" height="35" align="center" bgcolor="#FFFF00" ><strong>NO</strong></td>
    <td width="10%" align="center" bgcolor="#FFFF00" ><strong>NIS </strong></td>
    <td width="30%" align="center" bgcolor="#FFFF00" ><strong>NAMA</strong></td>
    <td width="50%" align="center" bgcolor="#FFFF00" ><strong>ESSAY</strong></td>
    <td width="10%" align="center" bgcolor="#FFFF00" ><strong>NILAI</strong></td>


  </tr>
      <?php
	  $no=0;
           $m=mysql_query("select  * from siswa where kelas='$dk[nama_kelas]' and kelas!=''");   
		
								
				while($d=mysql_fetch_array($m)){
                $nn=mysql_query("select  * from hasil_jwb where nis='$d[nis]' and id_ujian='$dj[id]' order by nilai desc");   
                $dn=mysql_fetch_array($nn);
            $no++;     
            $nialais=$dn[benar]/$djsoal[jum]*$dujiand[skala];
            
            
            ?>      
           
                  <tr>
				<td align="center"><?php echo"$no";?> </td>

				<td align="center"><?php echo"$d[nis]";?> </td>
				<td><?php echo"$d[nama]";?> </td>
				  <td align="center">
				      <?php if(!empty($dn[essay]) or !empty($dn[file])){?>
				  <button type="button" class="btn bg-green waves-effect" data-toggle="modal" 
				  data-target="#smallModalg<?php echo"$kl$no";?>"><i class="material-icons">book</i> Jawaban</button>
				  
                    <div class="modal fade" id="smallModalg<?php echo"$kl$no";?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-green">
                            <h4 class="modal-title bg" id="smallModalLabel">Detail Jawaban <?php echo"$d[nis] $d[nama]";?></h4>
                        </div>
                        <div class="modal-body">
                           <iframe src='detail_jawaban?d=<?php echo"$dn[id]";?>' name="detail<?php echo"$dn[id]";?>" width="100%" height="500px"></iframe>
                           <?php
                          
                           ?>
                            
                            </div>
                        <div class="modal-footer">

             <a href="detail_jawaban?d=<?php echo"$dn[id]";?>" target="detail<?php echo"$dn[id]";?>">
                            <button type="button" class="btn btn-success waves-effect"><i class="material-icons">arrow_back</i>Back</button>

                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <br>
            <?php } ?> 
                  <td align="center"><?php 
                  echo"<input type='number' step='any' id='cek$row[id]' class='filled-in update' name='nilai_essay'  data-id='$dn[id]' value='$dn[nilai_essay]' data-column='nilai_essay' >";?> </td>
                                       
                                        </tr>
                    <?php } ?>                    
                                       
                                </table>
<pagebreak>
 <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
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
  <script src="../../plugins/bootstrap-notify/bootstrap-notify.js"></script>

<script>
    function update_data(id, column_name, value)
  {
   $.ajax({
    url:"update.php",
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     
$.notify({
  // options
  message: 'Data Berhasil di simpan' 
},{
  // settings
  type: 'success'
});
           //alert("sukses");
     $('#alert_message').html('<div class="alert alert-warning">'+data+'</div>');
     $('#user_data').DataTable().destroy();
    // fetch_data();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }

  $(document).on('change', '.update', function(){
   var id = $(this).data("id");
   //    alert(id)

   var column_name = $(this).data("column");
   var value = $(this).val();

   
   update_data(id, column_name, value);
  });

  
</script>

</html>