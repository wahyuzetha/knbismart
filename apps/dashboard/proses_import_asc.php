<?php

include "../../inc/koneksi.php";
include "../../inc/aman.php";
include "excel_reader2.php";
include "akses.php";

ini_set('max_execution_time', 0);
ini_set('memory_limit', '128M');

$tahun_ajaran=$tahun_aktif;
$semester=$semester_aktif;

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
 
      $output = '';  
      if($_FILES['xml_file']['name'] != '')  
      {  
           $file_name = $_FILES['xml_file']['name'];  
           $array = explode(".", $file_name);  
           $name = $array[0];  
           $ext = $array[1];  
           if($ext == 'xml')  
           {  
	   
                $path = "xml_asc/";  
                $location = $path . $file_name;  
                if(move_uploaded_file($_FILES['xml_file']['tmp_name'], $location))  
                {  
                   //   echo"masuk $file_name";


//open manifest xml
$nama_xml="$path/$file_name";
$filexml = simplexml_load_file($nama_xml);

//1. PERIODS

//save periods
foreach ($filexml->periods->period as $p1) {

$q=mysql_query("replace asc_periods(period,
									name,
									short,
									starttime,
									endtime)
							values('$p1[period]',
								   '$p1[name]',
								   '$p1[short]',
								   '$p1[starttime]',
								   '$p1[endtime]')");

}
//akhir PERIODS//
		


//2. daysdefs

//save 
foreach ($filexml->daysdefs->daysdef as $p2) {

$q=mysql_query("replace asc_daysdefs(id,
									name,
									short,
									days)
							values('$p2[id]',
								   '".mysql_real_escape_string($p2[name])."',
								   '$p2[short]',
								   '$p2[days]')");
}
//akhir daysdefs//


//3. weeksdefs

//save 
foreach ($filexml->weeksdefs->weeksdef as $p3) {

$q=mysql_query("replace asc_weeksdefs(id,
									name,
									short,
									weeks)
							values('$p3[id]',
								   '".mysql_real_escape_string($p3[name])."',
								   '$p3[short]',
								   '$p3[weeks]')");
}
//akhir weeksdefs//

//4. termsdefs

//save 
foreach ($filexml->termsdefs->termsdef as $p4) {

$q=mysql_query("replace asc_termsdefs(id,
									name,
									short,
									terms)
							values('$p4[id]',
								   '".mysql_real_escape_string($p4[name])."',
								   '$p4[short]',
								   '$p4[terms]')");
}
//akhir termsdefs//


//5. subjects atau mapel

//save 
foreach ($filexml->subjects->subject as $p5) {

$q=mysql_query("replace asc_subjects(id,
									name,
									short,
									partner_id)
							values('$p5[id]',
								   '".mysql_real_escape_string($p5[name])."',
								   '$p5[short]',
								   '$p5[partner_id]')");
}
//akhir subjects atau mapel//

//6. teachers

//save 

foreach ($filexml->teachers->teacher as $p6) {

//cek guru apakah isi

$gr=mysql_query("SELECT * from guru where nik='$p6[short]'");	
$dgr=mysql_fetch_array($gr);

$pass     = md5($p6[short]);
$pengacak  = "sfdnfjdnfjdfnjdnfjdnf303033";
$p=md5($pengacak.md5($pass).$pengacak);


if(empty($dgr[nuptk])){
$q=mysql_query("INSERT INTO guru(nuptk,nama,id_jabatan,nik,teacher_id)         
                         VALUES('$p6[short]','".mysql_real_escape_string($p6[name])."','2','$p6[short]',
						 '$p6[id]')") 
						 or die("gagal".mysql_error());
$q=mysql_query("insert into users (username,password,level,id_pengguna) 
values('$p6[short]','$p','2','$p6[short]')") or die("gagal".mysql_error());
}
else {

$q=mysql_query("update guru set nama='".mysql_real_escape_string($p6[name])."',teacher_id='$p6[id]' where nik='$p6[short]'") 
						 or die("gagal".mysql_error());


	
}

}
//akhir teachers//
					

//7. classrooms atau selain ruang kelas
					
//save 
foreach ($filexml->classrooms->classroom as $p7) {

$q=mysql_query("replace asc_classrooms(id,
									name,
									short,
									capacity,
									partner_id)
							values('$p7[id]',
								   '".mysql_real_escape_string($p7[name])."',
								   '$p7[short]',
								   '$p7[capacity]',
								   '$p7[partner_id]')");
}
//akhir classrooms atau selain ruang kelas//
					
	
//8. grades
					
//save 
foreach ($filexml->grades->grade as $p8) {

$q=mysql_query("replace asc_grades(grade,
									name,
									short)
							values('$p8[grade]',
								   '".mysql_real_escape_string($p8[name])."',
								   '$p8[short]')");
}
//akhir grades//

//9. classes atau kelas 
					
//save 
//$qls=mysql_query("delete from kelas tahun_ajaran='$tahun_ajaran'");	

foreach ($filexml->classes->class as $p9) {
$tingkat_kelas=explode(" ",$p9[name]);
$tingkat_kelas=$tingkat_kelas[0];

$kls=mysql_query("SELECT * from kelas where nama_kelas='$p9[name]' and tahun_ajaran='$tahun_ajaran'");	
$dkls=mysql_fetch_array($kls);

if(empty($dkls[nama_kelas])){
$q=mysql_query("insert into kelas(nama_kelas,
									tingkat,
									tahun_ajaran,
									id_class)
							values('$p9[name]',
								   '$tingkat_kelas',
								   '$tahun_ajaran',
								   '$p9[id]')");
}
else {
	$q=mysql_query("update kelas set id_class='$p9[id]' where nama_kelas='$p9[name]' and tahun_ajaran='$tahun_ajaran'");

}
}
//akhir classes atau kelas//


//10. groups 
					
//save 

foreach ($filexml->groups->group as $p10) {

$q=mysql_query("replace asc_groups(id,
									name,
									classid,
									studentids,
									entireclass,
									divisiontag,
									studentcount)
							values('$p10[id]',
								   '$p10[name]',
								   '$p10[classid]',
								   '$p10[studentids]',
								   '$p10[entireclass]',
								   '$p10[divisiontag]',
								   '$p10[studentcount]')") or die("gagal".mysql_error());
}
//akhir groups//


//11. lessons 
					
//save 
$del=mysql_query("delete from asc_lessons where tahun_ajaran='$tahun_ajaran' and semester='$semester'");

foreach ($filexml->lessons->lesson as $p11) {

$q=mysql_query("insert into asc_lessons(id,
									subjectid,
									classids,
									groupids,
									teacherids,
									classroomids,
									periodspercard,
									periodsperweek,
									daysdefid,
									weeksdefid,
									termsdefid,
									seminargroup,
									capacity,
									partner_id,
									tahun_ajaran,
									semester)
							values('$p11[id]',
									'$p11[subjectid]',
									'$p11[classids]',
									'$p11[groupids]',
									'$p11[teacherids]',
									'$p11[classroomids]',
									'$p11[periodspercard]',
									'$p11[periodsperweek]',
									'$p11[daysdefid]',
									'$p11[weeksdefid]',
									'$p11[termsdefid]',
									'$p11[seminargroup]',
									'$p11[capacity]',
									'$p11[partner_id]',
									'$tahun_ajaran',
									'$semester')") or die("gagal".mysql_error());
}

//meneyesuaikan lesson dengan pembelajaran
//tahap 1 mencari nama guru
 //$del=mysql_query("delete from pembelajaran") or die("gagal".mysql_error());

 $qguru=mysql_query("SELECT * from guru") or die("gagal".mysql_error());
 while($dguru=mysql_fetch_array($qguru)){
 
 //loop tingkat
 $qtingkat=mysql_query("SELECT * from kelas group by tingkat");
 while($dtingkat=mysql_fetch_array($qtingkat)){
 

 
 
 //memasukkan guru ke tabel pembelajaran
 
 //mencari guru mengajar mapel apa
 $qmpl=mysql_query("SELECT guru.nama,asc_subjects.short as kode_asc,asc_subjects.name,kelas.nama_kelas,kelas.tingkat,asc_lessons.* 
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
	 

$cek_jadwal=mysql_query("SELECT * from pembelajaran where nuptk='$dguru[nik]' and 
														  kode_asc='$dmpl[kode_asc]' and
														  tingkat='$dtingkat[tingkat]' and
														  tahun_ajaran='$tahun_ajaran' and 
														  semester='$semester'"); 	
$dcek_jadwal=mysql_fetch_array($cek_jadwal);

  if(empty($dcek_jadwal[id])){
 $qsave=mysql_query("insert into pembelajaran(pembelajaran,
											 nuptk,
											 tingkat,
											 kelas,
											 teacher_id,
											 subjectid,
											 class_id,
											 tahun_ajaran,
											 semester,
											 kode_asc)
								 values
											('$dmpl[name]',
											 '$dguru[nik]',
											 '$dtingkat[tingkat]',
											 '$kelas_pem',
											 '$dguru[teacher_id]',
											 '$dmpl[subjectid]',
											 '$classids_pem',
											 '$tahun_ajaran',
											 '$semester',
											 '$dmpl[kode_asc]')");
  }
  else {
	   
   $qsave=mysql_query("update pembelajaran set pembelajaran='$dmpl[name]',
											kelas='$kelas_pem',
											class_id='$classids_pem',
											teacher_id='$dguru[teacher_id]',
											subjectid='$dmpl[subjectid]'
											where 
											nuptk='$dguru[nik]' and 
											kode_asc='$dmpl[kode_asc]' and
											tingkat='$dtingkat[tingkat]' and
											tahun_ajaran='$tahun_ajaran' and 
											semester='$semester'");
  }
  //echo"$dguru[nama] $dguru[teacher_id] - mapel $dmpl[name] - $kelas_pem - $classids_pem<hr>";		

 }
 }
 }

 //menghapus residu pembelajaran
  $qres=mysql_query("SELECT * from pembelajaran where 
					semester='$semester' and tahun_ajaran='$tahun_ajaran'
					and teacher_id='$dguru[teacher_id]'");
  while($dres=mysql_fetch_array($qres)){
	 echo"";
	$someArray_akses = json_decode($dres[kelas], true);

	foreach($someArray_akses as $klasku){	
	
	//echo"$dres[nuptk] - $dres[pembelajaran] - $dres[class_id] - $dres[kelas] 
	//<br>";
					
	 $qresc=mysql_query("SELECT * from asc_lessons,kelas,asc_cards,asc_subjects
					WHERE 
					asc_lessons.id=asc_cards.lessonid AND
					asc_lessons.classids=kelas.id_class AND  
					asc_lessons.subjectid=asc_subjects.id AND
					asc_lessons.semester='$semester' and asc_lessons.tahun_ajaran='$tahun_ajaran'
					and asc_lessons.teacherids='$dguru[teacher_id]' and 
					asc_subjects.short='$dres[kode_asc]'
					and kelas.nama_kelas='$klasku'");
    $dresc=mysql_fetch_array($qresc);
	
					
	if(empty($dresc[id])){
 echo"$dres[nuptk] - $dres[pembelajaran] - $dres[class_id] - $dres[kelas]  <hr>"; 
	$delq=mysql_query("delete from pembelajaran where id='$dres[id]'");
	
	}
  
	}
   }
 
 
 }



//akhir lessons//



//12. cards 
					
//save 
$del=mysql_query("delete from asc_cards where tahun_ajaran='$tahun_ajaran' and semester='$semester'");

foreach ($filexml->cards->card as $p12) {

$q=mysql_query("insert into asc_cards(lessonid,
									classroomids,
									period,
									weeks,
									terms,
									days,
									tahun_ajaran,
									semester)
							values('$p12[lessonid]',
									'$p12[classroomids]',
									'$p12[period]',
									'$p12[weeks]',
									'$p12[terms]',
									'$p12[days]',
									'$tahun_ajaran',
									'$semester')") or die("gagal".mysql_error());
}
//akhir cards//
		
	if($q){
	echo"<script>
	alert('Proses Import Data Selesai Silahkan cek pada menu guru,kelas,dan pembelajaran');
	</script>
";
	}		
					
					
					
                }  
           }  
		   else {
echo"Bukan File XML";
}	
      } 

 

?>

