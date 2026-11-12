<?php 
session_start();
include "../../inc/koneksi_sim.php";
include "../../inc/aman.php";
?>

             
               
                    <div class="card">
                        <div class="body bg-green">
                            <div class="font-bold m-b--35">MONITOR PENDAFTAR PPDB <?php $tahun_ini=date('Y');
$tahun_besok=$tahun_ini + 1;

$tahun_c="$tahun_ini/$tahun_besok";
echo"$tahun_c";
?></div>
                            <ul class="dashboard-stat-list">
                               
                               <?php
                               $total=0;
                               $result2 = mysql_query("SELECT * FROM jurusan") or trigger_error(mysql_error()); 
	                           while($row = mysql_fetch_array($result2)){
	                         $jum_r = mysql_query("SELECT count(id) as jum from siswa where siswa.tahun='$tahun_c' 
	                         and jenis_data='daftar_baru' and kompetensi_keahlian='$row[id]'") or trigger_error(mysql_error()); 
	                         $d_jumr = mysql_fetch_array($jum_r);
	                         $total=$total+$d_jumr[jum];
	                            ?>

                                <li>
                                    <?php echo"$row[nama_jurusan]";?>
                                    <span class="pull-right"><h5><?php echo"$d_jumr[jum]";?></h5></span><hr>
                                </li>
                               <?php } ?>
                               <li>TOTAL                                     <span class="pull-right"><h5><?php echo"$total";?></h5></span><hr>
</li>
                            </ul>
                        </div>
                    </div>
               
              