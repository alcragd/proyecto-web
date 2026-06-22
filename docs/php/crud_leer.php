<?php
require_once("connection.php");

$query = "SELECT a.boleta, a.nombre, a.pat, a.mat, a.esc_pro, a.prom, l.nombre as lab, h.hora_ini, h.hora_fin
          FROM alumnos a
          LEFT JOIN asignacion_examen ae ON a.boleta = ae.boleta
          LEFT JOIN laboratorio l ON ae.id_lab = l.id_lab
          LEFT JOIN horarios h ON ae.id_horario = h.id_horario";
$result = mysqli_query($conexion, $query);

while($row = mysqli_fetch_assoc($result)) {
    
    $apellidos = ($row['pat'] == 'S/A') ? "" : " " . $row['pat'] . " " . $row['mat'];
    $nombreCompleto = trim($row['nombre'] . $apellidos);
    
    $horario = ($row['hora_ini'] && $row['hora_fin']) ? substr($row['hora_ini'],0,5) . " - " . substr($row['hora_fin'],0,5) : "Sin asignar";
    $lab = $row['lab'] ? $row['lab'] : "Sin asignar";

    echo "<tr>";
    echo "<td class='fw-bold'>" . htmlspecialchars($row['boleta']) . "</td>";
    echo "<td>" . htmlspecialchars($nombreCompleto) . "</td>";
    echo "<td>" . htmlspecialchars($row['esc_pro']) . "</td>";
    echo "<td>" . htmlspecialchars($row['prom']) . "</td>";
    echo "<td>" . htmlspecialchars($lab) . "</td>";
    echo "<td>" . htmlspecialchars($horario) . "</td>";
    echo "<td>
            <button class='btn btn-sm btn-outline-secondary me-1 btn-editar' data-boleta='".$row['boleta']."' data-bs-toggle='modal' data-bs-target='#modalCrudAlumno' title='Editar'><i class='bi bi-pencil-square'></i></button>
            <button class='btn btn-sm btn-outline-danger btn-eliminar' data-boleta='".$row['boleta']."' title='Eliminar'><i class='bi bi-trash3'></i></button>
          </td>";
    echo "</tr>";
}
mysqli_close($conexion);
?>