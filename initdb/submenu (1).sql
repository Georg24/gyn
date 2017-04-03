-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2017 a las 17:04:51
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gyndb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submenu`
--

CREATE TABLE `submenu` (
  `id_submenu` int(10) UNSIGNED NOT NULL,
  `submenu` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `enlace` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_menu` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `submenu`
--

INSERT INTO `submenu` (`id_submenu`, `submenu`, `enlace`, `id_menu`) VALUES
(1, 'Noticias', 'index.php/Inicio', 1),
(2, 'Por Mayor', 'index.php/Venta/PorMayor', 2),
(3, 'Por Menor', 'index.php/Venta/PorMenor', 2),
(4, 'Vender', 'index.php/Venta', 2),
(5, 'Ajuste de Venta', 'index.php/Venta/ajuste', 2),
(6, 'Registro Diario', 'index.php/Venta/registroDiario', 2),
(7, 'Inventario', 'index.php/Inventario', 3),
(8, 'Ajuste', 'index.php/Inventario/ajuste', 3),
(9, 'Recepcion', 'index.php/Inventario/recepcion', 3),
(10, 'Reportes', 'index.php/Reportes', 4),
(11, 'Usuarios', 'index.php/Usuarios', 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`id_submenu`),
  ADD KEY `id_menu` (`id_menu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `submenu`
--
ALTER TABLE `submenu`
  MODIFY `id_submenu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `submenu`
--
ALTER TABLE `submenu`
  ADD CONSTRAINT `submenu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
