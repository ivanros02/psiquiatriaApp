-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-10-2024 a las 17:15:40
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
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `id` int(11) NOT NULL,
  `rutaImagen` varchar(200) NOT NULL DEFAULT '../img/por_defecto.png',
  `nombre` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `matricula` int(100) NOT NULL,
  `matriculaP` int(255) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `telefono` int(50) NOT NULL,
  `disponibilidad` int(11) NOT NULL,
  `valor` int(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `whatsapp` int(255) NOT NULL,
  `instagram` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id`, `rutaImagen`, `nombre`, `titulo`, `matricula`, `matriculaP`, `descripcion`, `telefono`, `disponibilidad`, `valor`, `mail`, `whatsapp`, `instagram`) VALUES
(18, '../img/perfiles/por_defecto.png', 'TEST', 'TEST', 123, 345, 'TEST', 1139114579, 24, 100, 'ivanrosendo1102@gmail.com', 1139114579, '@rosendo_ivann');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
