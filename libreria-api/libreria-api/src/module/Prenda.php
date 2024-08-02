<?php
class Prenda {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function find($id) {
        $query = "SELECT * FROM prendas WHERE PrendaID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all() {
        $query = "SELECT * FROM prendas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO prendas (MarcaID, Nombre, Talla, Precio, Stock, StockAcumulado) VALUES (:marca_id, :nombre, :talla, :precio, :stock, :stock_acumulado)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':marca_id', $data['marca_id'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':talla', $data['talla']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':stock_acumulado', $data['stock_acumulado']);
        $stmt->execute();
        return ['id' => $this->conn->lastInsertId()];
    }

    public function update($id, $data) {
        $query = "UPDATE prendas SET MarcaID = :marca_id, Nombre = :nombre, Talla = :talla, Precio = :precio, Stock = :stock, StockAcumulado = :stock_acumulado WHERE PrendaID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':marca_id', $data['marca_id'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':talla', $data['talla']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':stock_acumulado', $data['stock_acumulado']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return ['status' => 'updated'];
    }

    public function delete($id) {
        $query = "DELETE FROM prendas WHERE PrendaID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return ['status' => 'deleted'];
    }

    public function existsByName($nombre) {
        $query = "SELECT * FROM prendas WHERE Nombre = :nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para incrementar el stock acumulado
    public function incrementStockAcumulado($id, $cantidad) {
        $prenda = $this->find($id);
        $nuevoStockAcumulado = $prenda['StockAcumulado'] + $cantidad;

        $query = "UPDATE prendas SET StockAcumulado = :stock_acumulado WHERE PrendaID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':stock_acumulado', $nuevoStockAcumulado);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return ['status' => 'updated'];
    }
}
?>
