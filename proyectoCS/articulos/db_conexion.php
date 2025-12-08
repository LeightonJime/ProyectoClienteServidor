<?php
$servidor = "127.0.0.1";
$puerto   = 3307;           // si usas este puerto
$usuario_db = "Adminbiblio";
$contrasena_db = "biblio123";
$nombre_db = "biblioheredia";

$conexion = new mysqli($servidor, $usuario_db, $contrasena_db, $nombre_db, $puerto);


// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");
?>
