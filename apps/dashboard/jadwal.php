<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";

$m2=mysql_query("select  * from pengaturan where id='1'");
$d2=mysql_fetch_array($m2);

if(!empty($_GET[tahun_ajaran])){
$_SESSION[tahun_ajaran_pem]=$_GET[tahun_ajaran];
}
else {
$_SESSION[tahun_ajaran_pem]=$tahun_aktif;
}

if(!empty($_GET[semester])){
$_SESSION[semester_pem]=$_GET[semester];
}
else {
$_SESSION[semester_pem]=$semester_aktif;
}

?>
<!DOCTYPE html>
<html>

<?php include"../../inc/meta.php"; ?>

  <script src="../../js/jquery-1.11.2.min.js"></script>
<link rel="stylesheet" href="../../dist/css/select2.css" />
    <script src="../../dist/js/select2.js"></script>
<style>
#frameWrap {
    position:relative;
    height: 360px;
    width: 100%;
    border: 1px solid #777777;
    background:#f0f0f0;
    box-shadow:0px 0px 10px #777777;
}

#iframe1 {
    height: 360px;
    width: 100%;
    margin:0;
    padding:0;
    border:0;
}

#loader1 {
    position:absolute;
    left:40%;
    top:35%;
  
}
#cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
    display:none;
}

@-webkit-keyframes spin {
	from {-webkit-transform:rotate(0deg);}
	to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
	from {transform:rotate(0deg);}
	to {transform:rotate(360deg);}
}

#cover-spin::after {
    content:'';
    display:block;
    position:absolute;
    left:48%;top:40%;
    width:40px;height:40px;
    border-style:solid;
    border-color:black;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
}
.text_loader{
	    top: 50%;
    position: absolute;
    left: 37%;
    font-weight: 700;
    color: red;
}
</style>


<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 0,
           allowClear: true,
           placeholder: 'Ketik Nama Guru yang ingin anda cari',
         
      }).on('select2:select', function (evt) {
         var data2 = $(".select2 option:selected").text();
       //  alert("Data yang dipilih adalah "+data2);
      });
 });
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
    

                            <h2>
                               Jadwal Mengajar  <?php echo"$_SESSION[tahun_ajaran_pem] $_SESSION[semester_pem]";?>
                            </h2>
                         </div>
                        <div class="body">
						<form action="ijadwal" method="GET" target="_NEW">		
			<input type="hidden" value="<?php echo"1";?>" name="d">
          <div class="row">
		  <div class="col-md-3">
             <select class="form-control show-tick"  name="tahun_ajaran">          
			 <?php
            $mpjt=mysql_query("select * from tahun_ajaran order by namathn asc");
            while($t=mysql_fetch_array($mpjt)){ 
			if($_SESSION[tahun_ajaran_pem]==$t[namathn]){
			$pil="selected";
			}
			else {
			$pil="";
			}	
				
            ?>      
          <option value="<?php echo"$t[namathn]";?>" <?php echo"$pil";?>><?php echo"$t[namathn]";?></option>

              <?php } ?>    
              </select>
            
			</div>
			  <div class="col-md-3">
             <select class="form-control show-tick"  name="semester">          
			 <?php
            $s=mysql_query("select * from semester order by semester asc");
            while($sm=mysql_fetch_array($s)){ 
			if($_SESSION[semester_pem]==$sm[semester]){
			$pils="selected";
			}
			else {
			$pils="";
			}	
				
            ?>      
          <option value="<?php echo"$sm[semester]";?>" <?php echo"$pils";?>><?php echo"$sm[semester]";?></option>

              <?php } ?>    
              </select>
            
			</div>
			 <?php
            if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1){
            ?>    
           <div class="col-md-3">
			  <div class="form-group form-float">
            <div class="form-line">
            <select class="form-control show-tick select2" name="nuptk"  style="width:100%">
            <option value="">-- Pilih Guru --</option>
            <?php
            $mp=mysql_query("select * from guru order by nama asc");
             
           
            while($dp=mysql_fetch_array($mp)){ 
            ?>      
          <option value="<?php echo"$dp[teacher_id]";?>"><?php echo"$dp[nama]";?></option>

              <?php } ?>    
              </select>
                                
            </div>
            </div>

			</div>
			<?php } ?>
		    <div class="col-md-3">
		   <input type="date" name="tanggal" value="<?php echo date('Y-m-d');?>" class="form-control">
		   </div>
			</div>
			<div class="row">
			<div class="col-md-3">
             <select class="form-control show-tick"  name="tingkat">          
			 <option value="all">--Semua Tingkat--</option>
			 <?php
            $s2=mysql_query("select * from tingkat order by tingkat asc");
            while($sm2=mysql_fetch_array($s2)){ 
			if($_SESSION[tingkat_pem]==$sm2[tingkat]){
			$pilsk="selected";
			}
			else {
			$pilsk="";
			}	
				
            ?>      
          <option value="<?php echo"$sm2[tingkat]";?>" <?php echo"$pilsk";?>><?php echo"$sm2[tingkat]";?></option>

              <?php } ?>    
              </select>
            
			</div>
		   <div class="col-md-3">
		   <button class="btn btn-primary waves-effect k" type="submit"><i class="material-icons">search</i> Filter</button>
			</div>
			</div>
			</form>  			
                  
<div id="cover-spin">			
<span class="text_loader">Please Wait</span>
</div>				  
<!--            
<iframe src="ijadwal?d=1" id="loadarea" name="my_iframe" width="100%" height="500px"></iframe>					
   -->                   
        </div> 

    </section>
   <script>window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 1000);

    $(document).ready(function () {
		 //           $('#cover-spin').show();
 $('#loadarea').on('load', function () {
            $('#cover-spin').hide();
        });
        $( ".k" ).click(function() {

           var xml= $('.xml').val();
           var jns= $('.jns').val();
          if(xml==""){
              alert("Silahkan Pilih File Berjenis XML");
          }
           
          else {
		document.getElementById('loadarea').src = 'proses_import_asc.php';
 
            $('#cover-spin').show();
          }
            });
        $('#loadarea').on('load', function () {
            $('#cover-spin').hide();
        });
    });
	
</script>

<?php include"../../inc/footernojs.php";?></body>

</html>