<?php
require_once '../src/module/Marca.php';

class MarcaController {
    private $model;
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->model = new Marca($this->conn);
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

    public function getMarcasConVentas() {
        $query = "SELECT DISTINCT m.* FROM marcas m JOIN ventas v ON m.id = v.marca_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function getTop5Marcas() {
        $query = "SELECT m.*, COUNT(v.id) as cantidad_ventas
                  FROM marcas m
                  JOIN ventas v ON m.id = v.marca_id
                  GROUP BY m.id
                  ORDER BY cantidad_ventas DESC
                  LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }
}
?>
