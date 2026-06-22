<?php

require_once("connection.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{

    mysqli_begin_transaction($conexion);

    /* ======================
       DATOS
    ====================== */

    $correo = $_POST['correo'];

    $contra = $_POST['contrasena'];
    $hash = password_hash(
        $contra,
        PASSWORD_DEFAULT
    );

    $rol = 0;

    $boleta = $_POST['boleta'];
    $nombre = $_POST['nombre'];
    $pat = $_POST['appat'];
    $mat = $_POST['apmat'];
    $fecha_nac = $_POST['fechaNacimiento'];
    $gen = $_POST['genero'];
    $curp = $_POST['curp'];
    $ent_pro = $_POST['entidadFederativa'];
    $tel = $_POST['telefono'];
    $esc_pro = $_POST['escuelaProcedencia'];
    $prom = $_POST['promedio'];

    if(
        $esc_pro === "Otro" &&
        isset($_POST['nombreEscuela'])
    ){
        $esc_pro = $_POST['nombreEscuela'];
    }

    /* ======================
       INSERT usuarios
    ====================== */

    $stmtUser = mysqli_prepare(
        $conexion,
        "INSERT INTO usuarios
        (correo, password, rol)
        VALUES(?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmtUser,
        "ssi",
        $correo,
        $hash,
        $rol
    );

    mysqli_stmt_execute($stmtUser);

    $id_usuario = mysqli_insert_id($conexion);

    /* ======================
       INSERT alumnos
    ====================== */

    $stmtAlumno = mysqli_prepare(
        $conexion,
        "INSERT INTO alumnos
        (
        boleta,
        id_usuario,
        nombre,
        pat,
        mat,
        fecha_nac,
        gen,
        curp,
        ent_pro,
        tel,
        esc_pro,
        prom
        )
        VALUES
        (?,?,?,?,?,?,?,?,?,?,?,?)"
    );

    mysqli_stmt_bind_param(
        $stmtAlumno,
        "sisssssssssd",
        $boleta,
        $id_usuario,
        $nombre,
        $pat,
        $mat,
        $fecha_nac,
        $gen,
        $curp,
        $ent_pro,
        $tel,
        $esc_pro,
        $prom
    );

    mysqli_stmt_execute($stmtAlumno);

    /* ======================
       ASIGNACIÓN DE EXAMEN
    ====================== */
    
    $queryCupos = "
        SELECT 
            l.id_lab, 
            h.id_horario, 
            (30 - COUNT(a.id_asignacion)) AS lugares_disponibles 
        FROM laboratorio l
        CROSS JOIN horarios h
        LEFT JOIN asignacion_examen a 
            ON l.id_lab = a.id_lab AND h.id_horario = a.id_horario 
        GROUP BY l.id_lab, h.id_horario
        HAVING lugares_disponibles > 0
        ORDER BY lugares_disponibles DESC, h.id_horario ASC, l.id_lab ASC
        LIMIT 1
    ";

    $resultCupos = mysqli_query($conexion, $queryCupos);

    if(mysqli_num_rows($resultCupos) === 0){
        // ya se llenaron todos los laboratorios en todos los horarios
        throw new Exception("Ya no hay cupos disponibles para realizar el examen.", 9999);
    }

    $rowCupos = mysqli_fetch_assoc($resultCupos);
    $id_lab_asignado = $rowCupos['id_lab'];
    $id_horario_asignado = $rowCupos['id_horario'];

    $stmtAsignacion = mysqli_prepare(
        $conexion,
        "INSERT INTO asignacion_examen (boleta, id_lab, id_horario) VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmtAsignacion,
        "sii",
        $boleta,
        $id_lab_asignado,
        $id_horario_asignado
    );

    mysqli_stmt_execute($stmtAsignacion);

    /* ======================
       CONFIRMAR TRANSACCIÓN
    ====================== */

    mysqli_commit($conexion);

    echo "Registro exitoso";

} catch(mysqli_sql_exception $e){

    mysqli_rollback($conexion);

    if($e->getCode() == 1062){
        echo "El correo o boleta ya existen";
    }else{
        echo "Error interno de la base de datos";
        // Desarrollo:
        // echo $e->getMessage();
    }

} catch(Exception $e) {
    // Captura la excepción personalizada de falta de cupos
    mysqli_rollback($conexion);

    if($e->getCode() == 9999){
        echo $e->getMessage();
    }else{
        echo "Error interno del sistema";
    }
}

mysqli_close($conexion);

?>