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

## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (pembelajaran.pembelajaran like '%".$searchValue."%' or ujian.nama_ujian like '%".$searchValue."%') ";
}

if($_SESSION[jenis_ujian_k]=="susulan"){
$jns_v=" and ujian.susulan='1'";
}
else if($_SESSION[jenis_ujian_k]=="utama"){
$jns_v=" and ujian.susulan='0'";
}
else if($_SESSION[jenis_ujian_k]=="all"){
$jns_v="";
}
else {
$jns_v="";
}


## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from pembelajaran,ujian
WHERE ujian.id_pembelajaran=pembelajaran.id and ujian.jenis_ujian='1'
and pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and pembelajaran.semester='$_SESSION[semester_pem]' $jns_v ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from pembelajaran,ujian
WHERE ujian.id_pembelajaran=pembelajaran.id and ujian.jenis_ujian='1'
and pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and pembelajaran.semester='$_SESSION[semester_pem]' $jns_v ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT pembelajaran.tahun_ajaran,pembelajaran.tingkat,pembelajaran.pembelajaran,ujian.* from pembelajaran,ujian
WHERE ujian.id_pembelajaran=pembelajaran.id and ujian.jenis_ujian='1'
and pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and pembelajaran.semester='$_SESSION[semester_pem]' $jns_v ".$searchQuery." 
order by id desc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;



