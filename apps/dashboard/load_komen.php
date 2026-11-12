<?php
include"../../inc/koneksi.php";
include"../../inc/aman.php";

$data = explode("," , $_POST[id_data]);
$field=$data[1];
$id_data=$data[0];
?>
<script>
$('.close_sub_komen').hide();
	$(".sub_komen").click(function(){

	var no_id = $(this).attr("data-id");
   var field="<?php echo"$field";?>";
   var id_data="<?php echo"$id_data";?>";
 var dataString = 'field='+field+'&id_komen='+no_id+'&id_data='+id_data;
	 $.ajax({
	type: "POST",
	url: "load_sub_komen.php",
	data: dataString,
	cache: false,
	beforeSend: function(){
	$('#loadings'+no_id).show();
	},
	complete: function(){
	$('#loadings'+no_id).hide();
	},
	success: function(html) { 
	$('#loadings'+no_id).hide();
	$('#close_sub_komen'+no_id).show();

	$("#hasil"+no_id).html(html);

	}
	,timeout: 60000 
	});
	
	});
	
	function load_hitung_komen(id_komen){
    var dataString = 'id_komen='+id_komen;

	$.ajax({
	type: "POST",
	url: "hitung.php",
	data: dataString,
	cache: false,
	beforeSend: function(){
	$('#loading').show();
	},
	complete: function(){
	$('#loading').hide();
	},
	success: function(html) { 
	$('#loading').hide();
	$(".hasil_hitung"+id_komen).html(html);
	}
	,timeout: 60000 
	});
	}

	
	$(".close_sub_komen").click(function(){
	var no_ids = $(this).attr("data-id");
	$('#close_sub_komen'+no_ids).hide();
	$('.chk'+no_ids).hide();
	$('.edr'+no_ids).hide();

	});

   $(".tombol-batal-k").click(function(){
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
	url: "hapus_komen.php",
	data: dataString_id,
	beforeSend: function(){
	},
	complete: function(){
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
	$('.likomen'+no_id).hide();
	
	 var dataStringk = 'id_komen='+no_id;
	
	  }
	}); 

		

	}
 
	});
    } else {
      swal("Cancelled", "Proses di cancel", "error");
         e.preventDefault();
    }
 });

	
	
	
	});
	</script>
	<div class="col-md-12">
<ul class="chat">
					<?php 
	$k=mysql_query("select * from koment_forum where $field='$id_data' and kelas='$_SESSION[kelasku]' and tahun_ajaran='$tahun_aktif' order by id desc") 
	or die("gagal buka".mysql_error());
    while($dk=mysql_fetch_array($k)){


$jum=mysql_query("select count(id) as jum from koment_sub_forum where id_komen='$dk[id]'");
$djum=mysql_fetch_array($jum);
  
$cpeg=mysql_query("SELECT * from users where id_pengguna='$dk[id_users]'");
$cdpeg=mysql_fetch_array($cpeg);
$tanggal_tr=date('d/m/Y H:i:s', strtotime($dk[timestmp])); // Hasil 15 February 1994

$id_komen=$dk[id];
/*
$foto_s=substr($cdpeg[picture],0,4);
           
           if($foto_s=="http"){
             $foto_user_s="$cdpeg[picture]";  
           }
           else {
               
          if(!file_exists($fotok)){
			
			$foto_user_s="../../foto/avatar2.png";
			}
			else {
			$foto_user_s=$fotok;
		
			}	
			
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
	
                        <li class="left clearfix likomen<?php echo"$id_komen";?>">
                            <div class="chat-body clearfix">
                                    <strong class="primary-font"><?php echo"$nama";?></strong> <small class="pull-right">
									<?php
									if($_SESSION[namauser]==$dk[id_users] or $_SESSION[levelu]==2 or $_SESSION[levelu]==1){?>

                                        <ul class="header-dropdown" style="list-style: none;">
                                <li class="dropdown" style="border-bottom: 0px;">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li style="border-bottom: 0px;" data-id="<?php echo"$id_komen";?>" class="tombol-batal-k"><span style="color: red;
    cursor: pointer;
    margin-left: 20px;
    top: 8px !important;
    position: relative" >Hapus</span>
                                    </li>
                                      
                                    </ul>
                                </li>
                            </ul>
									<?php } ?>	
										
										</small> <br> <span class="glyphicon glyphicon-time"></span><?php echo"$tanggal_tr";?> 
                               
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
								<script>		
								load_hitung_komen("<?php echo"$dk[id]";?>");
							    </script>
								<span class="sub_komen" style="color:green; cursor:pointer;font-wight:bold;" 
								data-id='<?php echo"$id_komen";?>'><b>Komentar (<span class="hasil_hitung<?php echo"$dk[id]";?>"></b></span>)</span>
								<span id="loadings<?php echo"$id_komen";?>" style="display:none;"><img src="../../css/loader.gif"></span>   

								<span class="close_sub_komen pull-right" id="close_sub_komen<?php echo"$id_komen";?>" style="    color: red;
    cursor: pointer;
    
    " 
								data-id='<?php echo"$id_komen";?>'>close </span>
								<div id="hasil<?php echo"$id_komen";?>" style="margin-left: 22px;"></div>
                            </div>
                        </li>
                       <?php } ?>
                        
                    </ul>
                    </div>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>