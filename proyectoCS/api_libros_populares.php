<?php
require_once 'articulos/db_conexion.php';

header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT titulo, subtitulo, imagen FROM libros_populares ORDER BY id ASC";
$resultado = $conexion->query($sql);

$libros = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $libros[] = $fila;
    }
}

echo json_encode($libros, JSON_UNESCAPED_UNICODE);
