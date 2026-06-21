<?php
require_once("connection.php");
$boleta = $_POST['boleta'] ?? '';
$max_cupos = 30; 

// Busca laboratorios que tengan al menos un horario con lugares disponibles (ignorando a este mismo alumno si está editando)
$query = "SELECT l.id_lab, l.nombre 
            FROM laboratorio l WHERE EXISTS 
            (SELECT h.id_horario 
                FROM horarios h 
                WHERE (SELECT COUNT(*) 
                FROM asignacion_examen ae 
                    WHERE ae.id_lab = l.id_lab 
                        AND ae.id_horario = h.id_horario 
                        AND ae.boleta != ?) < ?)";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "si", $boleta, $max_cupos);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($res)){
    echo "<option value='".$row['id_lab']."'>".$row['nombre']."</option>";
}
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>