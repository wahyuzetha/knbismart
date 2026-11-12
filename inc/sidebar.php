
    <?php
	$m2peng=mysql_query("select  * from pengaturan where id='1'");
	$dm2peng=mysql_fetch_array($m2peng);
	

    if($_SESSION[levelu]==2){
    $login=mysql_query("select * from guru where nik='$_SESSION[namauser]'");
    $ketemu=mysql_fetch_array($login);
    $nama=$ketemu[nama];    
    $nik=$ketemu[nuptk];
    $foto=$ketemu[foto];
    $kelas_all="";  
	$tingkat_kelas_all="";	
	$jurusan_kelas_all="";
    }
    else if($_SESSION[levelu]==3){
    $login=mysql_query("SELECT kelas.nama_kelas,kelas.tingkat,kelas.tahun_ajaran,kelas.jurusan,kelas_siswa.kelas,siswa.nis,siswa.nama,siswa.foto 
from siswa,kelas_siswa,kelas
WHERE 
siswa.nis=kelas_siswa.nis AND
kelas_siswa.kelas=kelas.nama_kelas and  kelas_siswa.nis='$_SESSION[id_pengguna]' and kelas_siswa.tahun_ajaran='$tahun_aktif' order by kelas_siswa.kelas asc");
    $ketemu=mysql_fetch_array($login);
    $nama=$ketemu[nama];    
    $nik=$ketemu[nis];
     $foto=$ketemu[foto];
	 $kelas_all=$ketemu[kelas];
	$_SESSION[kelasku]=$kelas_all;
	
	$split=$dm2peng[split_import];
	
	$data_kelas_all = explode("$split" , $kelas_all);
	
	$tingkat_kelas_all=$ketemu[tingkat];
	$jurusan_kelas_all=$kelas_all;
	

	}
	
    
    else if($_SESSION[levelu]==1){
     $login=mysql_query("select * from users where username='$_SESSION[namauser]'");
    $ketemu=mysql_fetch_array($login);
    
    $nama="Admnistrator";   
	$tingkat_kelas_all="";	
	$jurusan_kelas_all="";
	     $foto=$ketemu[foto];

    }
    
    
    
?>
<style>
    
                .jr {
                padding:5px;
                margin:4px;
                width:40px;
                height:40px;
                }
                .jr:hover,
.btn-outline {
  color: #4fbfa8;
  background-color: #ffffff;
  border-color: #4fbfa8;
  font-weight: bold;
  letter-spacing: 0.05em;
}

.btn-outline {
     color: #fff;
    background-color: #333;
  border-color: #4fbfa8;
  font-weight: bold;
  border-radius: 0;
}

.btn-outline:hover,
.btn-outline:active,
.btn-outline:focus,
.btn-outline.active {
  background: #4fbfa8;
  color: #ffffff;
  border-color: #4fbfa8;
  
}


.btn-colour-1 {
 color: #ffffff;
    background-color: #333;
  border-color: #004E64;
  font-weight: bold;
  letter-spacing: 0.05em;
  border-radius: 0;
}

.btn-colour-1:hover,
.btn-colour-1:active,
.btn-colour-1:focus,
.btn-colour-1.active {
  /* let's darken #004E64 a bit for hover effect */
  background: #003D4F;
  color: #ffffff;
  border-color: #003D4F;
}

.klik:hover,
.klik:active,
.klik:focus,
.klik.active {
  /* let's darken #004E64 a bit for hover effect */
  background: #003D4F;
  color: #ffffff;
  border-color: #003D4F;
}

               
 .klik {
            background-color: #4caf50;
            border-radius: 5px;
            height: 41px;
            width: 43px;
            margin-top: -6px;
            margin-left: -7px;
         
            }
</style>
    <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
			
                <div class="image">
                    <?php if(!empty($foto)){?>
                    <img src="../../foto/<?php echo"$foto";?>" width="70" height="70" alt="User" />
                    <?php } 
                    else {
                        ?> <img src="../../css/<?php echo"nopic.png";?>" height="60" alt="User" /><?php    
                    }
                    ?>
                </div>
			
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo"<u>$nama</u><br>$kelas_all";?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            
                            <li>
                  
                </li>
                            <li><a href="../../logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                  
                <ul class="list">

                  
                                              <li class="header">MAIN NAVIGATION </li>

                    <?php
                  if(!empty($_GET[wmulai])){
                    ?>
                     <li class="active">
                        <a href="#">
                            <i class="material-icons">home</i>
                            <span><?php 					
							if($dpem[lama_ujian]!="auto"){
							echo"NAVIGASI SOAL";
							} else { echo"NAVIGASI TIMER";}?></span>
                        </a>
                    </li>
                    <?php
					if($dpem[lama_ujian]!="auto"){
					$nk=0;
					$pengacak = explode(",", $d['pengacak']);
					
					foreach($pengacak as $id_soal) {
					$nk++;	
                 $cek_ops1=mysql_fetch_array(mysql_query("select * from hasil_opsi where nis='$_SESSION[nis]' and id_ujian='$_SESSION[id_ujian]' 
                 and id_soal='$id_soal'"));
                    
                    if(!empty($cek_ops1[opsi]) and $cek_ops1[opsi]!="F"){
                        $kliks="klik";
                    }
                    else {
                        $kliks="";

                    }
					$noval="$nk,$id_soal";

                                ?>
                                <button id='<?php echo $nk;?>' class='pencet btn btn-outline jr' data-id="<?php echo"$noval";?>"  type='button'>
                                <div id="aku<?php echo"$nk";?>" class="<?php echo"$kliks";?>">
                                <span style='top: 5px;'><?php echo"$nk";?></span>
                                </div> </button>
                                
                                <?php } ?><br><br>
                                <?php if($dpem[status_essay]==1){?>
                                <button style="margin-left:5px" class="btn btn-warning waves-effect" type='button'
                                data-toggle="modal" data-target="#essay">
                               <i class="material-icons">border_color</i>  Essay
                                 </button>
                                 <?php } ?>
                                 
                                <button id="finish" type="button" class="finish btn bg-red waves-effect" style="margin-left:5px">
                                    <i class="material-icons">exit_to_app</i>
                                    <span>SELESAI</span>
                                </button>
                                
                                
                               
				  <?php }}
                  else {?>
                    
                   <?php if($_SESSION[levelu]==1){?>
                           <li class="active">
                        <a href="../../apps/dashboard/data">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
             
		
                   
				
				
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">computer</i>
                            <span>Master Data</span>
                        </a>
                        <ul class="ml-menu">
                             <li>
                                <a href="../../apps/dashboard/import_asc">ASC Time Tables</a>
                            </li>
							<li>
                                <a href="../../apps/guru/data">Data Guru</a>
                            </li>
							
                            <li>
                                <a href="../../apps/siswa/data">Data Siswa</a>
                            </li>
                             <li>
                                <a href="../../apps/tingkat/data">Data Tingkat</a>
                            </li>
							
                             <li>
                                <a href="../../apps/kelas/data">Data Kelas</a>
                            </li>
							
                            <li>
                                <a href="../../apps/pengaturan/edit">Pengaturan</a>
                            </li>
							<li>
                                <a href="../../apps/semester/data">Semester</a>
                            </li>
                             <li>
                                <a href="../../apps/tahun_ajaran/data">Tahun Ajaran</a>
                            </li>
                           
                            
                            
                           
                              

                                  </ul>
                    </li>
                   
                      
                    
                   
                   
                     
                    <li>
                        <a href="../../apps/informasi/data">
                            <i class="material-icons">book</i>
                            <span>Informasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="../../apps/pembelajaran/data">
                            <i class="material-icons">book</i>
                            <span>Mata Pelajaran</span>
                        </a>
                    </li>
                    
                     <li>
                        <a href="../../apps/perangkat/data">
                            <i class="material-icons">book</i>
                            <span>Perangkat Pembelajaran</span>
                        </a>
                    </li>
				
                    <li>
                        <a href="../../apps/materi/data_m">
                            <i class="material-icons">assignment</i>
                            <span>Materi</span>
                        </a>
                    </li>
                    
                        <li>
                        <a href="../../apps/tugas/data_m">
                            <i class="material-icons">assignment</i>
                            <span>Tugas</span>
                        </a>
                    </li>
					
					  <li>
                        <a href="../../apps/ujian/data_m">
                            <i class="material-icons">assignment</i>
                            <span>Ujian</span>
                        </a>
                    </li>
					
					
				
				
                    
                     
                    <li>
                        <a href="../../apps/laporan/data">
                            <i class="material-icons">assignment_turned_in</i>
                            <span>Laporan</span>
                        </a>
                    </li>
                   
                    <li>
                        <a href="../../apps/user/data">
                            <i class="material-icons">account_circle</i>
                            <span>Pengaturan Admin</span>
                        </a>
                    </li>
                   <?php } 
                   else if($_SESSION[levelu]==2){?>
                          <li class="active">
                        <a href="../../apps/dashboard/data">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>

                   
                    
                    <li>
                        <a href="../../apps/guru/edit">
                            <i class="material-icons">book</i>
                            <span>Profil</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="../../apps/siswa/data">
                            <i class="material-icons">book</i>
                            <span>Data Siswa</span>
                        </a>
                    </li>
                    
                     <li>
                        <a href="../../apps/kelas/data">
                            <i class="material-icons">book</i>
                            <span>Data Kelas</span>
                        </a>
                    </li>

                    <li>
                        <a href="../../apps/pembelajaran/data">
                            <i class="material-icons">book</i>
                            <span>Mapel</span>
                        </a>
                    </li>
                    
                     <li>
                        <a href="../../apps/perangkat/data">
                            <i class="material-icons">book</i>
                            <span>Perangkat Pembelajaran</span>
                        </a>
                    </li>
                    
				    <?php if($_SESSION[jabatan_guru]!=1){?>

                    <li>
                        <a href="../../apps/materi/data_m">
                            <i class="material-icons">assignment</i>
                            <span>Materi</span>
                        </a>
                    </li>
					 <li>
                        <a href="../../apps/tugas/data_m">
                            <i class="material-icons">assignment</i>
                            <span>Tugas</span>
                        </a>
                     <li>
                        <a href="../../apps/ujian/data_m">
                            <i class="material-icons">assignment</i>
                            <span>Ujian</span>
                        </a>
                    </li>
				 <?php } ?>
                 
                 <li>
                        <a href="../../apps/laporan/data">
                            <i class="material-icons">assignment_turned_in</i>
                            <span>Laporan</span>
                        </a>
                    </li>
                    
                    <?php
                    if(!empty($_SESSION[wali_kelas])){?>
                     <li>
                        <a href="../../apps/laporan/data?wali=<?php echo"$_SESSION[wali_kelas]";?>">
                            <i class="material-icons">assignment_turned_in</i>
                            <span>Laporan Wali Kelas</span>
                        </a>
                    </li>
                    <?php } ?>
                     <li>
                        <a href="../../logout">
                            <i class="material-icons">power_off</i>
                            <span> Logout</span>
                        </a>
                    </li>
                   <?php } 
                   else if($_SESSION[levelu]==3){?>
                          <li class="active">
                        <a href="../../apps/dashboard/data_siswa">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    
                        
              <li>
                        <a href="../../apps/dashboard/dash_2">
                            <i class="material-icons">book</i>
                            <span>Materi</span>
                        </a>
                    </li>
                    <li>
                        <a href="../../apps/dashboard/dashs_tugas">
                            <i class="material-icons">assignment</i>
                            <span>Tugas</span>
                        </a>
                    </li>
                      <li>
                        <a href="../../apps/dashboard/dash_ujian">
                            <i class="material-icons">book</i>
                            <span>Ulangan Harian</span>
                        </a>
                    </li>
					 <li>
                        <a href="../../apps/dashboard/ujian_event">
                            <i class="material-icons">book</i>
                            <span>Ujian Sekolah</span>
                        </a>
                    </li>
				
                    <li>
                        <a href="../../apps/siswa/profil">
                            <i class="material-icons">account_circle</i>
                            <span> Profil</span>
                        </a>
                    </li>
                    <!--
                     <li>
                        <a href="../../apps/laporan/data">
                            <i class="material-icons">assignment_turned_in</i>
                            <span>Laporan</span>
                        </a>
                    </li>
                    -->
                     <li>
                        <a href="../../logout">
                            <i class="material-icons">power_off</i>
                            <span> Logout</span>
                        </a>
                    </li>
                   <?php } 
                  }?>
                

                  </ul>

            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                   <?php echo date('Y');?> <a href="javascript:void(0);"><?php echo"$nama_sekolah";?></a>.
                </div>
                <div class="version">
                </div>
            </div>
            <!-- #Footer -->
        </aside>
    