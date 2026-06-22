<?php
require_once("connection.php");


$accion = $_POST['accion'] ?? 'crear';
$boleta = $_POST['boleta'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$pat = $_POST['pat'] ?? '';
$mat = $_POST['mat'] ?? '';
$curp = strtoupper($_POST['curp'] ?? '');
$tel = $_POST['tel'] ?? '';
$fecha_nac = $_POST['fecha_nac'] ?? '';
$gen = $_POST['genero'] ?? '';
$ent_pro = $_POST['ent_pro'] ?? '';
$esc_pro = $_POST['esc_pro'] ?? '';
$prom = $_POST['prom'] ?? 0.0;
$id_lab = $_POST['laboratorio'] ?? '';
$id_horario = $_POST['horario'] ?? '';
$correo = $_POST['correo'] ?? '';       
$contra = $_POST['contrasena'] ?? '';   

$nombreEscuela = $_POST['nombreEscuela'] ?? '';
if($esc_pro === 'Otro') {
    $esc_pro = trim($nombreEscuela);
}


if(empty($boleta) || empty($nombre) || empty($pat) || empty($mat)) {
    echo "Error: Faltan campos obligatorios del expediente.";
    exit;
}


if($accion === 'editar') {
    $sqlAlum = "UPDATE alumnos SET nombre=?, pat=?, mat=?, fecha_nac=?, gen=?, curp=?, ent_pro=?, tel=?, esc_pro=?, prom=? WHERE boleta=?";
    $stmtAlum = mysqli_prepare($conexion, $sqlAlum);
    mysqli_stmt_bind_param($stmtAlum, "sssssssssds", $nombre, $pat, $mat, $fecha_nac, $gen, $curp, $ent_pro, $tel, $esc_pro, $prom, $boleta);
    mysqli_stmt_execute($stmtAlum);
    mysqli_stmt_close($stmtAlum);

    $stmtCheck = mysqli_prepare($conexion, "SELECT * FROM asignacion_examen WHERE boleta = ?");
    mysqli_stmt_bind_param($stmtCheck, "s", $boleta);
    mysqli_stmt_execute($stmtCheck);
    $resCheck = mysqli_stmt_get_result($stmtCheck);

    if(mysqli_num_rows($resCheck) > 0) {
        $stmtAsign = mysqli_prepare($conexion, "UPDATE asignacion_examen SET id_lab = ?, id_horario = ? WHERE boleta = ?");
        mysqli_stmt_bind_param($stmtAsign, "iis", $id_lab, $id_horario, $boleta);
    } else {
        $stmtAsign = mysqli_prepare($conexion, "INSERT INTO asignacion_examen (boleta, id_lab, id_horario) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmtAsign, "sii", $boleta, $id_lab, $id_horario);
    }
    mysqli_stmt_execute($stmtAsign);
    mysqli_stmt_close($stmtAsign);
    
    echo "success";



} else if($accion === 'crear') {
    
    
    $stmtVerificar = mysqli_prepare($conexion, "SELECT boleta FROM alumnos WHERE boleta = ?");
    mysqli_stmt_bind_param($stmtVerificar, "s", $boleta);
    mysqli_stmt_execute($stmtVerificar);
    mysqli_stmt_store_result($stmtVerificar);
    
    if(mysqli_stmt_num_rows($stmtVerificar) > 0) {
        echo "Error: El número de boleta '$boleta' ya se encuentra registrado en el sistema.";
        mysqli_stmt_close($stmtVerificar);
        exit;
    }
    mysqli_stmt_close($stmtVerificar);
    
    $stmtVerificarCorreo = mysqli_prepare($conexion, "SELECT correo FROM usuarios WHERE correo = ?");
    mysqli_stmt_bind_param($stmtVerificarCorreo, "s", $correo);
    mysqli_stmt_execute($stmtVerificarCorreo);
    mysqli_stmt_store_result($stmtVerificarCorreo);
    
    if(mysqli_stmt_num_rows($stmtVerificarCorreo) > 0) {
        echo "Error: El correo '$correo' ya está en uso por otra cuenta en el sistema.";
        mysqli_stmt_close($stmtVerificarCorreo);
        exit;
    }
    mysqli_stmt_close($stmtVerificarCorreo);


    $passHash = password_hash($contra, PASSWORD_DEFAULT);
    $rolAlumno = 0;

    $stmtUser = mysqli_prepare($conexion, "INSERT INTO usuarios (correo, password, rol) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmtUser, "ssi", $correo, $passHash, $rolAlumno);
    
    if(mysqli_stmt_execute($stmtUser)) {
        $id_usuario = mysqli_insert_id($conexion);
        mysqli_stmt_close($stmtUser);

        $sqlInsertAlum = "INSERT INTO alumnos (boleta, id_usuario, nombre, pat, mat, fecha_nac, gen, curp, ent_pro, tel, esc_pro, prom) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtAlum = mysqli_prepare($conexion, $sqlInsertAlum);
        mysqli_stmt_bind_param($stmtAlum, "sisssssssssd", $boleta, $id_usuario, $nombre, $pat, $mat, $fecha_nac, $gen, $curp, $ent_pro, $tel, $esc_pro, $prom);
        mysqli_stmt_execute($stmtAlum);
        mysqli_stmt_close($stmtAlum);

        $stmtAsign = mysqli_prepare($conexion, "INSERT INTO asignacion_examen (boleta, id_lab, id_horario) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmtAsign, "sii", $boleta, $id_lab, $id_horario);
        mysqli_stmt_execute($stmtAsign);
        mysqli_stmt_close($stmtAsign);

        echo "success";
    } else {
        echo "Error interno: No se pudo generar la cuenta de usuario.";
    }
}

mysqli_close($conexion);
?>