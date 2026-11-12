<?php
session_start();
include "../../inc/koneksi.php";
include "../../inc/fire.php";

$id = $_GET['d'];

$m=mysql_query("select  * from berita where id='$id' and status='1'");
$d=mysql_fetch_array($m);
	$produk=str_replace("-","",$d[judul]);
				//	$slug=slug($produk);
				//	$encrypted=encryptor('encrypt',$d[id]);
//echo''.$alamat.'/lihat_berita-'.$encrypted.'-'.$slug.'.html';    
               $dv_ar=array();
               $sql_kategori = mysql_query("SELECT * FROM users where token_notif!=''");
               $total = mysql_num_rows($sql_kategori);
                $i=0;
                while($k = mysql_fetch_assoc($sql_kategori))
                {
                    $i++;
                
                
                  $dv_ar[]="'$k[token_notif]'";
                  $token=$k[token_notif];
               
             //  $token_all=implode(",",$dv_ar);
               
               //  $registrationIds = $token_all;
//echo"sds $registrationIds";
               
//$token='dTGfJ807L5I:APA91bGIStg8diwkuy-JJ-4esJxvDo9c-IfBW6R7jjS0dgluOdJh8tGXwaiWGEu-5JfZOYrOmaJJkLDQLmRq-PkrTOG8kThCPO4WTBKlKL64Nd9zr_M1TO_yhzgvVoZJpdfp_tKW-svY';

//$tokenList=['dTGfJ807L5I:APA91bGIStg8diwkuy-JJ-4esJxvDo9c-IfBW6R7jjS0dgluOdJh8tGXwaiWGEu-5JfZOYrOmaJJkLDQLmRq-PkrTOG8kThCPO4WTBKlKL64Nd9zr_M1TO_yhzgvVoZJpdfp_tKW-svY', 'e5_NdxSueBU:APA91bG97KoGA27_ogXRX9TlKjFEu34b4afNB3MbFrHXapZYe_XgnUQOmmmmF43ZQBL7eHpxRjMsP4h5PJcgziSiPshsfaBWQlcBKLmNLDBDf2WfkGOaUHr-hq5tGVHrVudwiTv232D-'];

     $notification = [
            'title' =>'Informasi ',
            'body' => ''.$d[judul].'',
            'icon' =>'logo_notif.png', 
            'sound' => 'default',
            'badge' => '1'
            ];

        $extraNotificationData = ["message" => $notification,"url"=>''.$alamat.'/lihat_berita-'.$encrypted.'-'.$slug.'.html'];

        $fcmNotification = [
            //'registration_ids' => $registrationIds, //multple token array
            
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);


        echo $result;
        
        $_SESSION['i'] = $i;
    $percent = intval($i/$total * 100)."%";   
	
 //  sleep(10); // Here call your time taking function like sending bulk sms etc.
 
    echo '<script>
    parent.document.getElementById("progressbar").innerHTML="<div style=\"width:'.$percent.';background:linear-gradient(to bottom, #fbe7e5 0%,#f44336 100%); ;height:35px;\">&nbsp;</div>";
    parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">'.$percent.' is processed.</div>";</script>';

    ob_flush(); 
    flush();
}

echo '<script>parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\"><h4>Proses kirim notifikasi selesai.</h4></div>"</script>';

unset($_SESSION['i']); 