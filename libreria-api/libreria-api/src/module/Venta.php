<?php
require_once '../src/db/Database.php';

class Venta {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function all() {
        try {
            $stmt = $this->db->query("SELECT * FROM Ventas");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching ventas: ' . $e->getMessage()];
        }
    }

    public function find($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM Ventas WHERE VentaID = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching venta: ' . $e->getMessage()];
        }
    }

    public function create($data) {
        try {
            $stmt = $this->db->prepare("INSERT INTO Ventas (PrendaID, Fecha, Cantidad) VALUES (?, ?, ?)");
            $stmt->execute([$data['PrendaID'], $data['Fecha'], $data['Cantidad']]);
            return ['id' => $this->db->lastInsertId()];
        } catch (PDOException $e) {
            return ['error' => 'Error creating venta: ' . $e->getMessage()];
        }
    }

    public function update($id, $data) {
        try {
            $stmt = $this->db->prepare("UPDATE Ventas SET PrendaID = ?, Fecha = ?, Cantidad = ? WHERE VentaID = ?");
            $stmt->execute([$data['PrendaID'], $data['Fecha'], $data['Cantidad'], $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['error' => 'Error updating venta: ' . $e->getMessage()];
        }
    }

    public function updateStock($prendaId, $cantidad) {
        try {
            // Obtener el stock actual de la prenda
            $stmt = $this->db->prepare("SELECT Stock FROM Prendas WHERE PrendaID = ?");
            $stmt->execute([$prendaId]);
            $prenda = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($prenda) {
                $stock = $prenda['Stock'];
    
                // Actualizar el stock
                $newStock = $stock + $cantidad; // La cantidad puede ser negativa si se reduce el stock
                $stmt = $this->db->prepare("UPDATE Prendas SET Stock = ? WHERE PrendaID = ?");
                $stmt->execute([$newStock, $prendaId]);
                return true;
            } else {
                return false; // Prenda no encontrada
            }
        } catch (PDOException $e) {
            return ['error' => 'Error updating stock: ' . $e->getMessage()];
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM Ventas WHERE VentaID = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['error' => 'Error deleting venta: ' . $e->getMessage()];
        }
    }

    public function getPrendas() {
        try {
            $stmt = $this->db->query("SELECT * FROM Prendas");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching prendas: ' . $e->getMessage()];
        }
    }

    public function getMarcas() {
        try {
            $stmt = $this->db->query("SELECT * FROM Marcas");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching marcas: ' . $e->getMessage()];
        }
    }

    public function checkStock($prendaId, $cantidad) {
        try {
            // Obtener el stock actual de la prenda
            $stmt = $this->db->prepare("SELECT Stock FROM Prendas WHERE PrendaID = ?");
            $stmt->execute([$prendaId]);
            $prenda = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($prenda) {
                return $prenda['Stock'] >= $cantidad;
            }
            return false; // Prenda no encontrada
        } catch (PDOException $e) {
            return false; // Error al verificar stock
        }
    }
}
?>
