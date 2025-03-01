<?php
require_once "productos.php";

class ProductoService{
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

    public function obtenerProductos() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $precio_mayor_que = isset($_GET['precio_mayor_que']) ? $_GET['precio_mayor_que'] : null;

        $resultado = $this->producto->obtenerProductos($nombre, $precio_mayor_que);
        $this->generarXML($resultado);
    }
    private function enviarError($mensaje, $dom = null, $root = null) {
        if (!$dom) {
            header('Content-Type: application/xml; charset=UTF-8');
            $dom = new DOMDocument("1.0", "UTF-8");
            $dom->formatOutput = true;
            $root = $dom->createElement("error");
            $dom->appendChild($root);
        }

        $mensajeNode = $dom->createElement("mensaje", $mensaje);
        $root->appendChild($mensajeNode);

        echo $dom->saveXML();
        exit;
    }

    private function generarXML($resultado) {
        header('Content-Type: application/xml; charset=UTF-8');
        $dom = new DOMDocument("1.0", "UTF-8");
        $dom->formatOutput = true;
        $root = $dom->createElement("productos");
        $dom->appendChild($root);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $producto = $dom->createElement("producto");
                $producto->setAttribute("id", $fila["id"]);
                $producto->setAttribute("nombre", $fila["nombre"]);
                $producto->setAttribute("precio", $fila["precio"]);
                $producto->setAttribute("stock", $fila["stock"]);
                $root->appendChild($producto);
            }
        } else {
            $this->enviarError("No se encontraron productos", $dom, $root);
        }

        echo $dom->saveXML();
    }
    
}
    $service = new sProductoService();
    $service->validarAcceso();
    $service->obtenerProductos();

?>    