<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
ini_set('max_execution_time', 0);

?>

                            <h2>
                               Data Kelas
                            </h2>
                         </div>
                        <div class="body">
                        
                                <table border='1'>
                          
                          
                           <hr>
                                    <thead class="bg-blue">
                                        <tr> <th>NO</th>
                                            <th>SOAL</th>
											 <th>A</th>
											  <th>B</th>
											   <th>C</th>
											    <th>D</th>
                                            <th>E</th>
											 <th>NO SOAL</th>
                                        </tr>
                                    </thead>
                     <tbody>
                          <?php
            $no=0;
           
          $m=mysql_query("SELECT pembelajaran.pembelajaran,ujian.nama_ujian,bank_soal.* from pembelajaran,ujian,bank_soal
WHERE ujian.id_pembelajaran=pembelajaran.id and ujian.id=bank_soal.id_ujian ORDER BY ujian.id,bank_soal.id");   
      
            while($d=mysql_fetch_array($m)){ 
            $no++;     
			$m2=mysql_query("SELECT * from bank_opsi where id_soal='$d[id]' and id_ujian='$d[id_ujian]' and opsi='A'");   
			$d2=mysql_fetch_array($m2);
			
			$m3=mysql_query("SELECT * from bank_opsi where id_soal='$d[id]' and id_ujian='$d[id_ujian]' and opsi='B'");   
			$d3=mysql_fetch_array($m3);
			
			$m4=mysql_query("SELECT * from bank_opsi where id_soal='$d[id]' and id_ujian='$d[id_ujian]' and opsi='C'");   
			$d4=mysql_fetch_array($m4);
			
			$m5=mysql_query("SELECT * from bank_opsi where id_soal='$d[id]' and id_ujian='$d[id_ujian]' and opsi='D'");   
			$d5=mysql_fetch_array($m5);
			
			$m6=mysql_query("SELECT * from bank_opsi where id_soal='$d[id]' and id_ujian='$d[id_ujian]' and opsi='E'");   
			$d6=mysql_fetch_array($m6);
			$pila=mysql_real_escape_string($d2[deskripsi]);
			$pilb=mysql_real_escape_string($d3[deskripsi]);
			$pilc=mysql_real_escape_string($d4[deskripsi]);
			$pild=mysql_real_escape_string($d5[deskripsi]);
			$pile=mysql_real_escape_string($d6[deskripsi]);

			$m6=mysql_query("update bank_soal set pila='$pila',pilb='$pilb',pilc='$pilc',pild='$pild',pile='$pile' where id='$d[id]' and id_ujian='$d[id_ujian]'") or die("gagal".mysql_error());   
			
            ?>      
           
                  <tr>
		<td width="10%"><?php echo"$no";?></td>
                <td width="30%"><?php echo"$d[pembelajaran] <br> $d[nama_ujian] <br> $d[soal]";?></td>
                <td width="10%"><?php echo"$d2[deskripsi]";?></td>
                <td width="10%"><?php echo"$d3[deskripsi]";?></td>
                <td width="10%"><?php echo"$d4[deskripsi]";?></td>
                <td width="10%"><?php echo"$d5[deskripsi]";?></td>
                <td width="10%"><?php echo"$d6[deskripsi]";?></td>
                <td width="10%"><?php echo"$d[no_soal]";?></td>
                         
                                        </tr>
                    <?php } ?>                    
                                       </tbody>
                                </table>
                           
