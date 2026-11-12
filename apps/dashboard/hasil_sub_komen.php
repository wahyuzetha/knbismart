<?php
include"../../inc/koneksi.php";
include"../../inc/engkrip_s.php";
include"../../inc/aman_customer.php";
$field=$_POST[field];
$id_data=$_POST[id_data];
$id_komen=$_POST[id_komen];

?>
<script>
$(".tombol-batal").click(function(){
	var no_id = $(this).attr("data-id");

	var dataString_id = 'no_id='+no_id;
	swal({
    title: "Apakah Anda Yakin?",
    text: "Menghapus Komentar?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes',
    cancelButtonText: "No",
    closeOnConfirm: false,
    closeOnCancel: false
 },
 function(isConfirm){

   if (isConfirm){
   $.ajax({
	type: 'POST',
	url: "hapus_subkomen.php",
	data: dataString_id,
	beforeSend: function(){
//	$('.page-loader-wrapper').show();
	},
	complete: function(){
//	$('.page-loader-wrapper').hide();
	},
	error: function(){
	swal("Peringatan", "Koneksi Terputus, Silahkan cek jaringan anda", "warning");
    },
	success: function(data) {
			
 
	swal({
  title: "Berhasil!",
  text: "Komentar Berhasil Dihapus",
  type: "success",
  confirmButtonText: "OK"
	},
	function(isConfirm){
	  if (isConfirm) {
	$('.sub'+no_id).hide();
	
	 var dataStringk = 'id_komen=<?php echo"$id_komen_c";?>';

	 $.ajax({
	type: "POST",
	url: "hitung.php",
	data: dataStringk,
	cache: false,
	beforeSend: function(){
	$('#loading').show();
	},
	complete: function(){
	$('#loading').hide();
	},
	success: function(html) { 
	$('#loading').hide();
	$(".hasil_hitung<?php echo"$id_komen_c";?>").html(html);
	}
	,timeout: 60000 
	});
	
	  }
	}); 

		

	}
	,timeout: 60000 
	});
    } else {
      swal("Cancelled", "Proses di cancel", "error");
         e.preventDefault();
    }
 });

	
	
	
	});
			</script>
<ul class="chat chk<?php echo"$_POST[id_komen]";?>">
<hr>
					<?php
						
	$k=mysql_query("select * from koment_sub_forum where $field='$id_data' and id_komen='$id_komen' order by id asc") 
	or die("gagal buka".mysql_error());
    while($dk=mysql_fetch_array($k)){

$cpeg=mysql_query("SELECT * from users where id_pengguna='$dk[id_users]'");
$cdpeg=mysql_fetch_array($cpeg);

$id_skomen=$dk[id];

  
 
$tanggal_tr=date('d/m/Y H:i:s', strtotime($dk[timestmp])); // Hasil 15 February 1994

/*
$foto_s=substr($cdpeg[picture],0,4);
           
           if($foto_s=="http"){
             $fotok="$cdpeg[picture]";  
           }
           else {
              $fotok="../../foto/$cdpeg[picture]";  
           }
              
			if(empty($cdpeg[picture]) and !file_exists($fotok)){
			
			$foto_user_s="../../foto/avatar2.png";
			}
			else {
			$foto_user_s=$fotok;
		
			}			
		
		
*/

if($cdpeg[level]==2){
    $nm=mysql_query("SELECT * from guru where nik='$dk[id_users]'");
    $dnm=mysql_fetch_array($nm);
    $nama="<span style='color:blue; font-wight:bold'>$dnm[nama] (Guru)</span>";
}
else if($cdpeg[level]==3){
    $nm=mysql_query("SELECT * from siswa where nis='$dk[id_users]'");
    $dnm=mysql_fetch_array($nm);
    $nama="<span style='color:red; font-wight:bold'>$dnm[nama] (Siswa)</span>";
}
else {
  $nama="<span style='color:blue; font-wight:bold'>$dk[id_users] (Admin)</span>";

}
	
	?>
	
                        <li class="left clearfix sub<?php echo"$id_skomen";?>">
                            <div class="chat-body clearfix">
                                    <strong class="primary-font"><?php echo"$nama";?></strong> 
                                     	<?php
									if($_SESSION[namauser]==$dk[id_users]){?>
                                    <small class="pull-right text-muted">
                                      
                                       <span style="color:red; cursor:pointer;" data-id="<?php echo"$id_skomen";?>" class="tombol-batal">Hapus</span></small> <br>
                                       <?php } ?>
                                       <br>
                                        <span class="glyphicon glyphicon-time"></span><?php echo"$tanggal_tr";?> 
                                <p><br>
                                 <?php   
                                    if(!empty($dk[gambar])){
                                        echo"<img src='../../imgforum/$dk[gambar]' width='150px' data-toggle='modal' data-target='#bcf$dk[id]'>";
                                  ?> <div class="modal fade" id="<?php echo"bcf$dk[id]";?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                    <?php                                        
                    echo"<img src='../../imgforum/$dk[gambar]' width='100%'>";
?>                           
                        <div class="modal-footer">
                        
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              
                        </div>
                    </div>
                </div>
            </div>
            <?php
                                    }
                                       echo"$dk[komentar]";
                                         if(!empty($dk[file])){
                                        echo"<a href='../../fileforum/$dk[file]' download> 
					<button class='btn bg-pink waves-effect btn-xs' type='button'>
					<i class='material-icons'>cloud_download</i> Lampiran </button>
					</a>";
                                    }
?>
                                </p>
								<br>
								 	
								<div id="hasil<?php echo"$dk[id]";?>"></div>
                            </div>
                        </li>
						
					

                       <?php } ?>
                        
                    </ul>