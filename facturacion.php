<?php
require_once __DIR__ . '/conexion.php';

// Verificar conexión
if (!isset($conn) || !($conn instanceof mysqli)) {
    die(json_encode(['error' => 'Error de conexión a la base de datos']));
}

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            // Listar todos los productos
            $sql = "SELECT Id_producto, Nombre, Descripción, precioUnitario, Cantidad, Existencia FROM productos";
            $result = $conn->query($sql);
            
            if (!$result) {
                throw new Exception("Error en la consulta: " . $conn->error);
            }
            
            $productos = [];
            while ($row = $result->fetch_assoc()) {
                $productos[] = [
                    'Id_producto' => $row['Id_producto'],
                    'Nombre' => $row['Nombre'],
                    'Descripción' => $row['Descripción'],
                    'precioUnitario' => $row['precioUnitario'],
                    'Cantidad' => $row['Cantidad'],
                    'Existencia' => $row['Existencia']
                ];
            }
            
            echo json_encode($productos);
            break;

        case 'POST':
    // Recibir y decodificar los datos JSON
    $json = file_get_contents('php://input');
 $data = json_decode($json, true);
    
    // Verificar si el JSON se decodificó correctamente
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'Datos JSON inválidos']);
        break;
    }
    
    // Validar campos requeridos
    if (empty($data['Id_producto']) || empty($data['Nombre'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Id_producto y Nombre son campos requeridos']);
        break;
    }
    
    // Escapar datos
    $id = $conn->real_escape_string($data['Id_producto']);
    $nombre = $conn->real_escape_string($data['Nombre']);
    $descripcion = $conn->real_escape_string($data['Descripción'] ?? '');
    $precio = floatval($data['precioUnitario'] ?? 0);
    $cantidad = intval($data['Cantidad'] ?? 0);
    $existencia = intval($data['Existencia'] ?? 0);
    
    // Insertar en la base de datos
    $sql = "INSERT INTO productos (Id_producto, Nombre, Descripción, precioUnitario, Cantidad, Existencia) 
            VALUES ('$id', '$nombre', '$descripcion', $precio, $cantidad, $existencia)";
    
    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al guardar en base de datos: ' . $conn->error]);
    }
    break;

        case 'PUT':
            // Actualizar producto
            parse_str(file_get_contents("php://input"), $data);
            
            $id_producto = $conn->real_escape_string($data['Id_producto'] ?? '');
            $nombre = $conn->real_escape_string($data['Nombre'] ?? '');
            $descripcion = $conn->real_escape_string($data['Descripción'] ?? '');
            $precio = floatval($data['precioUnitario'] ?? 0);
            $cantidad = intval($data['Cantidad'] ?? 0);
            $existencia = intval($data['Existencia'] ?? 0);
            
            $sql = "UPDATE productos SET 
                    Nombre = '$nombre',
                    Descripción = '$descripcion',
                    precioUnitario = $precio,
                    Cantidad = $cantidad,
                    Existencia = $existencia
                    WHERE Id_producto = '$id_producto'";
            
            if ($conn->query($sql)) {
                echo json_encode(['success' => 'Producto actualizado correctamente']);
            } else {
                throw new Exception("Error al actualizar producto: " . $conn->error);
            }
            break;

        case 'DELETE':
            // Eliminar producto
            $id_producto = $conn->real_escape_string($_GET['Id_producto'] ?? '');
            
            $sql = "DELETE FROM productos WHERE Id_producto = '$id_producto'";
            
            if ($conn->query($sql)) {
                echo json_encode(['success' => 'Producto eliminado correctamente']);
            } else {
                throw new Exception("Error al eliminar producto: " . $conn->error);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>