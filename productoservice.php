<?php
require_once "productos.php";

class ProductoService {
    private $tokenCorrecto = "123456";
    private $producto;

    public function __construct() {
        $this->producto = new Producto();
    }

    public function validarAcceso() {
        if (!isset($_GET['token']) || $_GET['token'] !== $this->tokenCorrecto) {
            $this->enviarError("Acceso no autorizado");
        }
    }

    public function obtenerProductos($nombre = null) {
        return $this->producto->obtenerProductos($nombre);
    }
    public function crearProducto($nombre, $precio, $stock) {
        $this->producto->crearProducto($nombre, $precio, $stock);
        return "Producto creado con éxito.";
    }
    
    public function actualizarProducto($id, $nombre, $precio, $stock) {
        $this->producto->actualizarProducto($id, $nombre, $precio, $stock);
        return "Producto actualizado con éxito.";
    }
    
    public function eliminarProducto($id) {
        $this->producto->eliminarProducto($id);
        return "Producto eliminado con éxito.";
    }
    
    
    private function enviarError($mensaje) {
        echo "Error: $mensaje";
        exit;
    }
}

?>