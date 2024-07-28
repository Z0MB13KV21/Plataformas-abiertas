<?php
require_once '../src/db/Database.php';

class Venta {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM Ventas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM Ventas WHERE VentaID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO Ventas (PrendaID, Fecha, Cantidad) VALUES (?, ?, ?)");
        $stmt->execute([$data['PrendaID'], $data['Fecha'], $data['Cantidad']]);
        return ['id' => $this->db->lastInsertId()];
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE Ventas SET PrendaID = ?, Fecha = ?, Cantidad = ? WHERE VentaID = ?");
        $stmt->execute([$data['PrendaID'], $data['Fecha'], $data['Cantidad'], $id]);
        return ['success' => true];
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Ventas WHERE VentaID = ?");
        $stmt->execute([$id]);
        return ['success' => true];
    }

    public function getPrendas() {
        $stmt = $this->db->query("SELECT * FROM Prendas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMarcas() {
        $stmt = $this->db->query("SELECT * FROM Marcas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
