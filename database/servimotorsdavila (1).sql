-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2024 a las 10:48:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servimotorsdavila`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avenidas`
--

CREATE TABLE `avenidas` (
  `avenidaId` int(11) NOT NULL,
  `nombreAvenida` varchar(50) NOT NULL,
  `parroquiaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `avenidas`
--

INSERT INTO `avenidas` (`avenidaId`, `nombreAvenida`, `parroquiaId`) VALUES
(2, 'Awewe', 2),
(1, 'Marcos2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calles`
--

CREATE TABLE `calles` (
  `calleId` int(11) NOT NULL,
  `nombreCalle` varchar(50) NOT NULL,
  `avenidaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calles`
--

INSERT INTO `calles` (`calleId`, `nombreCalle`, `avenidaId`) VALUES
(2, 'A2', 2),
(1, 'Osuna rodriguez', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casasapartamentos`
--

CREATE TABLE `casasapartamentos` (
  `casaApartamentoId` int(11) NOT NULL,
  `calleId` int(11) NOT NULL,
  `detalleCasaApartamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `casasapartamentos`
--

INSERT INTO `casasapartamentos` (`casaApartamentoId`, `calleId`, `detalleCasaApartamento`) VALUES
(2, 2, 'A2'),
(1, 1, 'Casa #2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cedula` varchar(8) NOT NULL,
  `primerNombre` varchar(30) NOT NULL,
  `segundoNombre` varchar(30) DEFAULT NULL,
  `primerApellido` varchar(30) NOT NULL,
  `segundoApellido` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactosusuario`
--

CREATE TABLE `contactosusuario` (
  `cedula` varchar(8) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `correo` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactosusuario`
--

INSERT INTO `contactosusuario` (`cedula`, `telefono`, `correo`) VALUES
('10713691', '04121009318', 'ander@gmail.com'),
('29634134', '04147510509', 'andersonlobo20@hotmail.com'),
('30478744', '04147687004', 'paolanathaly@gmail.com'),
('65465488', '04121009318', 'thania@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosusuario`
--

CREATE TABLE `datosusuario` (
  `cedula` varchar(8) DEFAULT NULL,
  `primerNombre` varchar(30) NOT NULL,
  `segundoNombre` varchar(30) NOT NULL,
  `primerApellido` varchar(30) NOT NULL,
  `segundoApellido` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datosusuario`
--

INSERT INTO `datosusuario` (`cedula`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`) VALUES
('10713691', 'Anderson', 'Alejandro', 'Lobo', 'uzcategui'),
('29634134', 'Anderson', 'Alejandro', 'lobo', 'uzcategui'),
('30478744', 'Paola', 'Nathaly', 'Solarte', 'Rivas'),
('65465488', 'Thania', 'DEciree', 'Uzcategui', 'Rico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `cedulaCliente` varchar(8) NOT NULL,
  `casaApartamentoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `estadoId` int(11) NOT NULL,
  `nombreEstado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`estadoId`, `nombreEstado`) VALUES
(2, 'Aewe'),
(1, 'Merida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `municipioId` int(11) NOT NULL,
  `nombreMunicipio` varchar(50) NOT NULL,
  `estadoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`municipioId`, `nombreMunicipio`, `estadoId`) VALUES
(1, 'Aefe', 1),
(2, 'Aew', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parroquias`
--

CREATE TABLE `parroquias` (
  `parroquiaId` int(11) NOT NULL,
  `nombreParroquia` varchar(50) NOT NULL,
  `municipioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parroquias`
--

INSERT INTO `parroquias` (`parroquiaId`, `nombreParroquia`, `municipioId`) VALUES
(1, 'Awero', 1),
(2, 'Awew', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rolusuario`
--

CREATE TABLE `rolusuario` (
  `idRol` int(11) NOT NULL,
  `nombreRol` enum('Administrador','Secretaría') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rolusuario`
--

INSERT INTO `rolusuario` (`idRol`, `nombreRol`) VALUES
(1, 'Administrador'),
(2, 'Secretaría');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos`
--

CREATE TABLE `telefonos` (
  `cedulaCliente` varchar(8) NOT NULL,
  `telefonoPersonal` varchar(11) DEFAULT NULL,
  `telefonoFijo` varchar(11) DEFAULT NULL,
  `telefonoOpcional` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cedula` varchar(8) NOT NULL,
  `idRol` int(11) DEFAULT NULL,
  `nombreUsuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cedula`, `idRol`, `nombreUsuario`, `contrasena`) VALUES
('29634134', 1, 'Ander', '$2y$10$VfGq0b6HXzHjvj/9dnO9.uiBbZVcFwLMFBflaeutKu8fcnE7VIdQC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avenidas`
--
ALTER TABLE `avenidas`
  ADD PRIMARY KEY (`avenidaId`),
  ADD UNIQUE KEY `nombreAvenida` (`nombreAvenida`,`parroquiaId`),
  ADD KEY `parroquiaId` (`parroquiaId`);

--
-- Indices de la tabla `calles`
--
ALTER TABLE `calles`
  ADD PRIMARY KEY (`calleId`),
  ADD UNIQUE KEY `nombreCalle` (`nombreCalle`,`avenidaId`),
  ADD KEY `avenidaId` (`avenidaId`);

--
-- Indices de la tabla `casasapartamentos`
--
ALTER TABLE `casasapartamentos`
  ADD PRIMARY KEY (`casaApartamentoId`),
  ADD UNIQUE KEY `detalleCasaApartamento` (`detalleCasaApartamento`,`calleId`),
  ADD KEY `calleId` (`calleId`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `contactosusuario`
--
ALTER TABLE `contactosusuario`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `datosusuario`
--
ALTER TABLE `datosusuario`
  ADD KEY `cedula` (`cedula`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`cedulaCliente`),
  ADD KEY `casaApartamentoId` (`casaApartamentoId`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`estadoId`),
  ADD UNIQUE KEY `nombreEstado` (`nombreEstado`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`municipioId`),
  ADD UNIQUE KEY `nombreMunicipio` (`nombreMunicipio`,`estadoId`),
  ADD KEY `estadoId` (`estadoId`);

--
-- Indices de la tabla `parroquias`
--
ALTER TABLE `parroquias`
  ADD PRIMARY KEY (`parroquiaId`),
  ADD UNIQUE KEY `nombreParroquia` (`nombreParroquia`,`municipioId`),
  ADD KEY `municipioId` (`municipioId`);

--
-- Indices de la tabla `rolusuario`
--
ALTER TABLE `rolusuario`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD PRIMARY KEY (`cedulaCliente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `nombreUsuario` (`nombreUsuario`),
  ADD UNIQUE KEY `contrasena` (`contrasena`),
  ADD KEY `idRol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avenidas`
--
ALTER TABLE `avenidas`
  MODIFY `avenidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `calles`
--
ALTER TABLE `calles`
  MODIFY `calleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `casasapartamentos`
--
ALTER TABLE `casasapartamentos`
  MODIFY `casaApartamentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `estadoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `municipioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `parroquias`
--
ALTER TABLE `parroquias`
  MODIFY `parroquiaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rolusuario`
--
ALTER TABLE `rolusuario`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `avenidas`
--
ALTER TABLE `avenidas`
  ADD CONSTRAINT `avenidas_ibfk_1` FOREIGN KEY (`parroquiaId`) REFERENCES `parroquias` (`parroquiaId`);

--
-- Filtros para la tabla `calles`
--
ALTER TABLE `calles`
  ADD CONSTRAINT `calles_ibfk_1` FOREIGN KEY (`avenidaId`) REFERENCES `avenidas` (`avenidaId`);

--
-- Filtros para la tabla `casasapartamentos`
--
ALTER TABLE `casasapartamentos`
  ADD CONSTRAINT `casasapartamentos_ibfk_1` FOREIGN KEY (`calleId`) REFERENCES `calles` (`calleId`);

--
-- Filtros para la tabla `contactosusuario`
--
ALTER TABLE `contactosusuario`
  ADD CONSTRAINT `contactosusuario_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`) ON DELETE CASCADE;

--
-- Filtros para la tabla `datosusuario`
--
ALTER TABLE `datosusuario`
  ADD CONSTRAINT `datosusuario_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`) ON DELETE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`cedulaCliente`) REFERENCES `clientes` (`cedula`),
  ADD CONSTRAINT `direcciones_ibfk_2` FOREIGN KEY (`casaApartamentoId`) REFERENCES `casasapartamentos` (`casaApartamentoId`);

--
-- Filtros para la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`estadoId`) REFERENCES `estados` (`estadoId`);

--
-- Filtros para la tabla `parroquias`
--
ALTER TABLE `parroquias`
  ADD CONSTRAINT `parroquias_ibfk_1` FOREIGN KEY (`municipioId`) REFERENCES `municipios` (`municipioId`);

--
-- Filtros para la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD CONSTRAINT `telefonos_ibfk_1` FOREIGN KEY (`cedulaCliente`) REFERENCES `clientes` (`cedula`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rolusuario` (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
