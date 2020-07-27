<?php
	session_start();
    require_once ('database.php');
    $query = "select * from info where language='".$_SESSION['language']."' and work is null";
    $result = mysqli_query($conn, $query);
    while($assoc = mysqli_fetch_assoc($result)){
        $lang[$assoc['title']] = $assoc['description'];
    }
?>