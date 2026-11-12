<?php

include "../../inc/koneksi.php";

ini_set('max_execution_time', 0);
ini_set('memory_limit', '128M');

$tahun_ajaran=$tahun_aktif;
$semester=$semester_aktif;


//meneyesuaikan lesson dengan pembelajaran
//tahap 1 mencari nama guru
 $del=mysql_query("delete from pembelajaran") or die("gagal".mysql_error());

 $qguru=mysql_query("SELECT * from guru") or die("gagal".mysql_error());
 while($dguru=mysql_fetch_array($qguru)){
 
 //loop tingkat
 $qtingkat=mysql_query("SELECT * from kelas group by tingkat");
 while($dtingkat=mysql_fetch_array($qtingkat)){
 

 
 
 //memasukkan guru ke tabel pembelajaran
 
 //mencari guru mengajar mapel apa
 $qmpl=mysql_query("SELECT guru.nama,asc_subjects.name,kelas.nama_kelas,kelas.tingkat,asc_lessons.* 
					from asc_lessons
					LEFT JOIN asc_subjects on asc_lessons.subjectid=asc_subjects.id
					LEFT JOIN kelas on asc_lessons.classids=kelas.id_class
					LEFT JOIN guru on asc_lessons.teacherids=guru.teacher_id
					WHERE asc_lessons.teacherids='$dguru[teacher_id]' and 
					kelas.tingkat='$dtingkat[tingkat]' and asc_lessons.semester='$semester' and asc_lessons.tahun_ajaran='$tahun_ajaran'
					group by asc_lessons.subjectid");
 while($dmpl=mysql_fetch_array($qmpl)){
 
 $kelas_ar=array();
 $classid_ar=array();

 $qpem=mysql_query("SELECT guru.nama,asc_subjects.name,kelas.nama_kelas,kelas.tingkat,asc_lessons.* 
					from asc_lessons
					LEFT JOIN asc_subjects on asc_lessons.subjectid=asc_subjects.id
					LEFT JOIN kelas on asc_lessons.classids=kelas.id_class
					LEFT JOIN guru on asc_lessons.teacherids=guru.teacher_id
					WHERE asc_lessons.teacherids='$dguru[teacher_id]' and 
					asc_lessons.subjectid='$dmpl[subjectid]' and
					kelas.tingkat='$dtingkat[tingkat]' and asc_lessons.semester='$semester' and asc_lessons.tahun_ajaran='$tahun_ajaran'
					group by asc_lessons.classids,asc_lessons.subjectid");
 while($dpem=mysql_fetch_array($qpem)){
 $kelas_ar[]=$dpem[nama_kelas];
 $classid_ar[]=$dpem[classids];
 
 }
$kelas_cek=implode(",",$kelas_ar);
$kelas_pem = '"'.implode('","', $kelas_ar).'"';
$kelas_pem="[$kelas_pem]";
$classids_pem = '"'.implode('","', $classid_ar).'"';
$classids_pem="[$classids_pem]";

 if(!empty($kelas_cek)){
	 
 echo"$dguru[nama] $dguru[teacher_id] - mapel $dmpl[name] - $kelas_pem - $classids_pem<hr>";		


 $qsave=mysql_query("insert into pembelajaran(pembelajaran,
											 nuptk,
											 tingkat,
											 kelas,
											 teacher_id,
											 subjectid,
											 class_id,
											 tahun_ajaran,
											 semester)
								 values
											('$dmpl[name]',
											 '$dguru[nik]',
											 '$dtingkat[tingkat]',
											 '$kelas_pem',
											 '$dguru[teacher_id]',
											 '$dmpl[subjectid]',
											 '$classids_pem',
											 '$tahun_ajaran',
											 '$semester')");
 
 }
 }
 }

 
 }



 

?>

