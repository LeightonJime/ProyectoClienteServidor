<?php
// header.php
// Inicia la sesión (si ya estaba iniciada, session_start() no falla)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Obtener nombre seguro para mostrar
$nombreUsuario = "";
if (!empty($_SESSION['session_usuario_nombre'])) {
    // Sanitizar para evitar XSS
    $nombreUsuario = htmlspecialchars($_SESSION['session_usuario_nombre'], ENT_QUOTES, 'UTF-8');
}
?>
<!-- Header visible en todas las páginas -->
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
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="right-element">
            <!-- Aquí mostramos nombre de usuario si existe -->
            <?php if ($nombreUsuario !== ""): ?>
              <a href="#" class="user-account for-buy">
                <i class="icon icon-user"></i>
                <span>Hola, <?php echo $nombreUsuario; ?></span>
              </a>
              <!-- Opcional: link para cerrar sesión -->
              <a href="logout.php" class="ms-3">Cerrar sesión</a>
            <?php else: ?>
              <a href="login.php" class="user-account for-buy">
                <i class="icon icon-user"></i>
                <span>Cuenta</span>
              </a>
            <?php endif; ?>
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
            <a href="../index.php"><img src="../images/main-logo.png" alt="logo"></a>
          </div>
        </div>
        <div class="col-md-10">
          <nav id="navbar">
            <div class="main-menu stellarnav">
              <ul class="menu-list">
                <li class="menu-item"><a href="../index.php">Inicio</a></li>
                <li class="menu-item"><a href="../index.php#featured-books">Destacados</a></li>
                <li class="menu-item"><a href="../index.php#popular-books">Populares</a></li>
                <li class="menu-item"><a href="../articulos/articulos.html">Artículos</a></li>
                <li class="menu-item"><a href="../index.php#download-app">Descargar App</a></li>
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
