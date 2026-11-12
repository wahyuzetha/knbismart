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

if($_SESSION[levelu]==1){
    $br="";
}
else if($_SESSION[levelu]==2){
    $br=" and (berita.kategori='1' or berita.kategori='2')";
}
else if($_SESSION[levelu]==3){
    $br=" and (berita.kategori='1' or berita.kategori='3')";
}


## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from berita
 WHERE 1 $br ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from berita where 1  $br ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT * from berita where 1 $br ".$searchQuery." 
order by id desc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;
while ($row = mysql_fetch_assoc($empRecords)) {
$i++;
$tgl=date('d/m/Y H:i:s', strtotime($row[timestmp]));

  if(!empty($row[foto]) and file_exists("../../images/$row[foto]")){
      $img="<img src='../../images/$row[foto]' height='100px'><br>";
  }
  else {
      $img="";
  }
   $data[] = array( 
    
      "foto"=>"",
       "kategori"=>"$img <h4>$row[judul]</h4>$tgl <br>
       <a href='../../apps/informasi/detail?d=$row[id]'>Selengkapnya..</a>",
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
