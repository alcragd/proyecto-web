<?php
    $conexion = mysqli_connect("localhost", "root", "");

    $sql = "DROP DATABASE registro";
    mysqli_query($conexion, $sql);
?>