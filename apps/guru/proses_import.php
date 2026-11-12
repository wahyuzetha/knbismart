<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "excel_reader2.php";
include "akses.php";


function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}



// membaca file excel yang diupload
$data = new Spreadsheet_Excel_Reader($_FILES['excel']['tmp_name']);

// membaca jumlah baris dari data excel
$baris = $data->rowcount($sheet_index=0);

$sukses = 0;
$gagal = 0;

// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
/*
$nama=mysql_real_escape_string($data->val($i,2));
$nuptk=mysql_real_escape_string($data->val($i,3));
$jk=mysql_real_escape_string($data->val($i,4));
$tempat_lahir=mysql_real_escape_string($data->val($i,5));
$tanggal_lahir=mysql_real_escape_string($data->val($i,6));
$nip=mysql_real_escape_string($data->val($i,7));
$status_kepeg=mysql_real_escape_string($data->val($i,8));
$jenis_ptk=mysql_real_escape_string($data->val($i,9));
$agama=mysql_real_escape_string($data->val($i,10));
$alamat_jalan=mysql_real_escape_string($data->val($i,11));
$rt=mysql_real_escape_string($data->val($i,12));
$rw=mysql_real_escape_string($data->val($i,13));
$nama_dusun=mysql_real_escape_string($data->val($i,14));
$desa=mysql_real_escape_string($data->val($i,15));
$kecamatan=mysql_real_escape_string($data->val($i,16));
$kode_pos=mysql_real_escape_string($data->val($i,17));
$telepon=mysql_real_escape_string($data->val($i,18));
$hp=mysql_real_escape_string($data->val($i,19));
$email=mysql_real_escape_string($data->val($i,20));
$tugas_tambahan=mysql_real_escape_string($data->val($i,21));
$sk_cpns=mysql_real_escape_string($data->val($i,22));
$tanggal_cpns=mysql_real_escape_string($data->val($i,23));
$sk_pengangkatan=mysql_real_escape_string($data->val($i,24));
$tmt_pengangkatan=mysql_real_escape_string($data->val($i,25));
$lembaga_pengangkatan=mysql_real_escape_string($data->val($i,26));
$pangkat_golongan=mysql_real_escape_string($data->val($i,27));
$sumber_gaji=mysql_real_escape_string($data->val($i,28));
$nama_ibu_kandung=mysql_real_escape_string($data->val($i,29));
$status_perkawinan=mysql_real_escape_string($data->val($i,30));
$nama_suami_istri=mysql_real_escape_string($data->val($i,31));
$nip_suami_istri=mysql_real_escape_string($data->val($i,32));
$pekerjaan_suami_istri=mysql_real_escape_string($data->val($i,33));
$tmt_pns=mysql_real_escape_string($data->val($i,34));
$sudah_lisensi_kepsek=mysql_real_escape_string($data->val($i,35));
$pernah_diklat_pengawas=mysql_real_escape_string($data->val($i,36));
$keahlian_braile=mysql_real_escape_string($data->val($i,37));
$keahlian_bahasa_isyarat=mysql_real_escape_string($data->val($i,38));
$npwp=mysql_real_escape_string($data->val($i,39));
$nama_wajib_pajak=mysql_real_escape_string($data->val($i,40));
$kewarganegaraan=mysql_real_escape_string($data->val($i,41));
$bank=mysql_real_escape_string($data->val($i,42));
$nomor_rekening_bank=mysql_real_escape_string($data->val($i,43));
$rekening_atas_nama=mysql_real_escape_string($data->val($i,44));
$nik=mysql_real_escape_string($data->val($i,45));
$no_kk=mysql_real_escape_string($data->val($i,46));
$karpeg=mysql_real_escape_string($data->val($i,47));
$karis=mysql_real_escape_string($data->val($i,48));
$lintang=mysql_real_escape_string($data->val($i,49));
$bujur=mysql_real_escape_string($data->val($i,50));
$nuks=mysql_real_escape_string($data->val($i,51));
$username=mysql_real_escape_string($data->val($i,52));
$password=mysql_real_escape_string($data->val($i,53));
*/
$nama=mysql_real_escape_string($data->val($i,1));
$nik=mysql_real_escape_string($data->val($i,2));
$username=mysql_real_escape_string($data->val($i,3));
$password=mysql_real_escape_string($data->val($i,4));


$p_nuptk=strlen($nik);

