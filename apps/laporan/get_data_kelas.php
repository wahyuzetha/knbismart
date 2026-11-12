 <?php
include"../../inc/aman.php";
include"../../inc/koneksi.php";

$tingkat=$_POST[tingkat];


?> <div class="form-group form-float">
            <label>Pilih Kelas</label>
            <div class="form-line">
            <select class="form-control show-tick tingkat" name="kelas">
            <option value="">-- Pilih Semua Kelas --</option>
             
           
            <?php
             if(!empty($_SESSION[wali_kelas_k])){
            $mp=mysql_query("select * from kelas where nama_kelas='$_SESSION[wali_kelas_k]' and tahun_ajaran='$_SESSION[tahun_ajaran_pem]'  order by nama_kelas asc");
             }
             else {
                         $mp=mysql_query("select * from kelas where tingkat='$tingkat'  and tahun_ajaran='$_SESSION[tahun_ajaran_pem]'  order by nama_kelas asc");
    
             }
            while($dp=mysql_fetch_array($mp)){ 
            
           
        
		  			if($_GET[kelas]==$dp[nama_kelas]){
							$pilk="selected";
					}
					else {
						$pilk="";
					}

		  ?>
          <option value="<?php echo"$dp[nama_kelas]";?>" <?php echo"$pilk";?>><?php echo"$dp[nama_kelas]";?></option>
          <?php

              } ?>    
              </select>
                                
            </div>
            </div>
             </div>

			