<?php
require_once 'db_conexion.php';

// ------------------------
// 1. PROCESAR ACCIONES
// ------------------------
if (isset($_GET['accion'], $_GET['id'])) {
    $accion = $_GET['accion'];
    $id = (int) $_GET['id'];

    // Obtener el ISBN de esa reserva
    $sqlGet = "SELECT isbn FROM reserva WHERE id_reserva = ?";
    $stmtGet = $conexion->prepare($sqlGet);
    $stmtGet->bind_param("i", $id);
    $stmtGet->execute();
    $resGet = $stmtGet->get_result();

    if ($resGet && $resGet->num_rows > 0) {
        $row = $resGet->fetch_assoc();
        $isbnReserva = $row['isbn'];

        if ($accion === 'retirar') {
            // Marcar la reserva como RETIRADO y guardar fecha de retiro
            $sqlUpdRes = "UPDATE reserva
                          SET estado = 'RETIRADO',
                              fecha_retiro = NOW()
                          WHERE id_reserva = ?";
            $stmtUpdRes = $conexion->prepare($sqlUpdRes);
            $stmtUpdRes->bind_param("i", $id);
            $stmtUpdRes->execute();

            // El libro sigue no disponible (estado RESERVADO),
            // porque está físicamente prestado.
        }

        if ($accion === 'liberar') {
            // Liberar el libro: vuelve a estar DISPONIBLE
            $sqlUpdLibro = "UPDATE libro
                            SET estado = 'DISPONIBLE'
                            WHERE isbn = ?";
            $stmtUpdLibro = $conexion->prepare($sqlUpdLibro);
            $stmtUpdLibro->bind_param("s", $isbnReserva);
            $stmtUpdLibro->execute();

            // Opcionalmente marcamos la reserva como CANCELADA
            $sqlUpdRes2 = "UPDATE reserva
                           SET estado = 'CANCELADA'
                           WHERE id_reserva = ?";
            $stmtUpdRes2 = $conexion->prepare($sqlUpdRes2);
            $stmtUpdRes2->bind_param("i", $id);
            $stmtUpdRes2->execute();
        }
    }

    // Redirigir para evitar reenvío de la acción al refrescar
    header("Location: admin_reservas.php");
    exit;
}

// ------------------------
// 2. CONSULTAR TODAS LAS RESERVAS
// ------------------------
$sql = "SELECT 
            r.id_reserva,
            r.isbn,
            l.titulo,
            r.nombre,
            r.correo,
            r.fecha_reserva,
            r.fecha_retiro,
            r.estado AS estado_reserva,
            l.estado AS estado_libro
        FROM reserva r
        INNER JOIN libro l ON r.isbn = l.isbn
        ORDER BY r.fecha_reserva DESC";

$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar reservas</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f5f3eb;
            padding: 30px;
        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        th, td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f0ede2;
            font-weight: 600;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .estado-pill {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 0.8rem;
        }
        .estado-pendiente {
            background: #fff3cd;
            color: #856404;
        }
        .estado-retirado {
            background: #d4edda;
            color: #155724;
        }
        .estado-cancelada {
            background: #f8d7da;
            color: #721c24;
        }
        .estado-libro-disponible {
            color: #28a745;
            font-weight: 600;
        }
        .estado-libro-reservado {
            color: #d39e00;
            font-weight: 600;
        }
        .acciones a {
            margin-right: 8px;
            font-size: 0.83rem;
            text-decoration: none;
            color: #0056b3;
        }
        .acciones a:hover {
            text-decoration: underline;
        }
        .top-links {
            margin-bottom: 15px;
        }
        .top-links a {
            margin-right: 15px;
            text-decoration: none;
            font-size: 0.9rem;
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="top-links">
    <a href="articulos.php">← Volver al catálogo</a>
</div>

<h1>Administración de reservas</h1>

<?php if ($resultado && $resultado->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Libro</th>
            <th>ISBN</th>
            <th>Usuario (quién reservó)</th>
            <th>Correo</th>
            <th>Fecha reserva</th>
            <th>Fecha retiro</th>
            <th>Estado reserva</th>
            <th>Estado libro</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($res = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?php echo $res['id_reserva']; ?></td>
            <td><?php echo htmlspecialchars($res['titulo'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($res['isbn'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($res['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($res['correo'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo $res['fecha_reserva']; ?></td>
            <td><?php echo $res['fecha_retiro'] ?: '-'; ?></td>
            <td>
                <?php
                $claseEstado = 'estado-pill ';
                if ($res['estado_reserva'] === 'PENDIENTE')  $claseEstado .= 'estado-pendiente';
                if ($res['estado_reserva'] === 'RETIRADO')   $claseEstado .= 'estado-retirado';
                if ($res['estado_reserva'] === 'CANCELADA')  $claseEstado .= 'estado-cancelada';
                ?>
                <span class="<?php echo $claseEstado; ?>">
                    <?php echo $res['estado_reserva']; ?>
                </span>
            </td>
            <td>
                <?php if ($res['estado_libro'] === 'DISPONIBLE'): ?>
                    <span class="estado-libro-disponible">DISPONIBLE</span>
                <?php else: ?>
                    <span class="estado-libro-reservado"><?php echo $res['estado_libro']; ?></span>
                <?php endif; ?>
            </td>
            <td class="acciones">
                <?php if ($res['estado_reserva'] === 'PENDIENTE'): ?>
                    <!-- Registrar que el usuario vino a retirar el libro -->
                    <a href="admin_reservas.php?accion=retirar&id=<?php echo $res['id_reserva']; ?>">
                        Marcar como retirado
                    </a>
                <?php endif; ?>

                <?php if ($res['estado_libro'] !== 'DISPONIBLE'): ?>
                    <!-- Liberar el libro (queda disponible) -->
                    <a href="admin_reservas.php?accion=liberar&id=<?php echo $res['id_reserva']; ?>">
                        Liberar libro
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <p>No hay reservas registradas.</p>
<?php endif; ?>

</body>
</html>
