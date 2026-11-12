<?php
include"koneksi.php";

if(!empty($_SESSION[namauser])){

$mpro=mysql_query("select  * from pengaturan where id='1'");
$dpro=mysql_fetch_array($mpro);
     
define('API_ACCESS_KEY',''.$dpro[apicloud].'');
$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
$alamat="http://$_SERVER[HTTP_HOST]";
 
function kirim_notif_kelas($judul,$isi,$level,$url,$kelas,$fcmUrl){
    
  // echo"$fcmUrl $url";
 $sql_kategori = mysql_query("SELECT * from siswa where token_firebase!='' and kelas='$kelas'");
 while($k = mysql_fetch_assoc($sql_kategori))
 {
                    
                   
  //  $token=$k[token_firebase];
    

         echo"$token";   
        $notification = [
            'title' =>''.$judul.'',
            'body' => ''.$isi.'',
            'icon' =>'logo_notif.png', 
            'sound' => 'default'
        ];

        $extraNotificationData = ["message" => $notification,"moredata" =>'dd',"url"=>''.$url.''];

        $fcmNotification = [
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

           // echo "asas $result";

        
   
    ob_flush(); 
    flush();

    
}
}   
}

?>