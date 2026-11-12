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
else {
             $mp="and pembelajaran.nuptk='$_SESSION[id_pengguna]'";
}

## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (pembelajaran.pembelajaran like '%".$searchValue."%' or pembelajaran.jurusan like '%".$searchValue."%' or pembelajaran.tingkat like '%".$searchValue."%' or guru.nama like '%".$searchValue."%') ";
}



## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from pembelajaran LEFT JOIN guru on pembelajaran.nuptk=guru.nik
 WHERE 1   and pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and 
 pembelajaran.semester='$_SESSION[semester_pem]'  $mp ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from pembelajaran LEFT JOIN guru on pembelajaran.nuptk=guru.nik where 1  and pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and 
 pembelajaran.semester='$_SESSION[semester_pem]'  $mp ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT guru.nama,pembelajaran.* from pembelajaran LEFT JOIN guru on pembelajaran.nuptk=guru.nik
 where 1  and pembelajaran.tahun_ajaran='$_SESSION[tahun_ajaran_pem]' and 
 pembelajaran.semester='$_SESSION[semester_pem]'  $mp ".$searchQuery." 
order by guru.nama,tingkat asc,pembelajaran asc  limit ".$row.",".$rowperpage;
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
   $data[] = array( 
    
      "1"=>"<b>$row[nama]</b>",
       "2"=>"$row[pembelajaran]",
	   	   "3"=>"$row[tingkat]",
      "4"=>"$jur",
      "aksi"=>" 
	  
	     <a href='data?d=$row[id]' 
                <button type='submit' class='btn bg-pink waves-effect'><i class='material-icons'>book</i>Detail</button></a>
            
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
