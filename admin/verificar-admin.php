<?php

    session_start();

    if(!$_SESSION['admin']){
        header("Location: ../index.php");
    }

?>