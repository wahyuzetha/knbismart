<?php 
session_start();
include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "../../inc/fungsi.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set("Asia/Bangkok");
$id_ujian = anti_injection($_GET['d']);

$m=mysql_query("SELECT pembelajaran.pembelajaran,pembelajaran.id as id_pem,ujian.* from ujian,pembelajaran WHERE ujian.id_pembelajaran=pembelajaran.id and ujian.id='$id_ujian'");   
$d=mysql_fetch_array($m);




     
//cek hasil jwb
$startTime = date("Y-m-d H:i:s");
$tgl_ini=date('Y-m-d');

$waktu_ujian_start=date('H:i:s');
$waktu_selesai_ujian=date('H:i:s',strtotime('+'.$d[lama_ujian].' seconds',strtotime($startTime)));



if(!empty($d_hasiljwb[waktu_selesai])){
    $selesai_ujian=$d_hasiljwb[waktu_selesai];
}
else {
    $selesai_ujian=$waktu_selesai_ujian;

}

$awal  = strtotime("$tgl_ini $waktu_ujian_start"); //waktu awal
$akhir = strtotime("$tgl_ini $selesai_ujian"); //waktu akhir
$diff  = $akhir - $awal;
$sisa_jam   = floor($diff / 60 * 60);
?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include"../../inc/meta.php"; ?>
 <script src="../../js/js/jquery-1.10.2.min.js"></script>
 
		<script src="../../js/js/countdown.js"></script>

</head>

<?php include"../../inc/nav.php";?>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->

    <?php
	$m2peng=mysql_query("select  * from pengaturan where id='1'");
	$dm2peng=mysql_fetch_array($m2peng);
	
	
    if($_SESSION[levelu]==2){
    $login=mysql_query("select * from guru where nuptk='$_SESSION[id_pengguna]'");
    $ketemu=mysql_fetch_array($login);
    $nama=$ketemu[nama];    
    $nik=$ketemu[nuptk];
    $foto=$ketemu[foto];
    $kelas_all="";  
	$tingkat_kelas_all="";	
	$jurusan_kelas_all="";
    }
    else if($_SESSION[levelu]==3){
    $login=mysql_query("select * from siswa where no_pes_ujian='$_SESSION[id_pengguna]'");
    $ketemu=mysql_fetch_array($login);
    $nama=$ketemu[nama];    
    $nik=$ketemu[no_pes_ujian];
     $foto=$ketemu[foto];
	 $kelas_all=$ketemu[kelas];
	

	
    }
    else if($_SESSION[levelu]==1){
    $nama="Admnistrator";   
	$tingkat_kelas_all="";	
	$jurusan_kelas_all="";
	
    }
    
    
    
?>
<style>
    
                .jr {
                padding:5px;
                margin:4px;
                width:40px;
                height:40px;
                }
                .jr:hover,
.btn-outline {
  color: #4fbfa8;
  background-color: #ffffff;
  border-color: #4fbfa8;
  font-weight: bold;
  letter-spacing: 0.05em;
}

.btn-outline {
     color: #fff;
    background-color: #333;
  border-color: #4fbfa8;
  font-weight: bold;
  border-radius: 0;
}

.btn-outline:hover,
.btn-outline:active,
.btn-outline:focus,
.btn-outline.active {
  background: #4fbfa8;
  color: #ffffff;
  border-color: #4fbfa8;
  
}


.btn-colour-1 {
 color: #ffffff;
    background-color: #333;
  border-color: #004E64;
  font-weight: bold;
  letter-spacing: 0.05em;
  border-radius: 0;
}

.btn-colour-1:hover,
.btn-colour-1:active,
.btn-colour-1:focus,
.btn-colour-1.active {
  /* let's darken #004E64 a bit for hover effect */
  background: #003D4F;
  color: #ffffff;
  border-color: #003D4F;
}

