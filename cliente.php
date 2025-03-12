<?php
require_once "ProductoService.php";

$service = new ProductoService();

// Procesar las solicitudes de creación, actualización o eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        $mensaje = $service->crearProducto($_POST['nombre'], $_POST['precio'], $_POST['stock']);
        echo '<script>alert("' . $mensaje . '");</script>';
    } elseif (isset($_POST['actualizar'])) {
        $mensaje = $service->actualizarProducto($_POST['id'], $_POST['nombre'], $_POST['precio'], $_POST['stock']);
        echo '<script>alert("' . $mensaje . '");</script>';
    } elseif (isset($_POST['eliminar'])) {
        $mensaje = $service->eliminarProducto($_POST['id']);
        echo '<script>alert("' . $mensaje . '");</script>';
    } elseif (isset($_POST['buscar'])) {
        $nombre = $_POST['Buscar'];
        $productos = $service->obtenerProductos($nombre);
        if (empty($productos)) {
            echo '<div class="alert alert-warning mt-3 text-center">No se encontraron productos que coincidan con la búsqueda.</div>';
        }
    }
}

// Si no se ha buscado nada, obtener todos los productos
if (!isset($productos)) {
    $productos = $service->obtenerProductos();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
        }
        .table {
            margin-top: 20px;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table td {
            text-align: center;
        }
        .btn {
            margin: 2px;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-secondary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-edit {
            background-color: #ffc107;
            border-color: #ffc107;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
    <h2 class="text-center mt-4">Buscar Productos</h2>
    <br>
        <form method="post" class="input-group">
            <input type="text" name="Buscar" class="form-control" placeholder="Buscar producto">
            <button type="submit" name="buscar" class="btn btn-secondary">Buscar</button>
        </form>
        <br>
        <div class="text-center">
        <h2 class="text-center">Crear Productos</h2>
        <form method="post" class="row g-3 mt-3">
    <div class="col-md-4">
        <label for="nombre" class="form-label">Nombre del producto</label>
        <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
    </div>
    <div class="col-md-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" name="precio" class="form-control" placeholder="Precio" step="0.01" required>
    </div>
    <div class="col-md-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" placeholder="Stock" required>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" name="crear" class="btn btn-primary">Crear</button>
    </div>
</form>
</div>
        <h2 class="text-center mt-5">Lista de Productos</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['id']; ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['precio']; ?></td>
                        <td><?php echo $producto['stock']; ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
                                <input type="number" name="precio" value="<?php echo $producto['precio']; ?>" step="0.01" required>
                                <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required>
                                <button type="submit" name="actualizar" class="btn btn-sm btn-success">Actualizar</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                <button type="submit" name="eliminar" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>