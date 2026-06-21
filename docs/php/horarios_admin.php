<?php
require_once("connection.php");
$id_lab = $_POST['id_lab'] ?? 0;
$boleta = $_POST['boleta'] ?? '';
$max_cupos = 30; // <- Mismo límite que arriba

// Busca horarios disponibles específicamente para el laboratorio seleccionado
$query = "SELECT h.id_horario, h.hora_ini, h.hora_fin 
            FROM horarios h 
                WHERE (SELECT COUNT(*) 
                FROM asignacion_examen ae 
                    WHERE ae.id_lab = ? 
                    AND ae.id_horario = h.id_horario 
                    AND ae.boleta != ?) < ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "isi", $id_lab, $boleta, $max_cupos);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($res)){
    $inicio = substr($row['hora_ini'], 0, 5);
    $fin = substr($row['hora_fin'], 0, 5);
    echo "<option value='".$row['id_horario']."'>".$inicio." - ".$fin." hrs</option>";
}
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>