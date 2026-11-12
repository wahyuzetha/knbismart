<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/tanggal.php";
function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m3=mysql_query("select  * from ujian where id='$id'");
$d3=mysql_fetch_array($m3);

$m2=mysql_query("select  * from pembelajaran where id='$d3[id_pembelajaran]'");
$d2=mysql_fetch_array($m2);

		?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
</head>

                             <h3>
                               Bank Soal Ujian <?php echo"$d3[nama_ujian]";?>, Pembelajaran <?php echo"$d2[pembelajaran]";?>
                            </h3>
                            
                         </div>
                        <div class="body">
                                                         
                                  <hr>
                         
 <?php
$_SESSION[id_ujian_soal]=$d3[id];

 ?>           
                                <table class="table table-bordered table-striped table-hover dataTable">
                           
                          
                                    <thead class="bg-blue">
                                        <tr>
                                             <th>NO</th>

                                            <th>SOAL</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $i=0;
           
          $m=mysql_query("SELECT * from bank_soal  where 1 and id_ujian='$d3[id]' order by id asc");   
      
            while($row=mysql_fetch_array($m)){ 
           $i++;


				$tipe_soal_ar=array();
				$opsi_soal="A~~$row[pila],,,,B~~$row[pilb],,,,C~~$row[pilc],,,,D~~$row[pild],,,,E~~$row[pile]";
				$opsi_soal_tampil = explode(",,,,", $opsi_soal);
				
				
				foreach($opsi_soal_tampil as $opsi_ts) {
				$opsi_tx=explode("~~", $opsi_ts);	
				$opsi_t=$opsi_tx[1];
				$opsi_huruf=$opsi_tx[0];	
				
				$desk=$opsi_t;
				$desk=str_ireplace('<p>','',$desk);
				$desk=str_ireplace('</p>','',$desk);   
               $tipe_soal_ar[]="$opsi_huruf = $desk <br>"; 
                 }
				 if($row[jenis]=="essay"){
			 $tipe_soal="";

			 }
			 else {
				$tipe_soal=implode("",$tipe_soal_ar);
			 }
            ?>      
           
                  <tr>
                <td width="10%"><?php echo"<b>$i</b>";?></td>
				<td width="70%"><?php echo"$row[soal] <hr>$tipe_soal <br><b>Kunci : $row[kunci]</b>";?></td>
                
                                       
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

</html>