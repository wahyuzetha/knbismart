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


if($_SESSION[levelu]==1 or $_SESSION[jabatan_guru]==7 or $_SESSION[jabatan_guru]==1){
             $mp="";
            }
else if($_SESSION[levelu]==2 and ($_SESSION[jabatan_guru]!=7 or $_SESSION[jabatan_guru]!=1)){
             $mp=" and pembelajaran.nuptk='$_SESSION[id_pengguna]'";
            }
## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (pembelajaran.pembelajaran like '%".$searchValue."%' or pembelajaran.jurusan like '%".$searchValue."%' or pembelajaran.tingkat like '%".$searchValue."%' or guru.nama like '%".$searchValue."%') ";
}


## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from pembelajaran LEFT JOIN guru on pembelajaran.nuptk=guru.nik
 WHERE 1 and pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and 
 pembelajaran.semester='$_SESSION[semester_pem]' $mp".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from pembelajaran LEFT JOIN guru on pembelajaran.nuptk=guru.nik where 1 and pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and 
 pembelajaran.semester='$_SESSION[semester_pem]'  $mp".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT guru.nama,pembelajaran.* from pembelajaran LEFT JOIN guru on pembelajaran.nuptk=guru.nik
 where 1 and pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and 
 pembelajaran.semester='$_SESSION[semester_pem]' $mp ".$searchQuery." 
order by guru.nama,tingkat asc,pembelajaran asc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;
while ($row = mysql_fetch_assoc($empRecords)) {
$i++;
$encrypted=$row[id];
$tgl=date('d/m/Y', strtotime($row[tanggal]));
			  $someArray = json_decode($row[kelas], true);

  $lokasi_ar=array();
			foreach($someArray as $jurusanku) { 
			
			$lokasi_ar[]=$jurusanku;
			
			
			}
			               $pilj=implode("<br>",$lokasi_ar);


    if(empty($pilj)){
		$jur="Semua Kelas";
	}
	else {
	$jur=$pilj;
	}
	
	if($row[manual]==1){
	$edit="   <button type='submit' class='btn bg-blue waves-effect'><i class='material-icons'>mode_edit</i></button>
             ";
	}
	else {
	$edit="";
	}
	
	if($_SESSION[levelu]==1){
	$pem="$row[id]<br>";
	}
	else {
	$pem="";	
	}
   $data[] = array( 
    
      "1"=>"$pem <b>$row[nama]</b>",
       "2"=>"$row[pembelajaran]",
	   	   "3"=>"$row[tingkat]",
      "4"=>"$jur",
      "aksi"=>" <form action='edit' method='post'> 
                <input type='hidden' name='d' value='".$row[id]."'>
$edit             
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
