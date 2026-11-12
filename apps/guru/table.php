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
   $searchQuery = " and (nuptk like '%".$searchValue."%' or nama like '%".$searchValue."%' or tanggal_lahir like '%".$searchValue."%') ";
}



## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from guru
LEFT JOIN jabatan on guru.id_jabatan=jabatan.id where 1 ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from guru
LEFT JOIN jabatan on guru.id_jabatan=jabatan.id where 1 ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT guru.*,jabatan.jenis_jab from guru
LEFT JOIN jabatan on guru.id_jabatan=jabatan.id where 1 ".$searchQuery." 
order by guru.id_jabatan desc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;
while ($row = mysql_fetch_assoc($empRecords)) {
$i++;
$encrypted=$row[id];
$tgl=date('d/m/Y', strtotime($row[tanggal]));

$debet=number_format($row[debet],0);
$kredit=number_format($row[kredit],0);

 $k=mysql_query("select * from users where id_pengguna='$row[nik]'");
 $dk=mysql_fetch_array($k);
  
  if(!empty($row[foto])){
      $ft="<img src='../../foto/$row[foto]' width='80px'>";
  }  
  else {
      $ft="<img src='../../css/nopic.png' width='80px'>";
  }
   $data[] = array( 
    
      "foto"=>"$ft ",
       "nama"=>"$row[nama]",
	   	   "tgl_lahir"=>"$row[tanggal_lahir]",
      "alamat"=>"$row[alamat_jalan]",
       "no_telp"=>"$row[hp]",
       "jabatan"=>"$row[jenis_jab]",
       "username"=>"$dk[username]",

      "aksi"=>" <form action='edit' method='get'> 
                <input type='hidden' name='d' value='".$row[nik]."'>
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
                 <input type='hidden' name='d' value='".$row[nik]."'>
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
