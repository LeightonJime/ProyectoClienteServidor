<?php
session_start();
include '../articulos/db_conexion.php';

if (!isset($_POST['email'], $_POST['password'])) {
    die("Error: Formulario incompleto.");
}

$email = trim($_POST['email']);
$password = $_POST['password'];

$sql = "SELECT id_usuario, username, email, password FROM usuarios WHERE email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    if (password_verify($password, $row['password'])) {

        $_SESSION['session_id_usuario']      = $row['id_usuario'];
        $_SESSION['session_usuario_nombre']  = $row['username'];
        $_SESSION['session_usuario_email']   = $row['email'];

        header("Location: ../index.html");
        exit();

    } else {
        echo "Contraseña incorrecta.";
    }

} else {
    echo "No se encontró un usuario con ese email.";
}

$stmt->close();
$conexion->close();
?>
