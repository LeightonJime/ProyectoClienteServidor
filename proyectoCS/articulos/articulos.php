<!DOCTYPE html>
<html lang="es">

<head>
  <title>Biblioteca Pública de Heredia – Artículos</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="Listado de artículos y artículos en audio de la Biblioteca Pública de Heredia.">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <!-- CSS globales del sitio (mismos que tu index principal) -->
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../icomoon/icomoon.css">
  <link rel="stylesheet" type="text/css" href="../css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../style.css">

  <!-- CSS específico de la página de artículos -->
  <link rel="stylesheet" type="text/css" href="css/articulos.css">
</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">

<!--Jose Acuna-->

<?php
require_once 'db_conexion.php';

$sql = "SELECT isbn, titulo, escritor, anno, descr, tipo, estado
        FROM libro
        ORDER BY anno DESC";

$resultadoLibros = $conexion->query($sql);
$totalLibros = ($resultadoLibros) ? $resultadoLibros->num_rows : 0;
?>



  <!-- jQuery (script.js y menú) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Header-->
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
                  <li class="menu-item">
                    <a href="../index.html#home" class="nav-link">Inicio</a>
                  </li>
                 
                  <li class="menu-item"><a href="../index.html#featured-books" class="nav-link">Destacados</a></li>
                  <li class="menu-item"><a href="../index.html#popular-books" class="nav-link">Populares</a></li>
                  <li class="menu-item"><a href="../index.html#special-offer" class="nav-link">Ofertas</a></li>
                  <!-- Página actual -->
                  <li class="menu-item active">
                    <a href="#listado-articulos" class="nav-link">Libros</a>
                  </li>
                  <li class="menu-item"><a href="../calificaciones/calificaciones.php" class="nav-link">Calificaciones</a></li>
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

  <!-- ===================================================================
       SECCIÓN PRINCIPAL: LISTADO DE ARTÍCULOS
  ==================================================================== -->
  <main id="listado-articulos" class="padding-medium articulos-page">
    <div class="container-fluid">

     <div class="articulos-grid">
  <?php if ($resultadoLibros && $resultadoLibros->num_rows > 0): ?>

    <?php while ($libro = $resultadoLibros->fetch_assoc()): ?>
      <article class="articulo-card">

        <figure class="articulo-cover">
          <img
            src="images/libros/<?php echo htmlspecialchars($libro['isbn'], ENT_QUOTES, 'UTF-8'); ?>.jpg"
            alt="<?php echo htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8'); ?>">
        </figure>

        <div class="articulo-info">

          <h3 class="articulo-autor">
            <?php echo htmlspecialchars($libro['escritor'], ENT_QUOTES, 'UTF-8'); ?>
          </h3>

          <a href="#" class="articulo-tipo">
            <?php echo htmlspecialchars($libro['tipo'], ENT_QUOTES, 'UTF-8'); ?>
          </a>

          <span class="articulo-anio">
            <?php echo htmlspecialchars($libro['anno'], ENT_QUOTES, 'UTF-8'); ?>
          </span>

          <p class="articulo-descr">
            <?php echo htmlspecialchars($libro['descr'], ENT_QUOTES, 'UTF-8'); ?>
          </p>

          <!-- NUEVO: zona de reserva -->
          <div class="articulo-reserva">
            <?php if ($libro['estado'] === 'DISPONIBLE'): ?>
              <a
                href="reservar.php?isbn=<?php echo urlencode($libro['isbn']); ?>"
                class="btn-reservar">
                Reservar
              </a>
            <?php else: ?>
              <span class="estado-no-disponible">No disponible</span>
            <?php endif; ?>
          </div>

        </div>
      </article>
    <?php endwhile; ?>

  <?php else: ?>
    <p>No hay artículos disponibles.</p>
  <?php endif; ?>
</div>

      </section>

     

    </div><!-- /.container-fluid -->
  </main>

  <!-- FOOTER  -->

  <!-- Scripts globales -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>

  <script src="../js/script.js"></script>

  <!-- JS específico para esta página (por ahora ligero) -->
  <script src="js/articulos.js"></script>

  <?php
$conexion->close();
?>


</body>

</html>