-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2024 a las 17:16:17
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
-- Base de datos: `terapia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad_turnos`
--

CREATE TABLE `disponibilidad_turnos` (
  `id` int(11) NOT NULL,
  `profesional_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `disponible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `disponibilidad_turnos`
--

INSERT INTO `disponibilidad_turnos` (`id`, `profesional_id`, `fecha`, `hora`, `disponible`) VALUES
(1, 2, '2024-10-30', '11:30:22', 0),
(2, 1, '2024-11-01', '12:54:29', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `disponibilidad_turnos`
--
ALTER TABLE `disponibilidad_turnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesional_id` (`profesional_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `disponibilidad_turnos`
--
ALTER TABLE `disponibilidad_turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `disponibilidad_turnos`
--
ALTER TABLE `disponibilidad_turnos`
  ADD CONSTRAINT `disponibilidad_turnos_ibfk_1` FOREIGN KEY (`profesional_id`) REFERENCES `presentaciones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