while ($row = mysql_fetch_assoc($empRecords)) {
$i++;
$encrypted=$row[id];
$tgl=date('d/m/Y', strtotime($row[waktu_mulai]));
$tgl2=date('d/m/Y', strtotime($row[waktu_selesai]));

if($row[status_essay]==1){
    $sts="<br><span style='color:red'>Menggunakan Essay</span>";
    $ns="  <a href='essay?id_ujian=$row[id]'>
              <button type='button' class='btn bg-pink waves-effect'><i class='material-icons'>assignment</i>Nilai Essay</button></a>";
}
else {
    $sts="";
    $ns="";
}

 $tipe_stok_ar=array();
               $sql_kategori = mysql_query("select * from pembelajaran where tingkat='$_SESSION[tingkat_ujians]'");
                while($k = mysql_fetch_assoc($sql_kategori))
                {
                    $dm=mysql_query("select  * from guru where nik='$k[nuptk]'"); 
            
                $guru=mysql_fetch_array($dm);
                
                  if($row[id_tipe_stok]==$k[id]){
                  $p='selected';
                  }
                  else {
                  $p='';
                  }
                
                  $tipe_stok_ar[]="<option value='$k[id]' $p>$guru[nama] - $k[pembelajaran] - Tingkat $k[tingkat]</option>'";
                  
                } 
               $pembelajarank=implode("",$tipe_stok_ar);
  
  if($row[akses_kelas]=="null"){
	  $kelas_siswa_ar=array();
	  //kelas
               $kelas_ar=array();
$cek=mysql_query("SELECT * from kelas where tahun_ajaran='$row[tahun_ajaran]'
			and tingkat='$row[tingkat]'");
			while($dcek=mysql_fetch_array($cek)){
			
			$kelas_siswa_ar[]=$dcek[nama_kelas];
			$kelas_ar[]="<option value='$dcek[nama_kelas]'>$dcek[nama_kelas]</option>";

			
			}
			$kelas_siswa=implode("<br>",$kelas_siswa_ar);
			 $kelas_si=implode("",$kelas_ar);

			
             
}
else {
$kelas_siswa_ar=array();
$kelas = json_decode($row[akses_kelas], true);
               $kelas_ar=array();

			foreach($kelas as $kelasku) { 
			
			$cek=mysql_query("SELECT status_belajar.status,status_belajar.warna,status_mengajar.* 
			from status_belajar,status_mengajar
			where 
			status_belajar.id=status_mengajar.status_belajar AND
			status_mengajar.id_ujian='$row[id]' and
			status_mengajar.id_kelas='$kelasku'");
						$dcek=mysql_fetch_array($cek);

			if($dcek[status_belajar]=="" or $dcek[status_belajar]==0){
			$status=$dwarna_o[ket];
			$warna=$dwarna_o[warna];

			}
			else {
			$status=$dcek[status];
			$warna=$dcek[warna];

			}
			$kelas_siswa_ar[]="$kelasku";
			$kelas_ar[]="<option value='$kelasku'>$kelasku</option>";

			}
			$kelas_siswa=implode("<br>",$kelas_siswa_ar);
						 $kelas_si=implode("",$kelas_ar);

}

if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==1 or $_SESSION[jabatan_guru]==7 or strstr($_SESSION[penyelenggara_ujians], '1')){
$edit_ujian="   <a href='../ujian/edit?d=$row[id]&j=pantau&id_pembelajaran=$row[id_pembelajaran]'>
              <button type='button' class='btn bg-green waves-effect'><i class='material-icons'>assignment</i>Edit</button></a>";
$bank_soal=" <a href='../bank_soal/data?d=$row[id]&j=pantau'>
              <button type='button' class='btn bg-green waves-effect'><i class='material-icons'>assignment</i>Naskah</button></a>";

}
else {
$edit_ujian="";
$bank_soal="";

}

				

if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==1 or $_SESSION[jabatan_guru]==7 or strstr($_SESSION[penyelenggara_ujians], '2')){
	$verifikasi_nilai=" <button type='button' class='btn bg-red waves-effect' data-toggle='modal' data-target='#smallModal".$row[id]."'>
                  
                <i class='material-icons'>assignment</i> Verifikasi Nilai</button>
			     
                    <div class='modal fade' id='smallModal".$row[id]."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-green'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Verifikasi Nilai</h4>
                        </div>
                        <div class='modal-body'>
 <form action='../../apps/laporan/cetak_laporan' method='get' target='_NEW'> 
                <input type='hidden' name='ujian' value='".$row[id]."'>

                 <input type='hidden' name='id_pembelajaran' value='$row[id_pembelajaran]'>
               
			   <select class='form-control' name='kelas'  style='width:200px;'>
                    <option value='all'>Semua Kelas</option>
                    $kelas_si
                    </select>
					<br><br>
					
					<input type='checkbox' id='basic_checkbox_pstl$i' class=' filled-in' value='c' name='analisis' >
		<label for='basic_checkbox_pstl$i'>Cetak Analisis Ujian</label>
		<br><br>
          <input name='jenis' type='radio' id='radio_1".$row[id]."' checked='' value='normal'>
		   <label for='radio_1".$row[id]."'> &nbsp;&nbsp; NORMAL</label>
		    <input name='jenis' type='radio' id='radio_2".$row[id]."' value='pdf'>
		   <label for='radio_2".$row[id]."'> &nbsp;&nbsp;PDF </label>
		    <input name='jenis' type='radio' id='radio_3".$row[id]."' value='excel'>
		   <label for='radio_3".$row[id]."'>&nbsp;&nbsp; EXCEL</label>
		  
		  
		   <hr>				
<button type='submit' class='btn btn-info waves-effect'><i class='material-icons'>launch</i> Proses</button>

             		   
							</div>
                        <div class='modal-footer'>
                       
                   
                            <button type='button' class='btn btn-danger waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>";			  

}
else {
$verifikasi_nilai="";
}


if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==1 or $_SESSION[jabatan_guru]==7 or strstr($_SESSION[penyelenggara_ujians], '2') or  strstr($_SESSION[penyelenggara_ujians], '3')){
	$daftar_hadir=" <button type='button' class='btn bg-orange waves-effect' data-toggle='modal' data-target='#smallModalh".$row[id]."'>
                  
                <i class='material-icons'>assignment</i> Daftar Hadir</button>
			     
                    <div class='modal fade' id='smallModalh".$row[id]."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-green'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Daftar Hadir</h4>
                        </div>
                        <div class='modal-body'>
 <form action='../../apps/laporan/cetak_laporan_absen_ujian_k' method='get' target='_NEW'> 
                <input type='hidden' name='ujian' value='".$row[id]."'>

                 <input type='hidden' name='pembelajaran' value='$row[id_pembelajaran]'>
               
			   <select class='form-control' name='kelas'  style='width:200px;'>
                    <option value='all'>Semua Kelas</option>
                    $kelas_si
                    </select>
					<br>
					
					 <select class='form-control' name='status_ujian'  style='width:200px;'>
                    <option value='all'>Semua Status Ujian</option>
                    <option value='belum'>Belum Ujian</option>
                    <option value='sedang'>Sedang Ujian</option>
                    <option value='selesai'>Selesai Ujian</option>

                    </select>
					<br><br>
          <input name='jenis' type='radio' id='radio_1d".$row[id]."' checked='' value='normal'>
		   <label for='radio_1d".$row[id]."'> &nbsp;&nbsp; NORMAL</label>
		    <input name='jenis' type='radio' id='radio_2d".$row[id]."' value='pdf'>
		   <label for='radio_2d".$row[id]."'> &nbsp;&nbsp;PDF </label>
		    <input name='jenis' type='radio' id='radio_3d".$row[id]."' value='excel'>
		   <label for='radio_3d".$row[id]."'>&nbsp;&nbsp; EXCEL</label>
		  
		  
		   <hr>				
<button type='submit' class='btn btn-info waves-effect'><i class='material-icons'>launch</i> Proses</button>

             		   
							</div>
                        <div class='modal-footer'>
                       
                   
                            <button type='button' class='btn btn-danger waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>";			  

}
else {
$daftar_hadir="";
}

