<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "excel_reader2.php";
include "akses.php";
ini_set('max_execution_time', 0);


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
$nis=$data->val($i,3);
$jk=mysql_real_escape_string($data->val($i,4));
$nisn=mysql_real_escape_string($data->val($i,5));
$tempat_lahir=mysql_real_escape_string($data->val($i,6));
$tanggal_lahir=mysql_real_escape_string($data->val($i,7));
$nik=mysql_real_escape_string($data->val($i,8));
$agama=mysql_real_escape_string($data->val($i,9));
$alamat=mysql_real_escape_string($data->val($i,10));
$rt=mysql_real_escape_string($data->val($i,11));
$rw=mysql_real_escape_string($data->val($i,12));
$dusun=mysql_real_escape_string($data->val($i,13));
$kelurahan=mysql_real_escape_string($data->val($i,14));
$kecamatan=mysql_real_escape_string($data->val($i,15));
$kode_pos=mysql_real_escape_string($data->val($i,16));
$jenis_tinggal=mysql_real_escape_string($data->val($i,17));
$alat_transportasi=mysql_real_escape_string($data->val($i,18));
$telepon=mysql_real_escape_string($data->val($i,19));
$hp=mysql_real_escape_string($data->val($i,20));
$email=mysql_real_escape_string($data->val($i,21));
$skhun=mysql_real_escape_string($data->val($i,22));
$penerima_kps=mysql_real_escape_string($data->val($i,23));
$no_kps=mysql_real_escape_string($data->val($i,24));
$data_ayah_nama=mysql_real_escape_string($data->val($i,25));
$data_ayah_tahun_lahir=mysql_real_escape_string($data->val($i,26));
$data_ayah_jenjang_pendidikan=mysql_real_escape_string($data->val($i,27));
$data_ayah_pekerjaan=mysql_real_escape_string($data->val($i,28));
$data_ayah_penghasilan=mysql_real_escape_string($data->val($i,29));
$data_ayah_nik=mysql_real_escape_string($data->val($i,30));
$data_ibu_nama=mysql_real_escape_string($data->val($i,31));
$data_ibu_tahun_lahir=mysql_real_escape_string($data->val($i,32));
$data_ibu_jenjang_pendidikan=mysql_real_escape_string($data->val($i,33));
$data_ibu_pekerjaan=mysql_real_escape_string($data->val($i,34));
$data_ibu_penghasilan=mysql_real_escape_string($data->val($i,35));
$data_ibu_nik=mysql_real_escape_string($data->val($i,36));
$data_wali_nama=mysql_real_escape_string($data->val($i,37));
$data_wali_tahun_lahir=mysql_real_escape_string($data->val($i,38));
$data_wali_jenjang_pendidikan=mysql_real_escape_string($data->val($i,39));
$data_wali_pekerjaan=mysql_real_escape_string($data->val($i,40));
$data_wali_penghasilan=mysql_real_escape_string($data->val($i,41));
$data_wali_nik=mysql_real_escape_string($data->val($i,42));
$kelas=mysql_real_escape_string($data->val($i,43));
$no_peserta_ujian_nasional=mysql_real_escape_string($data->val($i,44));
$no_seri_ijazah=mysql_real_escape_string($data->val($i,45));
$penerima_kip=mysql_real_escape_string($data->val($i,46));
$nomor_kip=mysql_real_escape_string($data->val($i,47));
$nama_di_kip=mysql_real_escape_string($data->val($i,48));
$nomor_kks=mysql_real_escape_string($data->val($i,49));
$no_registrasi_akta_lahir=mysql_real_escape_string($data->val($i,50));
$bank=mysql_real_escape_string($data->val($i,51));
$nomor_rekening_bank=mysql_real_escape_string($data->val($i,52));
$rekening_atas_nama=mysql_real_escape_string($data->val($i,53));
$layak_pip=mysql_real_escape_string($data->val($i,54));
$alasan_layak_pip=mysql_real_escape_string($data->val($i,55));
$kebutuhan_khusus=mysql_real_escape_string($data->val($i,56));
$sekolah_asal=mysql_real_escape_string($data->val($i,57));
$anak_ke=mysql_real_escape_string($data->val($i,58));
$lintang=mysql_real_escape_string($data->val($i,59));
$bujur=mysql_real_escape_string($data->val($i,60));
$no_kk=mysql_real_escape_string($data->val($i,61));
$tinggi_badan=mysql_real_escape_string($data->val($i,63));
$berat_badan=mysql_real_escape_string($data->val($i,62));
$lingkar_kepala=mysql_real_escape_string($data->val($i,64));
$jml_saudara=mysql_real_escape_string($data->val($i,65));
$jarak_rumah=mysql_real_escape_string($data->val($i,66));
$username=mysql_real_escape_string($data->val($i,67));
$password=mysql_real_escape_string($data->val($i,68));

