<?php
    $cadena_connexio = 'mysql:dbname=eduhacks;host=localhost:3306';
    $usuari = 'root';
    $passwd = '173240';
    try{
        //Ens connectem a la BDs
        $db = new PDO($cadena_connexio, $usuari, $passwd);
    }catch(PDOException $e){
        echo 'Error amb la BDs: ' . $e->getMessage();
    }
?>