.klik:hover,
.klik:active,
.klik:focus,
.klik.active {
  /* let's darken #004E64 a bit for hover effect */
  background: #003D4F;
  color: #ffffff;
  border-color: #003D4F;
}

               
 .klik {
            background-color: #4caf50;
            border-radius: 5px;
            height: 41px;
            width: 43px;
            margin-top: -6px;
            margin-left: -7px;
         
            }
            form p:last-child {
    margin-top: -19px;
    margin-left: 0px !important;
}
.opsi_huruf_multi {
    position: absolute;
    margin-left: -21px;
    margin-top: 20px !important;
    top: -19px;
}
</style>
    <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
         
            <div class="menu ">
                  
                <ul class="list">

                  

                  
                     <li class="active">
                        <a href="#">
                            <i class="material-icons">home</i>
                            <span>NAVIGASI SOAL</span>
                        </a>
                    </li>
                    <?php
					
					$nk=0;
					$pengacak = explode(",", $d['pengacak']);
					
					$res = mysql_query("select * from bank_soal where id_ujian='$id_ujian' order by id asc") or die(mysql_error());
					
                    $rows = mysql_num_rows($res);
					$i=1;
                while($result=mysql_fetch_array($res)){
                    $id_soal=$result[id];
                    
					
					
					$nk++;	
               
					$noval="$nk,$id_soal";

                                ?>
                                <button id='<?php echo $nk;?>' class='pencet btn btn-outline jr' data-id="<?php echo"$noval";?>"  type='button'>
                                <div id="aku<?php echo"$nk";?>" class="<?php echo"$kliks";?>">
                                <span style='top: 5px;'><?php echo"$nk";?></span>
                                </div> </button>
                                
                                <?php } ?><br><br>
                                <?php if($d[status_essay]==1){?>
                                <button style="margin-left:5px" class="btn btn-warning" type='button'
                                data-toggle="modal" data-target="#essay">
                               <i class="material-icons">border_color</i>  Essay
                                 </button>
                                 <?php } ?>
                                
              
               

                  </ul>

            </div>
           
        </aside>
            <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
    
    <section class="content">
     <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style="color:red; margin-top: -18px;">
			
			
			 <a href="data?d=<?php echo"$id_ujian";?>">        
						   <button type="button" class="btn bg-light-blue waves-effect"><i class="material-icons">arrow_back</i> Kembali Ke Bank Soal</button></a>
						   
	
	
            <?php echo"<h5>$d[nama_ujian] $d[pembelajaran]</h5>"; ?>
            <div id='timer'>
            <script type="application/javascript">
            var myCountdownTest = new Countdown({
                                    time: <?php echo"$d[lama_ujian]";?>, 
                                    width:200, 
                                    height:60, 
                                    rangeHi:"hour"
                                    });
           </script>
            </div>
         </div>
         <hr>
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
                        <div class="body">
            
         <div class="modal fade" id="essay" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="margin-top: 130px">
                        <div class="modal-header bg-green">
                            <h4 class="modal-title bg" id="smallModalLabel">Soal Essay</h4>
                        </div>
                        <div class="modal-body">
                            <form  method="post"> <br>
                    <?php echo html_entity_decode($d[essay]);?>
                            
                            </div>
                        <div class="modal-footer">
                <input type="hidden" name="d" value="<?php echo"$d[id]";?>">
                <input type="hidden" name="nm" value="<?php echo"$d[nama_ujian]";?>">

                 <input type="hidden" name="id_pembelajaran" value="<?php echo"$d[id_pembelajaran]";?>">
                   <button type="submit" class="btn btn-danger waves-effect"><i class="material-icons">save</i> Simpan</button>

             
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"><i class="material-icons">close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
                

        		<form class="form-horizontal" role="form" id='soalform' method="POST" action="hasil" name="soalform">
					<?php 
					$res = mysql_query("select * from bank_soal where id_ujian='$id_ujian' order by id asc") or die(mysql_error());
					
                    $rows = mysql_num_rows($res);
					$i=1;
                while($result=mysql_fetch_array($res)){
					
					if($result[jenis]=="multi"){
					$bentuk_opsi="checkbox";
					$class_multi="opsi_huruf_multi";
					}
					else {
					$bentuk_opsi="radio";
					$class_multi="opsi_hurufk";
				
					}
					?>
                    
                       
                    <?php if($i==1){?>         
                    <div id='question<?php echo $i;?>' class='cont'>
                                        <a href='edit?d=<?php echo"$result[id]";?>&id_ujian=<?php echo"$result[id_ujian]";?>'><button type="button" class="btn bg-pink waves-effect">
                    <i class="material-icons">mode_edit</i> Edit</button>
                </a>

                    <p class='questions' id="qname<?php echo $i;?>"> 
					<h5>No.<?php echo $i?>.</h5>
					<?php 
					if($result[jenis]!="essay"){
					echo"<h5> <span style='color:red'><b>Kunci $result[kunci]</b></span>";?></h5>
					<?php }
	if($d[lama_ujian]=="auto"){?>
	<label> Waktu <?php echo"$result[timer] Detik";?>
   
	<hr>
	<?php } ?>
					<?php echo $result['soal'];
					if($result[jenis]=="essay"){ 
					echo"<br> <b>Kunci    : </b><hr> <b> $result[kunci] </b>";
					}
					
					 if($result[jenis]=="match"){
			 $tipe_soal="Matching";
			 
			 	$ket_opsi_matching = explode("||", $result[ket_opsi_matching]);
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
          $match_ar=array();
		  $mo=mysql_query("SELECT * from bank_opsi  where 1 and id_ujian='$id_ujian' and id_soal='$result[id]' order by id asc");   
            while($rowo=mysql_fetch_array($mo)){ 
			$nom++;
						$kunci_mt=number_to_str($rowo[kunci]);

			$match_ar[]="$nom. $rowo[deskripsi] <input type='text' style='width:50px !important' value='$kunci_mt'>";
			}
				$tipe_soal=implode(" <br> ",$match_ar);
              echo"$tipe_soal";
					
					 }	
					
					?></p><hr>
                    <?php
                    $hruf="A";
                   	$opsi_soal="A~~$result[pila],,,,B~~$result[pilb],,,,C~~$result[pilc],,,,D~~$result[pild],,,,E~~$result[pile]";
				$opsi_soal_tampil = explode(",,,,", $opsi_soal);
				
				
				foreach($opsi_soal_tampil as $opsi_ts) {
				$opsi_tx=explode("~~", $opsi_ts);	
			
				$opsi_t=$opsi_tx[1];
				$opsi_huruf=$opsi_tx[0];	
                    
                    if($opsi_t==""){} else {
						$desk=$opsi_t;
				$desk=str_ireplace('<p>','',$desk);
				//$desk=str_ireplace('</p>','',$desk);  
                    ?>
                    
                    <input type="radio" <?php echo"$pilih_opsi";?> value="<?php echo"$dopsi1[opsi]";?>" 
                    class="radio-col-red <?php echo"$hruf";?>" id='radio1_<?php echo"$result[id]$opsi_huruf";?>' name='<?php echo $result['id'];?>'
                    onClick="document.getElementById('aku<?php echo $i;?>').setAttribute('class', 'klik');"/>
                      <label for="radio1_<?php echo"$result[id]$opsi_huruf";?>" style="margin-bottom: 22px;">
					  					  <?php echo"<span class='$class_multi'>$hruf</span> <span class='opsi_deskripsik'>$desk</span><br>";?>

						
						</label><br>
                  
                  
                    <?php } $hruf = chr(ord($hruf) + 1); } ?>
                    <input type="<?php echo"$bentuk_opsi";?>" <?php echo"$pilih_opsi_f";?>  style='display:none' value="F" id='radio1_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'/>                                                                      
                    <br/>
                    <button id='<?php echo $i;?>' class='next btn btn-success lanjut' type='button'>Next</button>
					<br><br><br><br>
                    </div>     
                      
                     <?php }elseif($i<1 || $i<$rows){?>
                     
                    <div id='question<?php echo $i;?>' class='cont'>
                                        <a href='edit?d=<?php echo"$result[id]";?>&id_ujian=<?php echo"$result[id_ujian]";?>'><button type="button" class="btn bg-pink waves-effect">
                    <i class="material-icons">mode_edit</i> Edit</button>
                </a>

                    <p class='questions' id="qname<?php echo $i;?>"><h5>No.<?php echo $i?>.</h5>
					<?php 
					if($result[jenis]!="essay"){
					echo"<h5> <span style='color:red'><b>Kunci $result[kunci]</b></span>";?></h5>
					<?php }
					
	if($d[lama_ujian]=="auto"){?>
	<label> Waktu <?php echo"$result[timer] Detik";?>
   
	<hr>
	<?php }  ?>
					
					<?php echo $result['soal']; 
					if($result[jenis]=="essay"){ 
					echo"<br> <b>Kunci    : </b><hr> <b> $result[kunci] </b>";
					}
					
					 if($result[jenis]=="match"){
			 $tipe_soal="Matching";
			 
			 	$ket_opsi_matching = explode("||", $result[ket_opsi_matching]);
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
          $match_ar=array();
		  $mo=mysql_query("SELECT * from bank_opsi  where 1 and id_ujian='$id_ujian' and id_soal='$result[id]' order by id asc");   
            while($rowo=mysql_fetch_array($mo)){ 
			$nom++;
						$kunci_mt=number_to_str($rowo[kunci]);

			$match_ar[]="$nom. $rowo[deskripsi] <input type='text' style='width:50px !important' value='$kunci_mt'>";
			}
				$tipe_soal=implode(" <br> ",$match_ar);
              echo"$tipe_soal";
					
					 }	
					?></p><hr>
                    <?php
                    $hruf="A";
                     	$opsi_soal="A~~$result[pila],,,,B~~$result[pilb],,,,C~~$result[pilc],,,,D~~$result[pild],,,,E~~$result[pile]";
				$opsi_soal_tampil = explode(",,,,", $opsi_soal);
				
				
				foreach($opsi_soal_tampil as $opsi_ts) {
				$opsi_tx=explode("~~", $opsi_ts);	
			
				$opsi_t=$opsi_tx[1];
				$opsi_huruf=$opsi_tx[0];	
                    
                    if($opsi_t==""){} else {
						$desk=$opsi_t;
				$desk=str_ireplace('<p>','',$desk);
				//$desk=str_ireplace('</p>','',$desk);
                   
                    ?>
                    
                    <input type="<?php echo"$bentuk_opsi";?>"  <?php echo"$pilih_opsi";?> value="<?php echo"$dopsi1[opsi]";?>" 
                    class="<?php echo"$bentuk_opsi";?>-col-red <?php echo"$hruf";?>" id='radio1_<?php echo"$result[id]$opsi_huruf";?>' name='<?php echo $result['id'];?>'
                     onClick="document.getElementById('aku<?php echo $i;?>').setAttribute('class', 'klik');"/>
                      <label for="radio1_<?php echo"$result[id]$opsi_huruf";?>" style="margin-bottom: 22px;">   
					  <?php echo"<span class='$class_multi'>$hruf</span> <span class='opsi_deskripsik'>$desk</span><br>";?>
					  </label><br>
                  <?php } ?>
                  
                    <?php $hruf = chr(ord($hruf) + 1); } ?>
                    <input type="<?php echo"$bentuk_opsi";?>"  <?php echo"$pilih_opsi_f";?> style='display:none' value="F" id='radio1_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'/>                                                                      
                    <br/>                    <br/>

                    <button id='<?php echo $i;?>' class='previous btn btn-success balik' type='button'>Previous</button>                    
                    <button id='<?php echo $i;?>' class='next btn btn-success lanjut' type='button' >Next</button>
					<br/><br> <br/><br>
                    </div>
                       
                       
                       
                        
                        
                   <?php }elseif($i==$rows){?>
                     <div id='question<?php echo $i;?>' class='cont'>
                                         <a href='edit?d=<?php echo"$result[id]";?>&id_ujian=<?php echo"$result[id_ujian]";?>'><button type="button" class="btn bg-pink waves-effect">
                    <i class="material-icons">mode_edit</i> Edit</button>
                </a>

                    <p class='questions' id="qname<?php echo $i;?>">
					
					<h5>No.<?php echo $i?>.</h5>
					<?php 
					if($result[jenis]==""){
					echo"<h5> <span style='color:red'><b>Kunci $result[kunci]</b></span>";?></h5>
					<?php }
	if($d[lama_ujian]=="auto"){?>
	<label> Waktu <?php echo"$result[timer] Detik";?>
   
	<hr>
	<?php } ?>
					<?php echo $result['soal']; 
					
					if($result[jenis]=="essay"){ 
					echo"<br> <b>Kunci    : </b><hr> <b> $result[kunci] </b>";
					}
   
					?></p><hr>
                    <?php
					
					 if($result[jenis]=="match"){
			 $tipe_soal="Matching";
			 
			 	$ket_opsi_matching = explode("||", $result[ket_opsi_matching]);
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
          $match_ar=array();
		  $mo=mysql_query("SELECT * from bank_opsi  where 1 and id_ujian='$id_ujian' and id_soal='$result[id]' order by id asc");   
            while($rowo=mysql_fetch_array($mo)){ 
			$nom++;
						$kunci_mt=number_to_str($rowo[kunci]);

			$match_ar[]="$nom. $rowo[deskripsi] <input type='text' style='width:50px !important' value='$kunci_mt'>";
			}
				$tipe_soal=implode(" <br> ",$match_ar);
              echo"$tipe_soal";
					
					 }	
                    $hruf="A";
                      	$opsi_soal="A~~$result[pila],,,,B~~$result[pilb],,,,C~~$result[pilc],,,,D~~$result[pild],,,,E~~$result[pile]";
				$opsi_soal_tampil = explode(",,,,", $opsi_soal);
				
				
				foreach($opsi_soal_tampil as $opsi_ts) {
				$opsi_tx=explode("~~", $opsi_ts);	
			
				$opsi_t=$opsi_tx[1];
				$opsi_huruf=$opsi_tx[0];	
                    
                    if($opsi_t==""){} else {
						$desk=$opsi_t;
				$desk=str_ireplace('<p>','',$desk);
				//$desk=str_ireplace('</p>','',$desk);  
                   
                    ?>
                    
                    <input type="<?php echo"$bentuk_opsi";?>" <?php echo"$pilih_opsi";?> value="<?php echo"$dopsi1[opsi]";?>" class="radio-col-red <?php echo"$hruf";?>" 
                    id='radio1_<?php echo"$result[id]$opsi_huruf";?>' name='<?php echo $result['id'];?>'
                     onClick="document.getElementById('aku<?php echo $i;?>').setAttribute('class', 'klik');"/>
                      <label for="radio1_<?php echo"$result[id]$opsi_huruf";?>" style="margin-bottom: 22px;">  
					  					  <?php echo"<span class='$class_multi'>$hruf</span> <span class='opsi_deskripsik'>$desk</span><br>";?>
						</label><br>
                  
                  
                    <?php } $hruf = chr(ord($hruf) + 1); } ?>
                    <input type="<?php echo"$bentuk_opsi";?>" <?php echo"$pilih_opsi_f";?> style='display:none' value="F" id='radio1_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'/>                                                                      
                    <br/><br> 
                    <button id='<?php echo $i;?>' class='previous btn btn-success lanjut' type='button'>Previous</button>                    
                    <!--<button id='<?php echo $i;?>' class='next btn btn-success' type='submit'>Finish</button>-->
					<br/><br> <br/><br>
                    </div>
					<?php } $i++;} ?>
					
				</form>
			</div>
		</div>
        </div>   
    </section>



   <?php



