 <?php
include"../../inc/aman.php";
include"../../inc/koneksi.php";

$m2peng=mysql_query("select  * from kelas where nama_kelas='$_POST[tingkat]' and tahun_ajaran='$_SESSION[tahun_ajaran_pem]'");
	$dm2peng=mysql_fetch_array($m2peng);
	
		$split=$dm2peng[split_import];
	

$tingkat=$_POST[tingkat];
$tingkat=explode("$split",$tingkat);
$tingkat=$dm2peng[tingkat];

$pth=" and tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and semester='$_SESSION[semester_pem]'";
?>
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>



<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Mapel yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".select2 option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
 </script>
 <div class="form-group form-float">
            <label class="form-label">Mata Pelajaran </label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick pembelajaran select2" name="pembelajaran" id="pembelajaran" style="width:100%">
            <option value="">-- Pilih Mata Pelajaran --</option>
            <?php
             if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1 or $_SESSION[jabatan_guru]==12){  
            $mp1=mysql_query("select * from pembelajaran where tingkat='$tingkat' $pth and
            (kelas='null' or kelas='' or kelas like '%$_POST[tingkat]%')");
             }
              else if(!empty($_SESSION[wali_kelas_k])){  
            $mp1=mysql_query("select * from pembelajaran where tingkat='$tingkat' and (kelas like '%$_SESSION[wali_kelas_k]%' or kelas='')");
             }
              else if($_SESSION[levelu]==3){  
            $mp1=mysql_query("select * from pembelajaran where tingkat='$tingkat' $pth and
            (kelas='null' or kelas='' or kelas like '%$_POST[tingkat]%')");
             }
             else {
               $mp1=mysql_query("select * from pembelajaran where  nuptk='$_SESSION[id_pengguna]'
			   and tingkat='$tingkat' $pth and
            (kelas='null' or kelas='' or kelas like '%$_POST[tingkat]%')");   
             }
            while($dp1=mysql_fetch_array($mp1)){ 
             
                        $dm=mysql_query("select  * from guru where nik='$dp1[nuptk]'"); 
            
                $guru=mysql_fetch_array($dm);
        if($_GET[pembelajaran]==$dp1[id]){
							$pilk2="selected";
					}
					else {
						$pilk2="";
					}
            ?>      
          <option value="<?php echo"$dp1[id]";?>"  <?php echo"$pilk2";?>><?php echo"$guru[nama] - $dp1[pembelajaran]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
			