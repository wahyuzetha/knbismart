<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$id = anti_injection($_GET['d']);
$id_pembelajaran = anti_injection($_GET['id_pembelajaran']);

$m2=mysql_query("select  * from pembelajaran where id='$id_pembelajaran'");
$d2=mysql_fetch_array($m2);

$m=mysql_query("select  * from ujian where id='$id'");
$d=mysql_fetch_array($m);

if(!empty($_GET[j])){
$_SESSION[jpantaus]=$_GET[j];
}
else {
$_SESSION[jpantaus]=$_SESSION[jpantaus];

} 

if(!empty($_SESSION[jpantaus])){
$_SESSION[jpantau]="../../apps/ujian/data_pantau_ujian";
}
else {
$_SESSION[jpantau]="../../apps/ujian/data?d=$id_pembelajaran";
}
?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>
    <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>
  <script src='../../plugins/tinymce/tinymce.min.js'></script>

<?php include"../../inc/tiny.php";?>


</head>
<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Kelas yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".select2 option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
 
     $(function(){
       $('.siswa').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Siswa yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".ptk option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
 
 $(document).ready(function() {
     $('.vkelas').hide();
     $('.vsiswa').hide();


var dataString = 'kelas=<?php echo"$d2[kelas]&akses_kelas=$d[akses_kelas]&akses_siswa=$d[akses_siswa]&tingkat=$d2[tingkat]&tahun_ajaran=$d2[tahun_ajaran]";?>';

   var tam='<?php echo"$d[jenis_akses]";?>';
    if(tam==2){
     $('.vkelas').show();
     $('.vsiswa').hide();
     
    $.ajax({
      type: "POST",
      url: "../materi/getkelas.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".kelas").html(html);
      } 
    });
    }
   else if(tam==3){
      $('.vkelas').hide();
     $('.vsiswa').show();
     
     $.ajax({
      type: "POST",
      url: "../materi/getsiswa.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".siswa").html(html);
      } 
    });
   }
   else {
        $('.vkelas').hide();
     $('.vsiswa').hide();
   } 
    
     
    
  $(".tampilan").change(function() {
 var dataString = 'kelas=<?php echo"$d2[kelas]&tingkat=$d2[tingkat]&tahun_ajaran=$d2[tahun_ajaran]";?>';

   var tam=$(".tampilan").val();
    if(tam==2){
     $('.vkelas').show();
     $('.vsiswa').hide();
     
    $.ajax({
      type: "POST",
      url: "../materi/getkelas.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".kelas").html(html);
      } 
    });
    }
   else if(tam==3){
      $('.vkelas').hide();
     $('.vsiswa').show();
     
     $.ajax({
      type: "POST",
      url: "../materi/getsiswa.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".siswa").html(html);
      } 
    });
   }
   else {
        $('.vkelas').hide();
     $('.vsiswa').hide();
   }
    
    
    
  });
});
</script>


<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include"../../inc/sidebar.php";?>    
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    
    <section class="content">
     <div class="container-fluid">
           <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                      
                        <div class="header">
                            <h2>Edit Data  <?php echo"$_SESSION[namajenis] $d2[pembelajaran] $d2[tingkat]";?></h2>
                            
                        </div>
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
    
          <div class="body">
          <form id="form_validation" method="POST" action="saveedit" enctype="multipart/form-data">

      <div class="body">
 
