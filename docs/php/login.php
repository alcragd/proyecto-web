<?php
session_start();

require_once("connection.php");

/* ======================
   VALIDAR CAPTCHA PRIMERO
   ====================== */

$secretKey = "6LeeNyktAAAAAOOphIqMJeqVKh1C9_QXMTSpx5Hw";

$captcha = $_POST['g-recaptcha-response'] ?? '';

// if(empty($captcha)){
//     echo "Error: Por favor completa el Captcha.";
//     exit; // Usamos exit para detener el script aquí
// }

$url = "https://www.google.com/recaptcha/api/siteverify";

$data = [
    'secret' => $secretKey,
    'response' => $captcha,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    ]
];

$context = stream_context_create($options);

$result = file_get_contents($url,false,$context);

$verify = json_decode($result);

// if(!$verify->success){
//     echo "Error: Captcha inválido. Intenta de nuevo.";
//     exit;
// }

/* ======================
   LOGIN
   ====================== */

$correo = $_POST["correo"];
$contra = $_POST["contrasena"];


/* Consulta segura */
$stmt = mysqli_prepare(
    $conexion,
    "SELECT *
     FROM usuarios
     WHERE correo=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $correo
);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado) > 0){

    $datos = mysqli_fetch_assoc($resultado);

    if(password_verify($contra,$datos['password'])){

        $_SESSION['usuario'] = $datos['correo'];
        $_SESSION['rol'] = $datos['rol'];

        echo $datos['rol'];

    }else{
        echo "Contraseña incorrecta";
    }

} else{

    echo "Correo o contraseña incorrectos";

}

mysqli_close($conexion);

?>