<?php
session_start();
require_once ('database.php');
$mensagem = mysqli_real_escape_string($conn, $_GET['mensagem']);
$ipaddress = $_SESSION['user'];

$query_verifica_user = "select * from chat_users where ip='$ipaddress'";
$result_verifica_user = mysqli_query($conn, $query_verifica_user);
if(!mysqli_num_rows($result_verifica_user) > 0){
    mysqli_query($conn, "insert into chat_users (ip) values ('$ipaddress')");
}

$result_get_user = mysqli_query($conn, $query_verifica_user);
$assoc_get_user = mysqli_fetch_assoc($result_get_user);
$user = $assoc_get_user['id'];

mysqli_query($conn, "insert into mensagens (mensagem, user) values ('$mensagem', '$user')");

?>