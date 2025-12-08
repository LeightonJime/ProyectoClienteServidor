<?php
require_once 'db_conexion.php';

// 1) Validar que venga un ISBN por GET

if (!isset($_GET['isbn'])) {
    die("Falta el parámetro ISBN.");
}
$isbn = $_GET['isbn'];


// 2) Obtener los datos del libro
$sqlLibro = "SELECT isbn, titulo, escritor, estado
             FROM libro
             WHERE isbn = ?";
$stmtLibro = $conexion->prepare($sqlLibro);
$stmtLibro->bind_param("s", $isbn);
$stmtLibro->execute();
$resultLibro = $stmtLibro->get_result();

if ($resultLibro->num_rows === 0) {
    die("El libro no existe.");
}

$libro = $resultLibro->fetch_assoc();

if ($libro['estado'] !== 'DISPONIBLE') {
    die("Este libro ya está reservado o no disponible.");
}

// 3) Si el formulario fue enviado (POST), procesar la reserva
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? "");
    $correo = trim($_POST['correo'] ?? "");

    if ($nombre === "" || $correo === "") {
        $mensaje = "Por favor complete todos los campos.";
    } else {
        // Insertar en tabla reserva
        $sqlReserva = "INSERT INTO reserva (isbn, nombre, correo)
                       VALUES (?, ?, ?)";
        $stmtRes = $conexion->prepare($sqlReserva);
        $stmtRes->bind_param("sss", $isbn, $nombre, $correo);
        $stmtRes->execute();

        // Marcar el libro como RESERVADO
        $sqlUpdate = "UPDATE libro
                      SET estado = 'RESERVADO'
                      WHERE isbn = ?";
        $stmtUpd = $conexion->prepare($sqlUpdate);
        $stmtUpd->bind_param("s", $isbn);
        $stmtUpd->execute();

        $mensaje = "¡Reserva realizada con éxito! Puede pasar a recoger el libro en la biblioteca.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reservar libro</title>
  <link rel="stylesheet" href="css/articulos.css">
</head>
<body>

<h1>Reservar libro</h1>

<h2><?php echo htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8'); ?></h2>
<p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['escritor'], ENT_QUOTES, 'UTF-8'); ?></p>

<?php if ($mensaje !== "" && strpos($mensaje, "éxito") !== false): ?>
  <p style="color:green;"><?php echo $mensaje; ?></p>
  <p><a href="articulos.php">Volver a la lista de libros disponibles</a></p>
<?php else: ?>

  <?php if ($mensaje !== ""): ?>
    <p style="color:red;"><?php echo $mensaje; ?></p>
  <?php endif; ?>

  <form method="post">
    <label>
      Nombre completo:<br>
      <input type="text" name="nombre" required>
    </label>
    <br><br>
    <label>
      Correo electrónico:<br>
      <input type="email" name="correo" required>
    </label>
    <br><br>
    <button type="submit">Confirmar reserva</button>
  </form>

<?php endif; ?>

</body>
</html>
