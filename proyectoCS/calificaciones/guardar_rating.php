<?php
session_start();
require_once __DIR__ . '/../articulos/db_conexion.php';

// 1) Validar sesión
if (!isset($_SESSION['session_id_usuario'])) {
    die("Debe iniciar sesión para calificar.");
}

$idUsuario = (int)$_SESSION['session_id_usuario'];

// 2) Leer datos del form
$isbn      = $_POST['isbn'] ?? '';
$estrellas = $_POST['estrellas'] ?? '';
$resena    = $_POST['resena'] ?? null;

$isbn = trim($isbn);
$resena = $resena !== null ? trim($resena) : null;

// 3) Validaciones básicas
if ($isbn === '' || $estrellas === '') {
    die("Faltan datos.");
}

$estrellas = (int)$estrellas;
if ($estrellas < 1 || $estrellas > 5) {
    die("Estrellas inválidas.");
}

// 4) Insert / Update (requiere UNIQUE (fk_id_usuario, fk_isbn) como ya tenés)
$sql = "INSERT INTO rating_libro (fk_id_usuario, fk_isbn, estrellas, resena)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            estrellas = VALUES(estrellas),
            resena    = VALUES(resena)";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    die("Error preparando SQL: " . $conexion->error);
}

$stmt->bind_param("isis", $idUsuario, $isbn, $estrellas, $resena);

if (!$stmt->execute()) {
    die("Error guardando: " . $stmt->error);
}

$stmt->close();
$conexion->close();

// 5) Volver al detalle
header("Location: libro_detalle.php?isbn=" . urlencode($isbn));
exit;
