<?php
// Incluir el modelo con las funciones CRUD
include_once 'crudtablon.php'; 

$error = '';

// Procesar el formulario si se envía por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Recoger y sanear datos
    $titulo = trim($_POST['a_titulo'] ?? '');
    $descripcion = trim($_POST['a_descripcion'] ?? '');
    $fecha = trim($_POST['a_fecha'] ?? '');
    $img = trim($_POST['a_img'] ?? '');
    
    // 2. Validación básica
    if (empty($titulo) || empty($descripcion) || empty($fecha)) {
        $error = "Por favor, completa todos los campos obligatorios.";
    } else {
        // 3. Llamar a la función de creación
        if (crearAnuncio($titulo, $descripcion, $fecha, $img)) {
            // Éxito: redirigir al tablón
            header("Location: tablon.php?mensaje=Anuncio creado exitosamente.");
            exit;
        } else {
            $error = "Error al guardar el anuncio en la base de datos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Anuncio</title>
    <link rel="stylesheet" href="stylestablon.css">
</head>
<body>
    <div class="container">
        <h1>Nuevo Anuncio</h1>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" class="crud-form">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="a_titulo" value="<?php echo htmlspecialchars($titulo ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="a_descripcion" required><?php echo htmlspecialchars($descripcion ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha del Anuncio:</label>
                <input type="date" id="fecha" name="a_fecha" value="<?php echo htmlspecialchars($fecha ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="img">Imagen:</label>
                <input type="text" id="img" name="a_img" value="<?php echo htmlspecialchars($img ?? ''); ?>">
            </div>
            <div class="form-actions">
                <button type="submit" class="button">Guardar Anuncio</button>
                <a href="tablon.php" class="button">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>