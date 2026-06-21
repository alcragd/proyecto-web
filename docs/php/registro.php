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
        $esc_pro==="Otro" &&
        isset($_POST['nombreEscuela'])
    ){
        $esc_pro=$_POST['nombreEscuela'];
    }

    /* ======================
       INSERT usuarios
    ====================== */

    $stmtUser = mysqli_prepare(
        $conexion,
        "INSERT INTO usuarios
        (correo,password,rol)
        VALUES(?,?,?)"
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

    mysqli_commit($conexion);

    echo "Registro exitoso";

}catch(mysqli_sql_exception $e){

    mysqli_rollback($conexion);

    if($e->getCode()==1062){

        echo "El correo o boleta ya existen";

    }else{

        echo "Error interno del sistema";

        // Desarrollo:
        // echo $e->getMessage();

    }

}

mysqli_close($conexion);

?>