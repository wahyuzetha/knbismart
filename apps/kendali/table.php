<?php
## Database configuration
include "../../inc/koneksi.php";
include "../../inc/aman.php";

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

if($_SESSION[status_ujian_s]=="1"){
$st="and hasil_jwb.status=''";
}
else if($_SESSION[status_ujian_s]=="2"){
$st="and hasil_jwb.status='3'";
}
else {
$st="";

}
if(!empty($_SESSION[tgl_awal_ujian_s])){
$tg="and hasil_jwb.tanggal between '$_SESSION[tgl_awal_ujian_s]' and '$_SESSION[tgl_akhir_ujian_s]'";
}
else {
$tg="";
}

if(!empty($_SESSION[jam_mulai_s])){
$jm=" and waktu_mulai between '$_SESSION[jam_mulai_s]' and '$_SESSION[jam_selesai_s]'";
}
else {
$jm="";
}

## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (siswa.nis like '%".$searchValue."%' or siswa.nis like '%".$searchValue."%' or siswa.nama like '%".$searchValue."%' or siswa.tanggal_lahir like '%".$searchValue."%' or siswa.kelas like '%".$searchValue."%') ";
}



## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from hasil_jwb,siswa
WHERE hasil_jwb.nis=siswa.nis and hasil_jwb.id_ujian='$_SESSION[id_ujian_kendali]' $st $tg $jm ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from hasil_jwb,siswa
WHERE hasil_jwb.nis=siswa.nis and hasil_jwb.id_ujian='$_SESSION[id_ujian_kendali]' $st $tg $jm ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT siswa.nis,siswa.kelas,siswa.nis,siswa.nama,siswa.tanggal_lahir,hasil_jwb.* from hasil_jwb,siswa
WHERE hasil_jwb.nis=siswa.nis and hasil_jwb.id_ujian='$_SESSION[id_ujian_kendali]' $st $tg $jm ".$searchQuery." 
order by siswa.kelas asc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;

 $peng=mysql_query("select * from pengaturan where id='1'");   
                $dpeng=mysql_fetch_array($peng);
             	 
