<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set("Asia/Bangkok");

$m=mysql_query("SELECT * from hasil_jwb where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]'");   
$d=mysql_fetch_array($m);

$mpem=mysql_query("SELECT * from ujian where id='$_SESSION[id_ujian]'");   
$dpem=mysql_fetch_array($mpem);

$_SESSION[jenis_waktu]=$dpem[lama_ujian];

$tgl_ini=date('Y-m-d');
$waktu_ujian_start=date('H:i:s');
$selesai_ujian=$d[waktu_selesai];

$awal  = strtotime("$tgl_ini $waktu_ujian_start"); //waktu awal
$akhir = strtotime("$tgl_ini $selesai_ujian"); //waktu akhir
$diff  = $akhir - $awal;
$sisa_jam   = floor($diff / 60 * 60);
$_SESSION[acak_jwb]=$_GET[acak_jwb];


$i=1;
					$pengacak = explode(",", $d['pengacak']);
					$j=0;

					foreach($pengacak as $id_soals) {
				 
						$j++;
					}
					$urutan_soal = $d['pengacak'];
					$_SESSION[urutan_soal_k]=$urutan_soal;
					$rows=$j;
					$keys = array_keys($pengacak);
?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>
 <script src="../../js/js/jquery-1.10.2.min.js"></script>

		<script src="../../js/js/countdown.js"></script>
		 <script src='../../plugins/tinymce/tinymce.min.js'></script>


 <script>
  tinymce.init({
  selector: 'textarea',
  themes: 'modern',
  height: 200,

 
  

});

 $(document).ready(function(){


	$(".tombol-simpan").click(function(){
	tinyMCE.triggerSave(); 

	var data = $('.form-user').serialize();
	var jawaban=$('#jawaban').val();
	if(jawaban==""){
	  swal("Peringatan", "Kolom Jawaban Essay Wajib Diisi !", "warning");

	}
	else {
	$.ajax({
	type: 'POST',
	url: "save_essay.php",
	data: data,
	beforeSend: function(){
	$('.page-loader-wrapper').show();
	},
	complete: function(){
	$('.page-loader-wrapper').hide();
	},
	error: function(){
	swal("Peringatan", "Koneksi Terputus, Silahkan cek jaringan anda", "warning");
    },
	success: function(data) {
	    //alert(data)
	if(data=="gagal"){	
		swal("Peringatan", "Gagal di simpan, silahkan ulangi", "warning");
	}
	else {	
	
	swal({
  title: "Berhasil!",
  text: "Jawaban Berhasil Di Simpan",
  type: "success",
  confirmButtonText: "OK"
},
function(isConfirm){
  if (isConfirm) {
//window.location = "detail_surat?d="+data;

	 
  }
}); 

	}	

	},
	timeout: 60000 
	});
	}
	});
 });

 <?php
					 if($dpem[lama_ujian]=="auto"){
						 ?>
 function ProgressCountdown(timeleft, nomor, urut, bar, text) {
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
			 
			// alert(id_soal);

								
								$.ajax({
									type:'POST',
									url:'soal_data.php',
									data:{id_soal:id_soal,pengacak:"<?php echo"$urutan_soal";?>"},
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
    }, 1000);
  });
}
					 <?php } ?>
  </script>
<style>
.save{
	color: red;
    margin-left: 221px;
    border-radius: 9px;
    background: bisque;
    height: 39px;
    padding: 7px;
position: fixed;}
.modal-dialog {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
margin-top: -130px !important;
}

.modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}
.opsi_huruf_multi {
    position: absolute;
    margin-left: -21px;
    margin-top: 20px !important;
    top: -19px;
}
</style>
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
            <div style="color:red; margin-top: -18px;">
            <?php echo"<h5>$d[nama_ujian] $d[pembelajaran]</h5>"; ?>
<?php 
	   if($dpem[lama_ujian]!="auto"){?>          
		  <div id='timer'>
            <script type="application/javascript">
            var myCountdownTest = new Countdown({
                                    time: <?php echo"$sisa_jam";?>, 
                                    width:200, 
                                    height:60, 
                                    rangeHi:"hour"
                                    });
           </script>
            </div>
			<hr>
	   <?php } ?>
	   <?php if($dpem[status_essay]==1){?>
                                <button style="margin-left:5px" class="btn btn-warning waves-effect" type='button'
                                data-toggle="modal" data-target="#essay">
                               <i class="material-icons">border_color</i>  Essay
                                 </button><hr>
                                 <?php } ?>
                                 
         </div>
         
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
    
                         </div>
						 
                        <div class="body"><?php // echo"$sisa_jam $d[lama_ujian]";?>
              <div class="modal fade modal-xl" id="essay" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-green">
                            <h4 class="modal-title bg" id="smallModalLabel">Soal Essay</h4>                     
                            <span class="pull-right" style="margin-top: -30px;" data-dismiss="modal"><i class="material-icons">close</i>
