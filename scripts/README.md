# Plataformas-abiertas
Este repositorio está dirigido a Trabajos Universitarios

#Primer Proyecto

#Integrante:
--Carlos Daniel Obando Lezama

Archivo README para la base de datos KVEstilos
a. Descripción del proyecto
KVEstilos es una base de datos diseñada para una tienda de ropa. El objetivo principal de esta base de datos es gestionar la información relacionada con las marcas, las prendas y las ventas realizadas. La base de datos consta de tres tablas principales: Marcas, Prendas y Ventas. Además, se han creado tres vistas para facilitar la consulta de datos importantes para la gestión del negocio.

Estructura de la base de datos

#Tablas:

Marcas: Contiene información sobre las diferentes marcas de ropa disponibles en la tienda.
Prendas: Almacena detalles sobre las prendas de ropa, incluyendo la marca, el nombre, la talla, el precio y el stock.
Ventas: Registra las ventas realizadas, especificando la prenda vendida, la fecha de la venta y la cantidad vendida.

#Vistas:

MarcasConVentas: Lista todas las marcas que han tenido al menos una venta.
PrendasVendidasConStock: Muestra las prendas vendidas junto con su cantidad restante en stock.
Top5MarcasMasVendidas: Lista las cinco marcas más vendidas y su cantidad de ventas.

b. Diagrama de la estructura de la base de datos

+----------------+         +----------------+         +----------------+
|    Marcas      |         |    Prendas     |         |    Ventas      |
+----------------+         +----------------+         +----------------+
| MarcaID (PK)   |<------- | PrendaID (PK)  |         | VentaID (PK)   |
| Nombre         |         | MarcaID (FK)   |         | PrendaID (FK)  |
+----------------+         | Nombre         |         | Fecha          |
                           | Talla          |         | Cantidad       |
                           | Precio         |         +----------------+
                           | Stock          |
                           +----------------+
#Marcas tiene una relación uno a muchos con Prendas.

--Un registro en Marcas puede estar relacionado con múltiples registros en Prendas.
--MarcaID es la clave primaria (PK) en Marcas y la clave foránea (FK) en Prendas.

#Prendas tiene una relación uno a muchos con Ventas.

--Un registro en Prendas puede estar relacionado con múltiples registros en Ventas.
--PrendaID es la clave primaria (PK) en Prendas y la clave foránea (FK) en Ventas.

#Creación de la base de datos y tablas

-- Creación de la base de datos KVEstilos
CREATE DATABASE KVEstilos;

-- Uso de la base de datos
USE KVEstilos;

-- Creación de la tabla Marcas
CREATE TABLE Marcas (
    MarcaID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL
);

-- Creación de la tabla Prendas
CREATE TABLE Prendas (
    PrendaID INT PRIMARY KEY AUTO_INCREMENT,
    MarcaID INT,
    Nombre VARCHAR(100) NOT NULL,
    Talla VARCHAR(10),
    Precio DECIMAL(10, 2) NOT NULL,
    Stock INT NOT NULL,
    FOREIGN KEY (MarcaID) REFERENCES Marcas(MarcaID)
);

-- Creación de la tabla Ventas
CREATE TABLE Ventas (
    VentaID INT PRIMARY KEY AUTO_INCREMENT,
    PrendaID INT,
    Fecha DATE NOT NULL,
    Cantidad INT NOT NULL,
    FOREIGN KEY (PrendaID) REFERENCES Prendas(PrendaID)
);


#Inserción de datos de ejemplo

-- Inserción de datos en la tabla Marcas
INSERT INTO Marcas (Nombre) VALUES
('Marca1'),
('Marca2'),
('Marca3');

-- Inserción de datos en la tabla Prendas
INSERT INTO Prendas (MarcaID, Nombre, Talla, Precio, Stock) VALUES
(1, 'Camiseta1', 'M', 19.99, 100),
(2, 'Pantalón1', 'L', 39.99, 50),
(3, 'Chaqueta1', 'S', 59.99, 30);

-- Inserción de datos en la tabla Ventas
INSERT INTO Ventas (PrendaID, Fecha, Cantidad) VALUES
(1, '2024-01-01', 5),
(2, '2024-01-02', 3),
(3, '2024-01-03', 2);


#Eliminación de un dato

-- Eliminación de un dato de la tabla Prendas
DELETE FROM Prendas WHERE PrendaID = 1;

#Actualización de un dato

-- Actualización de un dato en la tabla Prendas
UPDATE Prendas SET Precio = 29.99 WHERE PrendaID = 2;

#Consulta para obtener la cantidad vendida de prendas por fecha específica

-- Consulta para obtener la cantidad vendida de prendas por fecha específica
SELECT PrendaID, SUM(Cantidad) AS TotalVendido
FROM Ventas
WHERE Fecha = '2024-01-02'
GROUP BY PrendaID;

#Creación de vistas

-- Vista para obtener la lista de todas las marcas que tienen al menos una venta
CREATE VIEW MarcasConVentas AS
SELECT m.MarcaID, m.Nombre
FROM Marcas m
JOIN Prendas p ON m.MarcaID = p.MarcaID
JOIN Ventas v ON p.PrendaID = v.PrendaID
GROUP BY m.MarcaID, m.Nombre;

-- Vista para obtener prendas vendidas y su cantidad restante en stock
CREATE VIEW PrendasVendidasConStock AS
SELECT p.PrendaID, p.Nombre, p.Stock, SUM(v.Cantidad) AS TotalVendido
FROM Prendas p
JOIN Ventas v ON p.PrendaID = v.PrendaID
GROUP BY p.PrendaID, p.Nombre, p.Stock;

-- Vista para obtener el listado de las 5 marcas más vendidas y su cantidad de ventas
CREATE VIEW Top5MarcasMasVendidas AS
SELECT m.MarcaID, m.Nombre, SUM(v.Cantidad) AS TotalVendido
FROM Marcas m
JOIN Prendas p ON m.MarcaID = p.MarcaID
JOIN Ventas v ON p.PrendaID = v.PrendaID
GROUP BY m.MarcaID, m.Nombre
ORDER BY TotalVendido DESC
LIMIT 5;

