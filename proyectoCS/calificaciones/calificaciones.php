<?php
session_start();
require_once __DIR__ . '/../articulos/db_conexion.php';

$sql = "SELECT isbn, titulo, escritor, anno FROM libro ORDER BY titulo ASC";
$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Calificaciones - Biblioteca Pública de Heredia</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap (opcional, pero ayuda con spacing) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS globales del sitio -->
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../icomoon/icomoon.css">
  <link rel="stylesheet" type="text/css" href="../css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">

  <!-- jQuery (para tu menú/script.js) -->
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
              <a href="../login/login.html">Cuenta</a>

              <div class="action-menu">
                <div class="search-bar">
                  <a href="#" class="search-button search-toggle" data-selector="#header-wrap">
                    <i class="icon icon-search"></i>
                  </a>
                  <form role="search" method="get" class="search-box">
                    <input class="search-field text search-input" placeholder="Buscar" type="search">
                  </form>
                </div>
              </div>

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
                  <li class="menu-item"><a href="../index.html#special-offer" class="nav-link">Ofertas</a></li>
                  <li class="menu-item"><a href="../articulos/articulos.php" class="nav-link">Libros</a></li>
                  <!-- Página actual -->
                  <li class="menu-item active">
                    <a href="calificaciones.php" class="nav-link">Calificaciones</a>
                  </li>
                  <li class="menu-item"><a href="../libros/Anuncio.html" class="nav-link">Anuncios y actividades</a></li>
                  

                  
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

  <!-- Contenido -->
  <main class="padding-medium">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-10 col-xl-8 mx-auto">

          <h2 class="mb-2">Calificaciones de libros</h2>
          <p class="mb-4">Entrá a un libro para ver opiniones y dejar tu calificación.</p>

          <?php if (!isset($_SESSION['session_id_usuario'])): ?>
            <div class="alert alert-warning">
              <strong>Nota:</strong> Para calificar debes iniciar sesión.
            </div>
          <?php endif; ?>

          <div class="table-responsive">
            <table class="table table-hover align-middle calificaciones-table">

              <thead>
                <tr>
                  <th>Título</th>
                  <th>Autor</th>
                  <th>Año</th>
                  <th style="width:160px;">Acción</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                  <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                      <td><?php echo htmlspecialchars($row['escritor']); ?></td>
                      <td><?php echo htmlspecialchars($row['anno']); ?></td>
                      <td>
                        <a class="btn btn-calificar btn-sm"

                           href="libro_detalle.php?isbn=<?php echo urlencode($row['isbn']); ?>">
                          Ver / Calificar
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4">No hay libros cargados en la base de datos.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/script.js"></script>

  <?php $conexion->close(); ?>
</body>
</html>
