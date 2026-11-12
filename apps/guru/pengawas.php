<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$id = anti_injection($_GET['d']);
if($_SESSION[levelu]==1){
$m2=mysql_query("select  * from guru where nuptk='$id'");
$d2=mysql_fetch_array($m2);
}
else if($_SESSION[levelu]==2){
$m2=mysql_query("select  * from guru where nuptk='$_SESSION[id_pengguna]'");
$d2=mysql_fetch_array($m2);
}

?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js'></script>

</head>
<script type="text/javascript">
$(document).ready(function() {
  $(".provinsi").change(function() {
    var provinsi =$(this).val();
    var dataString = 'provinsi='+provinsi;
    $.ajax({
      type: "POST",
      url: "../delinasi/getkabupaten.php",
      data: dataString,
      cache: false,
      success: function(html) {
        $(".kabupaten").html(html);
      } 
    });
  });
  
    $('.date').datepicker({
  multidate: true,
	format: 'yyyy-mm-dd'
});
});

</script>
<style>
    .dragArea {
			background-color: #efefef;
			border: 3px dashed #cccccc;
			border-radius: 10px;
			text-align: center;
		
		}

		.dragArea.over {
			border-color: #ff0000;
			background-color: #FFE9EA;
		}

		.resultImageWrapper {
			display: none;
			
			text-align: center;
		}

		#resultImage {
			box-shadow: rgba(0,0,0,0.4) 0 40px 50px;
		}
    .select-wrapper {
  background: url(images/camera.png) no-repeat;
  background-size: cover;
  display: block;
  position: relative;
  width: 80px;
  height: 71px;
  margin: auto;
}
#imageFile {
  width: 80px;
  height: 61px;
  margin-right: 100px;
  opacity: 0;
  filter: alpha(opacity=0); /* IE 5-7 */
}

.dragArea2 {
			background-color: #efefef;
			border: 3px dashed #cccccc;
			border-radius: 10px;
			text-align: center;
		
		}

		.dragArea2.over {
			border-color: #ff0000;
			background-color: #FFE9EA;
		}

		.resultImageWrapper2 {
			display: none;
			
			text-align: center;
		}

		#resultImage2 {
			box-shadow: rgba(0,0,0,0.4) 0 40px 50px;
		}
    .select-wrapper2 {
  background: url(images/camera.png) no-repeat;
  background-size: cover;
  display: block;
  position: relative;
  width: 80px;
  height: 71px;
  margin: auto;
}
#imageFile2 {
  width: 80px;
  height: 61px;
  margin-right: 100px;
  opacity: 0;
  filter: alpha(opacity=0); /* IE 5-7 */
}
     .bfoto {
         margin-top: 0px;
     }
     .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
  	text-align: center;
  	 background: url(../../images/camera.png) no-repeat;
  background-size: cover;
  display: block;
  position: relative;
  width: 80px;
  height: 71px;
  margin: auto;
}

.btn {
  
  
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
top: 25px;
opacity: 0;
}

