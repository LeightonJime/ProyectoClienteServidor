<?php
include 'conn.php';
$username = $_POST['username'];
$email = $_POST['email'];
$password_plano = $_POST['password'];
$password_hash = password_hash($password_plano, PASSWORD_DEFAULT);
$sql = "INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $username, $email, $password_hash);

if ($stmt->execute()) { 
    echo "¡Cuenta creada exitosamente!";
} else {
    echo "Error al crear la cuenta: " . $conexion->error;
}

$stmt->close();
$conexion->close();
?>