<?php


function tanggal_indo($tanggal, $cetak_hari = false)
{
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $bulan[ (int)$split[1] ];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num];
	}
	return $tgl_indo;
}

function tgl_indonesia($tanggalindo){
	$bulanindo = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggalindo);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulanindo[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}


//Menampilkan hari dan tanggal

function Terbilang($x) 
{ 
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"); 
  if ($x < 12) 
    return " " . $abil[$x]; 
  elseif ($x < 20) 
    return Terbilang($x - 10) . " Belas"; 
  elseif ($x < 100) 
    return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10); 
  elseif ($x < 200) 
    return " seratus" . Terbilang($x - 100); 
  elseif ($x < 1000) 
    return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100); 
  elseif ($x < 2000) 
    return " seribu" . Terbilang($x - 1000); 
  elseif ($x < 1000000) 
    return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000); 
  elseif ($x < 1000000000) 
    return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000); 
    
    
} 

?>
