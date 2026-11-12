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
   $searchQuery = " and (siswa.nis like '%".$searchValue."%' or siswa.nama like '%".$searchValue."%') ";
}



## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from kelas_siswa
LEFT JOIN siswa on kelas_siswa.nis=siswa.nis where kelas_siswa.kelas='$_SESSION[kelas_c]' 
 and kelas_siswa.tahun_ajaran='$tahun_aktif' ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from kelas_siswa
LEFT JOIN siswa on kelas_siswa.nis=siswa.nis where kelas_siswa.kelas='$_SESSION[kelas_c]' 
 and kelas_siswa.tahun_ajaran='$tahun_aktif' ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT siswa.*,kelas_siswa.id as id_s from kelas_siswa
LEFT JOIN siswa on kelas_siswa.nis=siswa.nis where kelas_siswa.kelas='$_SESSION[kelas_c]' 
 and kelas_siswa.tahun_ajaran='$tahun_aktif' ".$searchQuery." 
order by nis asc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;
while ($row = mysql_fetch_assoc($empRecords)) {
$i++;
$encrypted=$row[id];
$tgl=date('d/m/Y', strtotime($row[tanggal]));


  if($row[aktif]==1){
$status="<span style='color:green'>Aktif</span>";
  }
else {
$status="<span style='color:red'>Non Aktif</span>";
}	
   $data[] = array( 
    
      "nis"=>"<b>$row[nis]</b><br><b>$status </b>",
       "nama"=>"$row[nama]",
	   	   "tgl_lahir"=>"$row[tanggal_lahir]",
      "kelas"=>"$row[kelas]",
      "alamat"=>"$row[alamat]",
       "no_telp"=>"$row[pas]",
      "aksi"=>" <form action='edit' method='get'> 
                <input type='hidden' name='d' value='".$row[id_s]."'>
              <button type='submit' class='btn bg-blue waves-effect'><i class='material-icons'>mode_edit</i></button>
                <button type='button' class='btn bg-red waves-effect' data-toggle='modal' data-target='#smallModal".$i."'>
                  
                <i class='material-icons'>delete</i></button>
                    </form>
                    <div class='modal fade' id='smallModal".$i."' tabindex='-1' role='dialog'>
                      <div class='modal-dialog modal-xl' role='document'>
                    <div class='modal-content' style='margin-top: 130px'>
                        <div class='modal-header bg-red'>
                            <h4 class='modal-title bg' id='smallModalLabel'>Konfirmasi Hapus</h4>
                        </div>
                        <div class='modal-body'>
                            Apakah anda yakin mau menghapus data ini?      </div>
                        <div class='modal-footer'>
                            <form action='del' method='post'> 
                 <input type='hidden' name='d' value='".$row[id_s]."'>
                   <button type='submit' class='btn btn-danger waves-effect'><i class='material-icons'>delete</i> HAPUS</button>

             
                            <button type='button' class='btn btn-info waves-effect' data-dismiss='modal'><i class='material-icons'>close</i>CLOSE</button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>"
     
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
