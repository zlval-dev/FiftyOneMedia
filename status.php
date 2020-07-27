<?php

session_start();
require_once('database.php');
$lang = $_SESSION['language'];

$query = "select * from administracao where id=1";
$result = mysqli_query($conn, $query);
$assoc = mysqli_fetch_assoc($result);
$change[0] = $assoc['online'];
$change[1] = $assoc['data'];
date_default_timezone_set('Europe/Lisbon');
$change[2] = date('Y:m:d H:i:s');
if((strtotime($change[2]) - strtotime($change[1])) < 60){
    $change[3] = intval(strtotime($change[2]) - strtotime($change[1]));
    if($lang == 'pt'){
        if($change[3] == 1){
            $change[4] = 'segundo';
        }else{
            $change[4] = 'segundos';
        }
    }else{
        if($change[3] == 1){
            $change[4] = 'second';
        }else{
            $change[4] = 'seconds';
        }
    }
}else if(((strtotime($change[2]) - strtotime($change[1]))/60) < 60){
   $change[3] = intval((strtotime($change[2]) - strtotime($change[1]))/60);
   if($lang == 'pt'){
        if($change[3] == 1){
            $change[4] = 'minuto';
        }else{
            $change[4] = 'minutos';
        }
   }else{
        if($change[3] == 1){
            $change[4] = 'minute';
        }else{
            $change[4] = 'minutes';
        }
   }
}else if(((strtotime($change[2]) - strtotime($change[1]))/60/60) < 24){
    $change[3] = intval((strtotime($change[2]) - strtotime($change[1]))/60/60);
    if($lang == 'pt'){
        if($change[3] == 1){
            $change[4] = 'hora';
        }else{
            $change[4] = 'horas';
        }
    }else{
        if($change[3] == 1){
            $change[4] = 'hour';
        }else{
            $change[4] = 'hours';
        }
    }
}else{
    $change[3] = intval((strtotime($change[2]) - strtotime($change[1]))/60/60/24);
    if($lang == 'pt'){
        if($change[3] == 1){
            $change[4] = 'dia';
        }else{
            $change[4] = 'dias';
        }
    }else{
        if($change[3] == 1){
            $change[4] = 'day';
        }else{
            $change[4] = 'days';
        }
    }
}

if($change[0] == 1){
    if(((strtotime($change[2]) - strtotime($change[1]))/60) >= 60){
        mysqli_query($conn, "update administracao set online=false, pages=0, data=DATE_SUB( NOW( ) , INTERVAL 17 MINUTE ) where id=1");
    }
}

echo json_encode($change);

?>