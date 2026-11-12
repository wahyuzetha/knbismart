<?php
## Database configuration
include "../../inc/koneksi.php";
include "../../inc/admin.php";

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
   $searchQuery = " and (kategori like '%".$searchValue."%') ";
}




## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from log_akses_materi,pembelajaran,materi,guru
WHERE log_akses_materi.id_pembelajaran=pembelajaran.id and log_akses_materi.id_materi=materi.id and guru.nik=pembelajaran.nuptk and log_akses_materi.id_user='$_SESSION[namauser]' ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from log_akses_materi,pembelajaran,materi,guru
WHERE log_akses_materi.id_pembelajaran=pembelajaran.id and log_akses_materi.id_materi=materi.id and guru.nik=pembelajaran.nuptk and log_akses_materi.id_user='$_SESSION[namauser]' ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT guru.nama,pembelajaran.pembelajaran,materi.judul,log_akses_materi.* from log_akses_materi,pembelajaran,materi,guru
WHERE log_akses_materi.id_pembelajaran=pembelajaran.id and log_akses_materi.id_materi=materi.id and guru.nik=pembelajaran.nuptk and log_akses_materi.id_user='$_SESSION[namauser]' ".$searchQuery." group by log_akses_materi.id_materi
order by id desc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;
while ($row = mysql_fetch_assoc($empRecords)) {
$i++;
$tgl=date('d/m/Y H:i:s', strtotime($row[timestmp]));

  
   $data[] = array( 
    
      "foto"=>"",
       "kategori"=>"$tgl <br><b>$row[pembelajaran] - $row[nama]</b><br>  
       <a href='detail_materi?d=$row[id_materi]&id_pembelajaran=$row[id_pembelajaran]'>$row[judul]</a>",
	  "aksi"=>" <form action='edit' method='GET'> 
                <input type='hidden' name='d' value='".$row[id]."'>
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
                 <input type='hidden' name='d' value='".$row[id]."'>
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
