<?php
require_once '../src/module/Prenda.php';

class PrendaController {
    private $model;
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->model = new Prenda($this->conn);
    }

    public function get($id = null) {
        if ($id) {
            echo json_encode($this->model->find($id));
        } else {
            echo json_encode($this->model->all());
        }
    }

    public function post() {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->model->create($data));
    }

    public function put($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->model->update($id, $data));
    }

    public function delete($id) {
        echo json_encode($this->model->delete($id));
    }

    public function getPrendasVendidas() {
        $query = "SELECT p.*, SUM(v.cantidad) as cantidad_vendida, p.stock - SUM(v.cantidad) as stock_restante
                  FROM prendas p
                  JOIN ventas v ON p.id = v.prenda_id
                  GROUP BY p.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }
}
?>