if(isset($_POST[1])){ 
   $keys=array_keys($_POST);
   $order=join(",",$keys);
   
   //$query="select * from questions id IN($order) ORDER BY FIELD(id,$order)";
  // echo $query;exit;
   
   $response=mysql_query("select id,kunci from bank_soal where id IN($order) and id_ujian='1' ORDER BY FIELD(id,$order)")   or die(mysql_error());
   $right_answer=0;
   $wrong_answer=0;
   $unanswered=0;
   while($result=mysql_fetch_array($response)){
       if($result['answer']==$_POST[$result['id']]){
               $right_answer++;
           }else if($_POST[$result['id']]=="F"){
               $unanswered++;
           }
           else{
               $wrong_answer++;
           }
       
   }
   
   
   echo "right_answer : ". $right_answer."<br>";
   echo "wrong_answer : ". $wrong_answer."<br>";
   echo "unanswered : ". $unanswered."<br>";
}
?>
		
		
		
		
		<script>
		

 var timer;
 var timeout = 5000; // Timout duration




 
 


		
		$('.cont').addClass('hide');
		count=$('.questions').length;
		 $('#question'+1).removeClass('hide');
		 
		 $(document).on('click','.next',function(){
		     last=parseInt($(this).attr('id'));     
		     nex=last+1;
		     $('#question'+last).addClass('hide');
		     
		     $('#question'+nex).removeClass('hide');
		 });
		 
		 $(document).on('click','.previous',function(){
             last=parseInt($(this).attr('id'));     
             pre=last-1;
             $('#question'+last).addClass('hide');
             
             $('#question'+pre).removeClass('hide');
         });
         
         $(document).on('click','.pencet',function(){

            
                last=parseInt($(this).attr('id'));
                localStorage.setItem('pagesoal',last);

              
                count=$('.questions').length;


             
                            pre=last-1;
                            pres=last+1;
                                $( "input" ).on( "click", function() {
                            var thisName = $(this).attr('name');
                            var qNum = thisName.substring(1);
                            $( "#log"+last ).html(css('color','red') + "");
                            });
                            
                            var u=count;
                            var l=last;
                            for ( var m = 1; m <= count; m++ ) {
                        if(u==l){
                            $( "#question"+m ).addClass('hide');
                            $( "#question"+m ).removeClass('active');
                            $( "#question"+count ).removeClass('hide');
                            $( "#question"+count ).addClass('active');
                            $('#questiona').addClass('hide');
                            $('#questiona').removeClass('active');
                            }
                            else {
                            $( "#question"+last ).removeClass('hide');
                            $( "#question"+last ).addClass('active');
                            $( "#question"+m ).addClass('hide');
                            $( "#question"+m ).removeClass('active');
                                $('#questiona').addClass('hide');
                                $('#questiona').removeClass('active');
                            }
                            }
                            
                            $('.overlay').fadeOut();
 
             $('body').removeClass('overlay-open');

                            });

     
		</script>
