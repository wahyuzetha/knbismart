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
   $searchQuery = " and (tugas.judul like '%".$searchValue."%') ";
}



## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from tugas where id_pembelajaran='$_SESSION[id_pembelajaran_mtns]' ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from tugas where id_pembelajaran='$_SESSION[id_pembelajaran_mtns]' ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT * from tugas where id_pembelajaran='$_SESSION[id_pembelajaran_mtns]'  ".$searchQuery." 
order by id desc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;
$warna_o=mysql_query("select  * from status_belajar where id='1'"); 
$dwarna_o=mysql_fetch_array($warna_o);   
 
while ($row = mysql_fetch_assoc($empRecords)) {
$i++;
$encrypted=$row[id];
$tgl=date('d/m/Y', strtotime($row[batas_tanggal]));
$tgl_mulai=date('d/m/Y', strtotime($row[tanggal_mulai]));

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
			status_mengajar.id_tugas='$row[id]' and
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
			$kelas_siswa_ar[]="$kelasku <span class='badge bg-$warna'>$status</span>";
			
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
			status_mengajar.id_tugas='$row[id]' and
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
			$kelas_siswa_ar[]="$kelasku <span class='badge bg-$warna'>$status</span>";
			
			}
			$kelas_siswa=implode("<br>",$kelas_siswa_ar);

}


   $data[] = array( 
    
      "1"=>"Tanggal Mulai $tgl_mulai <br><b>$row[judul]</b><br> Tanggal Pengumpulan $tgl $row[batas_jam] <br>
	  $kelas_siswa",
        "aksi"=>" 
	     <form action='edit' method='get'> 
                <input type='hidden' name='d' value='".$row[id]."'>
                <input type='hidden' name='id_pembelajaran' value='".$row[id_pembelajaran]."'>

              <a href='../../apps/dashboard/detail_tugas?d=$row[id]&id_pembelajaran=$row[id_pembelajaran]'>
              <button type='button' class='btn bg-orange waves-effect'><i class='material-icons'>assignment</i>Preview Tugas</button></a>
              <a href='nilai?id_ujian=$row[id]'>
              <button type='button' class='btn bg-pink waves-effect'><i class='material-icons'>assignment</i>Isi Nilai</button></a>
              <button type='submit' class='btn bg-blue waves-effect'><i class='material-icons'>mode_edit</i></button>
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
