-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-07-2025 a las 06:26:32
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
-- Base de datos: `servitax`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`) VALUES
(1, 'Pasajeros'),
(2, 'carga'),
(4, 'Eléctrico'),
(25, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `telefono`, `email`) VALUES
(1, 'Archugo Jiménez', '1112223333', 'prueba@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conductores`
--

CREATE TABLE `conductores` (
  `fo_conductores` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `Cédula` int(15) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `licencia` varchar(20) NOT NULL,
  `vehi_asig` int(150) NOT NULL,
  `E-mail` varchar(30) NOT NULL,
  `fo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `conductores`
--

INSERT INTO `conductores` (`fo_conductores`, `nombre`, `Cédula`, `direccion`, `celular`, `licencia`, `vehi_asig`, `E-mail`, `fo_usuario`) VALUES
(1, 'Perencejo Vargas', 1121863524, 'Cra. 54 # 35-25', '3205635978', 'C-1-222333666', 3641, 'pernvar@gmail.com', 3),
(3, 'Juan Vargas', 123456789, 'Calle Falsa 123', '3001234567', 'LIC12345', 0, 'juan.perez@example.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hoja_vida_taxis`
--

CREATE TABLE `hoja_vida_taxis` (
  `id_hoja_vida_taxis` int(11) NOT NULL,
  `Marca` varchar(15) NOT NULL,
  `Categoria` int(15) NOT NULL,
  `Modelo` varchar(15) NOT NULL,
  `fo_Placa` int(10) NOT NULL,
  `No_Orden` varchar(15) NOT NULL,
  `Fecha_Ingreso` date NOT NULL,
  `Fecha_Tecno_mecanica` date NOT NULL,
  `Vencimiento_Seguro _Obligatorio` date NOT NULL,
  `fo_Conductor` int(30) NOT NULL,
  `fo_revisiones` int(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `hoja_vida_taxis`
--

INSERT INTO `hoja_vida_taxis` (`id_hoja_vida_taxis`, `Marca`, `Categoria`, `Modelo`, `fo_Placa`, `No_Orden`, `Fecha_Ingreso`, `Fecha_Tecno_mecanica`, `Vencimiento_Seguro _Obligatorio`, `fo_Conductor`, `fo_revisiones`) VALUES
(7, 'LAND-ROVER', 0, '2022', 1236, '9874', '0000-00-00', '0000-00-00', '0000-00-00', 7, 5),
(8, 'CHANA', 0, '2018', 0, '9218', '0000-00-00', '0000-00-00', '0000-00-00', 3, 8),
(9, 'AUDI', 0, '2023', 2587, '4567', '2025-06-15', '2025-11-12', '2025-07-23', 6, 5),
(12, 'MG-GRAREN', 0, '2025', 4569, '7319', '2025-05-14', '2025-07-03', '2025-08-11', 8, 10),
(14, 'FERRARI', 0, '2025', 4628, '7319', '2025-03-04', '2025-04-15', '2025-12-06', 8, 3),
(15, 'KENWORK', 0, '2013', 4528, '7532', '2024-12-03', '2025-12-06', '2025-11-07', 7, 3),
(16, 'RENAULT', 0, '2019', 3641, '7896', '2023-12-08', '2025-09-23', '2025-12-08', 12, 63),
(17, 'BMW', 0, '2024', 4268, '4569', '2017-07-24', '2025-11-04', '2025-10-08', 5, 78),
(18, 'PORSHE', 0, '2015', 7519, '6482', '2015-06-06', '2025-08-05', '2025-12-24', 8, 1008),
(19, 'AUSTIN-1', 0, '2026', 4682, '5793', '2025-01-20', '2025-08-24', '2025-08-06', 4, 3),
(20, 'TOYOTA', 0, '2016', 4569, '5379', '2025-03-21', '2025-07-13', '2025-08-13', 23, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `id_mantenimiento` int(11) NOT NULL,
  `Placa` int(15) NOT NULL,
  `fecha_inicio_mant` date NOT NULL,
  `fecha_final_mant` date NOT NULL,
  `descripción` varchar(200) NOT NULL,
  `mant_preventivo` varchar(10) NOT NULL,
  `mant_correctivo` varchar(10) NOT NULL,
  `costo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `fo_cliente` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `fo_conductor` int(11) DEFAULT NULL,
  `fo_servicio` int(11) DEFAULT NULL,
  `fo_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `fo_cliente`, `total`, `fecha`, `fo_conductor`, `fo_servicio`, `fo_producto`) VALUES
(1, 1, 52000.00, '2025-07-09 22:45:26', 1, 2, NULL),
(2, 1, 35000.00, '2025-07-09 22:46:45', 3, NULL, NULL),
(4, 1, 52000.00, '2025-07-14 22:00:29', 1, NULL, NULL),
(5, 1, 52000.00, '2025-07-14 23:26:07', 3, 2, NULL),
(6, 1, 52000.00, '2025-07-14 23:27:03', 3, NULL, NULL),
(7, 1, 35000.00, '2025-07-14 23:28:34', 3, NULL, NULL),
(8, 1, 35000.00, '2025-07-14 23:32:20', 3, NULL, NULL),
(9, 1, 52000.00, '2025-07-15 00:56:40', 3, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `fo_cliente` int(11) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `fo_cliente`, `producto`, `descripcion`, `total`, `fecha`) VALUES
(1, 4, 'transporte carga', 'transporte de equipaje', 35000.00, '2025-07-08 02:17:15'),
(2, 5, 'transporte de lujo', 'vehículo de lujo', 52000.00, '2025-07-08 05:40:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fo_categoria` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `rol` varchar(150) NOT NULL,
  `clave` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `fo_categoria`, `cedula`, `celular`, `direccion`, `email`, `rol`, `clave`) VALUES
(1, 'Admin', 1, '', '', '', 'admin@example.com', 'administrador', 'password123'),
(2, 'Oscar Vanegas', 2, '79632605', '3202032333', 'Cra 12 a # 54-14 sur', 'oscar_ivanegas@soy.sena.edu.co', 'Administrador', '3529'),
(3, 'Archugo Jimenez', 1, '1212365479', '2458369874', 'Calle 35 # 8-24', 'archu_jimenez@gmail.com', 'Invitado', '2618');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `conductores`
--
ALTER TABLE `conductores`
  ADD PRIMARY KEY (`fo_conductores`),
  ADD KEY `fo_usuario` (`fo_usuario`) USING BTREE,
  ADD KEY `vehi_asig` (`vehi_asig`);

--
-- Indices de la tabla `hoja_vida_taxis`
--
ALTER TABLE `hoja_vida_taxis`
  ADD PRIMARY KEY (`id_hoja_vida_taxis`),
  ADD KEY `fo_revisiones` (`fo_revisiones`),
  ADD KEY `fo_Conductor` (`fo_Conductor`),
  ADD KEY `Placa` (`fo_Placa`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`id_mantenimiento`),
  ADD KEY `Placa` (`Placa`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fo_cliente` (`fo_cliente`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fo_categoria` (`fo_categoria`),
  ADD KEY `fo_categoria_2` (`fo_categoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `conductores`
--
ALTER TABLE `conductores`
  MODIFY `fo_conductores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `hoja_vida_taxis`
--
ALTER TABLE `hoja_vida_taxis`
  MODIFY `id_hoja_vida_taxis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `conductores`
--
ALTER TABLE `conductores`
  ADD CONSTRAINT `conductores_ibfk_1` FOREIGN KEY (`vehi_asig`) REFERENCES `hoja_vida_taxis` (`fo_Placa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `conductores_ibfk_2` FOREIGN KEY (`fo_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD CONSTRAINT `mantenimiento_ibfk_1` FOREIGN KEY (`Placa`) REFERENCES `hoja_vida_taxis` (`fo_revisiones`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`fo_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`fo_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
