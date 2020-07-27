<?php
    session_start();
    require_once('database.php');
    $_SESSION['language'] = $_GET['idioma'];
    $language = $_GET['idioma'];
    $ip = $_SESSION['user'];
    mysqli_query($conn, "update chat_users set language='$language' where ip='$ip'");
?>