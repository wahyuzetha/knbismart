<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/hari.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['id_materi']);
$id_pembelajaran = anti_injection($_GET['id_pembelajaran']);
$kelas = anti_injection($_GET['id_kelas']);

$_SESSION[kelasku]=$_GET[id_kelas];

$pem=mysql_query("select * from pembelajaran where id='$id_pembelajaran'");
$dpem=mysql_fetch_array($pem);


$id_tugas = anti_injection($_GET['id_tugas']);
$id_ujian = anti_injection($_GET['id_ujian']);
$tanggal=anti_injection($_GET['tanggal']);
$jam_sekarang=date('H:i:s');
$tgl_skrgs=date('Y-m-d');

?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
  <script src="../../js/jquery-1.11.2.min.js"></script>
 <script src="https://cdn.ckeditor.com/4.14.0/standard-all/ckeditor.js"></script>

<style>
.chat
{
    list-style: none;
    margin: 0;
    padding: 0;
	width:100%;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;

}

.chat li img { max-width: 100%; }

.chat li.left .chat-body
{
}

.chat li.right .chat-body
{
    margin-right: 60px;
}


.chat li .chat-body p
{
    margin: 0;
    color: #000;
}

.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
    overflow-y: scroll;
    height: 500px;
}


.image-upload > input
{
    display: none;
}

.image-upload img
{
    width: 70px;
    cursor: pointer;
}
iframe, object, embed {
    max-width: 100%;
}
</style>
<script>
 $(document).ready(function(){


	$('.loadingsave').hide();



$(".buka_komen_awal").click(function(){
    	$('.koment_awal').show();
    	$('.tutup_komen_awal').show();

}); 

$(".tutup_komen_awal").click(function(){
    	$('.koment_awal').hide();
    	    	$('.tutup_komen_awal').hide();


}); 



$(".baca").click(function(){
     	var data = 1;

  $.ajax({
	type: 'POST',
	url: "getpdf.php",
    data: { id: <?php echo"$id";?>},
	beforeSend: function(){
	$('.loadingpdf').show();
	},
	complete: function(){
	$('.loadingpdf').hide();
	},
	error: function(){
	swal("Peringatan", "Koneksi Terputus, Silahkan cek jaringan anda", "warning");
    },
	success: function(html) { 
	$(".hasil_pdf").html(html);

    
	},
	timeout: 60000 
	});
	
	});
	

$(".tombol-simpan").click(function(){
     for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    };
 	var data = $('.form-user').serialize();
 	
 	var cek=$('#editor1').val();
    if(cek==""){
     	swal("Peringatan", "Silahkan isi komentar", "warning");
   
    } 	
    else {
	$.ajax({
	type: 'POST',
	url: "save_komen.php",
	  cache: false,
	data: data,
	beforeSend: function(){
	$('.loadingsave').show();
	},
	complete: function(){
	$('.loadingsave').hide();
	},
	error: function(){
	swal("Peringatan", "Koneksi Terputus, Silahkan cek jaringan anda", "warning");
    },
	success: function(data) {
	if(data==""){	
		swal("Peringatan", "Gagal di simpan, silahkan ulangi", "warning");
	}
	else {	
	

//  	console.log(data)
$('.form-user')[0].reset();
$('#myText').val("");
$('#downlodf').val("");

      
	load_komen("<?php echo"$id,id_materi";?>");
	 for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
    }
        CKEDITOR.instances[instance].setData('');
$('.resultImageWrapper').hide();
$('.msg').hide();

  }
	

		

	},
	timeout: 60000 
	});
    }
	});
	
	function load_komen(id_data, field){
 var dataString = 'id_data='+id_data+'&field='+field;
	 $.ajax({
	type: "POST",
	url: "load_komen.php",
	data: dataString,
	cache: false,
	beforeSend: function(){
	$('#loading_komen').show();
	},
	complete: function(){
	$('#loading_komen').hide();
	},
	success: function(html) { 
	$('#loading_komen').hide();
	$(".hasil").html(html);



	}
	,timeout: 60000 
	});
	}
	
	load_komen("<?php echo"$id,id_materi";?>");
	});
	
	jQuery.event.props.push('dataTransfer');

	$(function(){



		handleDrop = function(files,hasil_wrapper,hasil_gambar,hasil_text){

			var file = files[0]; // Multiple files can be dropped. Lets only deal with the "first" one.

			if (file.type.match('image.*')) {
				resizeImage(file, 300, function(result) {
					hasil_gambar.attr('src', result);
                    hasil_text.val(result);
					hasil_wrapper.show();
				});
			} else {
				alert("That file wasn't an image.");
			}
		};


		

		resizeImage = function(file, size, callback) {
			var fileTracker = new FileReader;
			fileTracker.onload = function() {
				var image = new Image();
				image.onload = function(){
					var canvas = document.createElement("canvas");
				
					if(image.height > size) {
						image.width *= size / image.height;
						image.height = size;
					}
					
					else if(image.width > size) {
						image.height *= size / image.width;
						image.width = size;
					}
					var ctx = canvas.getContext("2d");
                    
					ctx.clearRect(0, 0, canvas.width, canvas.height);
					canvas.width = image.width;
					canvas.height = image.height;
					ctx.drawImage(image, 0, 0, image.width, image.height);
					callback(canvas.toDataURL("image/png"));
				};
				image.src = this.result;
			}

			fileTracker.readAsDataURL(file);

			fileTracker.onabort = function() {
				alert("The upload was aborted.");
			}

			fileTracker.onerror = function() {
				alert("An error occured while reading the file.");
			}
		};
		
		$('#imageFile').on('change', function(event) {
			var hasil_wrapper=$('.resultImageWrapper');
			var hasil_gambar=$('#resultImage');
			var hasil_text=$('#myText');
			handleDrop(event.target.files,hasil_wrapper,hasil_gambar,hasil_text);
		});
		
		$('#imageFile_ktp').on('change', function(event) {
			var hasil_wrapper=$('.resultImageWrapper_ktp');
			var hasil_gambar=$('#resultImage_ktp');
			var hasil_text=$('#myText_ktp');
			handleDrop(event.target.files,hasil_wrapper,hasil_gambar,hasil_text);
		});
		
		
	});

    var detik = <?php echo date('s'); ?>;
    var menit = <?php echo date('i'); ?>;
    var jam   = <?php echo date('H'); ?>;
     
    function clock()
    {
        if (detik!=0 && detik%60==0) {
            menit++;
            detik=0;
        }
        second = detik;
         
        if (menit!=0 && menit%60==0) {
            jam++;
            menit=0;
        }
        minute = menit;
         
        if (jam!=0 && jam%24==0) {
            jam=0;
        }
        hour = jam;
         
        if (detik<10){
            second='0'+detik;
        }
        if (menit<10){
            minute='0'+menit;
        }
         
        if (jam<10){
            hour='0'+jam;
        }
        waktu = hour+':'+minute+':'+second;
         
        document.getElementById("clock").innerHTML = waktu;
        detik++;
    }
 
    setInterval(clock,1000);
