-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2020 a las 00:22:06
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `medicine`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristicas`
--

CREATE TABLE `caracteristicas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(90) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `caracteristicas`
--

INSERT INTO `caracteristicas` (`id`, `nombre`, `id_producto`) VALUES
(17, 'talla', 45),
(18, 'tamaño', 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `items` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `id_usuario`, `items`) VALUES
(1, 13, '[{\"id\":\"42\",\"cantidad\":\"2\",\"sku\":\"42\",\"nombre\":\"HOMO PLUS\",\"caracteristicas\":[]}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `id_usuario`) VALUES
(6, 'Niños', 4),
(7, 'Diabéticos', 4),
(8, 'Vitamina', 4),
(9, 'Masculino', 4),
(10, 'Femenino', 4),
(11, ' Sistema circulatorio', 4),
(12, 'Músculos', 4),
(13, 'Sistema digestivo', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido` varchar(150) NOT NULL,
  `telefono` varchar(60) NOT NULL,
  `email` varchar(120) NOT NULL,
  `ciudad` varchar(150) NOT NULL,
  `direccion` text NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `password` varchar(250) NOT NULL,
  `token_email` varchar(350) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `telefono`, `email`, `ciudad`, `direccion`, `estado`, `password`, `token_email`, `fecha`) VALUES
(13, 'jesus david', 'martinez florez', '04160819773', 'martinez19florez@gmail.com', 'Bogotá', 'mi direccion', 1, '$2y$10$xxmOwewwcAWaT6zmXzPPCO4C2laOFGa7kksPWwAoA46Daj5bZUVj.', 'XFwvCQ6TEcGoHeOyuZlmN3xn8RBMqfdAUIPpitVW9h0LrY1S4K2Js7k5bajzDg', '2020-07-30 22:00:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `config_id` int(11) NOT NULL,
  `config_name` varchar(60) NOT NULL,
  `config_value` text NOT NULL,
  `config_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`config_id`, `config_name`, `config_value`, `config_code`) VALUES
(23, 'Pedidos-Ver pedidos generales', 'orders', 'SSU'),
(24, 'Usuarios-Todos los privilegios', 'listUsers', 'SSU'),
(25, 'admin_r', '{\"products\":\"true\",\"newProduct\":\"true\",\"editProduct\":\"true\",\"wallets\":\"true\",\"editWallet\":\"true\",\"statistics\":\"true\",\"nuewZone\":\"true\",\"appeals\":\"true\",\"updateStateAppeals\":\"true\",\"companys\":\"true\",\"newCompany\":\"true\",\"deleteCompany\":\"true\",\"editCompany\":\"true\",\"updateStateOrder\":\"true\"}', 'AR'),
(26, 'saller_r', '{\"products\":\"true\",\"companys\":\"true\"}', 'SR'),
(27, 'Seguridad', 'security', 'SSU'),
(29, 'Productos-Ver', 'products', 'SSU'),
(30, 'Productos-Crear', 'newProduct', 'SSU'),
(31, 'Productos-Editar', 'editProduct', 'SSU'),
(32, 'Productos-Eliminar', 'deleteProduct', 'SSU'),
(33, 'Clientes-Ver', 'clients', 'SSU'),
(34, 'Clientes-Crear', 'newClient', 'SSU'),
(35, 'Clientes-Borrar', 'deleteClient', 'SSU'),
(36, 'Clientes-Editar', 'editClient', 'SSU'),
(41, 'Pedidos-Editar pedidos generales', 'editOrder', 'SSU'),
(42, 'Pedidos-Editar estado del pedido', 'updateStateOrder', 'SSU'),
(43, 'Pedidos-Borrar pedidos generales', 'deleteGeneralOrders', 'SSU'),
(44, 'Estadísticas', 'statistics', 'SSU'),
(56, 'Pedidos-Exportar', 'orderExport', 'SSU'),
(68, 'config_user', '{\"type_money\":\"$\",\"rate\":\"3705.90\",\"payAtHome\":\"false\",\"receiveNotyByDay\":\"true\"}', 'USERS_CONFIG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_caracteristica`
--

CREATE TABLE `items_caracteristica` (
  `id` int(11) NOT NULL,
  `nombre` varchar(90) NOT NULL,
  `valor_agregado` decimal(10,2) NOT NULL,
  `id_caracteristica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `items_caracteristica`
--

INSERT INTO `items_caracteristica` (`id`, `nombre`, `valor_agregado`, `id_caracteristica`) VALUES
(1, 'xl', '0.00', 17),
(2, 'xxl', '2.00', 17),
(3, 'xxxl', '4.00', 17),
(4, 'pequeño', '0.00', 18),
(5, 'mediano', '0.00', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_pedidos`
--

CREATE TABLE `items_pedidos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `skus` text NOT NULL,
  `sku` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `items_pedidos`
--

INSERT INTO `items_pedidos` (`id`, `id_pedido`, `id_producto`, `precio_compra`, `cantidad`, `skus`, `sku`) VALUES
(5, 4, 44, '54.00', 1, '', ''),
(6, 4, 45, '23.00', 2, '[{\"name\":\"talla\",\"_id\":\"17\",\"value\":\"xxl\",\"child_id\":\"2\",\"suma\":\"2.00\",\"orden\":\"1\"},{\"name\":\"tamau00f1o\",\"_id\":\"18\",\"value\":\"pequeu00f1o\",\"child_id\":\"4\",\"suma\":\"0.00\",\"orden\":\"2\"}]', '2#4'),
(7, 5, 44, '54.00', 1, '', ''),
(8, 6, 42, '34.00', 2, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multimedia_product`
--

CREATE TABLE `multimedia_product` (
  `id_media` int(11) NOT NULL,
  `name_key` varchar(50) NOT NULL,
  `name` varchar(90) NOT NULL,
  `path_media` varchar(80) NOT NULL,
  `id_product` int(11) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `multimedia_product`
--

INSERT INTO `multimedia_product` (`id_media`, `name_key`, `name`, `path_media`, `id_product`, `orden`) VALUES
(119, 'image', '', 'views/images/productos/producto_img_8404-1-39.jpg', 39, 1),
(120, 'image', '', 'views/images/productos/producto_img_3398-1-40.jpg', 40, 1),
(121, 'image', '', 'views/images/productos/producto_img_2266-1-41.jpg', 41, 1),
(122, 'image', '', 'views/images/productos/producto_img_9619-1-45.jpg', 45, 1),
(123, 'image', '', 'views/images/productos/producto_img_5445-2-45.jpg', 45, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `link` varchar(70) NOT NULL,
  `fecha` datetime NOT NULL,
  `visto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `id_usuario`, `tipo`, `titulo`, `link`, `fecha`, `visto`) VALUES
(1, 8, 'peticion', 'Tu petición ha sido rechazada', 'newOrder', '2020-03-05 20:54:31', 1),
(2, 8, 'peticion', 'Tu petición ha sido aceptada', 'newOrder', '2020-03-05 21:07:23', 1),
(3, 8, 'peticion', 'Tu petición ha sido rechazada', 'newOrder', '2020-03-05 21:15:12', 1),
(4, 8, 'peticion', 'Tu petición ha sido aceptada', 'newOrder', '2020-03-05 21:15:44', 1),
(6, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-05 21:20:44', 0),
(7, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-05 21:20:44', 0),
(8, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-05 21:20:44', 0),
(11, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-05 21:33:51', 0),
(12, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-05 21:33:51', 0),
(13, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-05 21:33:51', 0),
(15, 8, 'peticion', 'Tu petición ha sido aceptada', 'newOrder', '2020-03-05 21:34:16', 1),
(16, 8, 'peticion', 'Tu petición ha sido aceptada', 'newOrder', '2020-03-05 21:34:16', 1),
(17, 8, 'estado_usuario', '¡Tu rango de usuario ha sido actualizado a Administrador!', 'profile', '2020-03-05 21:38:50', 1),
(18, 8, 'estado_usuario', '¡Tu rango de usuario ha sido actualizado a Master!', 'profile', '2020-03-05 21:39:09', 1),
(19, 8, 'estado_usuario', '¡Tu rango de usuario ha sido actualizado a Vendedor!', 'profile', '2020-03-05 21:39:22', 1),
(20, 0, 'pedido', '¡Tu pedido #31 ha sido procesado!', 'orders', '2020-03-06 17:22:15', 0),
(21, 8, 'pedido', '¡Tu pedido #31 ha sido rechazado!', 'orders', '2020-03-06 17:24:24', 1),
(22, 8, 'pedido', '¡Tu pedido #31 ha sido procesado!', 'orders', '2020-03-06 17:24:55', 1),
(23, 8, 'pedido', '¡Tu pedido #30 ha sido rechazado!', 'orders', '2020-03-06 17:35:47', 1),
(24, 8, 'pedido', '¡Tu pedido #30 ha sido procesado!', 'orders', '2020-03-06 17:51:01', 1),
(25, 8, 'pedido', '¡Tu pedido #33 ha sido procesado!', 'orders', '2020-03-06 18:22:02', 1),
(27, 10, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-06 18:23:59', 0),
(28, 11, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-06 18:23:59', 0),
(29, 12, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-06 18:23:59', 0),
(31, 8, 'pedido', '¡Tu pedido #34 ha sido rechazado!', 'orders', '2020-03-06 18:25:23', 1),
(32, 8, 'pedido', '¡Tu pedido #34 ha sido procesado!', 'orders', '2020-03-06 18:25:52', 1),
(33, 9, 'pedido', '¡Tu pedido #27 ha sido procesado!', 'orders', '2020-03-06 18:46:45', 0),
(34, 8, 'ruta', '¡Se te ha asignado una nueva ruta!', 'myRoutes', '2020-03-06 18:58:14', 1),
(35, 8, 'ruta', '¡Tu ruta ruta abc ha sido actualizada!', 'myRoutes', '2020-03-06 19:00:23', 1),
(36, 8, 'ruta', '¡Tu ruta ruta 4 editar ha sido actualizada!', 'myRoutes', '2020-03-06 19:00:45', 1),
(37, 8, 'ruta', '¡Tu ruta ruta 2 editada ha sido actualizada!', 'myRoutes', '2020-03-06 19:04:33', 1),
(38, 8, 'peticion', 'Tu petición ha sido aceptada', 'newOrder', '2020-03-06 21:27:08', 1),
(39, 8, 'pedido', '¡Tu pedido #29 ha sido procesado!', 'orders', '2020-03-06 21:27:28', 1),
(40, 8, 'ruta', '¡Tu ruta ruta ha sido actualizada!', 'myRoutes', '2020-03-09 17:35:51', 1),
(41, 8, 'ruta', '¡Tu ruta ruta g ha sido actualizada!', 'myRoutes', '2020-03-09 17:40:22', 1),
(42, 8, 'ruta', '¡Tu ruta ruta 2 edit ha sido actualizada!', 'myRoutes', '2020-03-09 17:43:24', 1),
(43, 8, 'ruta', '¡Tu ruta ruta 2 edit ha sido actualizada!', 'myRoutes', '2020-03-09 17:44:07', 1),
(44, 8, 'ruta', '¡Tu ruta ruta 2 edit ha sido actualizada!', 'myRoutes', '2020-03-09 17:45:01', 1),
(45, 8, 'ruta', '¡Tu ruta ruta 2 ha sido actualizada!', 'myRoutes', '2020-03-09 17:57:26', 1),
(46, 8, 'ruta', '¡Tu ruta ruta 4 ha sido actualizada!', 'myRoutes', '2020-03-09 17:59:51', 1),
(47, 8, 'ruta', '¡Tu ruta ruta 3 ha sido actualizada!', 'myRoutes', '2020-03-09 18:01:15', 1),
(48, 8, 'ruta', '¡Tu ruta ruta 3 ha sido actualizada!', 'myRoutes', '2020-03-09 18:04:43', 1),
(49, 8, 'ruta', '¡Tu ruta ruta 3 ha sido actualizada!', 'myRoutes', '2020-03-09 18:06:08', 1),
(50, 8, 'ruta', '¡Tu ruta ruta 3 ha sido actualizada!', 'myRoutes', '2020-03-09 18:06:42', 1),
(51, 8, 'ruta', '¡Tu ruta ruta 2 ha sido actualizada!', 'myRoutes', '2020-03-09 18:07:14', 1),
(52, 8, 'ruta', '¡Tu ruta ruta 2 ha sido actualizada!', 'myRoutes', '2020-03-09 18:08:01', 1),
(53, 8, 'ruta', '¡Tu ruta ruta 2 ha sido actualizada!', 'myRoutes', '2020-03-09 18:16:36', 0),
(54, 8, 'ruta', '¡Tu ruta ruta 3 ha sido actualizada!', 'myRoutes', '2020-03-09 18:16:53', 0),
(55, 8, 'ruta', '¡Tu ruta ruta 3 ha sido actualizada!', 'myRoutes', '2020-03-09 18:17:38', 1),
(57, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 18:35:50', 0),
(58, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 18:35:50', 0),
(59, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 18:35:50', 0),
(61, 8, 'peticion', 'Tu petición ha sido aceptada', 'newOrder', '2020-03-09 18:36:27', 1),
(63, 10, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-09 18:37:33', 0),
(64, 11, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-09 18:37:33', 0),
(65, 12, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-09 18:37:33', 0),
(68, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 18:43:13', 0),
(69, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 18:43:13', 0),
(70, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 18:43:13', 0),
(72, 8, 'peticion', 'Tu petición ha sido aceptada', 'newOrder', '2020-03-09 18:43:35', 0),
(74, 10, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_11', '2020-03-09 18:44:20', 0),
(75, 11, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_11', '2020-03-09 18:44:21', 0),
(76, 12, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_11', '2020-03-09 18:44:21', 0),
(79, 10, 'producto', '¡Límite mínimo de inventario alcanzado!', 'editProduct_11', '2020-03-09 18:44:22', 0),
(80, 11, 'producto', '¡Límite mínimo de inventario alcanzado!', 'editProduct_11', '2020-03-09 18:44:22', 0),
(81, 12, 'producto', '¡Límite mínimo de inventario alcanzado!', 'editProduct_11', '2020-03-09 18:44:22', 0),
(84, 10, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-09 18:44:24', 0),
(85, 11, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-09 18:44:24', 0),
(86, 12, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-09 18:44:24', 0),
(89, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 18:54:02', 0),
(90, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 18:54:02', 0),
(91, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 18:54:02', 0),
(94, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 19:08:33', 0),
(95, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 19:08:33', 0),
(96, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 19:08:33', 0),
(99, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 20:16:15', 0),
(100, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 20:16:15', 0),
(101, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 20:16:15', 0),
(104, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 20:19:18', 0),
(105, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 20:19:18', 0),
(106, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-09 20:19:18', 0),
(109, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-11 14:28:50', 0),
(110, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-11 14:28:50', 0),
(111, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-11 14:28:50', 0),
(114, 10, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-11 14:30:01', 0),
(115, 11, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-11 14:30:02', 0),
(116, 12, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-11 14:30:02', 0),
(119, 10, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_26', '2020-03-11 17:33:22', 0),
(120, 11, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_26', '2020-03-11 17:33:25', 0),
(121, 12, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_26', '2020-03-11 17:33:26', 0),
(124, 10, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:33:27', 0),
(125, 11, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:33:29', 0),
(126, 12, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:33:29', 0),
(128, 4, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_26', '2020-03-11 17:38:57', 1),
(129, 10, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_26', '2020-03-11 17:38:59', 0),
(130, 11, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_26', '2020-03-11 17:39:00', 0),
(131, 12, 'producto', '¡Límite de compra ajustado por inventario reducido!', 'editProduct_26', '2020-03-11 17:39:01', 0),
(133, 4, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:39:01', 1),
(134, 10, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:39:04', 0),
(135, 11, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:39:11', 0),
(136, 12, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:39:11', 0),
(138, 4, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:45:01', 1),
(139, 10, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:45:03', 0),
(140, 11, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:45:05', 0),
(141, 12, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 17:45:05', 0),
(143, 14, 'pedido', '¡Tu pedido #39 ha sido procesado!', 'orders', '2020-03-11 17:48:12', 1),
(144, 4, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 18:54:32', 1),
(145, 10, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 18:54:36', 0),
(146, 11, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 18:54:38', 0),
(147, 12, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 18:54:38', 0),
(149, 14, 'pedido', '¡Tu pedido #40 ha sido rechazado!', 'orders', '2020-03-11 18:55:15', 0),
(150, 4, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 21:04:46', 1),
(153, 4, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-11 21:07:43', 1),
(156, 4, 'peticion', '¡Nueva petición de inventario!', 'appeals', '2020-03-11 21:10:09', 1),
(160, 4, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-13 14:58:19', 1),
(162, 4, 'pedido', '¡Nuevo pedido!', 'orders', '2020-03-13 18:07:24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones`
--

CREATE TABLE `opiniones` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_comprador` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `comentario` text NOT NULL,
  `skus` text NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `opiniones`
--

INSERT INTO `opiniones` (`id`, `id_producto`, `id_comprador`, `valor`, `comentario`, `skus`, `fecha`) VALUES
(2, 44, 13, '4.00', 'bueno', '', '2020-08-06 17:36:05'),
(3, 45, 13, '3.50', 'regular...', '[{\"name\":\"talla\",\"_id\":\"17\",\"value\":\"xxl\",\"child_id\":\"2\",\"suma\":\"2.00\",\"orden\":\"1\"},{\"name\":\"tamau00f1o\",\"_id\":\"18\",\"value\":\"pequeu00f1o\",\"child_id\":\"4\",\"suma\":\"0.00\",\"orden\":\"2\"}]', '2020-08-06 17:36:05'),
(4, 44, 13, '3.00', 'ummmm', '', '2020-08-06 17:56:46'),
(5, 42, 13, '4.50', '', '', '2020-08-06 20:26:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_comprador` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `valorado` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `soft_delete_buyer` int(11) NOT NULL,
  `soft_delete_seller` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_comprador`, `estado`, `valorado`, `fecha`, `soft_delete_buyer`, `soft_delete_seller`) VALUES
(4, 13, 1, 1, '2020-08-04 16:42:53', 0, 0),
(5, 13, 1, 1, '2020-08-06 17:55:17', 0, 0),
(6, 13, 1, 1, '2020-08-06 20:12:57', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `respuesta` text NOT NULL,
  `fecha_pregunta` datetime NOT NULL,
  `fecha_respuesta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `id_producto`, `id_cliente`, `contenido`, `respuesta`, `fecha_pregunta`, `fecha_respuesta`) VALUES
(6, 44, 13, 'esta es una pregunta', 'espuesta 1', '2020-08-06 19:02:39', '2020-08-06 19:49:35'),
(8, 44, 13, 'esta es otra pregunta', 'respuesta 2 ... - edit', '2020-08-06 19:03:39', '2020-08-06 20:19:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `categorias` varchar(150) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `oferta` decimal(10,2) NOT NULL,
  `fechaLimiteOferta` datetime NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `inventario` int(11) NOT NULL,
  `inventario_minimo` int(11) NOT NULL,
  `codigo` varchar(60) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `slug`, `imagen`, `descripcion`, `categorias`, `precio`, `oferta`, `fechaLimiteOferta`, `estado`, `inventario`, `inventario_minimo`, `codigo`, `id_usuario`) VALUES
(39, 'Optimus', 'Optimus-39', 'views/images/productos/imagen_39.jpg', 'MEJORA LA CONCENTRACIÓN Y MEMORIA.  \r\nPRODUCE NEUROTRANSMISORES. \r\nELIMINA MIGRAÑAS Y DOLORES DE CABEZA.  MEJORA EL APRENDIZAJE EN LOS NIÑOS.  AYUDA AL SISTEMA CIRCULATORIO (VARICES). \r\nMEJORA LA VISIÓN. \r\nELIMINA EL INSOMNIO. \r\nCOMBATE ALZHEIMER, PARKINSON. \r\nEPILEPSIA Y PROBLEMAS DE HABLA.', '8,11', '23.00', '0.00', '0000-00-00 00:00:00', 1, 45, 0, '', 4),
(40, 'POWERMAKER', 'POWERMAKER-40', 'views/images/productos/imagen_40.jpg', 'TONIFICA E INCREMENTA LA MASA MUSCULAR .\r\nELIMINA HERNIAS DISCALES. \r\nREGENERA TEJIDOS, TENDONES, LIGAMENTOS Y HUESOS. \r\nCOMBATE :OSTEOPOROSIS, ARTRITIS, ARTROSIS Y FRACTURAS.\r\nREJUVENECE Y REAFIRMA LA PIEL. \r\nFAVORECE EL CRECIMIENTO DE LOS NIÑOS. \r\nFORTALECE LA ACTIVIDAD SEXUAL', '12', '45.00', '0.00', '0000-00-00 00:00:00', 1, 15, 0, '', 4),
(41, 'FIBER’NPLUS', 'FIBER-NPLUS-41', 'views/images/productos/imagen_41.jpg', ' EQUILIBRA SISTEMA DIGESTIVO ? GASTRITIS. ? HELICOBACTER PYLORI. ? COLON INFLAMADO, ESTREÑIMIENTO. ? AGRIERAS , ÚLCERAS. ? ACIDEZ, GASES. ? REFLUJO, HEMORROIDES. ? MALA DIGESTIÓN. ? COLESTEROL Y TRIGLICÉRIDOS. ? HÍGADO GRASO, VESÍCULA', '13', '23.00', '0.00', '0000-00-00 00:00:00', 1, 9, 0, '', 4),
(42, 'HOMO PLUS', 'HOMO-PLUS-42', 'views/images/productos/imagen_42.jpg', '? DESINFLAMA, LIMPIA Y DESINFLAMA LA PRÓSTATA. ? ESPECIALMENTE BENÉFICO PARA EL SISTEMA HORMONAL MASCULINO. ? AUMENTA CONTEO DE                    ESPERMATOZOIDES (FERTILIDAD). ? MEJORA LA ACTIVIDAD SEXUAL. ? DETIENE LA CAÍDA DEL CABELLO. ? CONTROLA EL ACNÉ JUVENIL.', '9', '34.00', '0.00', '0000-00-00 00:00:00', 1, 13, 0, '', 4),
(43, 'FEM PLUS ', 'FEM-PLUS-43', 'views/images/productos/imagen_43.jpg', '? NUTRE Y EQUILIBRA LAS HORMONAS  FEMENINAS. ? ELIMINA CÓLICOS MENSTRUALES. ? CONTROLA ANSIEDAD POR ALIMENTOS DULCES. ? ELIMINA QUISTES, MIOMAS Y PÓLIPOS. ? REGULA CICLOS MENSTRUALES. ? MEJORA LA FERTILIDAD FORTALECIENDO EL ÚTERO. ? FORTALECE PIEL, CABELLO Y UÑAS. ? CONTROLA EL ACNÉ JUVENIL.', '10', '45.00', '0.00', '0000-00-00 00:00:00', 1, 41, 0, '', 4),
(44, 'PROBIOTIC', 'PROBIOTIC-44', 'views/images/productos/imagen_44.jpg', '?CONTIENE 1 BILLÓN DE PROBIOTICOS POR CADA SOBRE ?CONTIENEN LACTOBACILOS QUE AYUDAN A MEJORAR LA DIGESTIÓN, ?PROMUEVEN EL EQUILIBRIO DE LA FLORA INTESTINAL. ?DISMINUYEN LA INFLAMACIÓN, EL DOLOR Y EL ESTREÑIMIENTO. ?AYUDAN A EVITAR QUE LAS BACTERIAS PATÓGENAS SE DESARROLLEN. ?NUTRE LAS DEFENSAS DEL S', '8,9,10', '54.00', '0.00', '0000-00-00 00:00:00', 1, 13, 0, '', 4),
(45, 'ALOEBETA', 'ALOEBETA-45', 'views/images/productos/imagen_45.jpg', 'LIMPIA DESINTOXIA Y CICATRIZA EXCELENTE ANTIOXIDANTE NATURAL.  INFECCIONES: CISTITIS, OTITIS, LARINGITIS. ? AYUDA AL SISTEMA DIGESTIVO. ? DESINTOXICA EL ORGANISMO. ? LIMPIA LOS &quot;INTESTINOS&quot;. ? DESINFLAMA EL COLON. ? LIMPIA LOS RIÑONES. ? MEJORA LA FUNCIÓN DEL HÍGADO. ? EXCELENTE PARA PROBL', '7,8', '23.00', '0.00', '0000-00-00 00:00:00', 1, 45, 0, '', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `puntos` text NOT NULL,
  `frecuencia` varchar(60) NOT NULL,
  `fecha_creada` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(70) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `imagen` varchar(150) NOT NULL,
  `tipo` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `password` varchar(250) NOT NULL,
  `tag_on_signal` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `correo`, `imagen`, `tipo`, `estado`, `password`, `tag_on_signal`) VALUES
(4, 'Jesus Martinez', 'martinez19florez@gmail.com', 'views/images/usuarios/imagen_4.jpg', 0, 1, '$2y$10$yVnc7Zh/IvAUcfiADG78zOzI.Z5c96ED4rCV7EVnNUZQYKTxLVCcS', 'user_4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variantes`
--

CREATE TABLE `variantes` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `sku` varchar(250) NOT NULL,
  `inventario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `variantes`
--

INSERT INTO `variantes` (`id`, `id_producto`, `sku`, `inventario`) VALUES
(91, 45, '1#4', 0),
(92, 45, '1#5', 15),
(93, 45, '2#4', 13),
(94, 45, '2#5', 13),
(95, 45, '3#4', 15),
(96, 45, '3#5', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE `zonas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`id`, `nombre`) VALUES
(2, 'DTO CAPITAL'),
(3, 'MIRANDA'),
(4, 'CAGUA'),
(6, 'GUÁRICO'),
(7, 'CARABOBO'),
(8, 'LARA'),
(9, 'APURE'),
(10, 'ZULIA'),
(11, 'FALCON'),
(12, 'MÉRIDA'),
(13, 'ANZOATEGUI'),
(14, 'BOLIVAR');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`config_id`);

--
-- Indices de la tabla `items_caracteristica`
--
ALTER TABLE `items_caracteristica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `items_pedidos`
--
ALTER TABLE `items_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `multimedia_product`
--
ALTER TABLE `multimedia_product`
  ADD PRIMARY KEY (`id_media`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `variantes`
--
ALTER TABLE `variantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zonas`
--
ALTER TABLE `zonas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `items_caracteristica`
--
ALTER TABLE `items_caracteristica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `items_pedidos`
--
ALTER TABLE `items_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `multimedia_product`
--
ALTER TABLE `multimedia_product`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `variantes`
--
ALTER TABLE `variantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
