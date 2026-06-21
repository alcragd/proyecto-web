<?php
// Incluimos tu archivo de conexión original
require_once("connection.php");

// 1. Define aquí las credenciales que tendrá tu Administrador para las pruebas
$correo_admin = "admin@ipn.mx"; 
$contrasena_plana = "Admin_123"; // Contraseña en texto plano que escribirás en el login
$rol_admin = 1; // Asignamos el rol 1 que corresponde a Admin en tu sistema

// 2. Hasheamos la contraseña de manera segura utilizando el algoritmo nativo de PHP
// Esto generará la cadena de 60 caracteres necesaria para que password_verify() funcione en tu login
$contrasena_hasheada = password_hash($contrasena_plana, PASSWORD_DEFAULT);

// 3. Preparamos la consulta segura para insertar los datos en tu tabla 'usuarios'
$query = "INSERT INTO usuarios (correo, password, rol) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conexion, $query);

if ($stmt) {
    // Vinculamos los parámetros: 's' (string) para correo, 's' (string) para el hash, 'i' (integer) para el rol
    mysqli_stmt_bind_param($stmt, "ssi", $correo_admin, $contrasena_hasheada, $rol_admin);
    
    // Ejecutamos la transacción en la base de datos
    if (mysqli_stmt_execute($stmt)) {
        echo "<div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 5px; max-width: 500px; margin: 20px auto; background-color: #f9f9f9;'>";
        echo "<h3 style='color: #750946;'>¡Cuenta de Administrador creada con éxito!</h3>";
        echo "<strong>Usuario/Correo:</strong> " . htmlspecialchars($correo_admin) . "<br>";
        echo "<strong>Contraseña en texto plano:</strong> " . htmlspecialchars($contrasena_plana) . "<br><br>";
        echo "<p style='color: #d9534f; font-size: 0.9em; font-weight: bold;'>* ¡IMPORTANTE! Por seguridad de tu proyecto, elimina este archivo de tu servidor local una vez que hayas verificado el registro en phpMyAdmin.</p>";
        echo "</div>";
    } else {
        echo "Error al registrar el administrador (es probable que el correo electrónico ya esté registrado): " . mysqli_stmt_error($stmt);
    }
    
    // Cerramos el statement preparado
    mysqli_stmt_close($stmt);
} else {
    echo "Error al estructurar la consulta preparada: " . mysqli_error($conexion);
}

// Cerramos la comunicación con la base de datos
mysqli_close($conexion);
?>