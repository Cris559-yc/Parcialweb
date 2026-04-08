<?php
require_once 'auth.php';
$titulo = "Sistema de Facturación";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: rgb(213, 108, 108);
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .showcase {
            min-height: 280px;
            background: url('factura1.jpg') no-repeat center center/cover;
            text-align: center;
            color: white;
            padding: 80px 20px;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.6);
        }
        .showcase h1 { font-size: 48px; margin-bottom: 15px; }
        .showcase p  { font-size: 18px; max-width: 700px; margin: 0 auto; }
        .main-content { padding: 20px 0; }
        footer {
            background: #35424a;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
        }
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            padding: 24px;
            margin: 20px 0;
        }
        .card h2 { color: #2c3e50; margin-bottom: 10px; }
        .card ul  { padding-left: 20px; }
        .card li  { margin-bottom: 6px; }
    </style>
</head>
<body>

    <?php require_once 'navbar.php'; ?>

    <section class="showcase">
        <div class="container">
            <h1>Sistema de Gestión de Productos</h1>
            <p>Una solución completa para el manejo de inventarios y facturación</p>
        </div>
    </section>

    <div class="container main-content">
        <div class="card">
            <h2>👋 Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?>!</h2>
            <p>Este sistema permite gestionar todos los productos de su inventario.</p>
            <br>
            <p>Utilice el menú superior para navegar entre las diferentes secciones:</p>
            <ul>
                <li><strong>Registrar Producto:</strong> Para añadir nuevos productos al sistema</li>
                <li><strong>Lista de Productos:</strong> Para ver, editar o eliminar productos existentes</li>
            </ul>
        </div>
    </div>

    <footer>
        <p>Sistema de Facturación &copy; <?= date('Y') ?></p>
    </footer>

</body>
</html>