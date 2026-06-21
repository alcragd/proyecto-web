<?php
header('Content-Type: application/json');
require_once("connection.php");

$boleta = $_POST['boleta'] ?? '';

$query = "SELECT a.*, ae.id_lab, ae.id_horario 
          FROM alumnos a 
          LEFT JOIN asignacion_examen ae ON a.boleta = ae.boleta 
          WHERE a.boleta = ?";
          
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "s", $boleta);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if($row = mysqli_fetch_assoc($res)){
    echo json_encode($row);
} else {
    echo json_encode(["error" => "No se localizó el expediente."]);
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>