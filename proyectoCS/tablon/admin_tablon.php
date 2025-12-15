<?php
session_start();
include_once 'crudtablon.php'; 
$anuncios = obtenerAnuncios();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablón de Anuncios</title>
    <link rel="stylesheet" href="stylestablon.css"> 
</head>
<body>
    <div class="container">
        <h1>Tablón de Anuncios</h1>

        <p class="create-button-container">
            <a href="crear_anuncio.php" class="button">+ Crear Nuevo Anuncio</a>
        </p>

        <?php
        if (isset($_GET['mensaje'])) {
            echo '<div class="alert success">' . htmlspecialchars($_GET['mensaje']) . '</div>';
        }
        
        if (isset($_GET['error'])) {
            echo '<div class="alert error">' . htmlspecialchars($_GET['error']) . '</div>';
        }

        if (!empty($anuncios)) {
        ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($anuncios as $anuncio) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($anuncio['id_anuncio']) . "</td>";
                    echo "<td>" . htmlspecialchars($anuncio['a_titulo']) . "</td>";
                    echo "<td>" . htmlspecialchars($anuncio['a_descripcion']) . "</td>";
                    $fecha_formato = $anuncio['a_fecha'] ? date('d-m-Y', strtotime($anuncio['a_fecha'])) : 'N/A';
                    echo "<td>" . $fecha_formato . "</td>";
                    echo "<td>" . htmlspecialchars($anuncio['a_img']) . "</td>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        } else {
            echo "<p class='no-records'>No hay anuncios</p>";
        }
        ?>
    </div>
</body>
</html> 