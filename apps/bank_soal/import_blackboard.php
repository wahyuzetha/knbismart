<?php
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "akses.php";
function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}
$id = anti_injection($_GET['d']);

$m3=mysql_query("SELECT ujian.*,pembelajaran.nuptk from ujian,pembelajaran WHERE pembelajaran.id=ujian.id_pembelajaran and ujian.id='$id'");
$d3=mysql_fetch_array($m3);


?>
<!DOCTYPE html>
<html>

<head>
<?php include"../../inc/meta.php"; ?>
  <script src="../../js/jquery-1.11.2.min.js"></script>
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
</head>

<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include"../../inc/sidebar.php";?>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->

    <section class="content">
        <br>
     <div class="container-fluid">
           <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">

                        <div class="header">
                            <h2>Import Data Soal dari Blackboard 6.0 <?php echo"$d3[nuptk]";?></h2>

                        </div>

          <div class="body">
          <form id="form_validation" method="POST" action="proses_import_blackboard" enctype="multipart/form-data" target="my_iframe">




	

            <label for="exampleInputName">Pilih File ZIP(Blackboard 6.0) </label><br>
            <input  class="form-control" name="zip_file" id="exampleInputName" type="file" aria-describedby="nameHelp"
             required>
              <br>
			  
			               <input type="hidden" class="form-control" name="id_ujian" required="" aria-required="true" value="<?php echo"$_GET[d]";?>">


            <button class="btn btn-success waves-effect k" type="submit"><i class="material-icons">import_export</i> IMPORT</button>
            <a href="data?d=<?php echo"$_GET[d]";?>"><button class="btn btn-warning waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
			
          
           
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
          

<div id="cover-spin">			
<span class="text_loader">Mohon Di tunggu hingga proses selesai, jangan di close proses ini</span>
</div>

            <iframe id="loadarea" name="my_iframe" src="proses_import_blackboard" width="100%" height="300px" frameborder="0"></iframe>
      
        </div>
    </section>
 <script>
//# sourceURL=pen.js
 $(document).ready(function () {
        $( ".k" ).click(function() {

           var zip_file= $('.zip_file').val();
           var jns= $('.jns').val();
          if(zip_file==""){
              alert("Silahkan Pilih File Blackboard 6.0");
          }
           
          else {
		document.getElementById('loadarea').src = 'proses_import_blackboard.php';
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
