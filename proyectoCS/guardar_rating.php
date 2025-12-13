<?php
session_start();
require 'conn.php';  

// Verificar sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "Debe iniciar sesión.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido.";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$isbn       = $_POST['isbn'] ?? '';
$estrellas  = (int)($_POST['estrellas'] ?? 0);
$resena     = $_POST['resena'] ?? '';

if ($isbn == '' || $estrellas < 1 || $estrellas > 5) {
    echo "Datos inválidos.";
    exit;
}

// Insertar o actualizar (si ya calificó ese libro)
$sql = "INSERT INTO rating_libros (fk_id_usuario, fk_isbn, estrellas, resena)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
          estrellas = VALUES(estrellas),
          resena    = VALUES(resena)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("isis", $id_usuario, $isbn, $estrellas, $resena);

if ($stmt->execute()) {
    header("Location: libro_detalle.php?isbn=" . urlencode($isbn));
    exit;
} else {
    echo "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
