<?php
    session_start();
    require_once("connection.php");

    if(!isset($_SESSION["boleta"])){
        echo "Error de sesión.";
        exit;
    }

    $boleta = $_SESSION["boleta"];

    $sql = "SELECT l.nombre AS lab_nombre, h.hora_ini, h.hora_fin 
            FROM asignacion_examen ae 
            INNER JOIN laboratorio l ON ae.id_lab = l.id_lab
            INNER JOIN horarios h ON ae.id_horario = h.id_horario
            WHERE ae.boleta = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $boleta);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $datos = mysqli_fetch_assoc($res);

    if($datos) {
        // Generamos el HTML directamente aquí
        echo '
            <div class="col-12 col-md-6 mt-2">
                <div class="ticket-label"><i class="bi bi-geo-alt-fill me-1"></i> Laboratorio Asignado</div>
                <div class="ticket-data text-escom">' . htmlspecialchars($datos['lab_nombre']) . '</div>
            </div>
            <div class="col-12 col-md-6 mt-2">
                <div class="ticket-label"><i class="bi bi-clock-fill me-1"></i> Horario de Examen</div>
                <div class="ticket-data text-escom">' . htmlspecialchars($datos['hora_ini'] . ' - ' . $datos['hora_fin']) . ' hrs</div>
            </div>
        ';
    } else {
        echo "<div>No hay asignación disponible.</div>";
    }
    mysqli_close($conexion);
?>