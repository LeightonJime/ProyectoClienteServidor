<?php



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tablón de anuncios</title>
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


</body>
</html>