</span>
                        </div>
                        <div class="modal-body">
                            
							<form method="post" class="form-user">		
                    <?php echo html_entity_decode($dpem[essay]);?>
                            <textarea class="form-control" id="jawaban" name="jessay" placeholder="Isi Jawaban Essay Di Sini" rows="20"><?php echo html_entity_decode($d[essay]);?></textarea>
                     <b style='color:red'>(* hanya bisa melampirkan 1 file, jika upload lbh dari 1 maka file lama akan di timpa dengan yang baru,
                     usahakan file yang di upload berukuran di bawah 600 kb agar cepat dalam mengupload file)
          </b><br>
                              <input type="file" id="media" name="media" style="display: none;" required>
    <label for="media" class="btn btn-info">
     <i class="material-icons" style="color:white"><b>attach_file</b></i> Pilih File  </label>


    <div class="progress" style="display:none">
					<div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						<span class="sr-only">0%</span>
					</div>
				</div>
				<?php
				
                                    if(!empty($d[file])){
                                        echo"<hr><a href='../../file/$d[file]' download class='dl'> 
					<button class='btn bg-pink waves-effect btn-xs' type='button'>
					<i class='material-icons'>cloud_download</i> Hasil Lampiran Jawaban Anda </button>
					</a>";}
					?>
                       				<div class="msg" style="display:none"></div>
         
                            </div>
                        <div class="modal-footer">

                   <button type="button" class="btn btn-danger waves-effect tombol-simpan"><i class="material-icons">save</i> Simpan</button>

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
            
        							<div id="image2" class='save'><img src="image.gif">Saving data..</div>			
        							<div id="load_image" class='save'><img src="image.gif">Load Soal..</div>			


        	<form class="form-horizontal" role="form" id='soalform' method="POST" action="hasil" name="soalform">
			                 <div id='loadsoal'></div>

					<?php 
					  
					
					
					foreach(array_keys($keys) as $k) {
					    $id_soal = $pengacak[$keys[$k]];
					    $nextval = $pengacak[$keys[$k+1]];
                        $backval = $pengacak[$keys[$k-1]];
						
						$urutnext=$i+1;
						$urutback=$i-1;
						$nextval="$urutnext,$nextval";
						$backval="$urutback,$backval";

                ?>
                    

                    <?php if($i==1){
					 $opsi1 = mysql_query("select * from bank_soal where id='$id_soal'") or die(mysql_error());
                   $dopsi1=mysql_fetch_array($opsi1)
                   	
						?>     

<script>
$(document).ready(function(){

 var id_soal=<?php echo"$id_soal";?>;

								
								$.ajax({
									type:'POST',
									url:'soal_data.php',
									data:{id_soal:"<?php echo"1,$id_soal";?>",pengacak:"<?php echo"$urutan_soal";?>"},
									 beforeSend: function(){
									$('#load_image').show();
									},
									complete: function(){
									$('#load_image').hide();
									},
									success:function(response) {
							//		console.log(response);
									$('#loadsoal').html(response);
							

									
								//$('.p1').hide();
								
								$('input[type=radio]').on('change', function() {
 
								saveData();
 
								});
								$(".simpan_essay").click(function(){
								saveData();
									});
					

									
										}
								});
								
                            
                            $('.overlay').fadeOut();
 
             $('body').removeClass('overlay-open');
 	$('input[type=radio]').on('change', function() {
 
								saveData();
 
								});
								});
								</script>












					 
                     <?php }
					
					 
					
					$i++;
					}
					
					?>

				</form>
			</div>
		</div>
        </div>   
    </section>



   <?php




?>
		
		
		
		
		<script>
		

 
 
// Save data
        $('#image2').hide();
		$('#load_image').hide();


		
function saveData(){
 
 var datastring = $("#soalform").serialize();
 //alert(datastring)
  $.ajax({
   url: 'save',
   type: 'post',
   data: datastring,
    cache: false,
    beforeSend: function(){
        $('#image2').show();
    },
    complete: function(){
        $('#image2').hide();
    },
    error: function(){
	swal("Peringatan", "Koneksi Terputus, Silahkan cek jaringan anda", "warning");
    },
   success: function(response){
      
	  //jgn lupa d buka
	 //  $("#aku"+response).addClass("klik");
 
    //$('#postid').val(response);
    
   //alert(response)
   } 
  });
 
}


		
		$('.cont').addClass('hide');
		count=$('.questions').length;
		 $('#question'+1).removeClass('hide');
		 
		 $(document).on('click','.next',function(){
		     last=parseInt($(this).attr('id'));     
		     nex=last+1;
			 var id_soal=$(this).attr("data-id");
			 
			// alert(id_soal);

								
								$.ajax({
									type:'POST',
									url:'soal_data.php',
									data:{id_soal:id_soal,pengacak:"<?php echo"$urutan_soal";?>"},
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
									$(".simpan_essay").click(function(){
								saveData();
									});
				
				
								$('input[type=checkbox]').on('change', function() {
 
								saveData();
 
								});
								
								$(".jawaban_match").on('change', function() {
 
								saveData();
 
								});
									}
								});
								
								
										
			 
			 
		 });
		 
		 $(document).on('click','.previous',function(){
             last=parseInt($(this).attr('id'));     
             pre=last-1;
			  var id_soal=$(this).attr("data-id");
			// alert(id_soal);
			 
			 $.ajax({
									type:'POST',
									url:'soal_data.php',
									data:{id_soal:id_soal,pengacak:"<?php echo"$urutan_soal";?>"},
									 beforeSend: function(){
									$('#load_image').show();
									},
									complete: function(){
									$('#load_image').hide();
									},
									success:function(response) {
									
										$('#loadsoal').html(response);
										$('#question'+last).addClass('hide');
										$('#question'+pre).removeClass('hide');
										$('.n1').hide();
										$('input[type=radio]').on('change', function() {
 
										saveData();
 
										});
										$(".simpan_essay").click(function(){
								saveData();
									});
									
									
								$('input[type=checkbox]').on('change', function() {
 
								saveData();
 
								});
								
								$(".jawaban_match").on('change', function() {
 
								saveData();
 
								});
				
									}
								});
            
         });
         
					$(document).on('click','.pencet',function(){

					var id_soal=$(this).attr("data-id");

								
								$.ajax({
									type:'POST',
									url:'soal_data.php',
									data:{id_soal:id_soal,pengacak:"<?php echo"$urutan_soal";?>"},
									 beforeSend: function(){
									$('#load_image').show();
									},
									complete: function(){
									$('#load_image').hide();
									},
									success:function(response) {
									
										$('#loadsoal').html(response);
							

									
								$('.p1').hide();
								
								$('input[type=radio]').on('change', function() {
 
								saveData();
 
								});
								
								$('input[type=checkbox]').on('change', function() {
 
								saveData();
 
								});
								
								$(".jawaban_match").on('change', function() {
 
								saveData();
 
								});
									
								$(".simpan_essay").click(function(){
								saveData();
									});
				

									
										}
								});
								
                            
                            $('.overlay').fadeOut();
 
             $('body').removeClass('overlay-open');

                            });

            
       <?php 
	   if($dpem[lama_ujian]!="auto"){
                $stw=$sisa_jam * 1000; ?>
                setTimeout(function() {
                $("form").submit();
               alert("waktu anda habis");
                }, <?php echo"$stw";?>);
				
	   <?php } ?>
		</script>
