<?php
include 'conn.php';
session_start();
$email = $_POST['email'];
$password = $_POST['password'];
$sql = "SELECT id_usuario, username, password FROM usuarios WHERE email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['session_id_usuario'] = $row['id_usuario'];        
        $_SESSION['session_usuario_nombre'] = $row['username'];        
        echo "Bienvenido, " . $row['username'];    } else {
        echo "Contraseña incorrecta.";    }
} else {
    echo "No se encontró el usuario.";}

$stmt->close();
$conexion->close();
?>