<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../configuracion/Database.php";
require_once "../clases/Productos.php";

$database = new Database();
$db = $database->getConnection();

$producto = new Productos($db);

$method = $_SERVER['REQUEST_METHOD'];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = "/RESTful/api";

$endpoint = str_replace($basePath, "", $uri);

$endpoint = trim($endpoint, "/");

$segments = explode("/", $endpoint);

if ($segments[0] !== "productos") {

    http_response_code(404);

    echo json_encode([
        "message" => "Recurso no encontrado"
    ]);

    exit;
}

if ($method === "GET" && count($segments) === 1) {

    $stmt = $producto->getProductos();

    $productos = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $productos[] = $row;
    }

    http_response_code(200);

    echo json_encode($productos);

    exit;
}

if ($method === "GET" && count($segments) === 2) {

    $producto->idProducto = $segments[1];

    if ($producto->getProducto()) {

        http_response_code(200);

        echo json_encode([
            "idProducto" => $producto->idProducto,
            "nombreproducto" => $producto->nombreproducto,
            "descripcion" => $producto->descripcion,
            "precioCompra" => $producto->precioCompra,
            "precioVenta" => $producto->precioVenta,
            "existencia" => $producto->existencia
        ]);

    } else {

        http_response_code(404);

        echo json_encode([
            "message" => "Producto no encontrado"
        ]);
    }

    exit;
}

if ($method === "POST" && count($segments) === 1) {

    $data = json_decode(file_get_contents("php://input"));

    $producto->nombreproducto = $data->nombreproducto;
    $producto->descripcion = $data->descripcion;
    $producto->precioCompra = $data->precioCompra;
    $producto->precioVenta = $data->precioVenta;
    $producto->existencia = $data->existencia;

    if ($producto->setProductos()) {

        http_response_code(201);

        echo json_encode([
            "status" => "success",
            "message" => "Producto creado correctamente"
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            "status" => "error",
            "message" => "Error al guardar"
        ]);
    }

    exit;
}

if ($method === "PUT" && count($segments) === 2) {

    $data = json_decode(file_get_contents("php://input"));

    $producto->idProducto = $segments[1];

    $producto->nombreproducto = $data->nombreproducto;
    $producto->descripcion = $data->descripcion;
    $producto->precioCompra = $data->precioCompra;
    $producto->precioVenta = $data->precioVenta;
    $producto->existencia = $data->existencia;

    if ($producto->updateProducto()) {

        http_response_code(200);

        echo json_encode([
            "message" => "Producto actualizado"
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            "message" => "Error al actualizar"
        ]);
    }

    exit;
}

if ($method === "DELETE" && count($segments) === 2) {

    $producto->idProducto = $segments[1];

    if ($producto->borrarProducto()) {

        http_response_code(200);

        echo json_encode([
            "message" => "Producto eliminado"
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            "message" => "No se pudo eliminar"
        ]);
    }

    exit;
}

http_response_code(405);

echo json_encode([
    "message" => "Método no permitido o ruta inválida"
]);

?>