<input type='hidden' name='id' value="<?php echo"$d[id]";?>">
<input type='hidden' name='id_pembelajaran' value="<?php echo"$d[id_pembelajaran]";?>">
  
  <div class="form-group form-float">
            <label class="form-label">Jenis <?php echo strtolower($_SESSION[namajenis]);?>:</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick" required name="jenis_ujian">

			 <?php
 if($_SESSION[jenis]=="p"){
			 $jns=" and id>='2'";
			 }
			 else {
			 $jns=" and id<='1'";
			 }
            $mpjta=mysql_query("select * from jenis_ujian where 1 $jns order by id asc");
                        while($dpjta=mysql_fetch_array($mpjta)){ 
			
			if($dpjta[id]==$d[jenis_ujian]){
			$pilkjns="selected";
			}
			else {
			$pilkjns="";
			
			}
            ?>      
          <option value="<?php echo"$dpjta[id]";?>" <?php echo"$pilkjns";?>><?php echo"$dpjta[jenis_ujian]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>             
              
			  
  <div class="form-group">
                          <label class="form-label">Nama <?php echo strtolower($_SESSION[namajenis]);?> </label>
         
            <div class="form-line ">
          
         <input type='text' name='nama_ujian' class='form-control' value="<?php echo"$d[nama_ujian]";?>">

    </div>
    </div>
  <div class="form-group">
            <label class="form-label">Waktu Mulai </label>
          
            <div class="form-line ">
         
             <input type='date' name='waktu_mulai' class='form-control' value="<?php echo"$d[waktu_mulai]";?>">

            </div>
  </div>
  <div class="form-group">
  
            <label class="form-label">Waktu Selesai </label>
         
              <div class="form-line ">
            
             <input type='date' name='waktu_selesai' class='form-control' value="<?php echo"$d[waktu_selesai]";?>">

            </div>

</div>
 <div class="form-group form-float">
                                                <label class="form-label">Pilih Jam Mulai</label>

                                        <div class="form-line">
                                       <input type="text" name="jam_mulai" id="date-format" class="waktu wkt form-control floating-label" placeholder="Klik di sini untuk pilih jam mulai" 
									   value="<?php echo"$d[jam_mulai]";?>">
                                        </div>
                                    </div>
									
				 <div class="form-group form-float">
                                                <label class="form-label">Pilih Jam Selesai</label>

                                        <div class="form-line">
                                       <input type="text" name="jam_selesai" id="date-format2" class="waktu wkt form-control floating-label" placeholder="Klik di sini untuk pilih jam selesai"
									   value="<?php echo"$d[jam_selesai]";?>">
                                        </div>
                                    </div>		
              <div class="form-group form-float">
            <label class="form-label">Lama Mengerjakan</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick" name="lama_ujian" id="provinsi">
            <option value="">-- Pilih Waktu --</option>
            <?php
            $mp=mysql_query("select * from waktu");
            while($dp=mysql_fetch_array($mp)){ 
            if($dp[detik]==$d[lama_ujian]) {
            ?>      
          <option value="<?php echo"$dp[detik]";?>" selected><?php echo"$dp[waktu]";?></option>

              <?php } else { ?>
             <option value="<?php echo"$dp[detik]";?>"><?php echo"$dp[waktu]";?></option>
 
              <?php } }?>
              </select>
                                
            </div>
            </div>

              <div class="form-group form-float">
            <label class="form-label">Soal Acak/Tidak Acak</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick" name="soal_acak">
            <option value="">-- Pilih --</option>
            <?php
            $mp1=mysql_query("select * from acak");
            while($dp1=mysql_fetch_array($mp1)){ 
             if($dp1[id]==$d[acak_soal]) {
                 ?>          
           
          <option value="<?php echo"$dp1[id]";?>" selected><?php echo"$dp1[acak] ";?></option>

              <?php } 
              else { ?>
                <option value="<?php echo"$dp1[id]";?>"><?php echo"$dp1[acak]";?></option>

              <?php } }?>    
              </select>
                                
            </div>
            </div>
            
                <div class="form-group form-float">
            <label class="form-label">Opsi Jawaban Acak/Tidak Acak</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick" name="opsi_acak">
            <option value="">-- Pilih --</option>
            <?php
            $mp2=mysql_query("select * from acak");
          while($dp2=mysql_fetch_array($mp2)){ 
             if($dp2[id]==$d[acak_jwb]) {
                 ?>          
           
          <option value="<?php echo"$dp2[id]";?>" selected><?php echo"$dp2[acak] ";?></option>

              <?php } 
              else { ?>
                <option value="<?php echo"$dp2[id]";?>"><?php echo"$dp2[acak]";?></option>

              <?php } }?>    
                </select>
                                
            </div>
            </div>
         
<?php
			if($_SESSION[jenis]=="p"){?>
			<div style='border:solid red; padding:10px'>
			<label style='color:red'>Khusus Pengayaan Pastikan isian dibawah ini sudah benar</label><br>
			
			<div class="form-group">
                          <label class="form-label">Jumlah Soal Yang Keluar  Pilgan</label>
         
            <div class="form-line ">
          
         <input type='number'  name='jumlah_soal_keluar_pilgan' class='form-control' value="<?php echo"$d[jumlah_soal_keluar_pilgan]";?>">

			</div>
			</div>
			
			<div class="form-group">
                          <label class="form-label">Jumlah Soal Yang Keluar Multiple Respon</label>
         
            <div class="form-line ">
          
         <input type='number'  name='jumlah_soal_keluar_multiple' class='form-control' value="<?php echo"$d[jumlah_soal_keluar_multiple]";?>">

			</div>
			</div>
			
			<div class="form-group">
                          <label class="form-label">Jumlah Soal Yang Keluar Matching Point</label>
         
            <div class="form-line ">
          
         <input type='number'  name='jumlah_soal_keluar_matching' class='form-control' value="<?php echo"$d[jumlah_soal_keluar_matching]";?>">

			</div>
			</div>
			
			<div class="form-group">
                          <label class="form-label">Jumlah Soal Yang Keluar Essay Auto</label>
         
            <div class="form-line ">
          
         <input type='number'  name='jumlah_soal_keluar_essay_auto' class='form-control' value="<?php echo"$d[jumlah_soal_keluar_essay_auto]";?>">

			</div>
			</div>
			
			<div class="form-group">
                          <label class="form-label">Batas Tuntas </label>
         
            <div class="form-line ">
          
         <input type='number'  name='batas_tuntas' class='form-control' required value="<?php echo"$d[batas_tuntas]";?>">

			</div>
			</div>
			
			 <div class="form-group form-float">
            <label class="form-label">Harus Berhasil Mengerjakan Level Sebelumnya (jika tidak terkait kosongi)</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick" name="id_soal_next">
            <option value="">-- Pilih --</option>
            <?php
            $mp2=mysql_query("select * from ujian where id_pembelajaran='$d2[id]' and id!='$d[id]'");
            while($dp2=mysql_fetch_array($mp2)){ 
             if($dp2[id]==$d[id_soal_next]) {
			 $pils="selected";
			 }
			 else {
			 $pils="";
			 }
		   ?>      
          <option value="<?php echo"$dp2[id]";?>" <?php echo"$pils";?>><?php echo"$dp2[nama_ujian]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
			</div>
			<?php } ?>
			<br>
            
            <div class="form-group form-float">
            <label class="form-label">Tampilke Ke :</label>
            <br>
            <div class="form-line">
            <select class="form-control show-tick tampilan" required name="jenis_akses">

			 <?php
            $mpjt=mysql_query("select * from jennis_tampil order by id asc");
            while($dpjt=mysql_fetch_array($mpjt)){ 
                if($dpjt[id]==$d[jenis_akses]){
                    $pil="selected";
                }
                else {
                    $pil="";
                }
            ?>      
          <option value="<?php echo"$dpjt[id]";?>" <?php echo"$pil";?>><?php echo"$dpjt[jenis_tampil]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>
         
		  <div class="form-group form-float vkelas">
            <label class="form-label">Pilih Kelas</label>
            <br>
            <select class="form-control show-tick  select2 kelas" name="akses_kelas[]"  multiple style="width:100%">
         
              </select>
                                
            </div>
            
             <div class="form-group form-float vsiswa">
            <label class="form-label">Pilih Siswa</label>
            <br>
            <select class="form-control show-tick  select3 siswa" name="akses_siswa[]"  multiple style="width:100%">
         
              </select>
                                
            </div>
            
		 <!--
          <div class="form-group">
                          <label class="form-label">Berapa kali kesempatan ujian </label>
         
            <div class="form-line ">
          
         <input type='text' name='kesempatan' class='form-control' value="<?php echo"$d[kesempatan]";?>">

    </div>
    </div>
    
        -->    
		
		 <div class="form-group">
                          <label class="form-label">Bobot Pilihan Ganda </label>
         
            <div class="form-line ">
          
         <input type='text' name='skala' class='form-control' value="<?php echo"$d[skala]";?>">

    </div>
    </div>
	
	 <div class="form-group">
                          <label class="form-label">Bobot Multiple Respon </label>
         
            <div class="form-line ">
          
         <input type='text' name='bobot_multiple' class='form-control' value="<?php echo"$d[bobot_multiple]";?>">

    </div>
    </div>
	
	<div class="form-group">
                          <label class="form-label">Bobot Matching </label>
         
            <div class="form-line ">
          
         <input type='text' name='bobot_matching' class='form-control' value="<?php echo"$d[bobot_matching]";?>">

    </div>
    </div>
      <?php 
      
      if($d[status_essay]==1){
          $cek="checked";
      }
      else {
          $cek="";
      }
	  
	   if($d[status_essay_auto]==1){
          $cek_auto="checked";
      }
      else {
          $cek_auto="";
      }
      
       if($d[tampilkan_nilai]==1){
          $cek_nilai="checked";
      }
      else {
          $cek_nilai="";
      }
	  
	   if($d[fix_uts]==1){
          $cfix_uts="checked";
      }
      else {
          $cfix_uts="";
      }
	  
	   if($d[susulan]==1){
          $csusulan="checked";
      }
      else {
          $csusulan="";
      }
       
	
	   if($d[nilai_koma]==1){
          $nilai_koma="checked";
      }
      else {
          $nilai_koma="";
      }
    
	echo"<input type='checkbox' id='cek_auto' class='filled-in status_essay' $cek_auto name='status_essay_auto'   value='1' data-column='sesuai' ><label for='cek_auto'> Apakah ujian ini menggunakan essay Auto (Koreksi Otomatis)? jika ia centang </label> <br>";
	?>
	 <div class="form-group essay_auto" style="display:none">
                          <label class="form-label">Bobot Essay Auto </label>
         
            <div class="form-line ">
          
         <input type='number' step="any" name='bobot_essay_auto' class='form-control' 
		 value="<?php echo"$d[bobot_essay_auto]";?>">

    </div>
    </div>
	
	  <?php
      echo"<input type='checkbox' id='cek' class='filled-in status_essay' $cek name='status_essay'   value='1'
                    data-column='sesuai' ><label for='cek'> Apakah ujian ini menggunakan essay Manual(Koreksi manual)? jika ia centang </label><br>";
                    
   
                                   
                    ?>
                    
    <div class="form-group essay">
                   <label class="form-label">Soal Essay </label>
          
            <div class="form-line">
         <textarea name="essay"><?php echo"$d[essay]";?></textarea>
         <input type='file' name='fileupload' id='fileupload' style='display: none;'>

    </div></div>
	
	<?php
	  echo"<input type='checkbox'  id='tampilkan_nilai' class='filled-in tampilkan_nilai' $cek_nilai name='tampilkan_nilai'   value='1'
                    ><label for='tampilkan_nilai'> Apakah setelah mengerjakan siswa dapat melihat nilai? jika ia centang </label>";
					?>
    <hr>
    
     <?php
	 if(($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==1 or $_SESSION[jabatan_guru]==7 or strstr($_SESSION[penyelenggara_ujians], '1')) and $d[jenis_ujian]==1){
		  
echo"<input type='checkbox' id='susulan'  class='filled-in' name='susulan'  $csusulan value='1'><label for='susulan'><b>Tampilkan Hanya Di Ujian Susulan<b></label> <hr>";
		 
	  echo"<input type='checkbox' id='fix_uts'  class='filled-in'  name='fix_uts'  $cfix_uts value='1'><label for='fix_uts'><b>Verifikasi, dan di tampilkan dalam event ujian<b></label> <hr>";
	 }  

	  echo"<input type='checkbox' id='nilai_koma'  class='filled-in'  name='nilai_koma'  $nilai_koma value='1'>
	  <label for='nilai_koma'><b>Tampilkan Nilai dengan Koma 2 digit Centang Jika Iya<b></label> <hr>";
		?> 
            <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
            <a href="<?php echo"$_SESSION[jpantau]";?>"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
     <script>
   $('document').ready(function(){
          
  if($('#cek').is(":checked")){
    $('.essay').show();
  }else{
    $('.essay').hide();
  }
  
  if($('#cek_auto').is(":checked")){
    $('.essay_auto').show();
  }else{
    $('.essay_auto').hide();
  }


   });

   $('#cek').click(function () {
  if($(this).is(":checked")){
    $('.essay').show();
  }else{
    $('.essay').hide();
  }
});

 $('#cek_auto').click(function () {
  if($(this).is(":checked")){
    $('.essay_auto').show();
  }else{
    $('.essay_auto').hide();
  }
});
   </script>

  <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="../../plugins/jquery-countto/jquery.countTo.js"></script>
     <!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>


    <script src="../../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../../js/pages/tables/jquery-datatable.js"></script>

  <script src="../../plugins/sweetalert/sweetalert.min.js"></script>
 <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="../../plugins/bootstrap-notify/bootstrap-notify.js"></script>
  
   <!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
     <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

   
    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>
   
    <script type="text/javascript">
		$(document).ready(function()
		{
			
			$('#date-format').bootstrapMaterialDatePicker
			({
								date: false,
			format: 'HH:mm',
				lang: 'id',
				weekStart: 1, 
				cancelText : 'Batal',
				nowButton : true,
				switchOnClick : true,
				//minDate : new Date() 
			});
			
			$('#date-format2').bootstrapMaterialDatePicker
			({
								date: false,
			format: 'HH:mm',
				lang: 'id',
				weekStart: 1, 
				cancelText : 'Batal',
				nowButton : true,
				switchOnClick : true,
				//minDate : new Date() 
			});
		
		});
		</script>
</html>
</html>