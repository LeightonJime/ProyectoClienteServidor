<?php
// para que esto funcione el db_conexion ya debio agregarsele el puerto correcto segun su computadora
require_once 'articulos/db_conexion.php';

header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT titulo, subtitulo, imagen FROM libros_destacados ORDER BY id ASC";
$resultado = $conexion->query($sql);

$libros = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $libros[] = $fila;
    }
}

// Devuelve un arreglo JSON como:
// [ { "titulo": "...", "subtitulo": "...", "imagen": "..." }, ... ]
echo json_encode($libros, JSON_UNESCAPED_UNICODE);