<script >window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);


$(document).ready(function(){
 
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
 
 load_unseen_notification();
 
 
 

 
 setInterval(function(){ 
  load_unseen_notification();; 
 }, 5000);
 
});

$('#finish').on('click',function(e) {
    
    event.preventDefault();
var form = this;
    
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
});

$(window).keypress(function(e) { 
		    //Captures 'a' or 'b'
		    if(e.which == 8 || e.which == 13 || e.which == 37  || e.which == 39 || e.which == 65 || e.which == 66 || e.which == 67 || e.which == 68 || e.which == 69 || e.which == 97 || e.which == 98 || e.which == 99 || e.which == 100 || e.which == 101)
		    {
		    	switch(e.which){
					/*
		    		case 65 : $(".A").prop("checked", true); break;
		    		case 66 : $(".B").prop("checked", true); break;
		    		case 67 : $(".C").prop("checked", true); break;
		    		case 68 : $(".D").prop("checked", true); break;
		    		case 69 : $(".E").prop("checked", true); break;
		    		case 97 : $(".A").prop("checked", true); break;
		    		case 98 : $(".B").prop("checked", true); break;
					case 99 : $(".C").prop("checked", true); break;
		    		case 100 : $(".D").prop("checked", true); break;
		    		case 101 : $(".E").prop("checked", true); break;
		    		case 13 : $(".lanjut").click(); break;
		    		case 8 : $(".balik").click(); break;
					case 37 : $(".lanjut").click(); break;
		    		case 39 : $(".balik").click(); break;
					*/

		    	}
		    }
		});
</script>
<?php include"../../inc/footerm.php";?></body>

</html>