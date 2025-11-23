<?php
$servidor = "localhost";
$usuario_db = "Adminbiblio"; 
$contrasena_db = "biblio123"; 
$nombre_db = "biblioheredia"; 
$conexion = new mysqli($servidor, $usuario_db, $contrasena_db, $nombre_db);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>