while ($row = mysql_fetch_assoc($empRecords)) {
$i++;
$encrypted=$row[id];
$tgl=date('d/m/Y', strtotime($row[tanggal]));
  $log=mysql_query("select  * from log_masuk_ujian where nis='$row[nis]' and id_ujian='$row[id_ujian]'");   
     $dlog=mysql_fetch_array($log);
   
if($row[status]==3){
	
$status_ujian="<button type='button' class='btn bg-red waves-effect'><i class='material-icons'>book</i>SUDAH SELESAI UJIAN</button>
                ";	
$reset="<button type='button' class='btn bg-red waves-effect' data-toggle='modal' data-target='#smallModal".$i."'>
                  
                <i class='material-icons'>delete</i> Hapus</button>
                    </form>
                    <div class='modal fade' id='smallModal".$i."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-red'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Konfirmasi Hapus</h4>
                        </div>
                        <div class='modal-body'>
						<h5>Menu ini di gunakan untuk MENGHAPUS HASIL UJIAN SISWA, SEHINGGA JAWABAN DAN NILAI AKAN HILANG, JANGAN GUNAKAN JIKA SUDAH BERHASIL UJIAN</h5>
						<hr>
                      
						 <b>$row[nis]</b><br>$row[nama] <br>$row[kelas]<br>
						 <hr>
                            Apakah anda yakin mau MENGHAPUS data ujian ini?   jika ia maka data ujian yang sdh di kerjakan akan terhapus   </div>
                        <div class='modal-footer'>
                            <form action='reset' method='post'> 
                 <input type='hidden' name='nis' value='".$row[nis]."'>
                 <input type='hidden' name='id_ujian' value='".$row[id_ujian]."'>

                   <button type='submit' class='btn btn-danger waves-effect'><i class='material-icons'>delete</i> Hapus</button>

             
                            <button type='button' class='btn btn-info waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>";				
}

else {
$status_ujian="<button type='button' class='btn bg-green waves-effect'><i class='material-icons'>book</i>BELUM SELESAI UJIAN</button>";	
$reset="<button type='button' class='btn bg-red waves-effect' data-toggle='modal' data-target='#smallModal".$i."'>
                  
                <i class='material-icons'>delete</i> Hapus</button>
                    </form>
                    <div class='modal fade' id='smallModal".$i."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-red'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Konfirmasi Hapus</h4>
                        </div>
                        <div class='modal-body'>
						<h5>Menu ini di gunakan untuk MENGHAPUS HASIL UJIAN SISWA, SEHINGGA JAWABAN DAN NILAI AKAN HILANG, JANGAN GUNAKAN JIKA SUDAH BERHASIL UJIAN</h5>
						<hr>
                      
						 <b>$row[nis]</b><br>$row[nama] <br>$row[kelas]<br>
						 <hr>
                            Apakah anda yakin mau MENGHAPUS data ujian ini?   jika ia maka data ujian yang sdh di kerjakan akan terhapus   </div>
                        <div class='modal-footer'>
                            <form action='reset' method='post'> 
                 <input type='hidden' name='nis' value='".$row[nis]."'>
                 <input type='hidden' name='id_ujian' value='".$row[id_ujian]."'>

                   <button type='submit' class='btn btn-danger waves-effect'><i class='material-icons'>delete</i> HAPUS</button>

             
                            <button type='button' class='btn btn-info waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>";	
			
			$selesaiakan="<button type='button' class='btn bg-red waves-effect' data-toggle='modal' data-target='#smallModalselesai".$i."'>
                  
                <i class='material-icons'>launch</i> Selesaiakan</button>
                    
                    <div class='modal fade' id='smallModalselesai".$i."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-red'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Konfirmasi Menyelesaiakan</h4>
                        </div>
                        <div class='modal-body'>
						<h5>Menu ini di gunakan untuk MENYELESAIAKAN UJIAN SISWA</h5>
						<hr>
                      
						 <b>$row[nis]</b><br>$row[nama] <br>$row[kelas]<br>
						 <hr>
                            Apakah anda yakin mau MENYELESAIAKAN data ujian ini?      </div>
                        <div class='modal-footer'>
                            <form action='selesaikan' method='post'> 
                 <input type='hidden' name='nis' value='".$row[nis]."'>
                 <input type='hidden' name='id_ujian' value='".$row[id_ujian]."'>

                   <button type='submit' class='btn btn-danger waves-effect'><i class='material-icons'>launch</i> SELESAIAKAN</button>

             
                            <button type='button' class='btn btn-info waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>";

}
                
	$log_ujian=number_format($dlog[jumlah_asli],0);
   $data[] = array( 
    
      "nis"=>"<b>$row[nis]</b><br>$row[nama]<br> $row[kelas]<br>
		<i style='color:red'>Mulai Ujian $row[tanggal] $row[waktu_mulai] <br>log masuk ujian $log_ujian</i> <br>$status_ujian <br><br> 
		$selesaiakan
		<button type='button' class='btn bg-blue waves-effect' data-toggle='modal' data-target='#smallModalks".$i."'>
                  
                <i class='material-icons'>refresh</i> Reset Status Ujian</button>
		
		<button type='button' class='btn bg-orange waves-effect' data-toggle='modal' data-target='#smallModalk".$i."'>
                  
                <i class='material-icons'>refresh</i> Reset Waktu Ujian</button> $reset 
                
				 <div class='modal fade' id='smallModalks".$i."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-blue'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Apakah anda yakin akan mereset Status ujian ini</h4>
                        </div>
                        <div class='modal-body'>
						<h5>Menu ini di gunakan untuk mereset status siswa yang sedang ujian atau sudah selesai ujian menjadi bisa ujian kembali</h5>
                         <hr> <b>$row[nis]</b><br>$row[nama] <br>$row[kelas]<br>
                          

				</div>
                        <div class='modal-footer'>
  <form action='reset_status' method='post'> 
                 <input type='hidden' name='nis' value='".$row[nis]."'>
                 <input type='hidden' name='id_ujian' value='".$row[id_ujian]."'>

             
                            <button type='submit' class='btn btn-warning waves-effect'>
							<i class='material-icons'>refresh</i> Reset</button>
							
                            <button type='button' class='btn btn-info waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
                    <div class='modal fade' id='smallModalk".$i."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-blue'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Apakah anda yakin akan mereset waktu ujian ini</h4>
                        </div>
                        <div class='modal-body'>
						<h5>Menu ini di gunakan untuk mereset waktu ujian siswa menjadi normal kembali tanpa mengurangi jam berjalan</h5>
						<hr>	
						 <b>$row[nis]</b><br>$row[nama] <br>$row[kelas]<br>
                          

				</div>
                        <div class='modal-footer'>
  <form action='reset_waktu' method='post'> 
                 <input type='hidden' name='nis' value='".$row[nis]."'>
                 <input type='hidden' name='id_ujian' value='".$row[id_ujian]."'>

             
                            <button type='submit' class='btn btn-warning waves-effect'>
							<i class='material-icons'>refresh</i> Reset</button>
							
                            <button type='button' class='btn btn-info waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>",
       "nama"=>"$row[kelas]",
	   "tgl_lahir"=>"",
      "kelas"=>"$row[kelas] <br>
	  
	   
	  ",
     
   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecordwithFilter,
  "iTotalDisplayRecords" => $totalRecords,
  "aaData" => $data
);

echo json_encode($response);
