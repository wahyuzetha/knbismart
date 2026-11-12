<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
include "../../inc/fungsi.php";

function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m3=mysql_query("select  * from ujian where id='$id'");
$d3=mysql_fetch_array($m3);

$m2=mysql_query("select  * from pembelajaran where id='$d3[id_pembelajaran]'");
$d2=mysql_fetch_array($m2);

mkdir("../../bank_soal/$d2[nuptk]");
mkdir("../../bank_soal/$d2[nuptk]/$id");

$_SESSION[folder]="../../bank_soal/$d2[nuptk]/$id";
$_SESSION[id_ujian_bank]=$id;

if(!empty($_GET[j])){
$_SESSION[jpantaus]=$_GET[j];
}
else {
$_SESSION[jpantaus]=$_SESSION[jpantaus];

} 

if(!empty($_SESSION[jpantaus])){
$_SESSION[jpantau]="../../apps/ujian/data_pantau_ujian";
}
else {
$_SESSION[jpantau]="../../apps/ujian/data?d=$d2[id]";
}
		
		?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>
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
    ?>    
    
                             <h2>
                               Bank Soal Ujian <?php echo"$d3[nama_ujian]";?>, Pembelajaran <?php echo"$d2[pembelajaran]";?>
                            </h2>
                            
                         </div>
                        <div class="body">
                                                          <?php
        error_reporting(0);
    if($_GET[h]=="sukses"){ ?>    
    <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Berhasil!! </strong> <p>Data Berhasil Di Simpan</p> </div>
    <?php } 
     else  if($_GET[h]=="suksesh"){ ?>    
    <div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Berhasil! </strong> <p>Data Berhasil Di Hapus</p>  </div>
    <?php } 
  
        else if($_GET[h]=="gagal") {
       ?>    
    <div class="alert alert-danger" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Gagal!! <br> <?php echo"$_GET[pesan]";?> </strong>  </div>
    <?php
        }
    ?>
	       <a href="<?php echo"$_SESSION[jpantau]";?>">        
						   <button type="button" class="btn bg-light-blue waves-effect"><i class="material-icons">arrow_back</i> Kembali</button></a>
						   
	
                                
						    <a href="import_blackboard?d=<?php echo"$d3[id]";?>">        
						   <button type="button" class="btn bg-green waves-effect"><i class="material-icons">import_export</i> Import Blackboard 6.0</button></a>
						   
						    <a href="import?d=<?php echo"$d3[id]";?>">        
						   <button type="button" class="btn bg-green waves-effect"><i class="material-icons">import_export</i> Import Excel (Khusus Pilganda)</button></a>
						   
						   
						   <a href="preview?d=<?php echo"$d3[id]";?>" target="_NEW">        
						   <button type="button" class="btn bg-pink waves-effect"><i class="material-icons">zoom_in</i> Preview</button></a>
						  
						
						   <a href="cetak_soal?d=<?php echo"$d3[id]";?>" class="btnPrint">        
						   <button type="button" class="btn bg-green waves-effect"><i class="material-icons">print</i> Cetak Soal</button></a>
						 
                                  <hr>
                         
 <?php
