<?php
class Prenda {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function find($id) {
        $query = "SELECT * FROM prendas WHERE PrendaID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
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
        $query = "INSERT INTO prendas (MarcaID, Nombre, Talla, Precio, Stock) VALUES (:marca_id, :nombre, :talla, :precio, :stock)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':marca_id', $data['MarcaID']);
        $stmt->bindParam(':nombre', $data['Nombre']);
        $stmt->bindParam(':talla', $data['Talla']);
        $stmt->bindParam(':precio', $data['Precio']);
        $stmt->bindParam(':stock', $data['Stock']);
        $stmt->execute();
        return ['id' => $this->conn->lastInsertId()];
    }

    public function update($id, $data) {
        $query = "UPDATE prendas SET MarcaID = :marca_id, Nombre = :nombre, Talla = :talla, Precio = :precio, Stock = :stock WHERE PrendaID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':marca_id', $data['MarcaID']);
        $stmt->bindParam(':nombre', $data['Nombre']);
        $stmt->bindParam(':talla', $data['Talla']);
        $stmt->bindParam(':precio', $data['Precio']);
        $stmt->bindParam(':stock', $data['Stock']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return ['status' => 'updated'];
    }

    public function delete($id) {
        $query = "DELETE FROM prendas WHERE PrendaID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return ['status' => 'deleted'];
    }
}
?>
