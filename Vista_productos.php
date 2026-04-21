<?php
// Pagina PUBLICA - no requiere login

require_once 'conexion.php';

$sql = "SELECT * FROM productos ORDER BY Nombre ASC";
$result = $conn->query($sql);
$productos = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo de Productos</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgba(114, 114, 215, 0.8);
            background-image: url('fact1.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: overlay;
            min-height: 100vh;
        }

        /* NAVBAR publico */
        .navbar {
            background: rgb(11, 116, 181);
            border-bottom: 3px solid #e8491d;
            padding: 16px 0;
        }
        .nav-inner {
            width: 85%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-brand {
            color: white;
            text-decoration: none;
            font-size: 22px;
            font-weight: bold;
        }
        .btn-login-nav {
            background: #e8491d;
            color: white;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-login-nav:hover { background: #c03a16; }

        /* Banner de aviso */
        .aviso-banner {
            background: rgba(255, 193, 7, 0.95);
            color: #333;
            text-align: center;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-bottom: 2px solid #e6a800;
        }
        .aviso-banner a {
            color: rgb(11, 116, 181);
            font-weight: bold;
            text-decoration: none;
        }
        .aviso-banner a:hover { text-decoration: underline; }

        /* Contenido */
        .page-content {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto;
        }

        .page-title {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 6px;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
        }
        .page-subtitle {
            color: #dde8f5;
            font-size: 14px;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.4);
        }

        /* Tabla */
        .table-wrapper {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: rgb(11, 116, 181);
            color: white;
        }

        thead th {
            padding: 14px 16px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.15s;
        }
        tbody tr:hover { background: #f0f7ff; }
        tbody tr:last-child { border-bottom: none; }

        tbody td {
            padding: 12px 16px;
            font-size: 14px;
            color: #444;
        }

        .precio-cell {
            font-weight: bold;
            color: #2c7a2c;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-activo    { background: #d4edda; color: #155724; }
        .badge-inactivo  { background: #f8d7da; color: #721c24; }
        .badge-agotado   { background: #fff3cd; color: #856404; }

        .sin-datos {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 16px;
        }

        /* Total de registros */
        .table-footer {
            padding: 12px 16px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
            font-size: 13px;
            color: #666;
            text-align: right;
        }

        footer {
            text-align: center;
            color: #cce0f5;
            padding: 20px;
            font-size: 13px;
            margin-top: 20px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

    <!-- Navbar publico -->
    <header class="navbar">
        <div class="nav-inner">
            <a href="ver_productos.php" class="nav-brand">Catalogo de Productos</a>
            <a href="login.php" class="btn-login-nav">Iniciar Sesion</a>
        </div>
    </header>

    <!-- Aviso para visitantes -->
    <div class="aviso-banner">
        Solo estas viendo el catalogo. Para registrar, editar o eliminar productos debes
        <a href="login.php">iniciar sesion</a>.
    </div>

    <!-- Contenido -->
    <div class="page-content">
        <div class="page-title">Catalogo de Productos</div>
        <div class="page-subtitle">Lista completa ordenada por nombre</div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Existencia</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($productos)): ?>
                        <tr>
                            <td colspan="9" class="sin-datos">No hay productos registrados aun.</td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach ($productos as $p): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($p['Id_producto']) ?></td>
                            <td><strong><?= htmlspecialchars($p['Nombre']) ?></strong></td>
                            <td><?= htmlspecialchars($p['Descripción'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($p['Categoria'] ?? '—') ?></td>
                            <td class="precio-cell">$<?= number_format($p['precioUnitario'], 2) ?></td>
                            <td><?= htmlspecialchars($p['Cantidad']) ?></td>
                            <td><?= htmlspecialchars($p['Existencia']) ?></td>
                            <td>
                                <?php
                                    $estado = $p['Estado'] ?? 'Activo';
                                    $clase  = strtolower($estado);
                                ?>
                                <span class="badge badge-<?= $clase ?>">
                                    <?= htmlspecialchars($estado) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="table-footer">
                Total de productos: <strong><?= count($productos) ?></strong>
            </div>
        </div>
    </div>

    <footer>
        Sistema de Facturacion &copy; <?= date('Y') ?> &mdash; Vista publica
    </footer>

</body>
</html>