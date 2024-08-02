<?php
require_once __DIR__ . '/../module/Marca.php';

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
    $nombre = $data['nombre'];

    // Comprobar si el nombre de la marca ya existe
    if ($this->model->existsByName($nombre)) {
        echo json_encode(['error' => 'La marca ya existe.']);
        http_response_code(400); // Bad Request
        return;
    }

    echo json_encode($this->model->create($data));
}

public function put($id) {
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];

    // Comprobar si el nombre de la marca ya existe para otra marca
    $existingMarca = $this->model->existsByName($nombre);
    if ($existingMarca && $existingMarca['MarcaID'] != $id) {
        echo json_encode(['error' => 'La marca ya existe.']);
        http_response_code(400); // Bad Request
        return;
    }

    echo json_encode($this->model->update($id, $data));
}

    public function delete($id) {
        echo json_encode($this->model->delete($id));
    }

    public function getMarcasConVentas() {
        $query = "SELECT DISTINCT m.*
                  FROM marcas m
                  JOIN prendas p ON m.MarcaID = p.MarcaID
                  JOIN ventas v ON p.PrendaID = v.PrendaID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function getTop5Marcas() {
        $query = "SELECT m.MarcaID, m.Nombre, SUM(v.Cantidad) as cantidad_vendida
                  FROM marcas m
                  JOIN prendas p ON m.MarcaID = p.MarcaID
                  JOIN ventas v ON p.PrendaID = v.PrendaID
                  GROUP BY m.MarcaID, m.Nombre
                  ORDER BY cantidad_vendida DESC
                  LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function checkMarcaNombre($nombre) {
        $query = "SELECT COUNT(*) as count FROM marcas WHERE Nombre = :nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}
?>
