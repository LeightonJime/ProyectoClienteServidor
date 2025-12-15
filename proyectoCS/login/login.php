<?php
$servidor = "127.0.0.1";
$puerto   = 3307;           // si usas este puerto
$usuario_db = "Adminbiblio";
$contrasena_db = "biblio123";
$nombre_db = "biblioheredia";

// Validación básica
if (!isset($_POST['email'], $_POST['password'])) {
    die("Error: Formulario incompleto.");
}

$email = trim($_POST['email']);
$password = $_POST['password'];

// Consulta preparada
$sql = "SELECT id_usuario, username, password FROM usuarios WHERE email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si existe el usuario
if ($row = $result->fetch_assoc()) {

    // Verificar contraseña encriptada
    if (password_verify($password, $row['password'])) {

        // Crear variables de sesión
        $_SESSION['session_id_usuario'] = $row['id_usuario'];
        $_SESSION['session_usuario_nombre'] = $row['username'];

        // Redirigir al inicio
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
