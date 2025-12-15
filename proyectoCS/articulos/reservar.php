<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$nombreSesion = $_SESSION['session_usuario_nombre'] ?? '';
$emailSesion  = $_SESSION['session_usuario_email'] ?? '';
$idUsuario    = $_SESSION['session_id_usuario'] ?? null;
// ✅ REQUERIR LOGIN PARA RESERVAR
if (empty($idUsuario)) {
    // opcional: guardar a dónde quería ir
    $_SESSION['redirect_after_login'] = "../reservas/reservar.php?isbn=" . urlencode($_GET['isbn'] ?? '');
    header("Location: ../login/login.html");
    exit();
}

?>

<?php
require_once __DIR__ . '/../articulos/db_conexion.php';

// 1) Validar ISBN
if (!isset($_GET['isbn'])) {
    die("Falta el parámetro ISBN.");
}
$isbn = $_GET['isbn'];

// 2) Obtener datos del libro
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

// 3) Procesar reserva
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = ($nombreSesion !== '') ? $nombreSesion : trim($_POST['nombre'] ?? '');
    $correo = ($emailSesion  !== '') ? $emailSesion  : trim($_POST['correo'] ?? '');

    if ($nombre === "" || $correo === "") {
        $mensaje = "Por favor complete nombre y correo.";
    } else {

        $sqlReserva = "INSERT INTO reserva (isbn, nombre, correo)
                       VALUES (?, ?, ?)";
        $stmtRes = $conexion->prepare($sqlReserva);
        $stmtRes->bind_param("sss", $isbn, $nombre, $correo);
        $stmtRes->execute();

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
  <title>Reservar libro - Biblioteca Pública de Heredia</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS globales -->
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../icomoon/icomoon.css">
  <link rel="stylesheet" href="../css/vendor.css">
  <link rel="stylesheet" href="../style.css">
</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Header Wrap (mismo look del sitio) -->
  <div id="header-wrap">

    <div class="top-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="social-links">
              <ul>
                <li><a href="#"><i class="icon icon-facebook"></i></a></li>
                <li><a href="#"><i class="icon icon-twitter"></i></a></li>
                <li><a href="#"><i class="icon icon-youtube-play"></i></a></li>
                <li><a href="#"><i class="icon icon-behance-square"></i></a></li>
              </ul>
            </div>
          </div>

          <div class="col-md-6">
           <div class="right-element">
  <div id="session-area" data-endpoint="../login/header_session.php?base=../"></div>

</div>

          </div>

        </div>
      </div>
    </div>

    <header id="header">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-2">
            <div class="main-logo">
              <a href="../index.html"><img src="../images/main-logo.png" alt="logo"></a>
            </div>
          </div>

          <div class="col-md-10">
            <nav id="navbar">
              <div class="main-menu stellarnav">
                <ul class="menu-list">
                  <li class="menu-item"><a href="../index.html#home" class="nav-link">Inicio</a></li>
                  <li class="menu-item"><a href="../index.html#featured-books" class="nav-link">Destacados</a></li>
                  <li class="menu-item"><a href="../index.html#popular-books" class="nav-link">Populares</a></li>
                  <li class="menu-item"><a href="../libros/Anuncio.html" class="nav-link">Ofertas</a></li>
                  <li class="menu-item"><a href="../articulos/articulos.php" class="nav-link">Libros</a></li>
                  <li class="menu-item"><a href="../calificaciones/calificaciones.php" class="nav-link">Calificaciones</a></li>
                  </li>
                  <li class="menu-item"><a href="../tablon/Anuncio.php" class="nav-link">Anuncios y actividades</a></li>
                  

                  
                </ul>

                <div class="hamburger">
                  <span class="bar"></span>
                  <span class="bar"></span>
                  <span class="bar"></span>
                </div>

              </div>
            </nav>
          </div>

        </div>
      </div>
    </header>

  </div><!-- /#header-wrap -->

<!-- CONTENIDO -->
<main class="padding-medium">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-8 col-xl-6 mx-auto">

        <h2 class="mb-1">Reservar libro</h2>
        <p class="text-muted mb-4">
          <?php echo htmlspecialchars($libro['titulo']); ?> —
          <?php echo htmlspecialchars($libro['escritor']); ?>
        </p>

        <?php if ($mensaje !== "" && str_contains($mensaje, "éxito")): ?>

          <div class="alert alert-success">
            <?php echo $mensaje; ?>
          </div>

          <a href="../articulos/articulos.php" class="btn btn-secondary btn-sm">
            Volver a libros
          </a>

        <?php else: ?>

          <?php if ($mensaje !== ""): ?>
            <div class="alert alert-danger">
              <?php echo $mensaje; ?>
            </div>
          <?php endif; ?>

         <form method="post">

  <div class="mb-3">
    <label class="form-label">Nombre completo</label>
    <input type="text"
       name="nombre"
       class="form-control"
       value="<?php echo htmlspecialchars($nombreSesion); ?>"
       <?php echo ($nombreSesion !== '') ? 'readonly' : 'required'; ?>>

  </div>

  <div class="mb-3">
    <label class="form-label">Correo electrónico</label>
    <input type="email"
       name="correo"
       class="form-control"
       value="<?php echo htmlspecialchars($emailSesion); ?>"
       <?php echo ($emailSesion !== '') ? 'readonly' : 'required'; ?>>

  </div>

  <button type="submit" class="btn btn-primary">
    Confirmar reserva
  </button>

</form>



        <?php endif; ?>

      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/script.js"></script>
<script src="../js/session-header.js"></script>



</body>
</html>

<?php $conexion->close(); ?>
