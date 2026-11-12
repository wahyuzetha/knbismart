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
   $searchQuery = " and soal like '%".$searchValue."%'";
}



## Total number of records without filtering
$sel = mysql_query("select count(*) as allcount from bank_soal  where 1 and id_ujian='$_SESSION[id_ujian_soal]' ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysql_query("select count(*) as allcount from bank_soal  where 1 and id_ujian='$_SESSION[id_ujian_soal]' ".$searchQuery);
$records = mysql_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT * from bank_soal  where 1 and id_ujian='$_SESSION[id_ujian_soal]' ".$searchQuery." 
order by id asc limit ".$row.",".$rowperpage;
$empRecords = mysql_query($empQuery);
$data = array();
$i=0;
while ($row = mysql_fetch_assoc($empRecords)) {
    $i++;


				$tipe_soal_ar=array();
				$opsi_soal="A~~$row[pila],,,,B~~$row[pilb],,,,C~~$row[pilc],,,,D~~$row[pild]";
				$opsi_soal_tampil = explode(",,,,", $opsi_soal);
				
				
				foreach($opsi_soal_tampil as $opsi_ts) {
				$opsi_tx=explode("~~", $opsi_ts);	
				$opsi_t=$opsi_tx[1];
				$opsi_huruf=$opsi_tx[0];	
				
				$desk=$opsi_t;
				$desk=str_ireplace('<p>','',$desk);
				$desk=str_ireplace('</p>','',$desk);   
               $tipe_soal_ar[]="$opsi_huruf = $desk <hr>"; 
                 }
				$tipe_soal=implode("",$tipe_soal_ar);

   $data[] = array( 
      "no"=>"<b>$i</b>",
       "detail"=>"$row[soal] <hr>$tipe_soal <br><b>Kunci : $row[kunci]</b>",
      "aksi"=>" <form action='edit' method='post'> 
                <input type='hidden' name='d' value='".$row[id]."'>
                <input type='hidden' name='id_ujian' value='".$row[id_ujian]."'>

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
                 <input type='text' name='d' value='".$row[id]."'>
                <input type='hidden' name='id_ujian' value='".$row[id_ujian]."'>

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
