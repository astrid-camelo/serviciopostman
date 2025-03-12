<?php

require_once "conexion.php";

class Servidor {
    private $db;

    public function __construct() {
        $this->db = (new Conexion()) ->getConexion();
    }

    public function autenticar($token) {
        $tokenValido = "mi_token_secreto";
        return $token === $tokenValido;
    }

    public function obtenerProductos($token){
        if(!$this->autenticar($token)){
            return[];
        }
        $query = $this->db->query("SELECT id, nombre, precio, stock FROM productos");
        $productos = $query->fetchALL(PDO::FETCH_ASSOC);

        return array_map(function($productos){
            return [
                'id' => (int)$productos['id'],
                'nombre' =>$productos['nombre'],
                'precio' => (float)$productos['precio'],
                'stock' => (int)$productos['stock'],
            ];
        }, $productos);
    }

    public function obtenerProducto ($id, $token) {
        if(!$this->autenticar($token)){
            return[];
    }

    $stmt = $this->db->query("SELECT id, nombre, precio, stock FROM productos");
    $stmt->execute([$id]);
    $productos = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$productos) {
        return[];
    }

    return [
        'id' => (int)$productos['id'],
                'nombre' =>$productos['nombre'],
                'precio' => (float)$productos['precio'],
                'stock' => (int)$productos['stock'],
    ];
  }

  public function crearProducto($nombre, $precio, $stock, $token) {
    if (!$this->autenticar($token)) {
        return [];
    }
    $stmt = $this->db->prepare("INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $precio, $stock]);
    return ["mensaje" => "Producto creado con éxito."];
}

public function actualizarProducto($id, $nombre, $precio, $stock, $token) {
    if (!$this->autenticar($token)) {
        return [];
    }
    $stmt = $this->db->prepare("UPDATE productos SET nombre = ?, precio = ?, stock = ? WHERE id = ?");
    $stmt->execute([$nombre, $precio, $stock, $id]);
    return ["mensaje" => "Producto actualizado con éxito."];
}

public function eliminarProducto($nombre, $token) {
    if (!$this->autenticar($token)) {
        return [];
    }
    $stmt = $this->db->prepare("DELETE FROM productos WHERE nombre = ?");
    $stmt->execute([$nombre]);
    return ["mensaje" => "Producto '$nombre' eliminado con éxito."];
}

}



?>