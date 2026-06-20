<?php
require_once("connection.php");

    
    $correo = $_POST["correo"];
    $contra = $_POST["contrasena"];
    

    $query = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($conexion, $query);

    if(mysqli_num_rows($resultado) > 0){
        $datos = mysqli_fetch_assoc($resultado);
        
        if(password_verify($contra,$datos['password']))
        {
            if($datos['rol'] == 1){
            echo "¡Bienvenido Administrador!";
        } else {
            echo "¡Bienvenido! Has iniciado sesión correctamente.";
        }
        }
        else {
        echo "Error: Contraseña incorrecta.";
        }
    } else {
        echo "Error: Correo o contraseña incorrectos.";
    }

    mysqli_close($conexion);

$secretKey = "6LeeNyktAAAAAOOphIqMJeqVKh1C9_QXMTSpx5Hw";

$captcha = $_POST['g-recaptcha-response'];

if(empty($captcha)){
    die("Captcha vacío");
}

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

$result = file_get_contents($url, false, $context);

$verify = json_decode($result);

if($verify->success){
    
    echo "Captcha Valido";
}else{
    echo "Captcha inválido";
}
?>