<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "registro";
    $conexion = mysqli_connect($server, $username, $password, $db);
    
    if(mysqli_connect_errno()){
        die ("No se puede conectar a la BD: " . mysqli_connect_error());
    }
    
    // Forzamos la codificación para que acepte acentos y la ñ sin romperse
    mysqli_set_charset($conexion, "utf8mb4");
?>