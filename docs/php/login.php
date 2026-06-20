<?php

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
    
    echo "Formulario válido";
}else{
    echo "Captcha inválido";
}
?>