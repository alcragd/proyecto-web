<?php
require_once("connection.php");


$correo_admin = "admin@ipn.mx"; 
$contrasena_plana = "Admin_123"; 
$rol_admin = 1; 


$contrasena_hasheada = password_hash($contrasena_plana, PASSWORD_DEFAULT);

$query = "INSERT INTO usuarios (correo, password, rol) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conexion, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssi", $correo_admin, $contrasena_hasheada, $rol_admin);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 5px; max-width: 500px; margin: 20px auto; background-color: #f9f9f9;'>";
        echo "<h3 style='color: #750946;'>¡Cuenta de Administrador creada con éxito!</h3>";
        echo "<strong>Usuario/Correo:</strong> " . htmlspecialchars($correo_admin) . "<br>";
        echo "<strong>Contraseña en texto plano:</strong> " . htmlspecialchars($contrasena_plana) . "<br><br>";
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