<?php
    require_once("connection.php");
    $conexion = mysqli_connect($server,$username,$password,$db);
    // 1. Recibir datos de Cuenta
    $correo = $_POST['correo'];

    $contra = $_POST['contrasena'];
    $hash = password_hash($contra, PASSWORD_DEFAULT);

    $rol = 0; // 0 para alumno

    // 2. Recibir Datos Personales y Procedencia
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

    // Lógica para atrapar el nombre de la escuela si seleccionó "Otro"
    if ($esc_pro === "Otro" && isset($_POST['nombreEscuela'])) {
        $esc_pro = $_POST['nombreEscuela'];
    }

    // --- PRIMERA INSERCIÓN: TABLA USUARIOS ---
    $queryUser = "INSERT INTO usuarios (correo, password, rol) VALUES ('$correo', '$hash', $rol)";
    
    if(mysqli_query($conexion, $queryUser)){
        
        // Recuperamos el id_usuario que se acaba de crear automáticamente por el AUTO_INCREMENT
        $id_usuario = mysqli_insert_id($conexion);

        // --- SEGUNDA INSERCIÓN: TABLA ALUMNOS ---
        $queryAlumno = "INSERT INTO alumnos (boleta, id_usuario, nombre, pat, mat, fecha_nac, gen, curp, ent_pro, tel, esc_pro, prom) 
                        VALUES ('$boleta', $id_usuario, '$nombre', '$pat', '$mat', '$fecha_nac', '$gen', '$curp', '$ent_pro', '$tel', '$esc_pro', $prom)";
        
        if(mysqli_query($conexion, $queryAlumno)){
            echo "Registro exitoso. Tu información se guardó correctamente en el sistema.";
        } else {
            echo "Error al guardar el alumno: " . mysqli_error($conexion);
        }

    } else {
        echo "Error al crear la cuenta (Es probable que el correo ya exista): " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
?>