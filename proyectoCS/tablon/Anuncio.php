<?php
include_once 'crudtablon.php'; 
$anuncios = obtenerAnuncios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncios</title>
    <link rel="stylesheet" href="stylestablon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../icomoon/icomoon.css">
    <link rel="stylesheet" href="../css/vendor.css">
    <link rel="stylesheet" href="../style.css"> 

</head>
<body>
<!-- header -->
<header class="py-3 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="../index.html" class="text-decoration-none fs-5">📚 Biblioteca Pública de Heredia</a>
      <nav class="d-none d-md-block">
        <a href="../index.html#featured-books" class="me-3">Destacados</a>
        <a href="../index.html#popular-books">Populares</a>
      </nav>
    </div>
  </header>

<!-- anuncios -->
    <div class="container">
        <h1>Anuncios Recientes</h1>

        <?php
        if (!empty($anuncios)) {
            foreach($anuncios as $anuncio) {
                $fecha_formato = $anuncio['a_fecha'] ? date('d-m-Y', strtotime($anuncio['a_fecha'])) : 'N/A';
        ?>
            <div class="anuncio-card">
                <h2><?php echo htmlspecialchars($anuncio['a_titulo']); ?></h2>
                <p class="fecha">Fecha: <?php echo $fecha_formato; ?></p>
                <p><?php echo nl2br(htmlspecialchars($anuncio['a_descripcion'])); ?></p>
                <?php if (!empty($anuncio['a_img'])): ?>
                    <img src="<?php echo htmlspecialchars($anuncio['a_img']); ?>" alt="Imagen del anuncio">
                <?php endif; ?>
                
            </div>
        <?php
            }
        } else {
            echo "<p>No hay anuncios</p>";
        }
        ?>
    </div>
</body>
</html>