<?php
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "akses.php";

?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>
  <script src="../../js/jquery-1.11.2.min.js"></script>

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
                            <h2>Import Data Anggota Rombel</h2>

                        </div>

          <div class="body">
          <form id="form_validation" method="POST" action="proses_import" enctype="multipart/form-data" target="my_iframe">




	<p style="color:red">
	    <a href="format_import_anggotarombel.xls">Download Format Import</a>
		
	
	</p>

            <label for="exampleInputName">Import Excel </label><br>
            <input  class="form-control" name="excel" id="exampleInputName" type="file" aria-describedby="nameHelp"
             required>
              <br>

            <button class="btn btn-success waves-effect" type="submit"><i class="material-icons">import_export</i> IMPORT</button>
            <a href="data"><button class="btn btn-warning waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
          
            </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
            <iframe name="my_iframe"  width="100%" height="1000px" frameborder="0"></iframe>
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

</html>
