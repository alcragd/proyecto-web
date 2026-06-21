<?php
require_once("connection.php");
$boleta = $_POST['boleta'] ?? '';

// Primero buscamos a qué usuario le pertenece esa boleta
$query = "SELECT id_usuario FROM alumnos WHERE boleta = '$boleta'";
$res = mysqli_query($conexion, $query);

if($row = mysqli_fetch_assoc($res)){
    $id = $row['id_usuario'];
    
    // Al borrar la cuenta, el "ON DELETE CASCADE" que configuraste en tu SQL borra al alumno y su examen asignado automáticamente
    if(mysqli_query($conexion, "DELETE FROM usuarios WHERE id_usuario = '$id'")){
        echo "success";
    } else {
        echo "Error al eliminar de la base de datos.";
    }
} else {
    echo "No se encontró el alumno en los registros.";
}
mysqli_close($conexion);
?>