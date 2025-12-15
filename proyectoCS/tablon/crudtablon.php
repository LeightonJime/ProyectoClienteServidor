<?php
include_once '../articulos/db_conexion.php';

/**
 * @return mysqli 
 */
function getDbConnection() {
    global $conexion;
    if (!$conexion) {
        die("No se pudo conectar con la base de datos");
    }
    return $conexion;
}

/**
 * @return array 
 */
function obtenerAnuncios() {
    $db = getDbConnection();
    $sql = "SELECT * FROM anuncio ORDER BY a_fecha ASC";
    $resultado = $db->query($sql);
    
    $anuncios = [];
    if ($resultado && $resultado->num_rows > 0) {
        while($fila = $resultado->fetch_assoc()) {
            $anuncios[] = $fila;
        }
    }
    return $anuncios;
}

/**
 * @param string $titulo
 * @param string $descripcion
 * @param string $fecha
 * @param string $img 
 * @return bool 
 */
function crearAnuncio($titulo, $descripcion, $fecha, $img) {
    $db = getDbConnection();
    $sql = "INSERT INTO anuncio (a_titulo, a_descripcion, a_fecha, a_img) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    if ($stmt === false) {
        error_log("Error al preparar la consulta de creación: " . $db->error);
        return false;
    }
    
    $stmt->bind_param("ssss", $titulo, $descripcion, $fecha, $img);
    $exito = $stmt->execute();
    $stmt->close();
    
    return $exito;
}
?>