<?php
require_once 'conexion.php';
require_once 'navbar.php';

// Procesar actualización si es una petición POST (edición)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'editar') {
    $id = $conn->real_escape_string($_POST['Id_producto']);
    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $descripcion = $conn->real_escape_string($_POST['Descripción']);
    $precio = floatval($_POST['precioUnitario']);
    $cantidad = intval($_POST['Cantidad']);
    $existencia = intval($_POST['Existencia']);
    
    $sql = "UPDATE productos SET 
            Nombre = '$nombre',
            Descripción = '$descripcion',
            precioUnitario = $precio,
            Cantidad = $cantidad,
            Existencia = $existencia
            WHERE Id_producto = '$id'";
    
    if ($conn->query($sql)) {
        $mensaje = "Producto actualizado correctamente";
    } else {
        $error = "Error al actualizar: " . $conn->error;
    }
}

// Obtener todos los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
$productos = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Productos</title>
    <meta charset="UTF-8">
    <style>

        body { 
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 20px;
            background-color: rgba(114, 114, 215, 0.8); /* Color con transparencia */
            background-image: url('fact1.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: overlay;
            min-height: 100vh;
        }
        
        
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
            background-color: white;
        }
        
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        
        th { 
            background-color: #f2f2f2; 
        }
        
        tr:nth-child(even) { 
            background-color: #f9f9f9; 
        }
        
        .modal { 
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0,0,0,0.4); 
        }
        
        .modal-content { 
            background-color: #fefefe; 
            margin: 10% auto; 
            padding: 20px; 
            border: 1px solid #888; 
            width: 50%; 
            border-radius: 8px;
        }
        


        body { background-color:rgb(181, 181, 215); font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4); }
        .modal-content { background-color: #fefefe; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 50%; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .close:hover { color: black; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 150px; }
        input { padding: 8px; width: 100%; }
        button { padding: 5px 10px; margin-right: 5px; cursor: pointer; }
        .editar-btn { background-color: #4CAF50; color: white; border: none; }
        .eliminar-btn { background-color: #f44336; color: white; border: none; }
        .guardar-btn { background-color: #2196F3; color: white; border: none; padding: 8px 15px; }
        .mensaje { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .exito { background-color: #dff0d8; color: #3c763d; }
        .error { background-color: #f2dede; color: #a94442; }
    </style>
</head>
<body>
    <h1>Listado de Productos</h1>
    
    <?php if (isset($mensaje)): ?>
        <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Existencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?= htmlspecialchars($producto['Id_producto']) ?></td>
                <td><?= htmlspecialchars($producto['Nombre']) ?></td>
                <td><?= htmlspecialchars($producto['Descripción']) ?></td>
                <td><?= number_format($producto['precioUnitario'], 2) ?></td>
                <td><?= htmlspecialchars($producto['Cantidad']) ?></td>
                <td><?= htmlspecialchars($producto['Existencia']) ?></td>
                <td>
                    <button class="editar-btn" onclick="mostrarModalEdicion(
                        '<?= htmlspecialchars($producto['Id_producto']) ?>',
                        '<?= htmlspecialchars($producto['Nombre']) ?>',
                        '<?= htmlspecialchars($producto['Descripción']) ?>',
                        '<?= htmlspecialchars($producto['precioUnitario']) ?>',
                        '<?= htmlspecialchars($producto['Cantidad']) ?>',
                        '<?= htmlspecialchars($producto['Existencia']) ?>'
                    )">Editar</button>
                    
                    <button class="eliminar-btn" onclick="eliminarProducto('<?= htmlspecialchars($producto['Id_producto']) ?>')">Eliminar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Modal de Edición -->
    <div id="modalEdicion" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2>Editar Producto</h2>
            <form id="formEditar" method="post">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" id="edit_Id_producto" name="Id_producto">
                
                <div class="form-group">
                    <label for="edit_Nombre">Nombre:</label>
                    <input type="text" id="edit_Nombre" name="Nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_Descripción">Descripción:</label>
                    <input type="text" id="edit_Descripción" name="Descripción">
                </div>
                
                <div class="form-group">
                    <label for="edit_precioUnitario">Precio Unitario:</label>
                    <input type="number" id="edit_precioUnitario" name="precioUnitario" step="0.01">
                </div>
                
                <div class="form-group">
                    <label for="edit_Cantidad">Cantidad:</label>
                    <input type="number" id="edit_Cantidad" name="Cantidad">
                </div>
                
                <div class="form-group">
                    <label for="edit_Existencia">Existencia:</label>
                    <input type="number" id="edit_Existencia" name="Existencia">
                </div>
                
                <button type="submit" class="guardar-btn">Guardar Cambios</button>
            </form>
        </div>
    </div>
    
    <script>
        // Mostrar modal de edición con los datos del producto
        function mostrarModalEdicion(id, nombre, descripcion, precio, cantidad, existencia) {
            document.getElementById('edit_Id_producto').value = id;
            document.getElementById('edit_Nombre').value = nombre;
            document.getElementById('edit_Descripción').value = descripcion;
            document.getElementById('edit_precioUnitario').value = precio;
            document.getElementById('edit_Cantidad').value = cantidad;
            document.getElementById('edit_Existencia').value = existencia;
            
            document.getElementById('modalEdicion').style.display = 'block';
        }
        
        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modalEdicion').style.display = 'none';
        }
        
        // Eliminar producto
        function eliminarProducto(id) {
            if (confirm('¿Estás seguro de eliminar este producto?')) {
                fetch('facturacion.php?Id_producto=' + id, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Error al eliminar el producto');
                    }
                });
            }
        }
        
        // Cerrar modal al hacer clic fuera del contenido
        window.onclick = function(event) {
            const modal = document.getElementById('modalEdicion');
            if (event.target == modal) {
                cerrarModal();
            }
        }
    </script>
</body>
</html>
