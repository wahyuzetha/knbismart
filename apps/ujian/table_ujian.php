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
   $searchQuery = " and (materi.judul like '%".$searchValue."%') ";
}


if($_SESSION[jenis]=="p"){
$jns=" and jenis_ujian='2'";
}
else {
$jns=" and jenis_ujian!='2'";

}

## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from ujian where id_pembelajaran='$_SESSION[id_mapel_ujians]' $jns ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from ujian where id_pembelajaran='$_SESSION[id_mapel_ujians]' $jns ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT * from ujian where id_pembelajaran='$_SESSION[id_mapel_ujians]'  $jns ".$searchQuery." 
order by id desc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;

if($row[akses_kelas]=="null"){
$mk=mysql_query("select  * from pembelajaran where id='$row[id_pembelajaran]'");   
$dk=mysql_fetch_array($mk);

$kelas_siswa_ar=array();
$kelas = json_decode($dk[kelas], true);
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
			if($row[jenis_ujian]<2){
			$kelas_siswa_ar[]="$kelasku <span class='badge bg-$warna'>$status</span>";
			}
			else {
			$kelas_siswa_ar[]="$kelasku";
			
			}
			
			}
			$kelas_siswa=implode("<br>",$kelas_siswa_ar);

}
else {
$kelas_siswa_ar=array();
$kelas = json_decode($row[akses_kelas], true);
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
			//$kelas_siswa_ar[]="$kelasku <span class='badge bg-$warna'>$status</span>";
			
			if($row[jenis_ujian]<2){
			$kelas_siswa_ar[]="$kelasku <span class='badge bg-$warna'>$status</span>";
			}
			else {
			$kelas_siswa_ar[]="$kelasku";
			
			}
			
			}
			$kelas_siswa=implode("<br>",$kelas_siswa_ar);

}
$warna_o=mysql_query("select  * from status_belajar where id='1'"); 
$dwarna_o=mysql_fetch_array($warna_o);   

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
               $sql_kategori = mysql_query("select * from pembelajaran where tingkat='$_SESSION[tingkat_ujians]' and tahun_ajaran='$tahun_aktif' and semester='$semester_aktif'");
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
$mk=mysql_query("select  * from pembelajaran where id='$row[id_pembelajaran]'");   
$dk=mysql_fetch_array($mk);

$kelas_siswa_ar=array();
$kelas = json_decode($dk[kelas], true);
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
			//$kelas_siswa_ar[]="$kelasku <span class='badge bg-$warna'>$status</span>";
			
			if($row[jenis_ujian]<2){
			$kelas_siswa_ar[]="$kelasku <span class='badge bg-$warna'>$status</span>";
			}
			else {
			$kelas_siswa_ar[]="$kelasku";
			
			}
			
			}
			$kelas_siswa=implode("<br>",$kelas_siswa_ar);

}
else {
$kelas_siswa_ar=array();
$kelas = json_decode($row[akses_kelas], true);
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
			//$kelas_siswa_ar[]="$kelasku <span class='badge bg-$warna'>$status</span>";
			if($row[jenis_ujian]<2){
			$kelas_siswa_ar[]="$kelasku <span class='badge bg-$warna'>$status</span>";
			}
			else {
			$kelas_siswa_ar[]="$kelasku";
			
			}
			}
			$kelas_siswa=implode("<br>",$kelas_siswa_ar);

}

if($row[jenis_ujian]==2){
$pen="<p  style='color:red'>  Batas Tuntas $row[batas_tuntas]</p>";
}
else {
$pen="";	
}


               $pembelajarank=implode("",$tipe_stok_ar);
  
if($row[akses_kelas]=="null"){
$mk=mysql_query("select  * from pembelajaran where id='$row[id_pembelajaran]'");   
$dk=mysql_fetch_array($mk);

if($_SESSION[jenis]=="p"){
$kj="1a";
	
	//kelas
               $kelas_ar=array();
			$cek=mysql_query("SELECT * from kelas where tahun_ajaran='$dk[tahun_ajaran]'
			and tingkat='$dk[tingkat]'");
			while($dcek=mysql_fetch_array($cek)){
			
			$kelas_siswa_ar[]=$dcek[nama_kelas];
			$kelas_ar[]="<option value='$dcek[nama_kelas]'>$dcek[nama_kelas]</option>";

			
			}
			//$kelas_siswa=implode("<br>",$kelas_siswa_ar);
			 $kelas_si=implode("",$kelas_ar);
}
else {


$kelas_siswa_ar=array();
               $kelas_ar=array();

$kelas = json_decode($dk[kelas], true);
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
			$kelas_siswa_ar[]="$kelasku <!--<span class='badge bg-$warna'>$status</span>-->";
			$kelas_ar[]="<option value='$kelasku'>$kelasku</option>";

			}
			$kelas_siswa=implode("<br>",$kelas_siswa_ar);
			 $kelas_si=implode("",$kelas_ar);

}
}
else {
$kelas_siswa_ar=array();
$kelas_ar=array();
$kelas = json_decode($row[akses_kelas], true);
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
			$kelas_siswa_ar[]="$kelasku <!--<span class='badge bg-$warna'>$status</span>-->";
						$kelas_ar[]="<option value='$kelasku'>$kelasku</option>";

			}
			$kelas_siswa=implode("<br>",$kelas_siswa_ar);
			 $kelas_si=implode("",$kelas_ar);

}
	$kls="<select class='form-control' name='kelas'  style='width:200px;' requred>
                    <option value=''>Pilih Kelas</option>
                    $kelas_si
                    </select>
				";

