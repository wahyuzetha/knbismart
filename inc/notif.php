<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
 <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js"></script>
   <?php
   include"../../inc/koneksi.php";
$pntk=mysql_query("select  * from pengaturan where id='1'");
$dpntk=mysql_fetch_array($pntk);
?>
<script>
        // Initialize Firebase
        // TODO: Replace with your project's customized code snippet
		 
        var config = {
            'messagingSenderId': '<?php echo"$dpntk[messagingSenderId]";?>',
            'apiKey': '<?php echo"$dpntk[apiKey]";?>',
            'projectId': '<?php echo"$dpntk[projectId]";?>',
            'appId': '<?php echo"$dpntk[appId]";?>',
        };
        firebase.initializeApp(config);

        const messaging = firebase.messaging();
        messaging
            .requestPermission()
            .then(function () {
               // MsgElem.innerHTML = "Notification permission granted." 
                console.log("Notification permission granted.");
                
                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function(token) {
			//alert(token);
			
			 var action = 'update_token';
 $.ajax({
  url:"../../inc/ol.php",
  method:"POST",
  data:{update_token:action,token_user:token},
  success:function(data)
  {
  }
 });
                TokenElem.innerHTML = "token is : " + token
            })
            .catch(function (err) {
				//alert(err)
              //  ErrElem.innerHTML =  ErrElem.innerHTML + "; " + err
                console.log("Unable to get permission to notify.", err);
            });

        let enableForegroundNotification = true;
        messaging.onMessage(function(payload) {
            console.log("Message received. ", payload);
           // NotisElem.innerHTML = NotisElem.innerHTML + JSON.stringify(payload);

            if(enableForegroundNotification) {
                const {title, ...options} = JSON.parse(payload.data.notification);
                navigator.serviceWorker.getRegistrations().then(registration => {
                    registration[0].showNotification(title, options);
                });
            }
        });
    </script>