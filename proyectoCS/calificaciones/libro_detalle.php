<?php
session_start();
require_once __DIR__ . '/../articulos/db_conexion.php';

$isbn = $_GET['isbn'] ?? '';

if (trim($isbn) === '') {
    echo "Libro no encontrado.";
    exit;
}

// Datos del libro + promedio
$sql = "SELECT l.*,
               AVG(r.estrellas) AS promedio,
               COUNT(r.id_rating) AS total
        FROM libro l
        LEFT JOIN rating_libro r ON l.isbn = r.fk_isbn
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

// Traer opiniones
$sql2 = "SELECT r.estrellas, r.resena, r.fecha_creacion, u.username
         FROM rating_libro r
         JOIN usuarios u ON u.id_usuario = r.fk_id_usuario
         WHERE r.fk_isbn = ?
         ORDER BY r.fecha_creacion DESC";

$stmt2 = $conexion->prepare($sql2);
$stmt2->bind_param("s", $isbn);
$stmt2->execute();
$ratings = $stmt2->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Biblioteca Pública de Heredia – Calificaciones</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <!-- CSS globales del sitio -->
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../icomoon/icomoon.css">
  <link rel="stylesheet" type="text/css" href="../css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="stylesheet" href="style.css">

  




</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">

  <!-- jQuery (script.js y menú) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Header integrado -->
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
                  <li class="menu-item"><a href="../articulos/index.php" class="nav-link">Libros</a></li>

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
  </div>
  <!-- /Header integrado -->

  <!-- Contenido -->
  <main style="padding:5px 0;">

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-10 col-xl-8 mx-auto">

         

          <div class="libro-detalle">
  <h1><?php echo htmlspecialchars($libro['titulo']); ?></h1>
  <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['escritor']); ?></p>
  <p><strong>Año:</strong> <?php echo htmlspecialchars($libro['anno']); ?></p>
  <p><strong>Descripción:</strong> <?php echo htmlspecialchars($libro['descr']); ?></p>
</div>


          <hr style="margin:20px 0;">

          <h2>Rating</h2>
          <p>
            Promedio:
            <?php echo $total > 0 ? number_format((float)$promedio, 1) . " / 5" : "Sin calificaciones"; ?>
            <?php if ($total > 0) echo " ({$total} opiniones)"; ?>
          </p>

          <h3>Opiniones</h3>
          <?php if ($ratings && $ratings->num_rows > 0): ?>
            <?php while ($rt = $ratings->fetch_assoc()): ?>
              <div class="opinion">


                <strong><?php echo htmlspecialchars($rt['username']); ?></strong>
                — <?php echo (int)$rt['estrellas']; ?>/5
                <br>
                <?php if (!empty($rt['resena'])): ?>
                  <?php echo nl2br(htmlspecialchars($rt['resena'])); ?>
                <?php else: ?>
                  <em>(Sin reseña)</em>
                <?php endif; ?>
                <br>
                <small><?php echo htmlspecialchars($rt['fecha_creacion']); ?></small>
              </div>
              <hr style="margin:10px 0;">

            <?php endwhile; ?>
          <?php else: ?>
            <p>Aún no hay reseñas.</p>
          <?php endif; ?>

          <?php $stmt2->close(); ?>

          <?php if (isset($_SESSION['session_id_usuario'])): ?>
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

        </div>
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>

  <script src="../js/script.js"></script>

</body>
</html>
<?php
$conexion->close();
?>
