<?php
    require_once('../database.php');
    require_once('verificar-admin.php');
    $id = $_GET['id'];
    $show = $_GET['show'];
    if($show){
        mysqli_query($conn, "update works set `show`=true where id=$id");
    }else{
        mysqli_query($conn, "update works set `show`=false where id=$id");
    }
?>