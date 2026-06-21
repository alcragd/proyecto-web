<?php
    session_start();
    require_once("connection.php");

    if(!isset($_SESSION["boleta"])){
        echo "Error de sesión.";
        exit;
    }

    $boleta = $_SESSION["boleta"];

    // Nueva consulta: Unimos la tabla de alumnos para obtener el nombre
    $sql = "SELECT a.nombre, a.pat, a.mat, l.nombre AS lab_nombre, h.hora_ini, h.hora_fin 
            FROM alumnos a
            LEFT JOIN asignacion_examen ae ON a.boleta = ae.boleta
            LEFT JOIN laboratorio l ON ae.id_lab = l.id_lab
            LEFT JOIN horarios h ON ae.id_horario = h.id_horario
            WHERE a.boleta = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $boleta);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $datos = mysqli_fetch_assoc($res);

    if($datos) {
        // Concatenar nombre completo
        $nombreCompleto = htmlspecialchars($datos['nombre'] . ' ' . $datos['pat'] . ' ' . $datos['mat']);
        
        // --- AQUÍ IMPRIMES EL NOMBRE ---
        echo '
            <div class="col-12 col-md-6 mb-3">
                <div class="ticket-label">Aspirante</div>
                <div class="ticket-data">' . $nombreCompleto . '</div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <div class="ticket-label">Estatus</div>
                <div class="ticket-data text-success">Registrado</div>
            </div>
        ';

        // --- AQUÍ IMPRIMES EL LABORATORIO Y HORARIO ---
        if($datos['lab_nombre']) {
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
            echo '<div class="col-12 mt-2 text-warning">Aún no tienes asignación de examen.</div>';
        }
    } else {
        echo "<div>No se encontraron datos del aspirante.</div>";
    }
    mysqli_close($conexion);
?>