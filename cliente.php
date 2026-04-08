<?php
require_once 'navbar.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Producto</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: rgba(186, 186, 210, 0.9); /* Color con transparencia */
            background-image: url('R.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: overlay;
        }
        
        .container {
            background-color: rgba(207, 129, 129, 0.85);
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .error { color: red; font-size: 0.8em; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { 
            padding: 8px; 
            width: 100%; 
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea { min-height: 80px; }
        button { 
            padding: 10px 15px; 
            background: #4CAF50; 
            color: white; 
            border: none; 
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            transition: background 0.3s;
        }
        button:hover { background: #45a049; }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro de Productos</h1>
        <form id="formProducto">
            <div class="form-group">
                <label for="Id_producto">ID Producto*:</label>
                <input type="text" id="Id_producto" name="Id_producto" required>
                <span id="error-id" class="error"></span>
            </div>
            
            <div class="form-group">
                <label for="Nombre">Nombre*:</label>
                <input type="text" id="Nombre" name="Nombre" required>
                <span id="error-nombre" class="error"></span>
            </div>
            
            <div class="form-group">
                <label for="Descripción">Descripción:</label>
                <textarea id="Descripción" name="Descripción"></textarea>
            </div>
            
            <div class="form-group">
                <label for="precioUnitario">Precio Unitario:</label>
                <input type="number" id="precioUnitario" name="precioUnitario" step="0.01">
            </div>
            
            <div class="form-group">
                <label for="Cantidad">Cantidad:</label>
                <input type="number" id="Cantidad" name="Cantidad">
            </div>
            
            <div class="form-group">
                <label for="Existencia">Existencia:</label>
                <input type="number" id="Existencia" name="Existencia">
            </div>
            
            <button type="button" onclick="validarYEnviar()">Guardar Producto</button>
        </form>
    </div>

    <script>
        function validarYEnviar() {
            // Resetear errores
            document.querySelectorAll('.error').forEach(el => el.textContent = '');
            
            // Obtener valores
            const id = document.getElementById('Id_producto').value.trim();
            const nombre = document.getElementById('Nombre').value.trim();
            let valido = true;
            
            // Validación
            if (!id) {
                document.getElementById('error-id').textContent = 'Debe ingresar un ID';
                valido = false;
            }
            
            if (!nombre) {
                document.getElementById('error-nombre').textContent = 'Debe ingresar un nombre';
                valido = false;
            }
            
            if (!valido) return;
            
            // Construir objeto de datos
            const data = {
                Id_producto: id,
                Nombre: nombre,
                Descripción: document.getElementById('Descripción').value.trim(),
                precioUnitario: parseFloat(document.getElementById('precioUnitario').value) || 0,
                Cantidad: parseInt(document.getElementById('Cantidad').value) || 0,
                Existencia: parseInt(document.getElementById('Existencia').value) || 0
            };
            
            // Enviar datos
            fetch('facturacion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(resultado => {
                if (resultado.error) {
                    alert(`Error: ${resultado.error}`);
                } else {
                    alert('Producto registrado exitosamente!');
                    document.getElementById('formProducto').reset();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un problema al enviar los datos');
            });
        }
    </script>
</body>
</html>