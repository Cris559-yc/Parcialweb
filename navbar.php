<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

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
            margin: 0;
            padding: 0;
            color: #333;
        }
        .navbar {
            background: rgb(11, 116, 181);
            color: white;
            padding: 16px 0;
            border-bottom: #e8491d 3px solid;
        }
        .container {
            width: 85%;
            margin: auto;
            overflow: hidden;
        }
        .nav-container {
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
        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .nav-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .nav-item {
            margin-left: 20px;
        }
        .nav-link {
            color: white;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #e8491d;
            font-weight: bold;
        }
        .nav-user {
            color: #d0eaff;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-left: 1px solid rgba(255,255,255,0.3);
            padding-left: 20px;
        }
        .btn-logout {
            background: #e8491d;
            color: white;
            border: none;
            padding: 7px 14px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn-logout:hover {
            background: #c03a16;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="container">
            <div class="nav-container">
                <a href="index.php" class="nav-brand">🧾 <?= $titulo ?></a>

                <div class="nav-right">
                    <ul class="nav-menu">
                        <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                        <li class="nav-item"><a href="cliente.php" class="nav-link">Registrar Producto</a></li>
                        <li class="nav-item"><a href="listar.php" class="nav-link">Lista de Productos</a></li>
                    </ul>

                    <div class="nav-user">
                        👤 <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong>
                        <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container" style="margin-top: 30px;"></div>