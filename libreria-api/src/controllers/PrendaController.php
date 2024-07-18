<?php
require_once __DIR__ . '/../module/Prenda.php';

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
        $query = "SELECT p.PrendaID, p.MarcaID, p.Nombre, p.Talla, p.Precio, p.Stock, 
                         SUM(v.Cantidad) as cantidad_vendida, 
                         (p.Stock - SUM(v.Cantidad)) as stock_restante
                  FROM prendas p
                  JOIN ventas v ON p.PrendaID = v.PrendaID
                  GROUP BY p.PrendaID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }
}
?>
