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

// Consulta de los libros (usamos todas las columnas)
$sql = "SELECT isbn, titulo, escritor, anno, descr, tipo FROM libro ORDER BY anno DESC";
$resultadoLibros = $conexion->query($sql);

// Total de libros para mostrarlo en "Ver X más"
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
                  <li class="menu-item has-sub">
                    <a href="../index.html#pages" class="nav-link">Páginas</a>
                    <ul>
                      <li><a href="../index.html">Inicio</a></li>
                      <li><a href="../index.html">Acerca de</a></li>
                      <li><a href="../index.html">Estilos</a></li>
                      <li><a href="../index.html">Blog</a></li>
                      <li><a href="../index.html">Entrada</a></li>
                      <li><a href="../index.html">Tienda</a></li>
                      <li><a href="../index.html">Producto</a></li>
                      <li><a href="../index.html">Contacto</a></li>
                      <li><a href="../index.html">Gracias</a></li>
                    </ul>
                  </li>
                  <li class="menu-item"><a href="../index.html#featured-books" class="nav-link">Destacados</a></li>
                  <li class="menu-item"><a href="../index.html#popular-books" class="nav-link">Populares</a></li>
                  <li class="menu-item"><a href="../index.html#special-offer" class="nav-link">Ofertas</a></li>
                  <li class="menu-item"><a href="../index.html#latest-blog" class="nav-link">Artículos</a></li>
                  <li class="menu-item"><a href="../index.html#download-app" class="nav-link">Descargar App</a></li>

                  <!-- Página actual -->
                  <li class="menu-item active">
                    <a href="#listado-articulos" class="nav-link">Artículos (catálogo)</a>
                  </li>
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

          <!-- Tipo ahora viene 100% desde la BD -->
          <a href="#" class="articulo-tipo">
            <?php echo htmlspecialchars($libro['tipo'], ENT_QUOTES, 'UTF-8'); ?>
          </a>

          <span class="articulo-anio">
            <?php echo htmlspecialchars($libro['anno'], ENT_QUOTES, 'UTF-8'); ?>
          </span>

          <p class="articulo-descr">
            <?php echo htmlspecialchars($libro['descr'], ENT_QUOTES, 'UTF-8'); ?>
          </p>

        </div>
      </article>
    <?php endwhile; ?>

  <?php else: ?>
    <p>No hay artículos disponibles.</p>
  <?php endif; ?>
</div>

 

      </section>

      <!-- Bloque: Artículo en audio -->
      <section class="articulos-section articulos-section-audio">
        <div class="articulos-section-header">
          <h2 class="articulos-title">Artículo en audio</h2>
          <a href="#" class="articulos-ver-mas">
            Ver 81 más <span class="icon icon-arrow-down"></span>
          </a>
        </div>

        <div class="articulos-grid">

          <!-- AUDIO 1 -->
          <article class="articulo-card articulo-card-audio">
            <figure class="articulo-cover">
              <img src="images/audio-01.jpg" alt="Diciembre">
              <span class="articulo-icon-audio">
                <i class="icon icon-play"></i>
              </span>
            </figure>
            <div class="articulo-info">
              <h3 class="articulo-autor">Juan Valera</h3>
              <a href="#" class="articulo-tipo">Artículo</a>
              <span class="articulo-anio">1824–1905</span>
            </div>
          </article>

          <!-- AUDIO 2 -->
          <article class="articulo-card articulo-card-audio">
            <figure class="articulo-cover">
              <img src="images/audio-02.jpg" alt="Alma vasca">
              <span class="articulo-icon-audio">
                <i class="icon icon-play"></i>
              </span>
            </figure>
            <div class="articulo-info">
              <h3 class="articulo-autor">Miguel de Unamuno</h3>
              <a href="#" class="articulo-tipo">Artículo</a>
              <span class="articulo-anio">1904</span>
            </div>
          </article>

          <!-- AUDIO 3 -->
          <article class="articulo-card articulo-card-audio">
            <figure class="articulo-cover">
              <img src="images/audio-03.jpg" alt="Al pie del Maladeta">
              <span class="articulo-icon-audio">
                <i class="icon icon-play"></i>
              </span>
            </figure>
            <div class="articulo-info">
              <h3 class="articulo-autor">Miguel de Unamuno</h3>
              <a href="#" class="articulo-tipo">Artículo</a>
              <span class="articulo-anio">1919</span>
            </div>
          </article>

          <!-- AUDIO 4 -->
          <article class="articulo-card articulo-card-audio">
            <figure class="articulo-cover">
              <img src="images/audio-04.jpg" alt="A la memoria de Miguel de Cervantes">
              <span class="articulo-icon-audio">
                <i class="icon icon-play"></i>
              </span>
            </figure>
            <div class="articulo-info">
              <h3 class="articulo-autor">Gustavo Adolfo Bécq...</h3>
              <a href="#" class="articulo-tipo">Artículo</a>
              <span class="articulo-anio">1836–1870</span>
            </div>
          </article>

          <!-- AUDIO 5 -->
          <article class="articulo-card articulo-card-audio">
            <figure class="articulo-cover">
              <img src="images/audio-05.jpg" alt="Kafka y sus precursores">
              <span class="articulo-icon-audio">
                <i class="icon icon-play"></i>
              </span>
            </figure>
            <div class="articulo-info">
              <h3 class="articulo-autor">Jorge Luis Borges</h3>
              <a href="#" class="articulo-tipo">Artículo</a>
              <span class="articulo-anio">1952</span>
            </div>
          </article>

        </div><!-- /.articulos-grid -->
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