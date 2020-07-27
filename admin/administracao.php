<?php
    require_once('../database.php');
    require_once('verificar-admin.php');
    $status = $_GET['status'];
    if($status == 'online'){
        mysqli_query($conn, "update administracao set online=true, pages=pages+1, data = CURRENT_TIMESTAMP where id=1");
    }else if($status == 'offline'){
        mysqli_query($conn, "update administracao set online = (case when pages=1 then false else online end), data = CURRENT_TIMESTAMP, pages = (case when pages > 0 then pages-1 else pages end) where id=1");
    }
?>