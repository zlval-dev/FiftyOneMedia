<?php
session_start();
require_once ('database.php');
$ipaddress = $_SESSION['user'];

$query_get_user = "select * from chat_users where ip='$ipaddress'";
$result_get_user = mysqli_query($conn, $query_get_user);
$assoc_get_user = mysqli_fetch_assoc($result_get_user);
$user = $assoc_get_user['id'];
mysqli_query($conn, "update mensagens set visto=true where user='$user' and visto=false and admin=true");

?>