<script >window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);


$(document).ready(function(){
 
 

								
									$('#media').on('change', function(event){
		event.preventDefault();
   var formData = new FormData();
   formData.append('media', $('#media')[0].files[0]);
		$('.msg').hide();
		$('.progress').show();
		
		$.ajax({
			xhr : function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(e){
					if(e.lengthComputable){
						console.log('Bytes Loaded : ' + e.loaded);
						console.log('Total Size : ' + e.total);
						console.log('Persen : ' + (e.loaded / e.total));
						
						var percent = Math.round((e.loaded / e.total) * 100);
						
						$('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
					}
				});
				return xhr;
			},
			
			type : 'POST',
			url : 'upload_file_essay.php',
			data : formData,
			processData : false,
			contentType : false,
			success : function(response){
				$('form')[0].reset();
				$('.progress').hide();
				$('.msg').show();
				if(response == ""){
					alert('File gagal di upload');
				}else{
					var msg = response;
					
									$('.dl').hide();

					$('.msg').html(msg);
				}
			}
		});
	});

 function load_unseen_notification(view = '')
 {
	 
  $.ajax({
   url:"fetch",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    if(data.unseen_notification > 0)
    {
	 swal("Peringatan",data.notification, "warning");

	//alert(data.notification);
	 $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{view:2},
   dataType:"json",
   success:function(data)
   {
   
   }
    });
   }}
  });
 }
 /*
 load_unseen_notification();
 
 setInterval(function(){ 
  load_unseen_notification();; 
 }, 5000);
 */
});

$('.finish').on('click',function(e) {
   
$.ajax({
   url:"selesai",
   method:"POST",
   data:{view:1},
   dataType:"html",
   success:function(data)
   {
	
//	alert(data)   
  /*  if(data!="sukses")
    {
    swal("Peringatan !", "Ujian hanya boleh diselesaikan pukul "+data+"", "warning");

	}
	else {*/
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


	//}
   }
  });
  });
</script>
<?php include"../../inc/footerm.php";?></body>

</html>