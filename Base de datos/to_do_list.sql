-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-10-2023 a las 21:11:42
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `to_do_list`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listas`
--

CREATE TABLE `listas` (
  `id_list` int(11) NOT NULL,
  `nom_list` varchar(70) NOT NULL,
  `color_list` varchar(50) NOT NULL,
  `prioridad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `listas`
--

INSERT INTO `listas` (`id_list`, `nom_list`, `color_list`, `prioridad`) VALUES
(1, 'Primera lista', 'rgb(220, 20, 60)', 1),
(2, 'Segunda lista', 'rgb(255, 0, 255)', 2),
(3, 'Tercera lista', 'rgb(0, 255, 0)', 3),
(13, 'Otra lista', 'rgb(75, 0, 130)', 4),
(19, 'Cosas pendientes de la universidad', 'rgb(0, 0, 139)', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tar` int(11) NOT NULL,
  `desc_tar` mediumtext NOT NULL,
  `fec_tar` datetime DEFAULT NULL,
  `completado` tinyint(1) NOT NULL,
  `prioridad` int(11) DEFAULT NULL,
  `id_list` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id_tar`, `desc_tar`, `fec_tar`, `completado`, `prioridad`, `id_list`) VALUES
(1, 'Primera tarea', '2023-10-05 00:54:00', 0, 1, 2),
(2, 'Segunda tarea', '4322-02-23 16:34:00', 1, 2, 2),
(20, 'uno', NULL, 0, 1, 1),
(21, 'dos', NULL, 0, 2, 1),
(23, 'Tercera tarea', NULL, 0, 3, 2),
(28, 'Prueba corta de ingeniería del software', '2023-10-17 00:00:00', 0, 5, 19),
(29, 'Microclase de sistemas operativos', '2023-10-31 00:00:00', 0, 7, 19),
(34, 'Entrega del sistema del proyecto', '2023-11-15 00:00:00', 0, 8, 19),
(35, 'Entrega del programa de programación', NULL, 0, 1, 19),
(60, 'Examen de probabilidad', '2023-10-23 00:00:00', 0, 6, 19),
(61, 'Mapa conceptual de electiva', '2023-10-17 00:00:00', 1, 3, 19),
(62, 'Cuadro comparativo de electiva', '2023-10-17 00:00:00', 1, 4, 19),
(63, 'Trabajo escrito de FEP', NULL, 1, 2, 19);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `listas`
--
ALTER TABLE `listas`
  ADD PRIMARY KEY (`id_list`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tar`),
  ADD KEY `id_list` (`id_list`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `listas`
--
ALTER TABLE `listas`
  MODIFY `id_list` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`id_list`) REFERENCES `listas` (`id_list`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