/*!
 * Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
 *
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */
.datepicker {
  padding: 4px;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  direction: ltr;
}
.datepicker-inline {
  width: 220px;
}
.datepicker.datepicker-rtl {
  direction: rtl;
}
.datepicker.datepicker-rtl table tr td span {
  float: right;
}
.datepicker-dropdown {
  top: 0;
  left: 0;
}
.datepicker-dropdown:before {
  content: '';
  display: inline-block;
  border-left: 7px solid transparent;
  border-right: 7px solid transparent;
  border-bottom: 7px solid #999999;
  border-top: 0;
  border-bottom-color: rgba(0, 0, 0, 0.2);
  position: absolute;
}
.datepicker-dropdown:after {
  content: '';
  display: inline-block;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-bottom: 6px solid #ffffff;
  border-top: 0;
  position: absolute;
}
.datepicker-dropdown.datepicker-orient-left:before {
  left: 6px;
}
.datepicker-dropdown.datepicker-orient-left:after {
  left: 7px;
}
.datepicker-dropdown.datepicker-orient-right:before {
  right: 6px;
}
.datepicker-dropdown.datepicker-orient-right:after {
  right: 7px;
}
.datepicker-dropdown.datepicker-orient-bottom:before {
  top: -7px;
}
.datepicker-dropdown.datepicker-orient-bottom:after {
  top: -6px;
}
.datepicker-dropdown.datepicker-orient-top:before {
  bottom: -7px;
  border-bottom: 0;
  border-top: 7px solid #999999;
}
.datepicker-dropdown.datepicker-orient-top:after {
  bottom: -6px;
  border-bottom: 0;
  border-top: 6px solid #ffffff;
}
.datepicker > div {
  display: none;
}
.datepicker table {
  margin: 0;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.datepicker td,
.datepicker th {
  text-align: center;
  width: 20px;
  height: 20px;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  border: none;
}
.table-striped .datepicker table tr td,
.table-striped .datepicker table tr th {
  background-color: transparent;
}
.datepicker table tr td.day:hover,
.datepicker table tr td.day.focused {
  background: #eeeeee;
  cursor: pointer;
}
.datepicker table tr td.old,
.datepicker table tr td.new {
  color: #999999;
}
.datepicker table tr td.disabled,
.datepicker table tr td.disabled:hover {
  background: none;
  color: #999999;
  cursor: default;
}
.datepicker table tr td.highlighted {
  background: #d9edf7;
  border-radius: 0;
}
.datepicker table tr td.today,
.datepicker table tr td.today:hover,
.datepicker table tr td.today.disabled,
.datepicker table tr td.today.disabled:hover {
  background-color: #fde19a;
  background-image: -moz-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: -ms-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fdd49a), to(#fdf59a));
  background-image: -webkit-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: -o-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd49a', endColorstr='#fdf59a', GradientType=0);
  border-color: #fdf59a #fdf59a #fbed50;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #000;
}
.datepicker table tr td.today:hover,
.datepicker table tr td.today:hover:hover,
.datepicker table tr td.today.disabled:hover,
.datepicker table tr td.today.disabled:hover:hover,
.datepicker table tr td.today:active,
.datepicker table tr td.today:hover:active,
.datepicker table tr td.today.disabled:active,
.datepicker table tr td.today.disabled:hover:active,
.datepicker table tr td.today.active,
.datepicker table tr td.today:hover.active,
.datepicker table tr td.today.disabled.active,
.datepicker table tr td.today.disabled:hover.active,
.datepicker table tr td.today.disabled,
.datepicker table tr td.today:hover.disabled,
.datepicker table tr td.today.disabled.disabled,
.datepicker table tr td.today.disabled:hover.disabled,
.datepicker table tr td.today[disabled],
.datepicker table tr td.today:hover[disabled],
.datepicker table tr td.today.disabled[disabled],
.datepicker table tr td.today.disabled:hover[disabled] {
  background-color: #fdf59a;
}
.datepicker table tr td.today:active,
.datepicker table tr td.today:hover:active,
.datepicker table tr td.today.disabled:active,
.datepicker table tr td.today.disabled:hover:active,
.datepicker table tr td.today.active,
.datepicker table tr td.today:hover.active,
.datepicker table tr td.today.disabled.active,
.datepicker table tr td.today.disabled:hover.active {
  background-color: #fbf069 \9;
}
.datepicker table tr td.today:hover:hover {
  color: #000;
}
.datepicker table tr td.today.active:hover {
  color: #fff;
}
.datepicker table tr td.range,
.datepicker table tr td.range:hover,
.datepicker table tr td.range.disabled,
.datepicker table tr td.range.disabled:hover {
  background: #eeeeee;
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
}
.datepicker table tr td.range.today,
.datepicker table tr td.range.today:hover,
.datepicker table tr td.range.today.disabled,
.datepicker table tr td.range.today.disabled:hover {
  background-color: #f3d17a;
  background-image: -moz-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: -ms-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f3c17a), to(#f3e97a));
  background-image: -webkit-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: -o-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3c17a', endColorstr='#f3e97a', GradientType=0);
  border-color: #f3e97a #f3e97a #edde34;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
}
.datepicker table tr td.range.today:hover,
.datepicker table tr td.range.today:hover:hover,
.datepicker table tr td.range.today.disabled:hover,
.datepicker table tr td.range.today.disabled:hover:hover,
.datepicker table tr td.range.today:active,
.datepicker table tr td.range.today:hover:active,
.datepicker table tr td.range.today.disabled:active,
.datepicker table tr td.range.today.disabled:hover:active,
.datepicker table tr td.range.today.active,
.datepicker table tr td.range.today:hover.active,
.datepicker table tr td.range.today.disabled.active,
.datepicker table tr td.range.today.disabled:hover.active,
.datepicker table tr td.range.today.disabled,
.datepicker table tr td.range.today:hover.disabled,
.datepicker table tr td.range.today.disabled.disabled,
.datepicker table tr td.range.today.disabled:hover.disabled,
.datepicker table tr td.range.today[disabled],
.datepicker table tr td.range.today:hover[disabled],
.datepicker table tr td.range.today.disabled[disabled],
.datepicker table tr td.range.today.disabled:hover[disabled] {
  background-color: #f3e97a;
}
.datepicker table tr td.range.today:active,
.datepicker table tr td.range.today:hover:active,
.datepicker table tr td.range.today.disabled:active,
.datepicker table tr td.range.today.disabled:hover:active,
.datepicker table tr td.range.today.active,
.datepicker table tr td.range.today:hover.active,
.datepicker table tr td.range.today.disabled.active,
.datepicker table tr td.range.today.disabled:hover.active {
  background-color: #efe24b \9;
}
.datepicker table tr td.selected,
.datepicker table tr td.selected:hover,
.datepicker table tr td.selected.disabled,
.datepicker table tr td.selected.disabled:hover {
  background-color: #9e9e9e;
  background-image: -moz-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: -ms-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b3b3b3), to(#808080));
  background-image: -webkit-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: -o-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: linear-gradient(to bottom, #b3b3b3, #808080);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3b3b3', endColorstr='#808080', GradientType=0);
  border-color: #808080 #808080 #595959;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.datepicker table tr td.selected:hover,
.datepicker table tr td.selected:hover:hover,
.datepicker table tr td.selected.disabled:hover,
.datepicker table tr td.selected.disabled:hover:hover,
.datepicker table tr td.selected:active,
.datepicker table tr td.selected:hover:active,
.datepicker table tr td.selected.disabled:active,
.datepicker table tr td.selected.disabled:hover:active,
.datepicker table tr td.selected.active,
.datepicker table tr td.selected:hover.active,
.datepicker table tr td.selected.disabled.active,
.datepicker table tr td.selected.disabled:hover.active,
.datepicker table tr td.selected.disabled,
.datepicker table tr td.selected:hover.disabled,
.datepicker table tr td.selected.disabled.disabled,
.datepicker table tr td.selected.disabled:hover.disabled,
.datepicker table tr td.selected[disabled],
.datepicker table tr td.selected:hover[disabled],
.datepicker table tr td.selected.disabled[disabled],
.datepicker table tr td.selected.disabled:hover[disabled] {
  background-color: #808080;
}
.datepicker table tr td.selected:active,
.datepicker table tr td.selected:hover:active,
.datepicker table tr td.selected.disabled:active,
.datepicker table tr td.selected.disabled:hover:active,
.datepicker table tr td.selected.active,
.datepicker table tr td.selected:hover.active,
.datepicker table tr td.selected.disabled.active,
.datepicker table tr td.selected.disabled:hover.active {
  background-color: #666666 \9;
}
.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td.active.disabled,
.datepicker table tr td.active.disabled:hover {
  background-color: #006dcc;
  background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
  background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: linear-gradient(to bottom, #0088cc, #0044cc);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
  border-color: #0044cc #0044cc #002a80;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.datepicker table tr td.active:hover,
.datepicker table tr td.active:hover:hover,
.datepicker table tr td.active.disabled:hover,
.datepicker table tr td.active.disabled:hover:hover,
.datepicker table tr td.active:active,
.datepicker table tr td.active:hover:active,
.datepicker table tr td.active.disabled:active,
.datepicker table tr td.active.disabled:hover:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active:hover.active,
.datepicker table tr td.active.disabled.active,
.datepicker table tr td.active.disabled:hover.active,
.datepicker table tr td.active.disabled,
.datepicker table tr td.active:hover.disabled,
.datepicker table tr td.active.disabled.disabled,
.datepicker table tr td.active.disabled:hover.disabled,
.datepicker table tr td.active[disabled],
.datepicker table tr td.active:hover[disabled],
.datepicker table tr td.active.disabled[disabled],
.datepicker table tr td.active.disabled:hover[disabled] {
  background-color: #0044cc;
}
.datepicker table tr td.active:active,
.datepicker table tr td.active:hover:active,
.datepicker table tr td.active.disabled:active,
.datepicker table tr td.active.disabled:hover:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active:hover.active,
.datepicker table tr td.active.disabled.active,
.datepicker table tr td.active.disabled:hover.active {
  background-color: #003399 \9;
}
.datepicker table tr td span {
  display: block;
  width: 23%;
  height: 54px;
  line-height: 54px;
  float: left;
  margin: 1%;
  cursor: pointer;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
}
.datepicker table tr td span:hover {
  background: #eeeeee;
}
.datepicker table tr td span.disabled,
.datepicker table tr td span.disabled:hover {
  background: none;
  color: #999999;
  cursor: default;
}
.datepicker table tr td span.active,
.datepicker table tr td span.active:hover,
.datepicker table tr td span.active.disabled,
.datepicker table tr td span.active.disabled:hover {
  background-color: #006dcc;
  background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
  background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: linear-gradient(to bottom, #0088cc, #0044cc);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
  border-color: #0044cc #0044cc #002a80;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.datepicker table tr td span.active:hover,
.datepicker table tr td span.active:hover:hover,
.datepicker table tr td span.active.disabled:hover,
.datepicker table tr td span.active.disabled:hover:hover,
.datepicker table tr td span.active:active,
.datepicker table tr td span.active:hover:active,
.datepicker table tr td span.active.disabled:active,
.datepicker table tr td span.active.disabled:hover:active,
.datepicker table tr td span.active.active,
.datepicker table tr td span.active:hover.active,
.datepicker table tr td span.active.disabled.active,
.datepicker table tr td span.active.disabled:hover.active,
.datepicker table tr td span.active.disabled,
.datepicker table tr td span.active:hover.disabled,
.datepicker table tr td span.active.disabled.disabled,
.datepicker table tr td span.active.disabled:hover.disabled,
.datepicker table tr td span.active[disabled],
.datepicker table tr td span.active:hover[disabled],
.datepicker table tr td span.active.disabled[disabled],
.datepicker table tr td span.active.disabled:hover[disabled] {
  background-color: #0044cc;
}
.datepicker table tr td span.active:active,
.datepicker table tr td span.active:hover:active,
.datepicker table tr td span.active.disabled:active,
.datepicker table tr td span.active.disabled:hover:active,
.datepicker table tr td span.active.active,
.datepicker table tr td span.active:hover.active,
.datepicker table tr td span.active.disabled.active,
.datepicker table tr td span.active.disabled:hover.active {
  background-color: #003399 \9;
}
.datepicker table tr td span.old,
.datepicker table tr td span.new {
  color: #999999;
}
.datepicker .datepicker-switch {
  width: 145px;
}
.datepicker .datepicker-switch,
.datepicker .prev,
.datepicker .next,
.datepicker tfoot tr th {
  cursor: pointer;
}
.datepicker .datepicker-switch:hover,
.datepicker .prev:hover,
.datepicker .next:hover,
.datepicker tfoot tr th:hover {
  background: #eeeeee;
}
.datepicker .cw {
  font-size: 10px;
  width: 12px;
  padding: 0 2px 0 5px;
  vertical-align: middle;
}
.input-append.date .add-on,
.input-prepend.date .add-on {
  cursor: pointer;
}
.input-append.date .add-on i,
.input-prepend.date .add-on i {
  margin-top: 3px;
}
.input-daterange input {
  text-align: center;
}
.input-daterange input:first-child {
  -webkit-border-radius: 3px 0 0 3px;
  -moz-border-radius: 3px 0 0 3px;
  border-radius: 3px 0 0 3px;
}
.input-daterange input:last-child {
  -webkit-border-radius: 0 3px 3px 0;
  -moz-border-radius: 0 3px 3px 0;
  border-radius: 0 3px 3px 0;
}
.input-daterange .add-on {
  display: inline-block;
  width: auto;
  min-width: 16px;
  height: 18px;
  padding: 4px 5px;
  font-weight: normal;
  line-height: 18px;
  text-align: center;
  text-shadow: 0 1px 0 #ffffff;
  vertical-align: middle;
  background-color: #eeeeee;
  border: 1px solid #ccc;
  margin-left: -5px;
  margin-right: -5px;
}

</style>

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
                            <h2>Atur Jadwal Mengawas</h2>
                            
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
          <form id="form_validation" method="POST" action="save_jadwal" enctype="multipart/form-data">


         
            <div class="form-group form-float">
            <div class="form-line ">
             <input type="text" class="form-control" disabled name="" required="" aria-required="true" value="<?php echo"$d2[nuptk]";?>">
              <input type="hidden" class="form-control" name="nuptk" required="" aria-required="true" value="<?php echo"$d2[nuptk]";?>">
             <label class="form-label">NUPTK</label>
            </div>
            </div>
            
            <div class="form-group form-float">
            <div class="form-line ">
             <input type="text" class="form-control" disabled name="nama" required="" aria-required="true" value="<?php echo"$d2[nama]";?>">
             <label class="form-label">Nama</label>
            </div>
            </div>


         
             <div class="row">
			<div class="col-md-12">
               <div class="form-group form-float">
			                <label class="form-label">Tanggal Mengawas</label>

            <div class="form-line ">
	<input type="text" class="form-control date" placeholder="Pilih Tanggal Mengawas" name="tanggal" value="<?php
	$mr=mysql_query("select  * from pengawas_ujian where id_peg='$d2[nuptk]'");
while($dr=mysql_fetch_array($mr)){ echo"$dr[tanggal],"; }

?>">            </div>
            </div>
			</div>
            </div>
            
            


         
         
            
            <button class="btn btn-primary waves-effect" type="submit"><i class="material-icons">save</i> SIMPAN</button>
            <a href="data"><button class="btn btn-success waves-effect" type="button"><i class="material-icons">arrow_back</i>Kembali</button>
            </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>   <!-- #END# Exportable Table -->
        </div>   
    </section>
 
   
 <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="../../plugins/jquery-countto/jquery.countTo.js"></script>

    <script src="../../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../../js/pages/tables/jquery-datatable.js"></script>

  <script src="../../plugins/sweetalert/sweetalert.min.js"></script>
 <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="../../plugins/bootstrap-notify/bootstrap-notify.js"></script>
  
    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/ui/dialogs.js"></script>
   
    
    <!-- Demo Js -->

</html>