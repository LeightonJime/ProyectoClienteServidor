<?php
session_start();
include '../conn.php';

// Validar datos
if (!isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm-password'])) {
    die("Error: Datos incompletos.");
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];

// Validar que las contraseñas coincidan
if ($password !== $confirm_password) {
    die("Las contraseñas no coinciden.");
}

// Verificar si ya existe un usuario con ese email
$sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    $conexion->close();
    die("El correo ya está registrado. Intenta iniciar sesión.");
}

$stmt->close();

// Encriptar la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar nuevo usuario
$sql = "INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $username, $email, $password_hash);

if ($stmt->execute()) {

    // Crear sesión automáticamente
    $_SESSION['session_id_usuario'] = $stmt->insert_id;
    $_SESSION['session_usuario_nombre'] = $username;

    // Redirigir al inicio
    header("Location: ../index.html");
    exit();

} else {
    echo "Error al crear la cuenta: " . $conexion->error;
}

$stmt->close();
$conexion->close();
?>
