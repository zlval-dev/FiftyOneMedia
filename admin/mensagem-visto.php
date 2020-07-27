<?php

session_start();
require_once('../database.php');
require_once('verificar-admin.php');
$user = $_GET['user'];
mysqli_query($conn, "update mensagens set visto=true where user='$user' and admin=false");

?>