if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==1 or $_SESSION[jabatan_guru]==7 or strstr($_SESSION[penyelenggara_ujians], '3')){
$kendali="  <a href='../kendali/peserta?d=$row[id]&j=pantau'>
              <button type='button' class='btn bg-green waves-effect'><i class='material-icons'>assignment</i>Kendali Ujian</button></a>";
}
else {
$kendali="";
}	
$k=strstr($_SESSION[penyelenggara_ujians], '2');

if($row[fix_uts]==1){
$verifikasi="<span class='badge bg-green'>Verified</span>";
}
else {
$verifikasi="<span class='badge bg-red'>Not Verified</span>";

}

if($row[susulan]==1){
$jenis_ujian="<span class='badge bg-orange'>Ujian Susulan</span>";
}
else {
$jenis_ujian="<span class='badge bg-green'>Ujian Utama</span>";

}

if(!empty($_SESSION[wali_kelas]) or $_SESSION[jabatan_guru]==12){

$daftar_hadir_wali=" <button type='button' class='btn bg-orange waves-effect' data-toggle='modal' data-target='#smallModalh".$row[id]."'>
                  
                <i class='material-icons'>assignment</i> Daftar Hadir</button>
			     
                    <div class='modal fade' id='smallModalh".$row[id]."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-green'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Daftar Hadir</h4>
                        </div>
                        <div class='modal-body'>
						Cetak Kelas $_SESSION[wali_kelas]
 <form action='../../apps/laporan/cetak_laporan_absen_ujian_k' method='get' target='_NEW'> 
                <input type='hidden' name='ujian' value='".$row[id]."'>
               <!-- <input type='hidden' name='kelas' value='".$_SESSION[wali_kelas]."'>-->

                 <input type='hidden' name='pembelajaran' value='$row[id_pembelajaran]'>
                 
			   <select class='form-control' name='kelas'  style='width:200px;'>
                    <option value='all'>Semua Kelas</option>
                    $kelas_si
                    </select>
					<br>
					
					 <select class='form-control' name='status_ujian'  style='width:200px;'>
                    <option value='all'>Semua Status Ujian</option>
                    <option value='belum'>Belum Ujian</option>
                    <option value='sedang'>Sedang Ujian</option>
                    <option value='selesai'>Selesai Ujian</option>

                    </select>
			  
					<br><br>
          <input name='jenis' type='radio' id='radio_1".$row[id]."' checked='' value='normal'>
		   <label for='radio_1".$row[id]."'> &nbsp;&nbsp; NORMAL</label>
		    <input name='jenis' type='radio' id='radio_2".$row[id]."' value='pdf'>
		   <label for='radio_2".$row[id]."'> &nbsp;&nbsp;PDF </label>
		    <input name='jenis' type='radio' id='radio_3".$row[id]."' value='excel'>
		   <label for='radio_3".$row[id]."'>&nbsp;&nbsp; EXCEL</label>
		  
		  
		   <hr>				
<button type='submit' class='btn btn-info waves-effect'><i class='material-icons'>launch</i> Proses</button>

             		   
							</div>
                        <div class='modal-footer'>
                       
                   
                            <button type='button' class='btn btn-danger waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>";			  

}
else {
$daftar_hadir_wali="";
}

   $data[] = array( 
    
      "1"=>"<b>$row[pembelajaran] <br> $row[nama_ujian]</b> <br>  $tgl s.d $tgl2 <br>Jam : $row[jam_mulai] - $row[jam_selesai]  <br> $jenis_ujian <br>$verifikasi" ,
      "2"=>"$kelas_siswa",
      "4"=>" ",

        "aksi"=>" 
	    $edit_ujian
        $bank_soal    
        $kendali      
		$verifikasi_nilai
		$daftar_hadir	  
		$daftar_hadir_wali
			

          
	 "
     
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
