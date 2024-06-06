-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2024 a las 09:54:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Creación de la base de datos KVEstilos la tienda de ropa
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

-- Eliminación de un dato de la tabla Prendas
DELETE FROM ventas WHERE PrendaID = 1;
DELETE FROM Prendas WHERE PrendaID = 1;

-- Actualización de un dato en la tabla Prendas
UPDATE Prendas SET Precio = 29.99 WHERE PrendaID = 2;

-- Consulta para obtener la cantidad vendida de prendas por fecha específica
SELECT PrendaID, SUM(Cantidad) AS TotalVendido
FROM Ventas
WHERE Fecha = '2024-01-02'
GROUP BY PrendaID;

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
