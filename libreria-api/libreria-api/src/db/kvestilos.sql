-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2024 a las 05:45:29
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kvestilos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `MarcaID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`MarcaID`, `Nombre`) VALUES
(1, 'Mike'),
(2, 'Ardidas'),
(3, 'AeroPostal'),
(6, 'sitcom');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `marcasconventas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `marcasconventas` (
`MarcaID` int(11)
,`Nombre` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prendas`
--

CREATE TABLE `prendas` (
  `PrendaID` int(11) NOT NULL,
  `MarcaID` int(11) DEFAULT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Talla` varchar(10) DEFAULT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prendas`
--

INSERT INTO `prendas` (`PrendaID`, `MarcaID`, `Nombre`, `Talla`, `Precio`, `Stock`) VALUES
(2, 3, 'pantalon', 'XL', 121.00, 50),
(3, 2, 'Chaqueta1', 'S', 59.99, 30),
(4, 6, 'as', 'asd', 123.00, 123),
(7, 2, 'asd', 'asd', 123.00, 123);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `prendasvendidasconstock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `prendasvendidasconstock` (
`PrendaID` int(11)
,`Nombre` varchar(100)
,`Stock` int(11)
,`TotalVendido` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `top5marcasmasvendidas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `top5marcasmasvendidas` (
`MarcaID` int(11)
,`Nombre` varchar(100)
,`TotalVendido` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `VentaID` int(11) NOT NULL,
  `PrendaID` int(11) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`VentaID`, `PrendaID`, `Fecha`, `Cantidad`) VALUES
(2, 2, '2024-01-02', 3),
(3, 3, '2024-01-03', 2),
(4, 2, '2024-07-19', 1),
(5, 4, '2024-07-17', 1);

-- --------------------------------------------------------

--
-- Estructura para la vista `marcasconventas`
--
DROP TABLE IF EXISTS `marcasconventas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `marcasconventas`  AS SELECT `m`.`MarcaID` AS `MarcaID`, `m`.`Nombre` AS `Nombre` FROM ((`marcas` `m` join `prendas` `p` on(`m`.`MarcaID` = `p`.`MarcaID`)) join `ventas` `v` on(`p`.`PrendaID` = `v`.`PrendaID`)) GROUP BY `m`.`MarcaID`, `m`.`Nombre` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `prendasvendidasconstock`
--
DROP TABLE IF EXISTS `prendasvendidasconstock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prendasvendidasconstock`  AS SELECT `p`.`PrendaID` AS `PrendaID`, `p`.`Nombre` AS `Nombre`, `p`.`Stock` AS `Stock`, sum(`v`.`Cantidad`) AS `TotalVendido` FROM (`prendas` `p` join `ventas` `v` on(`p`.`PrendaID` = `v`.`PrendaID`)) GROUP BY `p`.`PrendaID`, `p`.`Nombre`, `p`.`Stock` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `top5marcasmasvendidas`
--
DROP TABLE IF EXISTS `top5marcasmasvendidas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `top5marcasmasvendidas`  AS SELECT `m`.`MarcaID` AS `MarcaID`, `m`.`Nombre` AS `Nombre`, sum(`v`.`Cantidad`) AS `TotalVendido` FROM ((`marcas` `m` join `prendas` `p` on(`m`.`MarcaID` = `p`.`MarcaID`)) join `ventas` `v` on(`p`.`PrendaID` = `v`.`PrendaID`)) GROUP BY `m`.`MarcaID`, `m`.`Nombre` ORDER BY sum(`v`.`Cantidad`) DESC LIMIT 0, 5 ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`MarcaID`);

--
-- Indices de la tabla `prendas`
--
ALTER TABLE `prendas`
  ADD PRIMARY KEY (`PrendaID`),
  ADD KEY `MarcaID` (`MarcaID`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`VentaID`),
  ADD KEY `PrendaID` (`PrendaID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `MarcaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `prendas`
--
ALTER TABLE `prendas`
  MODIFY `PrendaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `VentaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
