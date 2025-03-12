<?php
require_once "vendor/autoload.php";
require_once "vendor/econea/nusoap/src/nusoap.php";
require_once "servidor.php";

$namespace = "urn:miserviciowsdl";
$server = new nusoap_server();
$server->configureWSDL("MiServicioWeb", $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;


//definir el tipo complejo producto
$server->wsdl->addComplexType (
    'Producto',
    'complexType',
    'struct',
    'all',
    '',
    [
        'id' => ['name' => 'id', 'type' => 'xsd:int'],
        'nombre' => ['name' => 'nombre', 'type' => 'xsd:string'],
        'precio' => ['name' => 'precio', 'type' => 'xsd:decimal'],
        'stock' => ['name' => 'stock', 'type' => 'xsd:int'],
    ]
);

//definir el tipo complejo ListaProducto como un array de producto
$server->wsdl->addComplexType(
    'ListaProductos',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    [],
    [
        ['ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Producto[]']
    ],
    'tns:Producto'
);

//registrar metodos con los tipos de datos correctos
$server->register(
    "Servidor.obtenerProductos",
    ['token' => 'xsd:string'],
    ['return' => 'tns:ListaProductos'],
    $namespace, false, 'rpc', 'encoded', "Obtener la lista de productos"
);

$server->register(
    "Servidor.crearProducto",
    [
        'nombre' => 'xsd:string',
        'precio' => 'xsd:decimal',
        'stock' => 'xsd:int',
        'token' => 'xsd:string'
    ],
    ['return' => 'tns:Producto'],
    $namespace, false, 'rpc', 'encoded', "Crear un nuevo producto"
);

$server->register(
    "Servidor.actualizarProducto",
    [
        'id' => 'xsd:int',
        'nombre' => 'xsd:string',
        'precio' => 'xsd:decimal',
        'stock' => 'xsd:int',
        'token' => 'xsd:string'
    ],
    ['return' => 'tns:Producto'],
    $namespace, false, 'rpc', 'encoded', "Actualizar un producto existente"
);

$server->register(
    "Servidor.eliminarProducto",
    [
        'nombre' => 'xsd:string',
        'token' => 'xsd:string'
    ],
    ['return' => 'tns:Producto'],
    $namespace, false, 'rpc', 'encoded', "Eliminar un producto por nombre"
);

$server->service(file_get_contents("php://input"));

?>