//nilai dan daftar hadir
	$nilai=" <button type='button' class='btn bg-blue waves-effect' data-toggle='modal' data-target='#smallModalNN".$row[id]."'>
                  
                <i class='material-icons'>assignment</i>Nilai</button>
			     
                    <div class='modal fade' id='smallModalNN".$row[id]."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-blue'>
                            <h4 class='modal-title bg' id='smallModalLabel'> Nilai</h4>
                        </div>
                        <div class='modal-body'>
 <form action='../../apps/laporan/cetak_laporan' method='get' target='_NEW'> 
                <input type='hidden' name='ujian' value='".$row[id]."'>
 
                 <input type='hidden' name='id_pembelajaran' value='$row[id_pembelajaran]'>
               
$kls			   
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




	$daftar_hadir=" <button type='button' class='btn bg-orange waves-effect' data-toggle='modal' data-target='#smallModalh".$row[id]."'>
                  
                <i class='material-icons'>assignment</i> Daftar Hadir</button>
			     
                    <div class='modal fade' id='smallModalh".$row[id]."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-blue'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Daftar Hadir</h4>
                        </div>
                        <div class='modal-body'>
 <form action='../../apps/laporan/cetak_laporan_absen_ujian_k' method='get' target='_NEW'> 
                <input type='hidden' name='ujian' value='".$row[id]."'>

                 <input type='hidden' name='pembelajaran' value='$row[id_pembelajaran]'>
               
			 $kls <br>
					
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




   $data[] = array( 
    
      "1"=>"<b>$row[nama_ujian]</b> <br>
      Waktu $tgl s.d $tgl2  <br> Jam : $row[jam_mulai] - $row[jam_selesai] $sts 
	  <br> $kelas_siswa $pen
	  
	  <br>
	  				  $nilai $daftar_hadir

",
        "aksi"=>" 
	     <form action='edit' method='get'> 
                <input type='hidden' name='d' value='".$row[id]."'>
                <input type='hidden' name='id_pembelajaran' value='".$row[id_pembelajaran]."'>

              <a href='../bank_soal/data?d=$row[id]'>
              <button type='button' class='btn bg-green waves-effect'><i class='material-icons'>assignment</i>Bank Soal</button></a>
               <a href='../kendali/peserta?d=$row[id]'>
              <button type='button' class='btn bg-green waves-effect'><i class='material-icons'>assignment</i>Kendali Ujian</button></a>
            $ns
              <button type='submit' class='btn bg-blue waves-effect'><i class='material-icons'>mode_edit</i></button>
                <button type='button' class='btn bg-green waves-effect' data-toggle='modal' data-target='#smallModalc".$row[id]."'>
                  
                <i class='material-icons'>content_copy</i> Copy</button>

                <button type='button' class='btn bg-red waves-effect' data-toggle='modal' data-target='#smallModal".$row[id]."'>
                  
                <i class='material-icons'>delete</i></button>
                    </form>
                    
                    
                    <div class='modal fade' id='smallModal".$row[id]."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-red'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Konfirmasi Hapus</h4>
                        </div>
                        <div class='modal-body'>
                            Apakah anda yakin mau menghapus data ini?      </div>
                        <div class='modal-footer'>
                            <form action='del' method='post'> 
                <input type='hidden' name='d' value='".$row[id]."'>
                   <input type='hidden' name='nama_m' value='$row[judul]'>

                 <input type='hidden' name='id_pembelajaran' value='$row[id_pembelajaran]'>
               
                   <button type='submit' class='btn btn-danger waves-effect'><i class='material-icons'>delete</i> HAPUS</button>

             
                            <button type='button' class='btn btn-info waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
            
                                <form action='copy' method='post'> 

             <div class='modal fade' id='smallModalc".$row[id]."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-green'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Konfirmasi Copy Ujian</h4>
                        </div>
                        <div class='modal-body'>
    <select class='form-control' name='copy' style='width:100%;' >
                    <option value=''>Pilih Nama Guru Tujuan </option>
                            $pembelajarank
                             </select> 
                              <input type='hidden' name='id_ujian' value='".$row[id]."'>

                 <input type='hidden' name='id_pembelajaran' value='$row[id_pembelajaran]'>
               
                            </div>
                        <div class='modal-footer'>
               
                   <button type='submit' class='btn bg-green waves-effect'><i class='material-icons'>content_copy</i> Copy</button>

             
                            <button type='button' class='btn btn-danger waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                            
                        </div>
                    </div>
                </div>
            </div>  </form>
			

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
