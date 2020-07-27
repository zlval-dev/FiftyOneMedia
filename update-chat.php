<?php

require_once('database.php');
session_start();

$ip = $_SESSION['user'];
$query_get_user = "select * from chat_users where ip='$ip'";
$result_get_user = mysqli_query($conn, $query_get_user);
$assoc_get_user = mysqli_fetch_assoc($result_get_user);
$user = $assoc_get_user['id'];
$query_get_notificacoes = "select * from mensagens where user='$user' and visto=false and admin=true";
$result_get_notificacoes = mysqli_query($conn, $query_get_notificacoes);
$change[0] = mysqli_num_rows($result_get_notificacoes);

$contador = 1;
while($assoc_get_notificacoes = mysqli_fetch_assoc($result_get_notificacoes)){
    $change[$contador] = $assoc_get_notificacoes['mensagem'];
    $contador++;
}
echo json_encode($change);

?>