*/

$nama=mysql_real_escape_string($data->val($i,2));
$nis=$data->val($i,1);
$tingkat=$data->val($i,3);
$kelas=$data->val($i,4);
$username=mysql_real_escape_string($data->val($i,5));
$password=mysql_real_escape_string($data->val($i,6));


$p_nis=strlen($nis);

if($p_nis>0){

//kelas
$m3=mysql_query("select  * from kelas where nama_kelas='$kelas' and tahun_ajaran='$tahun_aktif'");
$d3=mysql_fetch_array($m3);

if(empty($d3[nama_kelas]) ){
	
$q=mysql_query("INSERT INTO kelas(nama_kelas,tahun_ajaran,tingkat) 
          VALUES('$kelas','$tahun_aktif','$tingkat')") or die("gagal".mysql_error());

}
else {
	
}


$m2=mysql_query("select  * from siswa where nis='$nis'");
$d2=mysql_fetch_array($m2);

if(!empty($d2[nis])){

$q=mysql_query("update siswa set nama='$nama',
									nis='$nis',
									jk='$jk',
									nisn='$nisn',
									tempat_lahir='$tempat_lahir',
									tanggal_lahir='$tanggal_lahir',
									nik='$nik',
									agama='$agama',
									alamat='$alamat',
									rt='$rt',
									rw='$rw',
									dusun='$dusun',
									kelurahan='$kelurahan',
									kecamatan='$kecamatan',
									kode_pos='$kode_pos',
									jenis_tinggal='$jenis_tinggal',
									alat_transportasi='$alat_transportasi',
									telepon='$telepon',
									hp='$hp',
									email='$email',
									skhun='$skhun',
									penerima_kps='$penerima_kps',
									no_kps='$no_kps',
									data_ayah_nama='$data_ayah_nama',
									data_ayah_tahun_lahir='$data_ayah_tahun_lahir',
									data_ayah_jenjang_pendidikan='$data_ayah_jenjang_pendidikan',
									data_ayah_pekerjaan='$data_ayah_pekerjaan',
									data_ayah_penghasilan='$data_ayah_penghasilan',
									data_ayah_nik='$data_ayah_nik',
									data_ibu_nama='$data_ibu_nama',
									data_ibu_tahun_lahir='$data_ibu_tahun_lahir',
									data_ibu_jenjang_pendidikan='$data_ibu_jenjang_pendidikan',
									data_ibu_pekerjaan='$data_ibu_pekerjaan',
									data_ibu_penghasilan='$data_ibu_penghasilan',
									data_ibu_nik='$data_ibu_nik',
									data_wali_nama='$data_wali_nama',
									data_wali_tahun_lahir='$data_wali_tahun_lahir',
									data_wali_jenjang_pendidikan='$data_wali_jenjang_pendidikan',
									data_wali_pekerjaan='$data_wali_pekerjaan',
									data_wali_penghasilan='$data_wali_penghasilan',
									data_wali_nik='$data_wali_nik',
									kelas='$kelas',
									no_peserta_ujian_nasional='$no_peserta_ujian_nasional',
									no_seri_ijazah='$no_seri_ijazah',
									penerima_kip='$penerima_kip',
									nomor_kip='$nomor_kip',
									nama_di_kip='$nama_di_kip',
									nomor_kks='$nomor_kks',
									no_registrasi_akta_lahir='$no_registrasi_akta_lahir',
									bank='$bank',
									nomor_rekening_bank='$nomor_rekening_bank',
									rekening_atas_nama='$rekening_atas_nama',
									layak_pip='$layak_pip',
									alasan_layak_pip='$alasan_layak_pip',
									kebutuhan_khusus='$kebutuhan_khusus',
									sekolah_asal='$sekolah_asal',
									anak_ke='$anak_ke',
									lintang='$lintang',
									bujur='$bujur',
									no_kk='$no_kk',
									tinggi_badan='$tinggi_badan',
									berat_badan='$berat_badan',
									lingkar_kepala='$lingkar_kepala',
									jml_saudara='$jml_saudara',
									jarak_rumah='$jarak_rumah',
									pas='$password'
                where nis='$nis'") or die("gagal".mysql_error());
    
}

else {


$q=mysql_query("INSERT INTO siswa(nama,
				nis,
				jk,
				nisn,
				tempat_lahir,
				tanggal_lahir,
				nik,
				agama,
				alamat,
				rt,
				rw,
				dusun,
				kelurahan,
				kecamatan,
				kode_pos,
				jenis_tinggal,
				alat_transportasi,
				telepon,
				hp,
				email,
				skhun,
				penerima_kps,
				no_kps,
				data_ayah_nama,
				data_ayah_tahun_lahir,
				data_ayah_jenjang_pendidikan,
				data_ayah_pekerjaan,
				data_ayah_penghasilan,
				data_ayah_nik,
				data_ibu_nama,
				data_ibu_tahun_lahir,
				data_ibu_jenjang_pendidikan,
				data_ibu_pekerjaan,
				data_ibu_penghasilan,
				data_ibu_nik,
				data_wali_nama,
				data_wali_tahun_lahir,
				data_wali_jenjang_pendidikan,
				data_wali_pekerjaan,
				data_wali_penghasilan,
				data_wali_nik,
				kelas,
				no_peserta_ujian_nasional,
				no_seri_ijazah,
				penerima_kip,
				nomor_kip,
				nama_di_kip,
				nomor_kks,
				no_registrasi_akta_lahir,
				bank,
				nomor_rekening_bank,
				rekening_atas_nama,
				layak_pip,
				alasan_layak_pip,
				kebutuhan_khusus,
				sekolah_asal,
				anak_ke,
				lintang,
				bujur,
				no_kk,
				tinggi_badan,
				berat_badan,
				lingkar_kepala,
				jml_saudara,
				jarak_rumah,
				pas,
				tahun_ajaran) 
                                 
                         VALUES('$nama',
								'$nis',
								'$jk',
								'$nisn',
								'$tempat_lahir',
								'$tanggal_lahir',
								'$nik',
								'$agama',
								'$alamat',
								'$rt',
								'$rw',
								'$dusun',
								'$kelurahan',
								'$kecamatan',
								'$kode_pos',
								'$jenis_tinggal',
								'$alat_transportasi',
								'$telepon',
								'$hp',
								'$email',
								'$skhun',
								'$penerima_kps',
								'$no_kps',
								'$data_ayah_nama',
								'$data_ayah_tahun_lahir',
								'$data_ayah_jenjang_pendidikan',
								'$data_ayah_pekerjaan',
								'$data_ayah_penghasilan',
								'$data_ayah_nik',
								'$data_ibu_nama',
								'$data_ibu_tahun_lahir',
								'$data_ibu_jenjang_pendidikan',
								'$data_ibu_pekerjaan',
								'$data_ibu_penghasilan',
								'$data_ibu_nik',
								'$data_wali_nama',
								'$data_wali_tahun_lahir',
								'$data_wali_jenjang_pendidikan',
								'$data_wali_pekerjaan',
								'$data_wali_penghasilan',
								'$data_wali_nik',
								'$kelas',
								'$no_peserta_ujian_nasional',
								'$no_seri_ijazah',
								'$penerima_kip',
								'$nomor_kip',
								'$nama_di_kip',
								'$nomor_kks',
								'$no_registrasi_akta_lahir',
								'$bank',
								'$nomor_rekening_bank',
								'$rekening_atas_nama',
								'$layak_pip',
								'$alasan_layak_pip',
								'$kebutuhan_khusus',
								'$sekolah_asal',
								'$anak_ke',
								'$lintang',
								'$bujur',
								'$no_kk',
								'$tinggi_badan',
								'$berat_badan',
								'$lingkar_kepala',
								'$jml_saudara',
								'$jarak_rumah',
								'$password',
								'$tahun_aktif')") or die("gagal".mysql_error());
}


$mlo=mysql_query("select  * from users where id_pengguna='$nis'")or die("gagal".mysql_error());
$dlo=mysql_fetch_array($mlo);


$pass     = anti_injection(md5($password));
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);

if(!empty($dlo[id_pengguna])){

$q=mysql_query("update users set password='$p',pas='$password'
                where id_pengguna='$nis'") or die("gagal".mysql_error());
    
}
else {


$q=mysql_query("INSERT INTO users(username,password,level,id_pengguna,pas,token_notif) 
                                 
	                       VALUES('$username','$p','3','$nis','$password','$nama')") or die("gagal".mysql_error());
    
}

//memasukkan ke rombel	
$dr=mysql_query("select  * from kelas_siswa where nis='$nis' and kelas='$kelas' and tahun_ajaran='$tahun_aktif'");
$dr=mysql_fetch_array($dr);

if(empty($dr[id])){
$q=mysql_query("INSERT INTO kelas_siswa(nis,kelas,tahun_ajaran) 
                                 
	                       VALUES('$nis','$kelas','$tahun_aktif')") or die("gagal".mysql_error());
    
}


}

if ($q) { $sukses++;
?><font color="#00CC33"><?php echo"$nis $nama Sukses  atau berhasili di import <br>";?></font><?php
}
  else { $gagal++; ?><font color="#FF0000"> <?php echo"Gagal import $nis $nama, cek data<br>"; ?></font><?php }
}
if(!empty($sukses or $gagal)){
// tampilan status sukses dan gagal
echo "<h3>Proses import data selesai.</h3>";
echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
echo "Jumlah data yang gagal diimport : ".$gagal."</p>";




}

$m2peng=mysql_query("select  * from pengaturan where id='1'");
$dm2peng=mysql_fetch_array($m2peng);
$split=$dm2peng[split_import];
//echo"split $split";
//kelas
$m3c=mysql_query("select  * from kelas where tahun_ajaran='$tahun_aktif'");
while($d3c=mysql_fetch_array($m3c)){
$data = explode("$split" , $d3c[nama_kelas]);

$tingkat=$d3c[tingkat];
$jurusan=$d3c[jurusan];

//$q=mysql_query("update kelas set tahun_ajaran='$tahun_aktif',jurusan='$jurusan',tingkat='$tingkat',tahun_ajaran='$tahun_aktif' 
//where id='$d3c[id]'") or die("gagal".mysql_error());

//jurusan
$m3j=mysql_query("select  * from jurusan where jurusan='$jurusan'") or die("gagal".mysql_error());
$d3j=mysql_fetch_array($m3j);

if(empty($d3j[id]) and !empty($jurusan)){
	
$q=mysql_query("INSERT INTO jurusan(jurusan) 
          VALUES('$jurusan')") or die("gagal".mysql_error());

}
else {
	
}

//tingkat
$m3t=mysql_query("select  * from tingkat where tingkat='$tingkat'")or die("gagal".mysql_error());
$d3t=mysql_fetch_array($m3t);

if(empty($d3t[id]) and !empty($tingkat)){
	
$q=mysql_query("INSERT INTO tingkat(tingkat) 
          VALUES('$tingkat')") or die("gagal".mysql_error());

}
else {
	
}
}

?>