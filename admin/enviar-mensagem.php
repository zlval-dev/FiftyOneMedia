<?php
session_start();
require_once('../database.php');
require_once('verificar-admin.php');
$mensagem = mysqli_real_escape_string($conn, $_GET['mensagem']);
$user = $_GET['user'];

mysqli_query($conn, "insert into mensagens (mensagem, user, admin) values ('$mensagem', $user, true)");

?>