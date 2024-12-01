-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2024 a las 19:32:39
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
-- Base de datos: `veterinaria_berlin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_mascota` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `id_veterinario` int(11) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `id_cliente`, `id_mascota`, `id_servicio`, `id_veterinario`, `fecha_hora`, `estado`) VALUES
(9, 2, 3, 1, 2, '2024-11-17 13:28:00', 'Programada'),
(10, 2, 3, 9, 1, '2024-11-17 13:33:00', 'Programada'),
(11, 1, 4, 9, 2, '2024-11-17 13:34:00', 'Programada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `direccion`) VALUES
(1, 'Brayan', 'Chacón Molina', 'Tobosi, Cartago'),
(2, 'Emma', 'Chacón  Thames', 'Costa Rica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_contacto`
--

CREATE TABLE `cliente_contacto` (
  `id_cliente` int(11) NOT NULL,
  `id_contacto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente_contacto`
--

INSERT INTO `cliente_contacto` (`id_cliente`, `id_contacto`) VALUES
(1, 3),
(1, 4),
(2, 5),
(2, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_producto`, `nombre_producto`, `descripcion`, `cantidad`, `precio_unitario`, `id_proveedor`) VALUES
(2, 'Simparica	', 'Tratamiento contra garrapatas', 18, 5000.00, 2),
(3, 'Apoquel', 'Alivio del prurito en perros', 20, 30000.00, 2),
(4, 'Rimadyl', 'Manejo del dolor en perros', 15, 25000.00, 1),
(5, 'Convenia', 'Tratamiento de infecciones bacterianas', 10, 40000.00, 4),
(6, 'Aminolite', 'Suplemento nutricional para aves', 10, 20000.00, 3),
(7, 'Virbac', 'Soluciones de salud animal', 29, 6000.00, 6),
(8, 'Vetnia', 'Portal veterinario', 8, 15000.00, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascotas`
--

CREATE TABLE `mascotas` (
  `id_mascota` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `nombre_mascota` varchar(255) NOT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `raza` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `historial_medico` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mascotas`
--

INSERT INTO `mascotas` (`id_mascota`, `id_cliente`, `nombre_mascota`, `especie`, `raza`, `edad`, `sexo`, `historial_medico`) VALUES
(3, 2, 'Denver', 'Perro', 'Salchicha', 1, 'Macho', NULL),
(4, 1, 'Coki', 'Perro', 'Perro', 5, 'Macho', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medio_contacto`
--

CREATE TABLE `medio_contacto` (
  `id_contacto` int(11) NOT NULL,
  `tipo_contacto` varchar(50) NOT NULL,
  `valor_contacto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medio_contacto`
--

INSERT INTO `medio_contacto` (`id_contacto`, `tipo_contacto`, `valor_contacto`) VALUES
(1, 'Telefono', '0800-012-2221'),
(2, 'Email', 'Hillspet@hillspet.com'),
(3, 'Telefono', '84292659'),
(4, 'Email', 'bchacon959@gmail.com'),
(5, 'Telefono', '8888888'),
(6, 'Email', 'emma@gmail.com'),
(7, 'Telefono', '+1 800-999-0297'),
(8, 'Email', 'contacto@zoetis.com'),
(9, 'Telefono', '+1 800-243-0127'),
(10, 'Email', 'vetmedica@boehringer-ingelheim.com'),
(11, 'Telefono', '+1 877-352-6261'),
(12, 'Email', 'contacto@elanco.com'),
(13, 'Telefono', '+1 800-521-5767'),
(14, 'Email', 'contacto@merck.com'),
(15, 'Telefono', '+1 800-338-3659'),
(16, 'Email', 'contacto@virbac.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_venta`, `metodo_pago`, `fecha_pago`, `monto`) VALUES
(11, 15, 'Tarjeta', '2024-12-01 12:31:30', 6000.00),
(12, 16, 'Tarjeta', '2024-12-01 12:31:30', 10000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `direccion`) VALUES
(1, 'Hillspet', 'Costa Rica'),
(2, 'Zoetis Inc', '10 Sylvan Way, Parsippany, NJ 07054, USA'),
(3, 'Boehringer Ingelheim Vetmedica', '900 Ridgebury Road, Ridgefield, CT 06877, USA'),
(4, 'Elanco Animal Health', '2500 Innovation Way, Greenfield, IN 46140, USA'),
(5, 'Merck Animal Health', '2 Giralda Farms, Madison, NJ 07940, USA'),
(6, 'Virbac Corporation', '3200 Meacham Blvd, Fort Worth, TX 76137, USA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor_contacto`
--

CREATE TABLE `proveedor_contacto` (
  `id_proveedor` int(11) NOT NULL,
  `id_contacto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor_contacto`
--

INSERT INTO `proveedor_contacto` (`id_proveedor`, `id_contacto`) VALUES
(1, 1),
(1, 2),
(2, 7),
(2, 8),
(3, 9),
(3, 10),
(4, 11),
(4, 12),
(5, 13),
(5, 14),
(6, 15),
(6, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombre_servicio` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`, `descripcion`, `precio`) VALUES
(1, 'Consulta General', 'Consulta médica general para revisar la salud del animal.', 50000.00),
(2, 'Vacunación', 'Aplicación de vacunas necesarias para prevenir enfermedades.', 30000.00),
(3, 'Desparasitación', 'Tratamiento para eliminar parásitos internos y externos.', 20000.00),
(4, 'Cirugía', 'Procedimientos quirúrgicos necesarios para tratar diversas condiciones.', 200000.00),
(5, 'Limpieza Dental', 'Limpieza profesional de los dientes del animal.', 30000.00),
(6, 'Radiografía', 'Toma de radiografías para diagnóstico de problemas internos.', 60000.00),
(7, 'Ecografía', 'Realización de ecografías para evaluación de órganos y tejidos.', 100000.00),
(8, 'Hospitalización', 'Cuidado y monitoreo del animal durante la hospitalización.', 150000.00),
(9, 'Peluquería', 'Servicio de peluquería y corte de pelo para el animal.', 10000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `tipo` enum('producto','servicio') DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha_venta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_cliente`, `id_producto`, `tipo`, `cantidad`, `total`, `fecha_venta`) VALUES
(15, 1, 7, NULL, 1, 6000.00, '2024-12-01 12:31:30'),
(16, 1, 2, NULL, 2, 10000.00, '2024-12-01 12:31:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinarios`
--

CREATE TABLE `veterinarios` (
  `id_veterinario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `id_especialidad` int(11) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `veterinarios`
--

INSERT INTO `veterinarios` (`id_veterinario`, `nombre`, `id_especialidad`, `telefono`, `email`) VALUES
(1, 'Dr. LUIS GERARDO HERRERA GAMBOA', 1, '8888-8888', 'luis.gerardo.herrera.gamboa@uca.ac.cr'),
(2, 'Dra. Nicole Paola López Jimenez', 2, '8888-8888', 'nicole.paola.lopez.jimenez@uca.ac.cr');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_veterinario` (`id_veterinario`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `cliente_contacto`
--
ALTER TABLE `cliente_contacto`
  ADD PRIMARY KEY (`id_cliente`,`id_contacto`),
  ADD KEY `id_contacto` (`id_contacto`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `medio_contacto`
--
ALTER TABLE `medio_contacto`
  ADD PRIMARY KEY (`id_contacto`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `proveedor_contacto`
--
ALTER TABLE `proveedor_contacto`
  ADD PRIMARY KEY (`id_proveedor`,`id_contacto`),
  ADD KEY `id_contacto` (`id_contacto`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `veterinarios`
--
ALTER TABLE `veterinarios`
  ADD PRIMARY KEY (`id_veterinario`),
  ADD KEY `id_especialidad` (`id_especialidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id_mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `medio_contacto`
--
ALTER TABLE `medio_contacto`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `veterinarios`
--
ALTER TABLE `veterinarios`
  MODIFY `id_veterinario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`id_mascota`) REFERENCES `mascotas` (`id_mascota`),
  ADD CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `citas_ibfk_4` FOREIGN KEY (`id_veterinario`) REFERENCES `veterinarios` (`id_veterinario`);

--
-- Filtros para la tabla `cliente_contacto`
--
ALTER TABLE `cliente_contacto`
  ADD CONSTRAINT `cliente_contacto_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `cliente_contacto_ibfk_2` FOREIGN KEY (`id_contacto`) REFERENCES `medio_contacto` (`id_contacto`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
