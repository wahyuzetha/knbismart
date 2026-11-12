<?php
session_start();
if($_GET[token]!="null" and !empty($_GET[token])){
    $_SESSION[token_id]=$_GET[token];
}
else {
     $_SESSION[token_id]=$_SESSION[token_id];
}
header('location:login');

?>
