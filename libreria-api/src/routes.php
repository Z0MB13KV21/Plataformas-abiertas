<?php
require_once __DIR__ . '/controllers/MarcaController.php';
require_once __DIR__ . '/controllers/PrendaController.php';
require_once __DIR__ . '/controllers/VentaController.php';

$marcaController = new MarcaController();
$prendaController = new PrendaController();
$ventaController = new VentaController();

$request_method = $_SERVER['REQUEST_METHOD'];
//var_dump($_SERVER);
$path = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/') : '';
$segmentosDeUrl = explode('/', $path);

$rutaControlador = array_shift($segmentosDeUrl);
$id = !empty($segmentosDeUrl) ? end($segmentosDeUrl) : null;
//var_dump($rutaControlador);
switch ($rutaControlador) {
    case 'marcas':
        switch ($request_method) {
            case 'GET':
                if (isset($segmentosDeUrl[0]) && $segmentosDeUrl[0] == 'conVentas') {
                    $marcaController->getMarcasConVentas();
                } elseif (isset($segmentosDeUrl[0]) && $segmentosDeUrl[0] == 'top5') {
                    $marcaController->getTop5Marcas();
                } elseif (isset($_GET['nombre'])) {
                    $nombre = $_GET['nombre'];
                    echo json_encode(['exists' => $marcaController->checkMarcaNombre($nombre)]);
                } else {
                    $marcaController->get($id);
                }
                break;
            case 'POST':
                $marcaController->post();
                break;
            case 'PUT':
                $marcaController->put($id);
                break;
            case 'DELETE':
                $marcaController->delete($id);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                echo json_encode(['error' => 'Método no permitido']);
        }
        break;
    

    case 'prendas':
        switch ($request_method) {
            case 'GET':
                if (isset($segmentosDeUrl[0]) && $segmentosDeUrl[0] == 'vendidas') {
                    $prendaController->getPrendasVendidas();
                } else {
                    $prendaController->get($id);
                }
                break;
            case 'POST':
                $prendaController->post();
                break;
            case 'PUT':
                $prendaController->put($id);
                break;
            case 'DELETE':
                $prendaController->delete($id);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                echo json_encode(['error' => 'Método no permitido']);
        }
        break;

    case 'ventas':
        switch ($request_method) {
            case 'GET':
                $ventaController->get($id);
                break;
            case 'POST':
                $ventaController->post();
                break;
            case 'PUT':
                $ventaController->put($id);
                break;
            case 'DELETE':
                $ventaController->delete($id);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                echo json_encode(['error' => 'Método no permitido']);
        }
        break;

    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['error' => 'Ruta no encontrada']);
        break;
}
?>
