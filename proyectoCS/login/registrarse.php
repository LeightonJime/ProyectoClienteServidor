<?php
session_start();
include '../articulos/db_conexion.php';


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

    $newId = $conexion->insert_id; // id real insertado

    // Volver a leer el usuario recién creado (infalible)
    $sql2 = "SELECT id_usuario, username, email FROM usuarios WHERE id_usuario = ?";
    $stmt2 = $conexion->prepare($sql2);
    $stmt2->bind_param("i", $newId);
    $stmt2->execute();
    $user = $stmt2->get_result()->fetch_assoc();
    $stmt2->close();

    // Crear sesión automáticamente (completa)
    $_SESSION['session_id_usuario']     = $user['id_usuario'];
    $_SESSION['session_usuario_nombre'] = $user['username'];
    $_SESSION['session_usuario_email']  = $user['email'];

    // (Opcional recomendado) asegurar que se escriba la sesión antes del redirect
    session_write_close();

    header("Location: ../index.html");
    exit();

} else {
    echo "Error al crear la cuenta: " . $conexion->error;
}


$stmt->close();
$conexion->close();
?>
