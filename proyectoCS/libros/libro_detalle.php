<?php
session_start();
include '../articulos/db_conexion.php';

$isbn = $_GET['isbn'] ?? '';

if ($isbn == '') {
    echo "Libro no encontrado.";
    exit;
}

// Datos del libro + promedio
$sql = "SELECT l.*, 
               AVG(r.estrellas) AS promedio,
               COUNT(r.id_rating) AS total
        FROM libro l
        LEFT JOIN rating_libros r ON l.isbn = r.fk_isbn
        WHERE l.isbn = ?
        GROUP BY l.isbn";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $isbn);
$stmt->execute();
$result = $stmt->get_result();
$libro  = $result->fetch_assoc();

if (!$libro) {
    echo "Libro no encontrado.";
    exit;
}

$promedio = $libro['promedio'] ?? 0;
$total    = $libro['total'] ?? 0;

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($libro['titulo']); ?></title>
</head>
<body>

<h1><?php echo htmlspecialchars($libro['titulo']); ?></h1>
<p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['escritor']); ?></p>
<p><strong>Año:</strong> <?php echo htmlspecialchars($libro['anno']); ?></p>
<p><strong>Descripción:</strong> <?php echo htmlspecialchars($libro['descr']); ?></p>

<hr>

<h2>Rating</h2>
<p>
    Promedio: 
    <?php echo $total > 0 ? number_format($promedio, 1) . " / 5" : "Sin calificaciones"; ?>
    <?php if ($total > 0) echo " ({$total} opiniones)"; ?>
</p>

<?php if (isset($_SESSION['id_usuario'])): ?>
    <h3>Calificar este libro</h3>
    <form action="guardar_rating.php" method="post">
        <input type="hidden" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>">

        <label>Estrellas:</label>
        <select name="estrellas" required>
            <option value="">Seleccione</option>
            <option value="1">1 ⭐</option>
            <option value="2">2 ⭐⭐</option>
            <option value="3">3 ⭐⭐⭐</option>
            <option value="4">4 ⭐⭐⭐⭐</option>
            <option value="5">5 ⭐⭐⭐⭐⭐</option>
        </select>
        <br><br>

        <label>Reseña (opcional):</label><br>
        <textarea name="resena" rows="4" cols="40"></textarea>
        <br><br>

        <button type="submit">Guardar</button>
    </form>
<?php else: ?>
    <p>Debe iniciar sesión para dejar una calificación.</p>
<?php endif; ?>

</body>
</html>
