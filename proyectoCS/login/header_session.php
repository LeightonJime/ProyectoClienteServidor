<?php
// login/header_session.php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

// Base para rutas ("" desde raíz, "../" desde subcarpetas)
$base = $_GET['base'] ?? '';
$base = ($base === '../') ? '../' : '';

$nombre = $_SESSION['session_usuario_nombre'] ?? '';
$nombre = $nombre ? htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') : '';

if ($nombre) {
  // Logueado
  echo '
    <a href="#" class="user-account for-buy" style="pointer-events:none; cursor:default;">
      <i class="icon icon-user"></i>
      <span>' . $nombre . '</span>
    </a>
    <a href="'.$base.'login/logout.php" class="user-account for-buy" style="margin-left:12px;">
      <span>Cerrar sesión</span>
    </a>
  ';
} else {
  // No logueado
  echo '
    <a href="'.$base.'login/login.html" class="user-account for-buy">
      <i class="icon icon-user"></i>
      <span>Cuenta</span>
    </a>
  ';
}