$_SESSION[id_ujian_soal]=$d3[id];

        
 if(!empty($d3[skala])){
?>         
   <a href="add?d=<?php echo"$d3[id]&j=pilgan";?>">        
						   <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">add</i> Add Pilganda</button></a>
			
<?php }
if(!empty($d3[bobot_multiple])){

?>
 <a href="add?d=<?php echo"$d3[id]&j=multi";?>">        
						   <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">add</i> Add Multiple Respon</button></a>
<?php }
if(!empty($d3[bobot_matching])){
?>
 <a href="add_match?d=<?php echo"$d3[id]";?>">        
						   <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">add</i> Add Matching Point</button></a>
<?php } 
if(!empty($d3[bobot_essay_auto])){

?>
 <a href="add_essay?d=<?php echo"$d3[id]";?>">        
						   <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">add</i> Add Essay SIngkat</button></a>

<?php }?>
					  
         

		
						  
                                 <table class="table table-bordered table-striped table-hover dataTable">
                           
                          
                                    <thead class="bg-blue">
                                        <tr>
                                             <th>NO</th>

                                            <th>DETAIL</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $i=0;
           
          $m=mysql_query("SELECT * from bank_soal  where 1 and id_ujian='$d3[id]' order by id asc");   
      
            while($row=mysql_fetch_array($m)){ 
           $i++;
           
           if($row[jenis]==""){
               $ket_jenis_soal="Pilihan Ganda";
           }
           else if($row[jenis]=="essay"){
               $ket_jenis_soal="Essay Singkat";
           }
           else if($row[jenis]=="multi"){
               $ket_jenis_soal="Multiple Respon";
           }
           else if($row[jenis]=="match"){
               $ket_jenis_soal="Mathing Point";
           }
           
           if(!empty($row[pilc])){
               $pilc=",,,,C~~$row[pilc]";
           }
           else {
               $pilc="";
           }
           
           if(!empty($row[pild])){
               $pild=",,,,D~~$row[pild]";
           }
           else {
               $pild="";
           }
           
           if(!empty($row[pile])){
               $pile=",,,,E~~$row[pile]";
           }
           else {
               $pile="";
           }
           
           


				$tipe_soal_ar=array();
				$opsi_soal="A~~$row[pila],,,,B~~$row[pilb]$pilc$pild$pile";
				$opsi_soal_tampil = explode(",,,,", $opsi_soal);
				
		     if($row[jenis]=="essay"){
			 $tipe_soal="";
  $kunci="<br><b>Kunci : $row[kunci]";
  
  $keterangan_matching="";
			 }
			 else  if($row[jenis]=="match"){
				 
		  	$ket_opsi_matching = explode("||", $row[ket_opsi_matching]);
			$s = 'a';
			$ket_op=array();
			foreach($ket_opsi_matching as $ket_opsi){
			$ket_op[]="$s. $ket_opsi";
			$s = chr(ord($s) + 1);
			}
			$keterangan_matching=implode("<br>",$ket_op);
			$keterangan_matching="<br> $keterangan_matching <br>";
				 
			 $tipe_soal="Matching";
			 $nom=0;
          $match_ar=array();
		  $mo=mysql_query("SELECT * from bank_opsi  where 1 and id_ujian='$d3[id]' and id_soal='$row[id]' order by id asc");   
            while($rowo=mysql_fetch_array($mo)){ 
			$kunci_mt=number_to_str($rowo[kunci]);
			$nom++;
			$match_ar[]="$nom. $rowo[deskripsi] kunci = <b> $kunci_mt </b>";
			}
				$tipe_soal=implode(" <br> ",$match_ar);
               $kunci="";
			 }
			 else {
				$keterangan_matching="";
				foreach($opsi_soal_tampil as $opsi_ts) {
				$opsi_tx=explode("~~", $opsi_ts);	
				$opsi_t=$opsi_tx[1];
				$opsi_huruf=$opsi_tx[0];	
				
				$desk=$opsi_t;
				$desk=str_ireplace('<p>','',$desk);
				$desk=str_ireplace('</p>','',$desk);   
               $tipe_soal_ar[]="$opsi_huruf = $desk <hr>"; 
                 }
				$tipe_soal=implode("",$tipe_soal_ar);
				$kunci="<br><b>Kunci : $row[kunci]";
			 }
            ?>      
           
                  <tr>
                <td width="10%"><?php echo"<b>$i</b>";?></td>
				<td width="70%"><?php echo"<span class='badge bg-orange'>$ket_jenis_soal</span> <br>$row[soal] $keterangan_matching <hr>$tipe_soal $kunci </b>";?></td>
                  <td>
                
                <a href='<?php if($row[jenis]=="essay"){ echo"edit_essay";} else if($row[jenis]=="match"){ echo"edit_match";} else {echo"edit";}?>?d=<?php echo"$row[id]";?>&id_ujian=<?php echo"$row[id_ujian]";?>'>
                    <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">mode_edit</i></button>
                </a>
                <button type="button" class="btn bg-red waves-effect" data-toggle="modal" data-target="#smallModal<?php echo"$row[id]";?>"><i class="material-icons">delete</i></button>
                   
                    <div class="modal fade" id="smallModal<?php echo"$row[id]";?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-red">
                            <h4 class="modal-title bg" id="smallModalLabel">Konfirmasi Hapus</h4>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin mau menghapus data ini?      </div>
                        <div class="modal-footer">
                            <form action="del" method="post"> 
             <input type='hidden' name='d' value='<?php echo"$row[id]";?>'>
                <input type='hidden' name='id_ujian' value='<?php echo"$row[id_ujian]";?>'>
               

                   <button type="submit" class="btn btn-danger waves-effect"><i class="material-icons">delete</i> HAPUS</button>

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
            
            
         </td>
                                       
                                        </tr>
                    <?php }
                    
                    $no_e=$i+1;
                    if(!empty($d3[essay])){
                    ?>  


  <tr>
                                             <th><?php echo"$no_e";?></th>

                                            <th><span class='badge bg-orange'>ESSAY MANUAL </span> <br>
                                            <?php echo"$d3[essay]";?>
                                            </th>
                                            <th> <a href="add_essay_manual?d=<?php echo"$d3[id]";?>">        
						   <button type="button" class="btn bg-blue waves-effect"><i class="material-icons">edit</i> Edit</button></a>
						  
   </th>
                                        </tr>
                                        
  					<?php } ?>
                                       </tbody>
                                </table>
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

$(document).ready(function() {
    $('#dataTable').DataTable( {
        "paging":   false, 
        "ordering": false,
        "info":     false
    } );
} );
//# sourceURL=pen.js
</script>

<?php include"../../inc/footerm.php";?></body>
<script src="../../js/jquery.printPage.js" type="text/javascript"></script>
     <script>  
  $(document).ready(function() {
    $(".btnPrint").printPage();
  });
  </script>
</html>