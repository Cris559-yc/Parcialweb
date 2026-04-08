<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'conexion.php';

    $nombre   = $conn->real_escape_string(trim($_POST['nombre'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    if (empty($nombre) || empty($password)) {
        $error = 'Por favor ingrese usuario y contraseña.';
    } else {
        $sql    = "SELECT * FROM usuario WHERE nombre = '$nombre' LIMIT 1";
        $result = $conn->query($sql);

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($password === $user['password']) {
                $_SESSION['usuario']    = $user['nombre'];
                $_SESSION['id_usuario'] = $user['id'];
                $conn->close();
                header("Location: index.php");
                exit();
            } else {
                $error = 'Contraseña incorrecta.';
            }
        } else {
            $error = 'Usuario no encontrado.';
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Facturación</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgba(11, 116, 181, 0.85);
            background-image: url('R.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: overlay;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-header {
            background: rgb(11, 116, 181);
            border-bottom: 4px solid #e8491d;
            padding: 30px 32px;
            text-align: center;
            color: white;
        }

        .login-header .icon {
            font-size: 52px;
            margin-bottom: 10px;
        }

        .login-header h1 {
            font-size: 22px;
            font-weight: bold;
        }

        .login-header p {
            font-size: 13px;
            opacity: 0.85;
            margin-top: 5px;
        }

        .login-body {
            padding: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #444;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #999;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 11px 12px 11px 40px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.2s;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: rgb(11, 116, 181);
            box-shadow: 0 0 0 3px rgba(11, 116, 181, 0.12);
        }

        .error-box {
            background: #fde8e8;
            border: 1px solid #f5c6c6;
            color: #c0392b;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: rgb(11, 116, 181);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: #0a5fa0;
        }

        .login-footer {
            text-align: center;
            padding: 16px 32px;
            border-top: 1px solid #eee;
            font-size: 13px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <div class="icon">🧾</div>
                <h1>Sistema de Facturación</h1>
                <p>Ingrese sus credenciales para continuar</p>
            </div>

            <div class="login-body">

                <?php if ($error): ?>
                    <div class="error-box">⚠️ <?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="nombre">Usuario</label>
                        <div class="input-wrapper">
                            <span class="input-icon">👤</span>
                            <input type="text" id="nombre" name="nombre"
                                   placeholder="Ingrese su usuario"
                                   value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                                   required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🔒</span>
                            <input type="password" id="password" name="password"
                                   placeholder="Ingrese su contraseña"
                                   required>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">Iniciar Sesión</button>
                </form>
            </div>

            <div class="login-footer">
                Sistema de Facturación &copy; <?= date('Y') ?>
            </div>

        </div>
    </div>
</body>
</html>