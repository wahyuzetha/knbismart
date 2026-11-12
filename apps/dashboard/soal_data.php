<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
          
		   if($_SESSION[jenis_waktu]=="auto"){
						 ?>
						 <script>
 function ProgressCountdown(timeleft, nomor, urut, status, bar, text) {
  return new Promise((resolve, reject) => {
    var countdownTimer = setInterval(() => {
      timeleft--;

      document.getElementById(bar).value = timeleft;
      document.getElementById(text).textContent = timeleft;

      if (timeleft <= 0) {
		 
        clearInterval(countdownTimer);
        resolve(true);
		
		  last=parseInt(urut);     
		     nex=last+1;
			 var id_soal=nomor;
			 
			 if(status=="lanjut"){

								
								$.ajax({
									type:'POST',
									url:'soal_data.php',
									data:{id_soal:id_soal,pengacak:"<?php echo"$_SESSION[urutan_soal_k]";?>"},
									 beforeSend: function(){
									$('#load_image').show();
									},
									complete: function(){
									$('#load_image').hide();
									},
									success:function(response) {
									
										$('#loadsoal').html(response);
										$('#question'+last).addClass('hide');
		     
										$('#question'+nex).removeClass('hide');
										$('input[type=radio]').on('change', function() {
 
									saveData();
 
									});
									}
								});
			 }
			 else if(status=="finish"){
			 		     swal({
  title: "warning!",
  text: "Ujian Berakhir, Tekan OK untuk keluar",
  type: "warning",
  showCancelButton: false,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "OK",
  cancelButtonText: "No, Kembali Ujian",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  if (isConfirm) {
                $("form").submit();
	  } else {
    swal("Cancelled", "Melanjutkan ujian berhasil", "success");
	
  }
});
			 }
								
								
			
      }
    }, 1000);
  });
}





</script>
<?php } 
					
					
					
					
                 $soal=explode(",", $_POST[id_soal]);	
				$no_soal=$soal[0];
				$id_soal=$soal[1];	
				$soal_post=str_replace(" ","",$id_soal);
					//echo"no_soal $no_soal $id_soal";
					$soal_pengacak=$_POST[pengacak];
										$pengacak = explode(",", $soal_pengacak);

					$j=0;
					foreach($pengacak as $id_soals) {
				 
						$j++;
					}
		
					$keys = array_keys($pengacak);
					
					foreach(array_keys($keys) as $k) {
					    $id_soal_l = $pengacak[$keys[$k]];
					    $nextval = $pengacak[$keys[$k+1]];
                        $backval = $pengacak[$keys[$k-1]];
						
						$urutnext=$no_soal+1;
						$urutback=$no_soal-1;
						$nextval="$urutnext,$nextval";
						$backval="$urutback,$backval";
						
					if($id_soal==$id_soal_l){	
						
					?>
<?php
				   $opsi1 = mysql_query("select * from bank_soal where id='$soal_post'") or die(mysql_error());
                   $dopsi1=mysql_fetch_array($opsi1);
				   
				   	
				if($dopsi1[jenis]=="multi"){
					$bentuk_opsi="checkbox";
					$class_multi="opsi_huruf_multi";
					echo"<input type='hidden' name='jenis' value='multi'>";
					echo"<input type='hidden' name='id' value='$soal_post'>";

					$name_mul="jawaban_kirim[]";
					}
				
					else {
					$bentuk_opsi="radio";
					$class_multi="opsi_hurufk";
					$name_mul=$soal_post;
				
					}	
					
				   
                  	?>         
               <p class='questions' id="qname<?php echo $no_soal;?>"> <h5>No.<?php echo $no_soal; 
			 //  echo" $bentuk_opsi ID $id_soal - $soal_post - $id_soal_l";?>. </h5>

			   <?php
					 if($_SESSION[jenis_waktu]=="auto"){
						 if($j==$no_soal){ $status="finish"; } else { $status="lanjut"; }
						 ?>
					<script>
				ProgressCountdown(<?php echo"$dopsi1[timer]";?>,'<?php echo"$nextval";?>','<?php echo"$no_soal";?>', '<?php echo"$status";?>', 'pageBeginCountdown', 'pageBeginCountdownText').then(value => alert(`Waktu Habis, Klik OK untuk nomor Selanjutnya`));


</script>
<div class="row begin-countdown">
  <div class="col-md-12">
    <progress value="<?php echo"$dopsi1[timer]";?>" max="<?php echo"$dopsi1[timer]";?>" id="pageBeginCountdown"></progress><br>
    
  </div>
    <div class="col-md-4">
	Waktu Tinggal <span id="pageBeginCountdownText"><?php echo"$dopsi1[timer]";?> </span> Detik
	</div>
</div>
<hr>
					 <?php } ?>	
			   <?php echo $dopsi1['soal'];?></p><hr>
                 
					<?php
                    $hruf="A";
                   
				   if(!empty($dopsi1[pile])){
				 $opsi_soal="A~~$dopsi1[pila],,,,B~~$dopsi1[pilb],,,,C~~$dopsi1[pilc],,,,D~~$dopsi1[pild],,,,E~~$dopsi1[pile]";
				  }
				  else {
				 $opsi_soal="A~~$dopsi1[pila],,,,B~~$dopsi1[pilb],,,,C~~$dopsi1[pilc],,,,D~~$dopsi1[pild]";
				      
				  }
			//	 $opsi_soal="A~~$dopsi1[pila],,,,B~~$dopsi1[pilb],,,,C~~$dopsi1[pilc],,,,D~~$dopsi1[pild]";
				$opsi_soal_tampil = explode(",,,,", $opsi_soal);
				
				
			
			if($dopsi1[jenis]=="essay"){
				 $cek_ops=mysql_fetch_array(mysql_query("select * from hasil_opsi where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' 
                    and id_soal='$soal_post'"));
                    	
				echo"<textarea class='form-control' name='jawab' rows='5' placeholder='isi jawaban di sini'>$cek_ops[opsi]</textarea>
				<input type='hidden' name='id' value='$soal_post'>
				<input type='hidden' name='jenis' value='essay'>
				<input type='hidden' name='no_soal' value='$no_soal'>

				<br>
				<input type='button' class='btn bg-orange simpan_essay' value='simpan'>";	
				
			}
			else if($dopsi1[jenis]=="match"){
			include"../../inc/fungsi.php";
			
			$cek_opn=mysql_fetch_array(mysql_query("select * from hasil_jwb where nis='$_SESSION[nis]' 
				and id_ujian='$_SESSION[id_ujian]'"));
			
			
			$ket_opsi_matching = explode("||", $dopsi1[ket_opsi_matching]);
			$s = 'a';
			$ket_op=array();
			foreach($ket_opsi_matching as $ket_opsi){
			$ket_op[]="$s. $ket_opsi";
			$s = chr(ord($s) + 1);
			}
			$keterangan_matching=implode("<br>",$ket_op);
			$keterangan_matching="<br> $keterangan_matching <hr>";
				
			echo"$keterangan_matching";				
				 
			 $nom=0;
			if($_SESSION[acak_jwb]==1){
			$acak_s="order by rand()";
			}
			else {
			$acak_s=" order by id asc"; 
			}	


			echo"<input type='hidden' name='jenis' value='match'>";
			echo"<input type='hidden' name='id' value='$soal_post'>";
					
			if(!empty($cek_opn[matching_opsi_ar])){
			$pch_opsi_match=explode(",",$cek_opn[matching_opsi_ar]);
			
			$pch_opsi_data_ar=array();
			foreach($pch_opsi_match as $pch_opsi_data){
			$pch_opsi_data_ar[]="id='$pch_opsi_data'";
			}
			$pch_opsi_data_k=implode(" or ", $pch_opsi_data_ar);
			
			$qry_match=" and ($pch_opsi_data_k)";
			}
			else {
			$qry_match="";
			}				
		   $mo=mysql_query("SELECT * from bank_opsi  where 1 and 
		   id_ujian='$_SESSION[id_ujian]' and id_soal='$soal_post' $qry_match $acak_s");   
            while($rowo=mysql_fetch_array($mo)){ 
			$nom++;
			$kunci_mt=number_to_str($rowo[kunci]);
			$cek_ops=mysql_fetch_array(mysql_query("select * from hasil_opsi where nis='$_SESSION[nis]' 
				and id_ujian='$_SESSION[id_ujian]' 
                    and id_soal='$soal_post'"));
			
			$hasil_match=explode("||",$cek_ops[opsi]);
			
			$val_match=array();
			foreach($hasil_match as $hasil_match_cek){
			$jawaban_match=explode("=",$hasil_match_cek);
			$id_opsi=$jawaban_match[0];
			$jawaban_opsi=$jawaban_match[1];
			if($rowo[id]==$id_opsi){
			$val_match[]=$jawaban_opsi;	
			}
			}
			
			
			
			$val_matching=implode("",$val_match);
			
			echo"$nom. $rowo[deskripsi] <input type='text' name='jawaban_match$rowo[id]' value='$val_matching' class='jawaban_match' style='width:50px !important'> <br>";
			echo"<input type='hidden' name='id_opsi_match[]' value='$rowo[id]' class='jawaban_match' style='width:50px !important'> <br>";

			}
		
				
				}
				else {
				
					
				if($_SESSION[acak_jwb]==1){
				shuffle($opsi_soal_tampil);
				}
				
				foreach($opsi_soal_tampil as $opsi_ts) {
				$opsi_tx=explode("~~", $opsi_ts);	
				
				$opsi_t=$opsi_tx[1];
				$opsi_huruf=$opsi_tx[0];	
				if($opsi_t==""){} else {
				$desk=$opsi_t;
				$desk=str_ireplace('<p>','',$desk);
				//$desk=str_ireplace('</p>','',$desk);
				
				    $cek_ops=mysql_fetch_array(mysql_query("select * from hasil_opsi where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' 
                    and id_soal='$soal_post'"));
                    
					if($dopsi1[jenis]=="multi"){
						if(strstr($cek_ops[opsi],$opsi_huruf )){
                        $pilih_opsi="checked";
                    }
                    else {
                        $pilih_opsi="";

                    }
					
					}
					else {
                    if($cek_ops[opsi]==$opsi_huruf){
                        $pilih_opsi="checked";
                    }
                    else {
                        $pilih_opsi="";

                    }	
					}
                    ?>
                    
                    <input type="<?php echo"$bentuk_opsi";?>" <?php echo"$pilih_opsi";?> value="<?php echo"$opsi_huruf";?>" 
                    class="<?php echo"$bentuk_opsi";?>-col-red" id='radio1_<?php echo"$soal_post$opsi_huruf";?>' name='<?php echo"$name_mul";?>'
                    onClick="document.getElementById('aku<?php echo $no_soal;?>').setAttribute('class', 'klik');"/>
                      <label for="radio1_<?php echo"$soal_post$opsi_huruf";?>" style="margin-bottom: 22px;"> 
					  <?php
					  echo"<span class='$class_multi'>$hruf</span> <span class='opsi_deskripsik'>$desk</span><br>";?></label><br>
                  
                  
				<?php } $hruf = chr(ord($hruf) + 1); } } ?>
					
					
					
                    <br/><br><br>
					<?php
					 if($_SESSION[jenis_waktu]!="auto"){?>
                      <button id='<?php echo $no_soal;?>' class='previous btn btn-success' type='button' data-id="<?php echo $backval?>">Previous</button><?php 
						if($j==$no_soal){?>
						
						<button id="finish" type="button" class="finish btn bg-red waves-effect">
                                    SELESAI
                                </button>
							<br><br><br><br><br>
						
                                <script>
				$('.finish').on('click',function(e) {
   
$.ajax({
   url:"selesai",
   method:"POST",
   data:{view:1},
   dataType:"html",
   success:function(data)
   {
	
//	alert(data)   
  //  if(data!="sukses")
  //  {
  //  swal("Peringatan !", "Ujian hanya boleh diselesaikan pukul "+data+"", "warning");

//	}
//	else {
		     swal({
  title: "warning!",
  text: "Apakah Anda yakin mengakhiri ujian, jika yakin tekan Yes, jika tidak No",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes, Yakin",
  cancelButtonText: "No, Kembali Ujian",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  if (isConfirm) {
                $("form").submit();
	  } else {
    swal("Cancelled", "Melanjutkan ujian berhasil", "success");
	
  }
});


//	}
   }
  });
  });
</script>
					 <?php  } else {
						?>
                    <button id='<?php echo $no_soal;?>' class='next btn btn-success' type='button' data-id="<?php echo $nextval?>" >Next</button>
					
					
					 <?php } } }?>
					
					
					<?php
					}
						?>
				 
				 
					
				


  