</script>
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
                    <div class="card">
         <?php
            $no=0;
            $m=mysql_query("select  * from materi where id='$id'");   
            $d=mysql_fetch_array($m);
			
			$mt=mysql_query("select  * from tugas where id='$id_tugas'");   
            $dt=mysql_fetch_array($mt);
			
			
			$mj=mysql_query("select  * from ujian where id='$id_ujian'");   
            $dj=mysql_fetch_array($mj);
			
			$wm=mysql_query("select  * from asc_periods where starttime='$_GET[jam]'");   
            $dwm=mysql_fetch_array($wm);
			
             $dm=mysql_query("select  * from guru where nuptk='$d[nuptk]'");   
              $guru=mysql_fetch_array($dm);
			  
			  $chari=date('D', strtotime($tanggal));
				$hari_jadwal=hari_indo($chari);	

$qhr=mysql_query("SELECT * from asc_daysdefs where name='".mysql_real_escape_string($hari_jadwal)."'");	
$dhr=mysql_fetch_array($qhr);
 
			  
			  //mengecek status mengajar apakah sudah open
			$qstatus=mysql_query("SELECT status_belajar.status_siswa,status_belajar.status,status_belajar.warna,status_mengajar.* from status_mengajar,status_belajar
											where 
                                            status_belajar.id=status_mengajar.status_belajar and
											status_mengajar.id_pembelajaran='$_GET[id_pembelajaran]' and
											status_mengajar.tanggal='$tanggal' and
											status_mengajar.id_kelas='$_GET[id_kelas]' and
											status_mengajar.semester='$semester_aktif' and
											status_mengajar.tahun_ajaran='$tahun_aktif' ");	
	        $dstatus=mysql_fetch_array($qstatus);
	
	
            $no++;     
			
			if($_SESSION[levelu]==3){

				
			if($dstatus[status_belajar]!=3 and $jam_sekarang<=$jam_selesai_pelajaran_tutup){
	
	
			$cek=mysql_query("select * from log_akses_materi where id_user='$_SESSION[namauser]' and id_materi='$id' and tanggal='$tgl_skrgs'");
			
			
$dcek=mysql_fetch_array($cek);
if(!empty($dcek[id])){
   
}
else {
	$tgl_lg=$tanggal_pelajaran_aktif_s;
$jam_lg=date('H:i:s');
$save=mysql_query("insert into log_akses_materi(ip,id_materi,id_user,hit,tanggal,timestmp,device,id_pembelajaran,jam,id_mengajar)
                    values('$ip','$id','$_SESSION[namauser]','1','$tgl_skrgs',NOW(),'$_SERVER[HTTP_USER_AGENT]','$id_pembelajaran','$jam_lg','$dstatus[id]')") or die("gagal".mysql_error());
}
			}
			}
			
			
			
			 $qjadwal=mysql_query("SELECT asc_periods.starttime,asc_periods.endtime,guru.nama,kelas.id_class,kelas.tingkat,kelas.nama_kelas,asc_subjects.id as id_mapel,asc_subjects.name as mapel,asc_lessons.id as id_lesson,asc_cards.* 
	from asc_cards,guru,kelas,asc_subjects,asc_lessons,asc_periods
	WHERE 
	asc_lessons.id=asc_cards.lessonid AND
	asc_lessons.teacherids=guru.teacher_id AND
	asc_lessons.classids=kelas.id_class AND
	asc_lessons.subjectid=asc_subjects.id AND
	asc_cards.period=asc_periods.period and
	asc_lessons.classids='$dstatus[classid]' and
	asc_cards.days='$dhr[days]' AND
	asc_cards.tahun_ajaran='$tahun_aktif' AND
	asc_cards.semester='$semester_aktif' and
	asc_lessons.teacherids='$_GET[teacher_id]' and 
	asc_lessons.subjectid='$_GET[subject_id]' order by asc_periods.starttime asc
	");	
	$jno=0; 
	$jam_k=array();
	$jam_k2=array();
	$jum_jadwal=mysql_num_rows($qjadwal);
	while($djadwal=mysql_fetch_array($qjadwal)){
	$jno++;
	if($jno==1){
	$jam_k[]=$djadwal[starttime];
	}
	
   if($jno == $jum_jadwal) {
    $jam_k2[]=$djadwal[endtime];
	}
	
	
	
	
	}
	$jam_mg1=implode("",$jam_k);
	$jam_mg2=implode("",$jam_k2);

	$waktu_status_m="$jam_mg1 sampai $jam_mg2";

            ?>      
             
                        <div class="header">
                         <?php echo"<h4>Kelas $_SESSION[kelasku]</h4>";
						$tgl_k=date('d/m/Y', strtotime($tanggal));
						
						echo"<span style='font-size: 15px;'>$tgl_k</span>
						<span style='font-size: 15px;' id='clock'></span>";
						
						 
						 echo"<hr><b>Mapel : $dpem[pembelajaran] <br> Tema : $d[tema] <br> Judul : $d[judul] <br>
						 Waktu : $waktu_status_m</b>
						 ";
						 
						 if($_SESSION[levelu]==3){
						 $status_mn=$dstatus[status_siswa];
						 }
						 else {
						 $status_mn=$dstatus[status];
						 }
						 
						 echo"$djam[starttime] <br><span class='badge bg-$dstatus[warna]'> Status $status_mn</span>";
						if($_SESSION[levelu]!=3){   
						?> 
						
						 <form action="proses_belajar" method="get" id="<?php echo"fs";?>"> 
                <input type="hidden" name="id_pembelajaran" value="<?php echo"$_GET[id_pembelajaran]";?>">
                <input type="hidden" name="id_materi" value="<?php echo"$_GET[id_materi]";?>">
                <input type="hidden" name="id_tugas" value="<?php echo"$_GET[id_tugas]";?>">
                <input type="hidden" name="id_ujian" value="<?php echo"$_GET[id_ujian]";?>">
                <input type="hidden" name="id_kelas" value="<?php echo"$_GET[id_kelas]";?>">
                <input type="hidden" name="status_belajar" value="<?php echo"3";?>">
                <input type="hidden" name="tanggal" value="<?php echo"$_GET[tanggal]";?>">
                <input type="hidden" name="jam" value="<?php echo"$_GET[jam]";?>">
                <input type="hidden" name="teacher_id" value="<?php echo"$_GET[teacher_id]";?>">
                <input type="hidden" name="classid" value="<?php echo"$_GET[classid]";?>">
                <input type="hidden" name="subject_id" value="<?php echo"$_GET[subject_id]";?>">
                <input type="hidden" name="days" value="<?php echo"$_GET[days]";?>">
                <input type="hidden" name="startime" value="<?php echo"$_GET[starttime]";?>">
				
				<?php
				
				if($dstatus[status_belajar]==2){
				?>
				<br>
				<button type="button" id="<?php echo"si";?>" class="btn bg-green waves-effect"  data-toggle="modal" data-target="#close">
 <i class="material-icons">launch</i>  <?php echo"Close/Akhiri";?></button>

                   
                    <div class="modal fade" id="close" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-green">
                            <h4 class="modal-title bg" id="smallModalLabel">Konfirmasi Close </h4>
							 <button type="button" class="btn btn-warning waves-effect pull-right" data-dismiss="modal"><i class="material-icons">close</i></button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin akan menutup pelajaran ini? jika ia silahkan isi catatan dibawah ini							
					<textarea class="form-control" name="catatan" rows="10" required></textarea>
							
							</div>
                        <div class="modal-footer">
                   <button type="submit" class="btn bg-green waves-effect"><i class="material-icons">save</i> Proses</button>

             
                           
                              </form>
                        </div>
                    </div>
                </div>
            </div>
 </form>
<br>
 
						<?php } 
						else if($dstatus[status_belajar]==3){
						
						echo"<br><h5>Catatan : </h5> <br> $dstatus[catatan] <br><br>
						 <a href='cetak_jurnal?d=$dstatus[id]&jam_mengajar=$waktu_status_m' target='_NEW'>
				 <button type='button'  class='btn bg-green waves-effect'>
				 Cetak Jurnal </button></a>
						";
						
						
						}
						} 
						
						?>
                         </div>
                         
                        <div class="body">
      
 
                     <script type="text/javascript">
  function resizeIframe(iframe) {
    iframe.height = iframe.contentWindow.document.body.scrollHeight + "px";
  }
</script>      

<iframe src="detail_open_isi?id_materi=<?php echo"$_GET[id_materi]&id_tugas=$_GET[id_tugas]&id_ujian=$_GET[id_materi]";?>" onload="resizeIframe(this)" style="width:100%" frameborder='0'></iframe>
                 <?php 
				 /*
				 echo"<h5>Materi : </h5> <br> $d[isi]";
				 
				 */
				 
				
$ext = pathinfo($d[file], PATHINFO_EXTENSION);
$base_url=$dpng[base_url];
 if(!empty($d[file])){

	echo"<a href='../../file/$d[file]' download> 
				<button type='button' class='btn bg-orange waves-effect'><i class='material-icons'>book</i> Download File</button>	
					</a>

					";
						}
				
				if(!empty($d[file]) and $ext=="pdf"){
					
?>
  <button type="button" class="btn bg-blue waves-effect baca" data-toggle="modal" data-target="#vpdf"><i class="material-icons">book</i> Baca Online</button>
                 
                    <div class="modal fade" id="vpdf" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                                                <span class="loadingpdf" style="display:none"> <img src="../../css/loader.gif"></span> 

                            <div class="hasil_pdf"></div>
                        <div class="modal-footer">
                        
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              
                        </div>
                    </div>
                </div>
            </div>
             <?php }
				 if($_SESSION[levelu]==3){
				 if(!empty($dt[judul])){
				 echo"<hr><h5>Tugas: </h5> <br><b> $dt[judul]</b><br><br> $dt[isi]
				 <a href='detail_tugas_2?d=$id_tugas&id_pembelajaran=$id_pembelajaran'>
				 <button type='button'  class='btn bg-green waves-effect'>
				 Detail Tugas Klik di sini </button></a>";
				 }
				 
				if(!empty($dj[nama_ujian])){
				 echo"<hr><h5>Ujian: </h5> <br> $dj[nama_ujian]<br><br>
				 <a href='ujian?d=$id_pembelajaran'>
				 <button type='button'  class='btn bg-green waves-effect'>
				 Detail Ujian Klik di sini </button></a>";
				 }			
				 }


				else if($_SESSION[levelu]!=3){
				 if(!empty($dt[judul])){
				 echo"<hr><h5>Tugas: </h5> <br><b> $dt[judul]</b><br><br> $dt[isi]
				 <a href='detail_tugas_2?d=$id_tugas&id_pembelajaran=$id_pembelajaran'>
				 <button type='button'  class='btn bg-green waves-effect'>
				 Detail Tugas Klik di sini </button></a>
				 
				";
				 }
				 
				if(!empty($dj[nama_ujian])){
				 echo"<hr><h5>Ujian: </h5> <br> $dj[nama_ujian]<br><br>
				 <a href='../../apps/bank_soal/data?d=$id_ujian'>
				 <button type='button'  class='btn bg-green waves-effect'>
				 Detail Bank Soal Klik di sini </button></a>";
				 }			
				 }
	
				 
				 ?>
                
          


              
  


<hr>
<h5>DISKUSI</h5>

          	<?php 
			
			
          	if(!empty($_SESSION[kelasku])){?>
          	<span class="buka_komen_awal"><button type="button" class='btn bg-green waves-effect'><i class="material-icons">comment</i> Komentar </button></span>
<?php } ?>
 
	<br><span class="tutup_komen_awal pull-right" style='color:red; cursor:pointer; display:none;'>  close</span>

	<hr>
	<div class="koment_awal" style="display:none">
	 <form method="post" class="form-user" name="form-user">
		<input type='hidden' class='form-control'  name='id_data'  value='<?php echo"$id";?>' required>
  		<input type='hidden' class='form-control'  name='field'  value='<?php echo"id_materi";?>' required>
  		<input type='hidden' class='form-control'  name='judul_materi'  value='<?php echo"$d[judul]";?>' required>
  
    <div class="image-upload">
    <label for="imageFile">
       <i class="material-icons" style="color:green">add_a_photo</i>
    </label>

    <input type="file" id="imageFile" accept="image/*"/>
   
    <input type="file" id="media" name="media" style="display: none;" required>
    <label for="media">
       <i class="material-icons" style="color:green"><b>attach_file</b></i>
    </label>


    <div class="progress" style="display:none">
					<div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						<span class="sr-only">0%</span>
					</div>
				</div>
</div>
    <div class="resultImageWrapper">
    <img src="" alt="" id="resultImage" width="100" style="padding:10px;border-radius:10px;" /> 
    </div>
    <input type="hidden" id="myText" value="" name="img" >    
    				<div class="msg" style="display:none"></div>

    		 <textarea  id="editor1" name="isi" rows="5" class="form-control" data-sample-short></textarea>
<br>
                            <button class="btn btn-info btn-sm tombol-simpan" type="button" id="btn-chat">
                                <i class="material-icons">comment</i> 
								
								 Kirim <span class="loadingsave"> <img src="../../css/loader.gif"></span> </button>
								</form>
								<br><br>
								<hr>
								</div>
								
<div id="loading_komen">Memuat Komentar <img src="../../css/loader.gif"></div>   
   <div class="row hasil">
          
                    
                </div>
                      
            
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
//# sourceURL=pen.js
</script>
<?php include"../../inc/footerm.php";?></body>
	<script>
	$(document).ready(function() {
		
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
			url : 'upload_file.php',
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
					$('.msg').html(msg);
				}
			}
		});
	});
});
    CKEDITOR.replace('editor1', {
      extraPlugins: 'image2,uploadimage,emoji',

      toolbar: [{
          name: 'clipboard',
          items: ['Undo', 'Redo']
        },
        {
          name: 'basicstyles',
          items: ['Bold', 'Italic']
        },
       
        {
          name: 'links',
          items: ['Link', 'Unlink']
        },
        {
          name: 'insert',
          items: ['Source,Emoji']
        },
        {
          name: 'tools',
          items: ['Maximize']
        },
      //  {
        //  name: 'editing',
          //items: ['Scayt']
        //}
      ],

     
      // Reduce the list of block elements listed in the Format drop-down to the most commonly used.
      format_tags: 'p;h1;h2;h3;pre',
      // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
      removeDialogTabs: 'image:advanced;link:advanced',

      height: 100,
	  
    });

  </script>
          
</html>