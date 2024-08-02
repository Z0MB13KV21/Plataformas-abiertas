<?php
require_once __DIR__ . '/../module/Venta.php';

class VentaController {
    private $model;

    public function __construct() {
        $this->model = new Venta();
    }

    public function get($id = null) {
        try {
            if ($id) {
                $result = $this->model->find($id);
                if ($result) {
                    echo json_encode($result);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Venta no encontrada.']);
                }
            } else {
                echo json_encode($this->model->all());
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener ventas: ' . $e->getMessage()]);
        }
    }

    public function post() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
    
            // Validar los datos de la venta
            if (!$this->validateData($data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Datos inválidos.']);
                return;
            }
    
            // Crear la venta
            $result = $this->model->create($data);
    
            // Actualizar el stock de la prenda
            $stockUpdated = $this->model->updateStock($data['PrendaID'], $data['Cantidad']);
            if (!$stockUpdated) {
                http_response_code(400);
                echo json_encode(['error' => 'No hay suficiente stock para completar la venta.']);
                return;
            }
    
            echo json_encode($result);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear venta: ' . $e->getMessage()]);
        }
    }
    

public function put($id) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar los datos de la venta
        if (!$this->validateData($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos inválidos.']);
            return;
        }

        // Obtener la venta actual para comparar con la nueva
        $ventaActual = $this->model->find($id);
        if (!$ventaActual) {
            http_response_code(404);
            echo json_encode(['error' => 'Venta no encontrada.']);
            return;
        }

        // Actualizar la venta
        $result = $this->model->update($id, $data);

        // Ajustar el stock: sumar la cantidad anterior y restar la nueva
        $this->model->updateStock($ventaActual['PrendaID'], $ventaActual['Cantidad']);
        $stockUpdated = $this->model->updateStock($data['PrendaID'], $data['Cantidad']);
        if (!$stockUpdated) {
            http_response_code(400);
            echo json_encode(['error' => 'No hay suficiente stock para completar la venta.']);
            return;
        }

        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al actualizar venta: ' . $e->getMessage()]);
    }
}


    public function delete($id) {
        try {
            $result = $this->model->delete($id);
            if ($result['success']) {
                echo json_encode(['success' => 'Venta eliminada con éxito.']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Venta no encontrada.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar venta: ' . $e->getMessage()]);
        }
    }

    private function validateData($data) {
        if (!isset($data['PrendaID']) || !isset($data['Fecha']) || !isset($data['Cantidad'])) {
            return false;
        }
    
        if (!is_numeric($data['Cantidad']) || $data['Cantidad'] <= 0) {
            return false;
        }
    
        $fecha = DateTime::createFromFormat('Y-m-d', $data['Fecha']);
        if (!$fecha || $fecha->format('Y-m-d') !== $data['Fecha']) {
            return false;
        }
    
        return true;
    }
    
}
?>
