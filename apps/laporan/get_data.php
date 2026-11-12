<?php
include"../../inc/aman.php";
include"../../inc/koneksi.php";

if($_POST['pembelajaran']) {?>
<div class="form-group form-float">
            <label class="form-label">Ujian</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick ujian" name="ujian" id="ujian">
           <?php
	$id 			= $_POST['pembelajaran'];

	$query 		= "select * from ujian where id_pembelajaran = '$id'";
	$results 	= mysql_query( $query);

	    if($_SESSION[levelu]==3){
	        ?>	      <option value="semua"><?php echo"Semua Ujian";?></option>
<?php
	    }
	    else {} 
	    	while($row=mysql_fetch_assoc($results)){
	?>
	      <option value="<?php echo"$row[id]";?>"><?php echo"$row[nama_ujian]";?></option>

              <?php } 
		
	}

?>  </select>
                                
            </div>
            </div>
			<div class="row">
			<div class="col-md-12">
           <input name="jenis" type="radio" id="radio_1" checked="" value="normal">
		   <label for="radio_1"> &nbsp;&nbsp; NORMAL</label>
		    <input name="jenis" type="radio" id="radio_2" value="pdf">
		   <label for="radio_2"> &nbsp;&nbsp;PDF </label>
		    <input name="jenis" type="radio" id="radio_3" value="excel">
		   <label for="radio_3">&nbsp;&nbsp; EXCEL</label>
		   </div>
		   </div>
             <input type="submit" class="btn btn-success" value="REKAP">  
                  <hr>
