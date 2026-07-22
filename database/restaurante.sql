-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-07-2026 a las 02:07:28
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `adelanto` decimal(10,2) DEFAULT NULL,
  `total_consumo` decimal(10,2) DEFAULT NULL,
  `total_pagar` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `pedido_id`, `adelanto`, `total_consumo`, `total_pagar`, `fecha`) VALUES
(1, 1, 0.00, 13.00, 13.00, '2026-07-21 18:17:54'),
(2, 2, 0.00, 52.00, 52.00, '2026-07-21 18:18:09'),
(3, 3, 0.00, 88.00, 88.00, '2026-07-21 18:19:17'),
(4, 4, 0.00, 126.00, 126.00, '2026-07-21 20:45:21'),
(5, 5, 0.00, 41.00, 41.00, '2026-07-21 21:20:21'),
(6, 6, 0.00, 81.00, 81.00, '2026-07-21 21:20:25'),
(7, 7, 15.00, 15.00, 0.00, '2026-07-21 21:20:27'),
(8, 8, 0.00, 90.00, 90.00, '2026-07-21 21:20:30'),
(9, 9, 30.00, 64.00, 34.00, '2026-07-21 21:20:32'),
(10, 10, 0.00, 20.00, 20.00, '2026-07-21 21:24:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `activo`, `creado`, `actualizado`) VALUES
(1, 'General', NULL, 1, '2026-07-20 15:40:34', '2026-07-20 15:40:34'),
(2, 'Menu Tarde', 'Menu tarde', 1, '2026-07-20 15:55:21', '2026-07-20 15:55:21'),
(3, 'Platos principales', 'Platos fuertes de la carta.', 1, '2026-07-20 16:57:24', '2026-07-20 16:57:24'),
(4, 'Bebidas', 'Bebidas frías y calientes.', 1, '2026-07-20 16:57:24', '2026-07-20 16:57:24'),
(5, 'Entradas', 'Entradas y piqueos.', 1, '2026-07-20 16:57:24', '2026-07-20 16:57:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombres`, `apellidos`, `dni`, `telefono`, `creado`) VALUES
(1, 'Jhonatan', 'Fernandez', '78018294', '902211958', '2026-07-21 17:21:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros`
--

CREATE TABLE `cobros` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `cajera_id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo` enum('Efectivo','Tarjeta','Yape','Plin','QR') NOT NULL,
  `comprobante` enum('Boleta','Factura') NOT NULL DEFAULT 'Boleta',
  `numero_operacion` varchar(100) DEFAULT NULL,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cobros`
--

INSERT INTO `cobros` (`id`, `pedido_id`, `cajera_id`, `monto`, `metodo`, `comprobante`, `numero_operacion`, `creado`) VALUES
(1, 1, 1, 13.00, 'Efectivo', 'Factura', NULL, '2026-07-21 18:17:54'),
(2, 2, 1, 52.00, 'Efectivo', 'Boleta', NULL, '2026-07-21 18:18:09'),
(3, 3, 1, 88.00, 'Efectivo', 'Boleta', NULL, '2026-07-21 18:19:17'),
(4, 4, 1, 126.00, 'Efectivo', 'Boleta', NULL, '2026-07-21 20:45:21'),
(5, 5, 10, 41.00, 'Efectivo', 'Boleta', NULL, '2026-07-21 21:20:21'),
(6, 6, 10, 81.00, 'Efectivo', 'Boleta', NULL, '2026-07-21 21:20:25'),
(7, 7, 10, 0.00, 'Efectivo', 'Boleta', NULL, '2026-07-21 21:20:27'),
(8, 8, 10, 90.00, 'Efectivo', 'Boleta', NULL, '2026-07-21 21:20:30'),
(9, 9, 10, 34.00, 'Efectivo', 'Boleta', NULL, '2026-07-21 21:20:32'),
(10, 10, 1, 20.00, 'Efectivo', 'Boleta', NULL, '2026-07-21 21:24:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio`, `subtotal`) VALUES
(1, 1, 1, 1, 13.00, 13.00),
(2, 2, 1, 4, 13.00, 52.00),
(3, 3, 3, 4, 22.00, 88.00),
(4, 4, 3, 1, 22.00, 22.00),
(5, 4, 3, 2, 22.00, 44.00),
(6, 4, 4, 2, 30.00, 60.00),
(7, 5, 7, 1, 15.00, 15.00),
(8, 5, 7, 1, 15.00, 15.00),
(9, 5, 5, 1, 5.00, 5.00),
(10, 5, 6, 1, 6.00, 6.00),
(11, 6, 7, 1, 15.00, 15.00),
(12, 6, 3, 3, 22.00, 66.00),
(13, 7, 5, 3, 5.00, 15.00),
(14, 8, 4, 3, 30.00, 90.00),
(15, 9, 5, 4, 5.00, 20.00),
(16, 9, 3, 2, 22.00, 44.00),
(17, 10, 5, 4, 5.00, 20.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_espera`
--

CREATE TABLE `lista_espera` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `personas` int(11) DEFAULT NULL,
  `estado` enum('En espera','Atendido','Cancelado') NOT NULL DEFAULT 'En espera',
  `mesa_id` int(11) DEFAULT NULL,
  `atendido_en` datetime DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lista_espera`
--

INSERT INTO `lista_espera` (`id`, `nombres`, `telefono`, `personas`, `estado`, `mesa_id`, `atendido_en`, `fecha_registro`) VALUES
(1, 'Josep', '902211958', 5, 'Atendido', 6, '2026-07-21 14:16:54', '2026-07-21 18:38:43'),
(2, 'Corporacionhuancayo Peres', '90222111992', 4, 'Atendido', 4, '2026-07-21 14:17:16', '2026-07-21 19:17:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `estado` enum('Libre','Reservada','Ocupada','Limpieza') DEFAULT 'Libre',
  `ubicacion` varchar(100) NOT NULL DEFAULT 'Salón principal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigo`, `capacidad`, `estado`, `ubicacion`) VALUES
(1, 'M01', 2, 'Reservada', 'Salón principal'),
(2, 'M02', 2, 'Reservada', 'Salón principal'),
(3, 'M03', 4, 'Reservada', 'Salón principal'),
(4, 'M04', 4, 'Reservada', 'Salón principal'),
(5, 'M05', 4, 'Libre', 'Terraza'),
(6, 'M06', 6, 'Libre', 'Terraza'),
(7, 'M07', 6, 'Libre', 'Salón principal'),
(8, 'M08', 8, 'Ocupada', 'Área familiar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `reserva_id` int(11) DEFAULT NULL,
  `metodo` enum('Yape','Plin') DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `numero_operacion` varchar(100) DEFAULT NULL,
  `voucher` varchar(255) DEFAULT NULL,
  `validado` tinyint(1) DEFAULT 0,
  `estado_revision` enum('Pendiente','Aceptado','Rechazado') NOT NULL DEFAULT 'Pendiente',
  `revisado_por` int(11) DEFAULT NULL,
  `revisado_en` datetime DEFAULT NULL,
  `observacion_revision` varchar(255) DEFAULT NULL,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `reserva_id`, `metodo`, `monto`, `numero_operacion`, `voucher`, `validado`, `estado_revision`, `revisado_por`, `revisado_en`, `observacion_revision`, `creado`) VALUES
(1, 1, 'Yape', 30.00, '123456789', 'voucher_20260721_122141_4779eaf5db55a3cd.jpg', 1, 'Aceptado', 8, '2026-07-21 12:39:38', NULL, '2026-07-21 17:21:41'),
(2, 2, 'Yape', 30.00, '123456789', 'voucher_20260721_145003_6467fac2fd621b04.jpg', 1, 'Aceptado', 1, '2026-07-21 14:50:30', NULL, '2026-07-21 19:50:03'),
(3, 3, 'Yape', 30.00, '12345678', 'voucher_20260721_151243_659423c10ce327de.jpg', 0, 'Rechazado', 1, '2026-07-21 15:28:31', NULL, '2026-07-21 20:12:43'),
(4, 4, 'Yape', 30.00, '9022111958', 'voucher_20260721_155058_90baf98b9bbfc11c.png', 1, 'Aceptado', 1, '2026-07-21 15:51:15', NULL, '2026-07-21 20:50:58'),
(5, 5, 'Yape', 30.00, '9022111958', 'voucher_20260721_155840_395476a6a1d0f5cf.png', 1, 'Aceptado', 8, '2026-07-21 15:59:42', NULL, '2026-07-21 20:58:40'),
(6, 6, 'Yape', 30.00, '12345678', 'voucher_20260721_185005_c702973cd8f307fa.jpg', 1, 'Aceptado', 1, '2026-07-21 18:50:34', NULL, '2026-07-21 23:50:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `reserva_id` int(11) DEFAULT NULL,
  `mesa_id` int(11) DEFAULT NULL,
  `mesero_id` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('Pendiente','Preparando','Entregado','Pagado') DEFAULT 'Pendiente',
  `observaciones` varchar(500) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `adelanto_aplicado` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `reserva_id`, `mesa_id`, `mesero_id`, `fecha`, `estado`, `observaciones`, `subtotal`, `descuento`, `adelanto_aplicado`, `total`) VALUES
(1, NULL, 2, 1, '2026-07-20 16:54:59', 'Pagado', 'Casa', 13.00, 0.00, 0.00, 13.00),
(2, NULL, 2, 1, '2026-07-20 16:56:24', 'Pagado', NULL, 52.00, 0.00, 0.00, 52.00),
(3, NULL, 4, 1, '2026-07-20 16:57:43', 'Pagado', NULL, 88.00, 0.00, 0.00, 88.00),
(4, NULL, 5, 1, '2026-07-21 18:19:07', 'Pagado', NULL, 126.00, 0.00, 0.00, 126.00),
(5, NULL, 4, 9, '2026-07-21 21:00:38', 'Pagado', NULL, 41.00, 0.00, 0.00, 41.00),
(6, NULL, 4, 9, '2026-07-21 21:01:05', 'Pagado', NULL, 81.00, 0.00, 0.00, 81.00),
(7, 2, 7, 9, '2026-07-21 21:01:15', 'Pagado', NULL, 15.00, 0.00, 15.00, 0.00),
(8, NULL, 6, 9, '2026-07-21 21:01:32', 'Pagado', NULL, 90.00, 0.00, 0.00, 90.00),
(9, 2, 7, 9, '2026-07-21 21:01:54', 'Pagado', NULL, 64.00, 0.00, 30.00, 34.00),
(10, NULL, 4, 1, '2026-07-21 21:23:56', 'Pagado', NULL, 20.00, 0.00, 0.00, 20.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `imagen`, `precio`, `stock`, `activo`, `creado`, `actualizado`) VALUES
(1, 2, 'Ceviche', 'Rico Ceviche', NULL, 13.00, 0, 1, '2026-07-20 15:55:39', '2026-07-20 16:56:24'),
(2, 3, 'Lomo Saltado', 'Lomo salteado con papas y arroz.', NULL, 28.00, 50, 1, '2026-07-20 16:57:24', '2026-07-20 16:57:24'),
(3, 3, 'Arroz Chaufa Especial', 'Arroz chaufa con pollo y verduras.', NULL, 22.00, 38, 1, '2026-07-20 16:57:24', '2026-07-21 21:01:54'),
(4, 3, 'Ceviche Clásico', 'Pescado fresco con limón y acompañamientos.', NULL, 30.00, 30, 1, '2026-07-20 16:57:24', '2026-07-21 21:01:32'),
(5, 4, 'Inca Kola Personal', 'Bebida gaseosa personal.', NULL, 5.00, 88, 1, '2026-07-20 16:57:24', '2026-07-21 21:23:56'),
(6, 4, 'Chicha Morada', 'Vaso de chicha morada artesanal.', NULL, 6.00, 79, 1, '2026-07-20 16:57:24', '2026-07-21 21:00:38'),
(7, 5, 'Tequeños', 'Seis tequeños con salsa de la casa.', NULL, 15.00, 37, 1, '2026-07-20 16:57:24', '2026-07-21 21:01:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `mesa_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `personas` int(11) DEFAULT NULL,
  `adelanto` decimal(10,2) DEFAULT 30.00,
  `hora_limite` datetime DEFAULT NULL,
  `bloqueo_hasta` datetime DEFAULT NULL,
  `estado` enum('PendientePago','Confirmada','EnCurso','Finalizada','Expirada','Cancelada') DEFAULT 'PendientePago',
  `fecha_llegada` datetime DEFAULT NULL,
  `fecha_expiracion` datetime DEFAULT NULL,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `cliente_id`, `mesa_id`, `fecha`, `hora`, `personas`, `adelanto`, `hora_limite`, `bloqueo_hasta`, `estado`, `fecha_llegada`, `fecha_expiracion`, `creado`) VALUES
(1, 1, 3, '2026-08-28', '14:00:00', 4, 30.00, '2026-08-28 14:20:00', '2026-08-28 16:00:00', 'Confirmada', NULL, NULL, '2026-07-21 17:21:41'),
(2, 1, 7, '2026-07-21', '18:00:00', 3, 30.00, '2026-07-21 18:20:00', '2026-07-21 20:00:00', 'EnCurso', NULL, NULL, '2026-07-21 19:50:03'),
(3, 1, 8, '2026-07-21', '20:00:00', 5, 30.00, '2026-07-21 20:20:00', '2026-07-21 22:00:00', 'Cancelada', NULL, NULL, '2026-07-21 20:12:43'),
(4, 1, 8, '2026-07-21', '20:00:00', 5, 30.00, '2026-07-21 20:20:00', '2026-07-21 22:00:00', 'Confirmada', NULL, NULL, '2026-07-21 20:50:58'),
(5, 1, 2, '2026-07-28', '20:00:00', 2, 30.00, '2026-07-28 20:20:00', '2026-07-28 22:00:00', 'Confirmada', NULL, NULL, '2026-07-21 20:58:40'),
(6, 1, 4, '2026-07-21', '21:00:00', 4, 30.00, '2026-07-21 21:20:00', '2026-07-21 23:00:00', 'Confirmada', NULL, NULL, '2026-07-21 23:50:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Recepcion'),
(3, 'Mesero'),
(4, 'Cajera'),
(5, 'Gerente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `rol_id`, `nombres`, `correo`, `password`, `estado`, `creado`) VALUES
(1, 1, 'Administrador Principal', 'admin@restaurant.com', '$2y$10$aDBUbRyMPOe.YyhXxWshjO2mn4alVn8WsqubjzslJy7BVx3.Oxc.6', 1, '2026-07-19 06:26:10'),
(8, 2, 'Recepción RMRS', 'recepcion@restaurant.com', '$2y$10$pZtymS330GLv.DTBFxJRSus5j2ep8pH1RW/qZuafoc5CopSRwf80a', 1, '2026-07-19 08:33:30'),
(9, 3, 'Mesero RMRS', 'mesero@restaurant.com', '$2y$10$L55Oiae5GZ/GOwXUwaS/kujGPY51IWXnmBWHuGOJK9EC3VUiru6q2', 1, '2026-07-19 08:33:30'),
(10, 4, 'Cajera RMRS', 'caja@restaurant.com', '$2y$10$TskP8zB.vKbOBMB8lWNWs.J/xHcWAFugjQWp7TbBjvk73Q7054cAe', 1, '2026-07-19 08:33:30'),
(11, 5, 'Gerente RMRS', 'gerente@restaurant.com', '$2y$10$fKHhx6hQGjS/xnGsKrRfueV4NpaMmJ/ec99mxfClqpHde8fYlehCC', 1, '2026-07-19 08:33:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_categorias_nombre` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cobros_cajera` (`cajera_id`),
  ADD KEY `idx_cobros_fecha` (`creado`),
  ADD KEY `idx_cobros_pedido` (`pedido_id`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lista_espera_estado_fecha` (`estado`,`fecha_registro`),
  ADD KEY `fk_lista_espera_mesa` (`mesa_id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserva_id` (`reserva_id`),
  ADD KEY `idx_pagos_estado_revision` (`estado_revision`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserva_id` (`reserva_id`),
  ADD KEY `mesero_id` (`mesero_id`),
  ADD KEY `fk_pedidos_mesa` (`mesa_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_productos_categoria` (`categoria_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `mesa_id` (`mesa_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cobros`
--
ALTER TABLE `cobros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD CONSTRAINT `fk_cobros_cajera` FOREIGN KEY (`cajera_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cobros_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  ADD CONSTRAINT `fk_lista_espera_mesa` FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_mesa` FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`mesero_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