if($p_nuptk>1){


$m2=mysql_query("select  * from guru where nik='$nik'");
$d2=mysql_fetch_array($m2);

if(!empty($d2[nik])){

$q=mysql_query("update guru set
						nama='$nama',
						nuptk='$nuptk',
						jk='$jk',
						tempat_lahir='$tempat_lahir',
						tanggal_lahir='$tanggal_lahir',
						nip='$nip',
						status_kepeg='$status_kepeg',
						jenis_ptk='$jenis_ptk',
						agama='$agama',
						alamat_jalan='$alamat_jalan',
						rt='$rt',
						rw='$rw',
						nama_dusun='$nama_dusun',
						desa='$desa',
						kecamatan='$kecamatan',
						kode_pos='$kode_pos',
						telepon='$telepon',
						hp='$hp',
						email='$email',
						tugas_tambahan='$tugas_tambahan',
						sk_cpns='$sk_cpns',
						tanggal_cpns='$tanggal_cpns',
						sk_pengangkatan='$sk_pengangkatan',
						tmt_pengangkatan='$tmt_pengangkatan',
						lembaga_pengangkatan='$lembaga_pengangkatan',
						pangkat_golongan='$pangkat_golongan',
						sumber_gaji='$sumber_gaji',
						nama_ibu_kandung='$nama_ibu_kandung',
						status_perkawinan='$status_perkawinan',
						nama_suami_istri='$nama_suami_istri',
						nip_suami_istri='$nip_suami_istri',
						pekerjaan_suami_istri='$pekerjaan_suami_istri',
						tmt_pns='$tmt_pns',
						sudah_lisensi_kepsek='$sudah_lisensi_kepsek',
						pernah_diklat_pengawas='$pernah_diklat_pengawas',
						keahlian_braile='$keahlian_braile',
						keahlian_bahasa_isyarat='$keahlian_bahasa_isyarat',
						npwp='$npwp',
						nama_wajib_pajak='$nama_wajib_pajak',
						kewarganegaraan='$kewarganegaraan',
						bank='$bank',
						nomor_rekening_bank='$nomor_rekening_bank',
						rekening_atas_nama='$rekening_atas_nama',
						nik='$nik',
						no_kk='$no_kk',
						karpeg='$karpeg',
						karis='$karis',
						lintang='$lintang',
						bujur='$bujur',
						nuks='$nuks'
                where nik='$nik'") or die("gagal".mysql_error());
    
}

else {


$q=mysql_query("INSERT INTO guru(nama,
								nuptk,
								jk,
								tempat_lahir,
								tanggal_lahir,
								nip,
								status_kepeg,
								jenis_ptk,
								agama,
								alamat_jalan,
								rt,
								rw,
								nama_dusun,
								desa,
								kecamatan,
								kode_pos,
								telepon,
								hp,
								email,
								tugas_tambahan,
								sk_cpns,
								tanggal_cpns,
								sk_pengangkatan,
								tmt_pengangkatan,
								lembaga_pengangkatan,
								pangkat_golongan,
								sumber_gaji,
								nama_ibu_kandung,
								status_perkawinan,
								nama_suami_istri,
								nip_suami_istri,
								pekerjaan_suami_istri,
								tmt_pns,
								sudah_lisensi_kepsek,
								pernah_diklat_pengawas,
								keahlian_braile,
								keahlian_bahasa_isyarat,
								npwp,
								nama_wajib_pajak,
								kewarganegaraan,
								bank,
								nomor_rekening_bank,
								rekening_atas_nama,
								nik,
								no_kk,
								karpeg,
								karis,
								lintang,
								bujur,
								nuks) 
                                 
                         VALUES('$nama',
								'$nuptk',
								'$jk',
								'$tempat_lahir',
								'$tanggal_lahir',
								'$nip',
								'$status_kepeg',
								'$jenis_ptk',
								'$agama',
								'$alamat_jalan',
								'$rt',
								'$rw',
								'$nama_dusun',
								'$desa',
								'$kecamatan',
								'$kode_pos',
								'$telepon',
								'$hp',
								'$email',
								'$tugas_tambahan',
								'$sk_cpns',
								'$tanggal_cpns',
								'$sk_pengangkatan',
								'$tmt_pengangkatan',
								'$lembaga_pengangkatan',
								'$pangkat_golongan',
								'$sumber_gaji',
								'$nama_ibu_kandung',
								'$status_perkawinan',
								'$nama_suami_istri',
								'$nip_suami_istri',
								'$pekerjaan_suami_istri',
								'$tmt_pns',
								'$sudah_lisensi_kepsek',
								'$pernah_diklat_pengawas',
								'$keahlian_braile',
								'$keahlian_bahasa_isyarat',
								'$npwp',
								'$nama_wajib_pajak',
								'$kewarganegaraan',
								'$bank',
								'$nomor_rekening_bank',
								'$rekening_atas_nama',
								'$nik',
								'$no_kk',
								'$karpeg',
								'$karis',
								'$lintang',
								'$bujur',
								'$nuks')") or die("gagal".mysql_error());


    
}
$pass     = anti_injection(md5($password));
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);

$mlo=mysql_query("select  * from users where id_pengguna='$nik'")or die("gagal".mysql_error());
$dlo=mysql_fetch_array($mlo);


if(!empty($dlo[username])){

$q=mysql_query("update users set password='$p',username='$username'
                where id_pengguna='$nik'") or die("gagal".mysql_error());
    
}
else {
	
$q=mysql_query("INSERT INTO users(username,password,level,id_pengguna) 
                                 
	                       VALUES('$username','$p','2','$nik')") or die("gagal".mysql_error());
}   
}

if ($q) { $sukses++;
?><font color="#00CC33"><?php echo"$nuptk $nama Sukses  atau berhasili di import <br>";?></font><?php
}
  else { $gagal++; ?><font color="#FF0000"> <?php echo"Gagal import $nip $nama, cek data<br>"; ?></font><?php }
}
if(!empty($nis)){
// tampilan status sukses dan gagal
echo "<h3>Proses import data selesai.</h3>";
echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
echo "Jumlah data yang gagal diimport : ".$gagal."</p>";




}

